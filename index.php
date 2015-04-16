<!doctype html>
<html lang="en" ng-app="app">

<head>
    <meta charset="UTF-8">
    <title>Ajax Long Polling</title>
</head>

<body>
	<h1>Data will be injected here:</h1>
	<div id="inject"></div>
	
	<script type="text/javascript" src="jquery.js"></script>
	
	<script type="text/javascript">

		function pollMessage(){
			$.ajax({
				type: "GET",
				url: "server.php",
				dataType:"json",
				async: true, /* If set to non-async, browser shows page as "Loading.."*/
				cache: false,
				timeout:50000, /* Timeout in ms */

				success: function(data){ /* called when request to barge.php completes */			
					console.log(data)
					console.log(data.length)
					for (var i in data) {
						$('#inject').append('<p>' + data[i]['id'] + ':' + data[i]['message'] + '</p>'); /* Add response to a #inject*/
					}
					setTimeout(pollMessage, 1000 ); /* Request next message after 1 second (long poll)*/
				},
				error: function(XMLHttpRequest, textStatus, errorThrown){
					addmsg("error", textStatus + " (" + errorThrown + ")");
					setTimeout(pollMessage, 15000); /* Try again after 15 sec*/
				}
			});
		}
		
		$(function(){
			pollMessage();
		})
	
	</script>
</body>

</html>