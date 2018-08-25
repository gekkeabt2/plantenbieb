<?php
require_once "../includes/config.php";
$name = $mail = $zip = $pass = $pass2 = $bio = $error = $success= "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	$name = $_POST["name"];
	$mail = $_POST["mail"];
	$zip = $_POST["zip"];
	$pass = $_POST["pass"];
	$pass2 = $_POST["pass2"];
	$bio = $_POST["bio"];

	if($name!=""&&$mail!=""&&$zip!=""&&$pass!=""&&$pass2!=""){
		$query = "SELECT * FROM users WHERE user_mail='$mail'";
		$result = $link->query($query);

        if($result->num_rows > 0) {
				$error = "Er is al iemand ingeschreven met de email-adres die u heeft opgegeven.";
        }else{
			if($_POST["pass"]!=$_POST["pass2"]){
				$error = "De ingevulde wachtwoorden komen niet overeen.";
			}else{
				$sql = "INSERT INTO users (user_name, user_mail, user_zip, user_password,user_points,user_bio)
				VALUES (' $name', '$mail', '$zip',' " . md5($_POST['pass']) . "','0','$bio')";

				if ($link->query($sql) === TRUE) {
					$success = "Gefeliciteerd! U kunt nu inloggen via de <a href='login.php'>inlog pagina.</a>";
					$name = $mail = $zip = $pass = $pass2 = $bio = "";
				} else {
					echo "Error: " . $sql . "<br>" . $link->error;
				}
			}	
		}
	}else{
		$error = "U heeft nog niet alle benodigde velden ingevuld.";
	}
}
?>
<?php include_once("../template/header.php")?>
    

<div class="container">
  <div class="row">
	 <div class="col-md-12">
		<h1 class="display-4">Registreren</h1>
	 </div>
  </div>
  <div class="row">
	 <div class="col-md-12">
		<?php if($error!=""){ ?>
		<div class="alert alert-warning"><?php echo $error; ?></div>
		<?php } ?>
		<?php if($success!=""){ ?>
		<div class="alert alert-success"><?php echo $success; ?></div>
		<?php } ?>
		<p>U kunt hier uw gegevens invullen om een account aan te maken.</p>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		   <div class="form-group">
			  <label>Naam</label>
			  <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
		   </div>
		   <div class="form-group">
			  <label>Email</label>
			  <input type="email" name="mail" class="form-control" value="<?php echo $mail; ?>">
		   </div>
		   <div class="form-group">
			  <label>Postcode</label> <small>Dit is niet uw exacte adres, maar uw buurt.</small>
			  <input type="text" name="zip" class="form-control" value="<?php echo $zip; ?>">
		   </div>
		   <div class="form-group">
			  <label>Wachtwoord</label>
			  <input type="password" name="pass" class="form-control">
		   </div>
		   <div class="form-group">
			  <label>Bevestig wachtwoord</label>
			  <input type="password" name="pass2" class="form-control">
		   </div>
		   <div class="form-group">
			  <label>Biografie</label> <small>Optioneel en openbaar.</small>
			  <textarea name="bio" class="form-control" placeholder="Hier kunt u iets over uzelf vertellen."><?php echo $bio; ?></textarea>
		   </div>
		   <div class="form-group">
			  <input type="submit" class="btn btn-primary" value="Registreer">
			  <input type="reset" class="btn btn-default" value="Reset">
		   </div>
		   <p>Heeft u al een account? <a href="login.php">Inloggen</a>.</p>
		</form>
	 </div>
  </div>
</div>
	
	
<?php include_once("../template/footer.php")?>