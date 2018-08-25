<?php 
include_once("template/header.php"); 
require_once("includes/config.php"); 
?>




    <main role="main">
      <div class="jumbotron p-2">
        <div class="col-sm-8 mx-auto">
          <h1>Bij de PlantenBieb vind je het voor niets!</h1>
          <p>Door middel van deze website willen we de tussenpersoon tussen natuur en consument vervangen door een andere consument. Door jouw zaden/stekjes/planten aan te bieden die jij niet (meer) nodig hebt kan je een ander blij maken. Zo weet de afnemer
            waar die aan toe is en dat de zaden op natuurlijke wijze verkregen zijn. En ook jij kan natuurlijk kijken bij het aanbod wat er te vinden valt voor je tuin!
            <br>
            <br>De website werkt door middel van een "geven en nemen" policy: Als jij wat van iemand neemt word er van je verwacht dat je in de nabije toekomst ook iets anders aanbied. Zo bouw je een hoeveelheid aan punten op die de aanbieders (ook mensen
            zoals jij) van planten kunnen zien wanneer jij interesse toont.</p>
        </div>
      </div>
    </main>
  <div class="">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1 class="display-4">Recent geplaatst</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <h1 class="">Stekjes</h1>
        </div>
      </div>
    </div>
  </div>
  <div class="m-2">
    <div class="container">
      <div class="row">
        <?php 
	  $sql_offers = "SELECT * FROM offers WHERE offer_kind = 'Stek' LIMIT 4";$result_offers = $link->query($sql_offers);
			if ($result_offers->num_rows > 0) {
				while($row_offers = $result_offers->fetch_assoc()) {
					$sql_user = "SELECT * FROM users WHERE user_id = ". $row_offers['offer_user'] ."";$result_user = $link->query($sql_user);
					
					$sql_cat = "SELECT * FROM categories WHERE cat_id = " . $row_offers["offer_category"]; $result_cat = $link->query($sql_cat);
					if ($result_cat->num_rows > 0) {
						while($row_cat = $result_cat->fetch_assoc()) {
						$category = $row_cat["cat_name"];
					}}
	  ?>
        <div class="col-3">
          <div class="card">
            <ul class="list-group list-group-flush">
              <li class="list-group-item"><h4><?php echo $row_offers["offer_title"]; ?></h4></li>
            <img class="card-img-top" src="<?php if($row_offers["offer_picture"]!=""){echo "uploads/".$row_offers["offer_picture"];}else{echo "uploads/stock.jpg";} ?>" alt="Card image cap">
              <li class="list-group-item"><?php echo $category; ?></li>
              <li class="list-group-item"><?php echo substr($row_offers["offer_description"],0,100); ?></li>
              <li class="list-group-item">Postcode: <?php while($row_users = $result_user->fetch_assoc()) {echo $row_users["user_zip"];}?></li>
            </ul>
            <div class="card-body">
              <a href="<?php echo "listings/product_view.php?id=".$row_offers["offer_id"]; ?>" class="card-link">Bekijk aanbod</a>
            </div>
          </div>
        </div>
		<?php
			}}else {
				echo "Geen resultaten, wees de eerste die iets toevoegt!";
			}
		?>
      </div>
    </div>
  </div>
  <div class="">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1 class="">Zaden</h1>
        </div>
      </div>
    </div>
  </div>
  <div class="m-2">
    <div class="container">
      <div class="row">
        <?php 
	  $sql_offers = "SELECT * FROM offers WHERE offer_kind = 'Zaad' LIMIT 4";$result_offers = $link->query($sql_offers);
			if ($result_offers->num_rows > 0) {
				while($row_offers = $result_offers->fetch_assoc()) {
					$sql_user = "SELECT * FROM users WHERE user_id = ". $row_offers['offer_user'] ."";$result_user = $link->query($sql_user);
					
					$sql_cat = "SELECT * FROM categories WHERE cat_id = " . $row_offers["offer_category"]; $result_cat = $link->query($sql_cat);
					if ($result_cat->num_rows > 0) {
						while($row_cat = $result_cat->fetch_assoc()) {
						$category = $row_cat["cat_name"];
					}}
	  ?>
        <div class="col-3">
          <div class="card">
            <ul class="list-group list-group-flush">
              <li class="list-group-item"><h4><?php echo $row_offers["offer_title"]; ?></h4></li>
            <img class="card-img-top" src="<?php if($row_offers["offer_picture"]!=""){echo "uploads/".$row_offers["offer_picture"];}else{echo "uploads/stock.jpg";} ?>" alt="Card image cap">
              <li class="list-group-item"><?php echo $category; ?></li>
              <li class="list-group-item"><?php echo substr($row_offers["offer_description"],0,100); ?></li>
              <li class="list-group-item">Postcode: <?php while($row_users = $result_user->fetch_assoc()) {echo $row_users["user_zip"];}?></li>
            </ul>
            <div class="card-body">
              <a href="<?php echo "listings/product_view.php?id=".$row_offers["offer_id"]; ?>" class="card-link">Bekijk aanbod</a>
            </div>
          </div>
        </div>
		<?php
			}}else {
				echo "Geen resultaten, wees de eerste die iets toevoegt!";
			}
		?>
      </div>
    </div>
  </div>
  <div class="">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1 class="">Hele Planten</h1>
        </div>
      </div>
    </div>
  </div>
  <div class="m-2">
    <div class="container">
      <div class="row">
                <?php 
	  $sql_offers = "SELECT * FROM offers WHERE offer_kind = 'Plant' LIMIT 4";$result_offers = $link->query($sql_offers);
			if ($result_offers->num_rows > 0) {
				while($row_offers = $result_offers->fetch_assoc()) {
					$sql_user = "SELECT * FROM users WHERE user_id = ". $row_offers['offer_user'] ."";$result_user = $link->query($sql_user);
					
					$sql_cat = "SELECT * FROM categories WHERE cat_id = " . $row_offers["offer_category"]; $result_cat = $link->query($sql_cat);
					if ($result_cat->num_rows > 0) {
						while($row_cat = $result_cat->fetch_assoc()) {
						$category = $row_cat["cat_name"];
					}}
	  ?>
        <div class="col-3">
          <div class="card">
            <ul class="list-group list-group-flush">
              <li class="list-group-item"><h4><?php echo $row_offers["offer_title"]; ?></h4></li>
            <img class="card-img-top" src="<?php if($row_offers["offer_picture"]!=""){echo "uploads/".$row_offers["offer_picture"];}else{echo "uploads/stock.jpg";} ?>" alt="Card image cap">
              <li class="list-group-item"><?php echo $category; ?></li>
              <li class="list-group-item"><?php echo substr($row_offers["offer_description"],0,100); ?></li>
              <li class="list-group-item">Postcode: <?php while($row_users = $result_user->fetch_assoc()) {echo $row_users["user_zip"];}?></li>
            </ul>
            <div class="card-body">
              <a href="<?php echo "listings/product_view.php?id=".$row_offers["offer_id"]; ?>" class="card-link">Bekijk aanbod</a>
            </div>
          </div>
        </div>
		<?php
			}}else {
				echo "Geen resultaten, wees de eerste die iets toevoegt!";
			}
		?>
      </div>
    </div>
  </div>
  
 
<?php include_once("template/footer.php")?>