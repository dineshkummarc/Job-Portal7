<?php 
	require('PHPMailer/PHPMailerAutoload.php'); 
	require('credentials.php');

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>
<body>
<?php 
$conn = mysqli_connect("localhost","root","selin@1234","login_register");

if(isset($_POST['forgrt'])){
	
	$email = $_POST['email'];
		
		$select = "SELECT * FROM register WHERE email = '$email'";
		$result = mysqli_query($conn,$select);
		$data = mysqli_fetch_array($result);
		$url = 'http://'.$_SERVER['SERVER_NAME'].'/ip-mini-project/forget-password-recovery/changepass.php?id='.$data['id'].'&email='.$email;  // Set email format to HTML
	
		$output = '<div>Please click this link to change your password <br>'.$url.'</div>';

		if ($result == true) {

			$mail = new PHPMailer();
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'smtp.gmail.com';  					// Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = EMAIL;                 		// SMTP username
			$mail->Password = PASS;                           // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;                                    // TCP port to connect to

			$mail->setFrom(EMAIL, 'Localhost');
			$mail->addAddress($email, $data['name']);     // Add a recipient
	
			$mail->isHTML(true);

			$mail->Subject = 'Reset Password';
			$mail->Body    = $output;

			if(!$mail->send()) {
				echo 'Message could not be sent.';
				echo 'Mailer Error: ' . $mail->ErrorInfo;
			} else {
				$msg = '<div class="alert alert-success">Check your email for a link to reset your password.</div>';
			}
		
		}
}

?>

	<br><br><br><br>
	<div class="container">
		<?php if (isset($msg)) { echo $msg; } ?>
		<form action="" method="post">
			<h1>Forgot Your Password?</h1>
				<hr>
			<div class="col-md-12" style="width: 40%">
				
				<div class="form-group" >
					<label>Enter Email</label>
					<input class="form-control" type="email" name="email" placeholder="Enter Email">
				</div>
				
				<div class="form-group">
					<input class="btn btn-success pull-left" type="submit" name="forgrt" value="Submit">
					<a href="login.php" class="btn btn-warning pull-right">Log In</a>
				</div>
			</div>
			
		</form>
	</div>

</body>
</html>
