<?php
// Include the base files and check if user is logged in //
include_once("../template/header.php");
include_once("../includes/config.php");
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
{
header("location: ../index.php");
exit;
}
// Initialize PHPMailer //
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

 
$error = $email = $success = "";
// Processing form data when form is submitted //
if($_SERVER["REQUEST_METHOD"] == "POST"){
	// Check if user exists //
    $user = $database->select("users", ['user_name','user_password','user_mail','user_id'], ["user_mail" => $_POST["email"]]);
	if (count($user) != 0)
		{
		// Generate new password //
		$randomString = generateRandomString();
		$mdRandomString = md5($randomString);
		// Insert new password
		$data = $database->update("users", [
			"user_password" => $mdRandomString
		], [
			"user_mail[=]" => $_POST["email"]
		]);
		// Send mail to user //
		$mail = new PHPMailer(TRUE);
		try {
		   $mail->setFrom('noreply@ahmedsy301.301.axc.nl', 'PlantenBieb');
		   $mail->addAddress($user[0]['user_mail'], $user[0]['user_name']);
		   $mail->Subject = 'Wachtwoord vergeten';
		   $mail->isHTML(TRUE);
		   $mail->Body = "
		   <h2>PlantenBieb</h2>
		   <h5>Nieuwe wachtwoord</h5>
		   <p>
				Je nieuwe wachtwoord is: <b>" . $randomString . "</b><br>
				Gebruik deze wachtwoord om in te loggen en daarna op je profielpagina je wachtwoord aan te passen.<br><br>
				
				Groeten,<br>
				PlantenBieb!
		   
		   </p>   
		   ";
		   $mail->send();
		}catch (Exception $e){
		   echo $e->errorMessage();
		}catch (\Exception $e){
		   echo $e->getMessage();
		}
		$success = "Check je email voor je nieuwe wachtwoord." ;
		}
	  else
		{
		$error = "Geen gebruiker gevonden met die emailadres, wil je misschien registreren?";
		}
}
?>
    
	
	
	
	
<div class="container">
  <div class="row">
	 <div class="col-md-12">
		<h1 class="display-4">Wachtwoord resetten</h1>
	 </div>
  </div>
  <div class="row">
	 <div class="col-md-12">
	 			<?php
		if ($error != ""){ ?>
			<div class="alert alert-warning"><?php
	echo $error; ?></div>
			<?php } ?>
	 			<?php
		if ($success != ""){ ?>
			<div class="alert alert-success"><?php
	echo $success; ?></div>
			<?php } ?>
        <p>Vul je email in en je nieuwe wachtwoord zal ernaartoe gestuurd worden. Tip: Check je spam folder als de mail niet in je inbox komt ;)</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label>E-mail</label>
                <input type="email" name="email" class="form-control" >
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="users/login.php">Cancel</a>
            </div>
        </form>
	 </div>
  </div>
</div>
	
	
<?php include_once("../template/footer.php")?>