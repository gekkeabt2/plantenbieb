<?php
include_once ("../template/header.php");
include_once("../includes/config.php");
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
	{
	header("location: ../users/login");
	exit;
	}

// Define variables and initialize with empty values

$mail = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
	$mail = $_POST["mail"];
	$pass = md5($_POST["pass"]);
	$user = $database->select("users", ['user_password','user_mail','user_id'], ["user_mail" => $mail]);
	if (count($user) != 0)
		{
		if ($pass == str_replace(" ", "", $user[0]["user_password"]))
			{
			session_start();
			$_SESSION["loggedin"] = true;
			$_SESSION["id"] = $user[0]["user_id"];
			$_SESSION["mail"] = $user[0]["user_mail"];
			header("location: ../index.php");
			}
		  else
			{
			$error = "Het wachtwoord dat u heeft ingevoerd blijkt fout te zijn.";
			}
		}
	  else
		{
		$error = "Geen gebruiker gevonden met die emailadres, wilt u misschien registreren?";
		}
	}

 ?>
	
	
<div class="container">
  <div class="row">
	 <div class="col-md-12">
		<h1 class="display-4">Inloggen</h1>
	 </div>
  </div>
  <div class="row">
	 <div class="col-md-12">
			<?php
		if ($error != ""){ ?>
			<div class="alert alert-warning"><?php
	echo $error; ?></div>
			<?php } ?>
			<p>Vul uw email en wachtwoord in om in te loggen.</p>
		   <form action="<?php
echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			  <div class="form-group">
				 <label>E-Mail</label>
				 <input type="email" name="mail" class="form-control" value="<?php
echo $mail; ?>">
			  </div>
			  <div class="form-group">
				 <label>Wachtwoord</label>
				 <input type="password" name="pass" class="form-control">
			  </div>
			  <div class="form-group">
				 <input type="submit" class="btn btn-primary" value="Inloggen">
			  </div>
			  <p>Heeft u nog geen account? <a href="users/register.php">Registreer!</a>.</p>
			  <p>Wachtwoord vergeten? <a href="users/pass_reset.php">Reset uw wachtwoord</a>.</p>
		   </form>
	 </div>
  </div>
</div>
	
	
<?php
include_once ("../template/footer.php") ?>