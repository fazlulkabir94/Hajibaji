<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Models\BankAccounts;
use App\Models\Employee;
use App\Models\EmployeeTada;
use App\Models\EmployeeLoan;
use App\Models\SalaryMonth;
use App\Models\SalarySheet;
use App\Models\Attendance;
use App\Models\CashbookTransection;
use App\Models\BankLoan;
use App\Models\Bank;
use App\Models\LoanRefund;
use App\Models\Cheque;
use App\Models\ChequeManagement;
use App\Models\CashTransfer;
use App\Models\Customers;
use App\Models\Suppliers;
use App\Models\Advance;
use App\Models\PurchaseAdvance;
use App\Models\InventoryInOut;
use App\Models\Assets;
use App\Models\ProductPriceHistory;
use App\Models\AssetPriceHistory;
use App\Models\Products;
use App\Models\Purchase;
use App\Models\Sales;

use Auth;
use Session;
use Validator;
use DB;
use Cashbook;

class ProfitlossController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIndex()
    {
    	$data['title'] = 'Profit Loss Report';
    	return view('profitloss.index', $data);
    }

    public function postIndex(Request $request)
    {

    	// start initial investment

    	$InvestCashAmount = 0;
    	$InvestCash = CashTransfer::where('transection_type', 2)->orderBy('created_at')->sum('amount');
    	if($InvestCash){
    		$InvestCashAmount = $InvestCash;
    	}
    	$data['InvestCashAmount'] = $InvestCashAmount;

    	$InvestBankAmount = 0;
    	$InvestBank = CashTransfer::where('transection_type', 4)->sum('amount');
    	if($InvestBank){
    		$InvestBankAmount = $InvestBank;
    	}
    	$data['InvestBankAmount'] = $InvestBankAmount;

    	$InvestProductAmount = 0;
    	$InvestProduct = InventoryInOut::where('is_initial_product', 1)->sum('qtys_total_price');
    	if($InvestProduct){
    		$InvestProductAmount = $InvestProduct;
    	}
    	$data['InvestProductAmount'] = $InvestProductAmount;

    	$InvestAssetAmount = 0;
    	$InvestAsset = Assets::where('status', 1)->where('is_initial_asset', 1)->sum('initial_price');
    	if($InvestAsset){
    		$InvestAssetAmount = $InvestAsset;
    	}
    	$data['InvestAssetAmount'] = $InvestAssetAmount;

    	$InvestCustomerAmount = 0;
    	$InvestCustomer = Customers::where('status', 1)->sum('opening_balance');
    	if($InvestCustomer){
    		$InvestCustomerAmount = $InvestCustomer;
    	}
    	$data['InvestCustomerAmount'] = $InvestCustomerAmount;

    	$InvestSupplierAmount = 0;
    	$InvestSupplier = Suppliers::where('status', 1)->sum('opening_balance');
    	if($InvestSupplier){
    		$InvestSupplierAmount = $InvestSupplier;
    	}
    	$data['InvestSupplierAmount'] = $InvestSupplierAmount;


    	$InvestBankLoanAmount = 0;
    	$InvestBankLoan = BankLoan::where('status', 1)->where('is_old_loan', 1)->sum('amount');
    	if($InvestBankLoan){
    		$InvestBankLoanAmount = $InvestBankLoan;
    	}
    	$data['InvestBankLoanAmount'] = $InvestBankLoanAmount;


    	$InvestEmployeeLoanAmount = 0;
    	$InvestEmployeeLoan = EmployeeLoan::where('type', 1)->where('is_old_loan', 1)->sum('loan_amount');
    	if($InvestEmployeeLoan){
    		$InvestEmployeeLoanAmount = $InvestEmployeeLoan;
    	}
    	$data['InvestEmployeeLoanAmount'] = $InvestEmployeeLoanAmount;




    	// end initial investment

    	// start now situation

    	$to = date('Y-m-d 23:59:59', strtotime($request->date));
    	// dd($to);

    	$CashBookAmount = 0;
    	$CashbookInAmount = 0;
    	$CashbookOutAmount = 0;
    	$CashbookIn = CashbookTransection::where('created_at', '<=', $to)->where('transection_type', 1)->sum('amount');
    	if($CashbookIn) $CashbookInAmount = $CashbookIn;
    	$CashbookOut = CashbookTransection::where('created_at', '<=', $to)->where('transection_type', 2)->sum('amount');
    	if($CashbookOut) $CashbookOutAmount = $CashbookOut;
    	$CashBookAmount = $CashbookIn-$CashbookOut;
    	$data['CashBookAmount'] = $CashBookAmount;


    	$BankAmount = 0;
    	$BankInAmount = 0;
    	$BankOutAmount = 0;
    	$BankIn = CashTransfer::where('date', '<=', $to)->where('in_out', 1)->where(function($query){
    		$query->where('from_bank_account', '!=', 0)->orWhere('to_bank_account', '!=', 0);
    	})->sum('amount');
    	if($BankIn) $BankInAmount = $BankIn;
    	$BankOut = CashTransfer::where('date', '<=', $to)->where('in_out', 2)->where(function($query){
    		$query->where('from_bank_account', '!=', 0)->orWhere('to_bank_account', '!=', 0);
    	})->sum('amount');
    	if($BankOut) $BankOutAmount = $BankOut;
    	$BankAmount = $BankIn-$BankOut;
    	$data['BankAmount'] = $BankAmount;



    	$ProductAmount = 0;
    	$Product = Products::all();
    	foreach ($Product as $p) {
    		$in = $p->inventory()->where('created_at', '<=', $to)->where('in_out_type', 1)->sum('qty');
    		$out = $p->inventory()->where('created_at', '<=', $to)->where('in_out_type', 2)->sum('qty');
    		$total = $in-$out;
    		$price = ProductPriceHistory::where('product_id', $p->id)->where('change_date', '<=', $to)->orderBy('change_date', 'desc')->first();
    		if($price){
    			$ProductAmount += $total*$price->new_price;
    		}
    		
    	}
    	$data['ProductAmount'] = $ProductAmount;



    	$AssetAmount = 0;
    	$Asset = Assets::all();
    	
    	foreach ($Asset as $s) {
    		$price = AssetPriceHistory::where('asset_id', $s->id)->where('change_date', '<=', $to)->orderBy('change_date', 'desc')->first();
    		if($price){
    			$AssetAmount += $price->new_price;
    		}
    		
    	}
    	$data['AssetAmount'] = $AssetAmount;




    	$CustomerAmount = 0;
    	$CDueCollection = Advance::where('sales_collection.date', '<=', $to)->where('payment_type', '!=', 0)->sum('amount');
    	$CSales = Sales::where('sales.sales_date', '<=', $to)->sum('invoice_total');
    	$CTotalDue = $CSales-$CDueCollection;
    	$CustomerAmount = $InvestCustomerAmount+$CTotalDue;
    	$data['CustomerAmount'] = $CustomerAmount;



    	$SuplierAmount = 0;
    	$SDueCollection = PurchaseAdvance::where('date', '<=', $to)->where('payment_method', '!=', 0)->sum('amount');
    	$SSales = Purchase::where('purchase_date', '<=', $to)->sum('invoice_total');
    	$STotalDue = $SSales-$SDueCollection;
    	$SuplierAmount = $InvestSupplierAmount+$STotalDue;
    	$data['SuplierAmount'] = $SuplierAmount;

    	
    	
    	$BankLoanAmount = 0;
    	$BLoan = BankLoan::where('date', '<=', $to)->sum('amount');
    	$OpeningLoanRefund = BankLoan::where('date', '<=', $to)->sum('opening_refunded_amount');
    	$BLoanRefund = LoanRefund::where('date', '<=', $to)->sum('amount');
		$BankLoanAmount = $BLoan-$OpeningLoanRefund-$BLoanRefund;
    	$data['BankLoanAmount'] = $BankLoanAmount;

    	
    	
    	$EmployeeLoanAmount = 0;
    	$ELoan = EmployeeLoan::where('date', '<=', $to)->where('type', 1)->sum('loan_amount');    	
    	$ELoanRefund = EmployeeLoan::where('date', '<=', $to)->where('type', 2)->sum('loan_amount');
		$EmployeeLoanAmount = $ELoan-$ELoanRefund;
    	$data['EmployeeLoanAmount'] = $EmployeeLoanAmount;


		$data['profileLoss'] = true;
		$data['title'] = 'Profit Loss Report';
		$data['selectedDate'] = $request->date;

    	return view('profitloss.index', $data);

    	// InventoryInOut::where('created_at', '<=', $to)->get();
    	// foreach ($Product as $p) {
    	// 	$price = ProductPriceHistory::where('product_id', $p->id)->where('change_date', '<=', $to)->orderBy('change_date', 'desc')->first();
    	// 	if($price){
    	// 		if($p->in_out_type == 1){
    	// 			$ProductAmount += $price*$p->qty;
    	// 		}else{
    	// 			$ProductAmount -= $price*$p->qty;
    	// 		}
    	// 	}
    	// }

    	


    }
}
