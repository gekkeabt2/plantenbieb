<?php 
include_once("../template/header.php"); 
require_once "../includes/config.php";
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != true){
    header("location: /users/login.php");
    exit;
}
$error  = $success = $pass_que = "";
$sql_offers = "SELECT * FROM offers WHERE offer_user =". $_SESSION["id"];$result_offers = $link->query($sql_offers);
$sql_user = "SELECT * FROM users WHERE user_id = ". $_SESSION["id"] ."";$result_user = $link->query($sql_user);

if ($result_user->num_rows > 0) {
	while($row_user = $result_user->fetch_assoc()) {
		$mail = $row_user["user_mail"];
		$zip = $row_user["user_zip"];
		$bio = $row_user["user_bio"];	
	}
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$mail = $_POST["mail"];
	$zip = $_POST["zip"];
	$pass = $_POST["pass"];
	$pass2 = $_POST["pass2"];
	$bio = $_POST["bio"];
	$id = $_SESSION["id"];

	if($mail!=""&&$zip!=""){
		if((isset($pass)&&$pass!="")||(isset($pass2)&&$pass2!="")){
			if($pass==$pass2){
				$passs = md5($pass);
				$pass_que = " , user_password = '$passs'";
				$sql = "UPDATE users SET user_mail='$mail', user_zip = '$zip', user_bio = '$bio' ".$pass_que." WHERE user_id = $id";
				if (mysqli_query($link, $sql)) {
					$success = "Gegevens zijn met succes aangepast, u wordt nu uitgelogd.";
					session_destroy();
					header("location: /users/login.php");
				}else{
					$error = "Er is iets fout gegaan..." . mysqli_error($link);
				}
			}else{
				$error = "De ingevoerde wachtwoorden komen niet overeen.";
			}
		}else{
			$sql = "UPDATE users SET user_mail='$mail', user_zip = '$zip', user_bio = '$bio' ".$pass_que." WHERE user_id = $id";
			if (mysqli_query($link, $sql)) {
				$success = "Gegevens zijn met succes aangepast, u wordt nu uitgelogd.";
				session_destroy();
				header("location: /users/login.php");
			}else{
			$error = "Er is iets fout gegaan..." . mysqli_error($link);
			}
		}
		

		

		
	}else{
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
			
          <h1 class="">Ahmed</h1>	

		<?php if($error!=""){ ?>
		<div class="alert alert-warning"><?php echo $error; ?></div>
		<?php } ?>
		
		<?php if($success!=""){ ?>
		<div class="alert alert-success"><?php echo $success; ?></div>
		<?php } ?>		  
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"  enctype="multipart/form-data">
                <div class="form-group">
                  <label>Email address</label>
                  <input name="mail" type="email" class="form-control" placeholder="Enter email" value="<?php echo $mail ?>"> </div>
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
                <button type="submit" class="btn btn-primary">Save</button><br>
				<small>Na het wijzigen moet u opnieuw inloggen, dus onthoud uw nieuwe gegevens goed (email en wachtwoord).</small>
              </form>
            </div>
            <div class="col-md-6">
			<h1>Mijn aanbod</h1>
              
			  	  <div class="list-group">	
		<?php
			if ($result_offers->num_rows > 0) {
				while($row_offers = $result_offers->fetch_assoc()) {
					
					
					?>
					<a href="<?php echo "product_edit.php?id=".$row_offers['offer_id']; ?>" class="list-group-item list-group-item-action flex-column align-items-start">
					<div class="row">
					<div class="col-9">
					  <div class="d-flex w-100 justify-content-between">
						<h5 class="mb-1"><?php echo $row_offers["offer_title"];?> </h5>
						<small><?php if(isset($distance)){echo $distance; ?> km hemelsbreed<?php } ?></small>  
					  </div>
					   <p class="mb-1"><?php $maxLength = 50; $offer_description = substr( $row_offers["offer_description"], 0, $maxLength);  echo $offer_description; ?></p>
					<?php $sql_user = "SELECT * FROM users WHERE user_id = ". $row_offers['offer_user'] ."";$result_user = $link->query($sql_user); ?>
					</div>
					<div class="col-md-auto">
					<?php if($row_offers["offer_picture"]==""){?>
						<img width="75px" src="<?php echo "../uploads/stock.jpg" ?>">
					
					<?php }else{?>
						<img width="75px" src="<?php echo "../uploads/" .$row_offers["offer_picture"] ?>">
					<?php } ?>
					</div>
					</div>
				  </a>
		  
		<?php	}			
			} else {
				echo "0 Resultaten";
			}
		?>
	  </div>
			  
			  
			  </div>
          </div>
        </div>
      </div>

 <?php include_once("../template/footer.php"); ?>