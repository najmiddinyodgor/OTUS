<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Online brackets checker</title>
</head>
<body>
	<h1>Check Brackets!!!</h1>
	<form action="index.php" method="POST">
		<input type="text" id="input" placeholder="Enter your text here" name="text" required />
		<button type="submit" name="submit">Submit</button>
	</form>
	<p class="result">
		<?php
			require "./vendor/autoload.php";
			require "./config.php";

			if(isset($_POST["submit"])) {
				$text = trim($_POST['text']);
				$socket = new App\Socket($host, $port, true);
				$socket->connect();
				$socket->write($text);
				
				$reply = $socket->read();
			}

			echo $reply;
		?>
	</p>
</body>
</html>