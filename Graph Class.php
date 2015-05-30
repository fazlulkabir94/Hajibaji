 <?php
class Node
{
	public $edge;
	public function __construct()
	{
		$this->edge=array();
	}
	public function init_array()
	{
		for ($i=0; $i<=3; $i++) { 
			for ($j=0;$j<=3; $j++) { 
				$this->edge[$i][$j]=0;
			}
		}
	}
	public function Add_edge($u,$v,$val)
	{
		$this->edge[$u][$v]=$val;
	}
	public function store()
	{
		$this->Add_edge(0,1,1);
		$this->Add_edge(0,2,3);
		$this->Add_edge(2,3,4);
		$this->Add_edge(3,1,5);
	}
	public function show()
	{
		$this->store();
		for ($i=0; $i<=3; $i++) { 
			for ($j=0;$j<=3; $j++) { 
				printf("%d %d %d",$i,$j,$this->edge[$i][$j]);
				printf("<br/>");
			}
		}
	}
}
$N=new Node();
$N->init_array();
$N->show();
?> 
