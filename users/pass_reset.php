<?php
include_once("../template/header.php");
include_once("../includes/config.php");
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
{
header("location: ../index.php");
exit;
}
 
 $error = $email = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $user = $database->select("users", ['user_password','user_mail','user_id'], ["user_mail" => $_POST["email"]]);
	if (count($user) != 0)
		{
		$to      = 'gekkeabt2@gmail.com';
		$subject = 'the subject';
		$message = 'hello';
		$headers = 'From: webmaster@example.com' . "\r\n" .
			'Reply-To: webmaster@example.com' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);
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
		<h1 class="display-4">Wachtwoord resetten - Uitgeschakeld</h1>
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
        <p><b>Op dit moment nog uitgeschakeld, neem contact op met admin@admin.com voor een reset van je wachtwoord.</b></p>
        <p>Vul je email in en je nieuwe wachtwoord zal ernaartoe gestuurd worden. Tip: Check je spam folder als de mail niet in je inbox komt ;)</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label>E-mail</label>
                <input type="email" name="email" class="form-control" >
            </div>
            <div class="form-group">
                <input type="submit" disabled class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="login.php">Cancel</a>
            </div>
        </form>
	 </div>
  </div>
</div>
	
	
<?php include_once("../template/footer.php")?>