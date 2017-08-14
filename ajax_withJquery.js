$(document).ready(function() {
	$('#bt').hover(function() {
			$.getJSON('me.json',function(textStatus) {
			var data=Array();
			flag=false;
				for (var i = 0; i < textStatus.name.length; i++) {
					data.push(textStatus.name[i]);
				}
				for (var i = 0; i < data.length; i++) {
					if (data[i]=='shohag') {
						$('.test').text(data[i]);
						flag=true;
						break;
					}
				}
				if (!flag) {
					$('.test').addClass('anika').text('your data not matching');
				}
		});
	}, function() {
		$('.test').text('this is my first web page');
	});
});
/*
{
"name":["Jara ali","shohag","kabir"],
"age" : "67",
"sex": "female"
}
this is me.json file which is store in a server
*/
