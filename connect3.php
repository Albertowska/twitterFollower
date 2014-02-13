<html>
	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta name="description" content="">
	    <meta name="author" content="">

	    <title>EasyFollow</title>

		<script src="jquery.min.js"></script>
	    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
		
	</head>
	<body>
		<div class="container" style="margin-top:1%">
			<div class="row">
		        <div class="span12">
		            <h1>Success!</h1>
		        </div>
			</div>
		</div>
	<script>
		alert("hola");
		$.ajax({
			url: 'connect2.php',
			type: 'get',
			data: '',
			dataType: 'json',
			success: function(data){
				alert("end");
			}
		});
	</script>
	</body>
</html>
