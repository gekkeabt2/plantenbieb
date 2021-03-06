<?php
// Include the base files and check if user is logged in //
include_once ("../template/header.php");
include_once("../includes/config.php");
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != true) {
	header("location: ../users/login");
	exit;
}

// Set the variables //
$error = $success = $pass_que = "";
$offers = $database->select("offers", ['offer_title', 'offer_description', 'offer_picture', 'offer_id'], ["offer_user" => $_SESSION["id"]]);
$user = $database->select("users", ['user_mail', 'user_zip', 'user_bio', 'user_name'], ["user_id" => $_SESSION["id"]]);
$name = $user[0]["user_name"];
$mail = $user[0]["user_mail"];
$zip = $user[0]["user_zip"];
$bio = $user[0]["user_bio"];


// Check if the user wants to change something //
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Get the new values //
	$zip = $_POST["zip"];
	$pass = $_POST["pass"];
	$pass2 = $_POST["pass2"];
	$bio = $_POST["bio"];
	$id = $_SESSION["id"];
	// Check if the values are filled in //
	if ($mail != "" && $zip != "") {
		// Check if the user wants to change the password //
		if ((isset($pass) && $pass != "") || (isset($pass2) && $pass2 != "")) {
			// Check if the passwords correspond //
			if ($pass == $pass2) {
				// Encrypt pass and update database //
				$passs = md5($pass);
				$data = $database->update("users", [
					"user_zip" => $zip,
					"user_bio" => $bio,
					"user_password" => $passs,
				], [
					"user_id[=]" => $id
				]);
				$success = "Gegevens zijn met succes aangepast.";
			}
			else {
				// Throw error //
				$error = "De ingevoerde wachtwoorden komen niet overeen.";
			}
		}else {
				// Update database //
				$data = $database->update("users", [
					"user_zip" => $zip,
					"user_bio" => $bio
				], [
					"user_id[=]" => $id
				]);
				$success = "Gegevens zijn met succes aangepast.";
		}
	}
	else {
		// Throw error //
		$error = "U heeft nog niet alle benodigde velden ingevuld.";
	}
}

?>

<div class="row">
	<div class="col-md-12">
		<h1 class="display-4">Mijn Profiel</h1>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-6">

				<h1 class=""><?php echo $name; ?></h1>	

				<?php if ($error != "") { ?>
				<div class="alert alert-warning"><?php echo $error; ?></div>
				<?php } ?>
				<?php if ($success != "") { ?>
				<div class="alert alert-success"><?php echo $success; ?></div>
				<?php } ?>		
				
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"  enctype="multipart/form-data">
					<div class="form-group">
					  <label>Email address</label>
					  <input name="mail" disabled type="email" class="form-control" placeholder="Enter email" value="<?php echo $mail ?>"> </div>
					<div class="form-group">
					  <label>Wachtwoord</label>
					  <input name="pass" type="password" class="form-control" placeholder="Password"> </div>
					<div class="form-group">
					  <label>Herhaal uw Wachtwoord</label>
					  <input name="pass2" type="password" class="form-control" placeholder="Password"> </div>
					<div class="form-group">
					  <label>Postcode</label>
					  <input name="zip" type="text" class="form-control" placeholder="Postcode" value="<?php echo $zip ?>"> </div>
					<div class="form-group">
					  <label>Profielbeschrijving</label>
					  <textarea class="form-control" placeholder="Postcode" name="bio"><?php echo $bio ?></textarea>
					</div>
					<button type="submit" class="btn btn-primary">Opslaan</button>
				</form>
			</div>
			
			
			<div class="col-md-6">
			<h1>Mijn aanbod</h1>
				<div class="list-group">	
					<?php
					if (count($offers) != 0) {
						foreach($offers as $data) { ?>
							<a href="<?php echo "users/product_edit.php?id=" . $data['offer_id']; ?>" class="list-group-item list-group-item-action flex-column align-items-start">
								<div class="row">
									<div class="col-9">
										<div class="d-flex w-100 justify-content-between">
										<h5 class="mb-1"><?php echo $data["offer_title"]; ?> </h5>
										</div>
										<p class="mb-1">
											<?php $maxLength = 50; $offer_description = substr($data["offer_description"], 0, $maxLength);echo $offer_description; ?>
										</p>
									</div>
									<div class="col-md-auto">
										<?php if ($data["offer_picture"] == "") { ?>
										<img width="75px" src="<?php echo "uploads/stock.jpg" ?>">
										<?php }else { ?>
										<img width="75px" src="<?php echo "uploads/" . $data["offer_picture"] ?>">
										<?php } ?>
									</div>
								</div>
							</a>

					<?php 
					}}else {
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