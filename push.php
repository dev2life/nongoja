<!DOCTYPE html>
<html>
    <head>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    </head>
<body>

	<h2>Push</h2>

	<button type="button">Start</button>&nbsp&nbsp
	<p id="iDate"></p>


	<script type="text/javascript">

	function AjaxCaller(){
		var xmlhttp=false;
		try{
			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		}catch(e){
			try{
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}catch(E){
				xmlhttp = false;
			}
		}

		if(!xmlhttp && typeof XMLHttpRequest!='undefined'){
			xmlhttp = new XMLHttpRequest();
		}
		return xmlhttp;
	}

    $(document).ready(function(){
        $("button").click(function(){
			alert('Start');
			callPage();
			//var myVar = setInterval(myTimer, 1000);
			setInterval(function () {callPage();}, 10000);			
			//alert('End'); 
		});
	});

	function callPage(){
		$.ajax({
			url: "lib.php",
			type: "get", //send it through get method
			data: { 
				token: '9999', 
				action: 'push', 
			},
			success: function(response) {
				//Do Something
				var iDate = document.getElementById('iDate');
				iDate.insertAdjacentHTML('afterbegin', Date()+'<br />');
			},
			error: function(xhr) {
				//Do Something to handle error
			}
		});
	}
	</script>
	</body>
</html> 


