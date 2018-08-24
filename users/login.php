<?php
require_once "../includes/config.php";
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: ../index.php");
    exit;
}
 
// Define variables and initialize with empty values
$mail = $error =  "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$mail = $_POST["mail"];
	$pass = md5($_POST["pass"]);
	$query = "SELECT * FROM users WHERE user_mail='$mail'";
	$result = $link->query($query);
		if ($result->num_rows > 0) {
			if($row = $result->fetch_assoc()) {
				if($pass==$row["user_password"]){
					session_start();
					$_SESSION["loggedin"] = true;
					$_SESSION["id"] = $id;
					$_SESSION["mail"] = $mail;
					header("location: ../index.php");
				}else{
					$error = "Het wachtwoord dat u heeft ingevoerd blijkt fout te zijn.";
				}
			}
		}else{
			$error = "Geen gebruiker gevonden met die emailadres, wilt u misschien registreren?";
		}
}
?>
<?php include_once("../template/header.php")?>
	
	
<div class="container">
  <div class="row">
	 <div class="col-md-12">
		<h1 class="display-4">Inloggen</h1>
	 </div>
  </div>
  <div class="row">
	 <div class="col-md-12">
			<?php if($error!=""){ ?>
			<div class="alert alert-warning"><?php echo $error; ?></div>
			<?php } ?>
			<p>Vul uw email en wachtwoord in om in te loggen.</p>
		   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			  <div class="form-group">
				 <label>E-Mail</label>
				 <input type="text" name="mail" class="form-control" value="<?php echo $mail; ?>">
			  </div>
			  <div class="form-group">
				 <label>Wachtwoord</label>
				 <input type="password" name="pass" class="form-control">
			  </div>
			  <div class="form-group">
				 <input type="submit" class="btn btn-primary" value="Inloggen">
			  </div>
			  <p>Heeft u nog geen account? <a href="register.php">Registreer!</a>.</p>
			  <p>Wachtwoord vergeten? <a href="pass_reset.php">Reset uw wachtwoord</a>.</p>
		   </form>
	 </div>
  </div>
</div>
	
	
<?php include_once("../template/footer.php")?>