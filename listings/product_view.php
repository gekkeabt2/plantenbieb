<?php 
include_once("../template/header.php");
include_once("../includes/config.php");
$id = $_GET["id"];
$offers = $database->select("offers", ['offer_amount','offer_date','offer_picture','offer_title','offer_id','offer_user','offer_category','offer_description','offer_kind'], ["offer_id" => $id]);
$offer_cat = $database->select("categories", ['cat_name'], ["cat_id" => $offers[0]["offer_category"]]);
$offer_user = $database->select("users", ['user_zip','user_id','user_name'], ["user_id" => $offers[0]["offer_user"]]);

$title = $offers[0]["offer_title"];
$kind = $offers[0]["offer_kind"];
$offer_id = $offers[0]["offer_id"];
$description = $offers[0]["offer_description"];
$date = $offers[0]["offer_date"];
$amount = $offers[0]["offer_amount"];
$picture = $offers[0]["offer_picture"];
$offer_user_id = $offers[0]["offer_user"];
$category = $offer_cat[0]["cat_name"];

$user = $offer_user[0]["user_name"];
$user_id = $offer_user[0]["user_id"];
$user_zip = $offer_user[0]["user_zip"];
?> 

  <div class="">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1 class="display-4"><?php echo $title; ?></h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <h4>Door: <a href="listings/public_profile?id=<?php echo $user_id; ?>"><?php echo $user; ?></a></h4>
                  <h6 class="text-muted"><?php echo $kind; ?> -&gt; <?php echo $category; ?></h6>
                  <p><b>Omschrijving</b><br><?php echo $description; ?></p>
                  <p><b>Hoeveelheid</b><br><?php echo $amount; ?></p>
                  <p><b>Geplaatst op</b><br><?php echo $date; ?></p>
                  <iframe src="http://maps.google.co.uk/maps?q=<?php echo $user_zip; ?>&amp;output=embed" width="100%" height="400"></iframe>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <img class="img-fluid d-block" src="<?php if($picture!=""){echo "uploads/" . $picture;}else{echo "uploads/stock.jpg";} ?>">
              <br>
              <?php if(isset($_SESSION["id"])){if($_SESSION["id"] != $offer_user_id){ ?><a class="btn btn-primary" href="../users/messages?id=<?php echo $offer_user_id; ?>">Contact opnemen </a><br><?php }}else{echo "<div class='alert alert-warning'>U dient ingelogd te zijn om contact op te kunnen nemen met de aanbieder.</div>";} ?><br>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  
  <?php include_once("../template/footer.php"); ?>