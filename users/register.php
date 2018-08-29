<?php
// Include the base files and check if user is logged in //
include_once ("../template/header.php");
include_once("../includes/config.php");
// Initialize PHPMailer //
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Set the variables //
$name = $mail = $zip = $pass = $pass2 = $bio = $error = $success = "";

// Check if the form is POST //
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	// Set the variables //
	$name = $_POST["name"];
	$mail = $_POST["mail"];
	$zip = $_POST["zip"];
	$pass = $_POST["pass"];
	$pass2 = $_POST["pass2"];
	$bio = $_POST["bio"];
	
	// Check if the necessary variables aren't empty //
	if ($name != "" && $mail != "" && $zip != "" && $pass != "" && $pass2 != ""){
		// Check if user already exists //
		$user = $database->select("users", ['user_mail'], ["user_mail" => $mail]);
		if (count($user) != "0"){
			// Throw error //
			$error = "Er is al iemand ingeschreven met de email-adres die u heeft opgegeven.";
		}else{
			// Check if passwords correspond //
			if ($_POST["pass"] != $_POST["pass2"]){
			// Throw error //
			$error = "De ingevulde wachtwoorden komen niet overeen.";
			}else{
			// Insert the new user //
			$database->insert("users", ["user_name" => $name, "user_mail" => $mail, "user_zip" => $zip, "user_password" => md5($_POST["pass"]) , "user_points" => 0, "user_bio" => $bio]);
			$success = "Gefeliciteerd! Je kunt nu je account activeren met de mail die je ontvangen hebt. Tip: Check je spam folder als die niet in je inbox zit. ";
			$mail2 = $mail;
			$mail = new PHPMailer(TRUE);
			try {
			   $mail->setFrom('noreply@ahmedsy301.301.axc.nl', 'PlantenBieb');
			   $mail->addAddress($mail2, $name);
			   $mail->Subject = 'Account activeren';
			   $mail->isHTML(TRUE);
			   $mail->Body = "
			   <h2>PlantenBieb</h2>
			   <h5>Account activeren</h5>
			   <p>
					Klik op de link om je account te activeren: <b><a href='ahmedsy301.301.axc.nl/users/activate?key=" . $mail2 . "&rg=awdi42u8338rhd9@dha982dh9dhuahdwuiihdiwauhdaiuwiuhiwahduguaifawdlawhdiawudhjfawhdafhi'>Klik hier!</a></b><br><br>
					U kunt na het bezoeken van de link direct inloggen.<br><br>
					
					
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
			
			$name = $mail = $zip = $pass = $pass2 = $bio = "";
			}
		}
	}else{
		// Throw error //
		$error = "U heeft nog niet alle benodigde velden ingevuld.";
	}
}

?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h1 class="display-4">Registreren</h1>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
		<?php if ($error != "") { ?>
		<div class="alert alert-warning"><?php echo $error; ?></div>
		<?php } ?>
		<?php if ($success != "") { ?>
		<div class="alert alert-success"><?php echo $success; ?></div>
		<?php } ?>		
      <p>U kunt hier uw gegevens invullen om een account aan te maken.
      </p>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
          <label>Naam
          </label>
          <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
        </div>
        <div class="form-group">
          <label>Email
          </label>
          <input type="email" name="mail" class="form-control" value="<?php echo $mail; ?>">
        </div>
        <div class="form-group">
          <label>Postcode
          </label> 
          <small>Dit is niet uw exacte adres, maar uw buurt.
          </small>
          <input type="text" name="zip" class="form-control" value="<?php echo $zip; ?>">
        </div>
        <div class="form-group">
          <label>Wachtwoord
          </label>
          <input type="password" name="pass" class="form-control">
        </div>
        <div class="form-group">
          <label>Bevestig wachtwoord
          </label>
          <input type="password" name="pass2" class="form-control">
        </div>
        <div class="form-group">
          <label>Biografie
          </label> 
          <small>Optioneel en openbaar.
          </small>
          <textarea name="bio" class="form-control" placeholder="Hier kunt u iets over uzelf vertellen."><?php echo $bio; ?></textarea>
        </div>
        <div class="form-group">
          <input type="submit" class="btn btn-primary" value="Registreer">
          <input type="reset" class="btn btn-default" value="Reset">
        </div>
        <p>Heeft u al een account? 
          <a href="users/login.php">Inloggen
          </a>.
        </p>
      </form>
    </div>
  </div>
</div>
<?php
include_once ("../template/footer.php") ?>