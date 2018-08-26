<?php 
include_once("../template/header.php"); 
include_once("../includes/config.php"); 
$id = $_GET["id"];

$sql = "SELECT * FROM offers WHERE offer_id = $id";$result = $link->query($sql);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {			
		$title = $row["offer_title"];
		$sql_user = "SELECT * FROM users WHERE user_id = ". $row['offer_user'] ."";$result_user = $link->query($sql_user);
		while($row_users = $result_user->fetch_assoc()) {$user = $row_users["user_name"];$user_id = $row_users["user_id"];$user_zip = $row_users["user_zip"];}
		$kind = $row["offer_kind"];
		$description = $row["offer_description"];
		$date = $row["offer_date"];
		$amount = $row["offer_amount"];
		$picture = $row["offer_picture"];
		$sql2 = "SELECT * FROM categories WHERE cat_id = " . $row["offer_category"]; $result2 = $link->query($sql2);
		if ($result->num_rows > 0) {
			while($row2 = $result2->fetch_assoc()) {
			$category = $row2["cat_name"];
		}}					
	}					
} else {
	echo "0 results";
}

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
                  <h4>Door: <a href="public_profile.php?id=<?php echo $user_id; ?>"><?php echo $user; ?></a></h4>
                  <h6 class="text-muted"><?php echo $kind; ?> -&gt; <?php echo $category; ?></h6>
                  <p><b>Omschrijving</b><br><?php echo $description; ?></p>
                  <p><b>Hoeveelheid</b><br><?php echo $amount; ?></p>
                  <p><b>Geplaatst op</b><br><?php echo $date; ?></p>
                  <iframe src="http://maps.google.co.uk/maps?q=<?php echo $user_zip; ?>&amp;output=embed" width="100%" height="400"></iframe>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <img class="img-fluid d-block" src="<?php if($picture!=""){echo "../uploads/" . $picture;}else{echo "../uploads/stock.jpg";} ?>">
              <br>
              <a class="btn btn-primary" href="public_profile.php?id=<?php echo $user_id; ?>">Contact opnemen </a><br><br>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  
  <?php include_once("../template/footer.php"); ?>