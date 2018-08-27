<?php
include_once ("../template/header.php");
include_once("../includes/config.php");
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != true) {
	header("location: /users/login.php");
	exit;
}

$error = $success = $pass_que = "";
$offers = $database->select("offers", ['offer_title', 'offer_description', 'offer_picture', 'offer_id'], ["offer_user" => $_GET["id"]]);
$user = $database->select("users", ['user_mail', 'user_zip', 'user_bio', 'user_name','user_created_at'], ["user_id" => $_GET["id"]]);
$name = $user[0]["user_name"];
$mail = $user[0]["user_mail"];
$zip = $user[0]["user_zip"];
$bio = $user[0]["user_bio"];
$created = $user[0]["user_created_at"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$zip = $_POST["zip"];
	$pass = $_POST["pass"];
	$pass2 = $_POST["pass2"];
	$bio = $_POST["bio"];
	$id = $_SESSION["id"];
	if ($mail != "" && $zip != "") {
		if ((isset($pass) && $pass != "") || (isset($pass2) && $pass2 != "")) {
			if ($pass == $pass2) {
				$passs = md5($pass);
				$pass_que = " , user_password = '$passs'";
				$sql = "UPDATE users SET user_zip = '$zip', user_bio = '$bio' " . $pass_que . " WHERE user_id = $id";
				if (mysqli_query($link, $sql)) {
					$success = "Gegevens zijn met succes aangepast, u wordt nu uitgelogd.";
					session_destroy();
					header("location: /users/login.php");
				}
				else {
					$error = "Er is iets fout gegaan..." . mysqli_error($link);
				}
			}
			else {
				$error = "De ingevoerde wachtwoorden komen niet overeen.";
			}
		}
		else {
			$sql = "UPDATE users SET user_zip = '$zip', user_bio = '$bio' " . $pass_que . " WHERE user_id = $id";
			if (mysqli_query($link, $sql)) {
				$success = "Gegevens zijn met succes aangepast.";
			}
			else {
				$error = "Er is iets fout gegaan..." . mysqli_error($link);
			}
		}
	}
	else {
		$error = "U heeft nog niet alle benodigde velden ingevuld.";
	}
}

?>

      <div class="row">
        <div class="col-md-12">
          <h1 class="display-4">Publieke Profiel</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-6">
			
          <h1 class=""><?php echo $name; ?></h1>	

              <div class="card">
                <div class="card-body">
		<?php
if ($error != "") { ?>
		<div class="alert alert-warning"><?php
	echo $error; ?></div>
		<?php
} ?>
		
		<?php

if ($success != "") { ?>
		<div class="alert alert-success"><?php
	echo $success; ?></div>
		<?php
} ?>		  
              <form action="<?php
echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"  enctype="multipart/form-data">
                <h4>Email address</h4>
                  <?php echo $mail ?><br><br>
				<h4>Postcode</h4>
                 <?php echo $zip ?><br><br>
                  <h4>Profielbeschrijving</h4>
                 <?php echo $bio ?><br><br>
                  <h4>Aangemeld op</h4>
                 <?php echo $created ?>
            </div>
            </div>
            </div>
			
			
			
            <div class="col-md-6">
			<h1>Aanbod</h1>
              
			  	  <div class="list-group">	
<?php
if (count($offers) != 0) {
	foreach($offers as $data) { ?>
					<a href="<?php
		echo "product_view.php?id=" . $data['offer_id']; ?>" class="list-group-item list-group-item-action flex-column align-items-start">
					<div class="row">
					<div class="col-9">
					  <div class="d-flex w-100 justify-content-between">
						<h5 class="mb-1"><?php
		echo $data["offer_title"]; ?> </h5>
					  </div>
					   <p class="mb-1"><?php
		$maxLength = 50;
		$offer_description = substr($data["offer_description"], 0, $maxLength);
		echo $offer_description; ?></p>
					</div>
					<div class="col-md-auto">
					<?php
		if ($data["offer_picture"] == "") { ?>
						<img width="75px" src="<?php
			echo "../uploads/stock.jpg" ?>">
					
					<?php
		}
		else { ?>
						<img width="75px" src="<?php
			echo "../uploads/" . $data["offer_picture"] ?>">
					<?php
		} ?>
					</div>
					</div>
				  </a>
		  
		<?php
	}
}
else {
	echo "U heeft nog geen aanbod, klik op het plusje bij de zoekbalk om uw eerste aanbod te plaatsen!";
}

?>
	  </div>
			  
			  
			  </div>
          </div>
        </div>
      </div>

 <?php
include_once ("../template/footer.php");
 ?>