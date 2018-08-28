<?php 
// Include the base files //
include_once("template/header.php"); 
require_once("includes/config.php"); 


// Function to get a list of the specified kind //
function getList($kind) {
	// Get the last 4 offers //
	$result_offers = $GLOBALS["pdo"]->query("SELECT * FROM offers WHERE offer_kind = '$kind' LIMIT 4")->fetchAll();
	// Show message when there are no offers //
	if(count($result_offers)=="0"){
		echo "Geen resultaten gevonden, wees de eerste die iets toevoegt!";
	}else{
	?>
	
	<div class="list-group">	
		<?php
			foreach($result_offers as $offer_data){
					// Get the user data //
					$user = $GLOBALS["database"]->select("users", ['user_zip', 'user_name'], ["user_id" => $offer_data['offer_user']]);
					$user = $user[0];
					?>
					<a href="<?php echo "listings/product_view?id=".$offer_data['offer_id']; ?>" class="list-group-item list-group-item-action flex-column align-items-start">
					<div class="row">
						<div class="col-9">
							<div class="d-flex w-100 justify-content-between">
								<h5 class="mb-1"><?php echo $offer_data["offer_title"];?> </h5>
							</div>
							<p class="mb-1"><?php $maxLength = 400; $offer_description = substr( $offer_data["offer_description"], 0, $maxLength);  echo $offer_description; ?></p>
							<small>Aangeboden door: <?php echo $user["user_name"];?></small>
						</div>
						<div class="col-md-auto">
							<?php if($offer_data["offer_picture"]==""){?>
							<img width="100px" src="<?php echo "uploads/stock.jpg" ?>">
							<?php }else{?>
							<img width="100px" src="<?php echo "uploads/" .$offer_data["offer_picture"] ?>">
							<?php } ?>
						</div>
					</div>
				  </a>
		<?php } ?>
	</div>
<?php }} ?>


<main role="main">
  <div class="jumbotron p-2">
    <div class="col-sm-8 mx-auto">
      <h1>Bij de PlantenBieb vind je het voor niets!
      </h1>
      <p>Door middel van deze website willen we de tussenpersoon tussen natuur en consument vervangen door een andere consument. Door jouw zaden/stekjes/planten aan te bieden die jij niet (meer) nodig hebt kan je een ander blij maken. Zo weet de afnemer
        waar die aan toe is en dat de zaden op natuurlijke wijze verkregen zijn. En ook jij kan natuurlijk kijken bij het aanbod wat er te vinden valt voor je tuin!
        <br>
        <br>De website werkt door middel van een "geven en nemen" policy: Als jij wat van iemand neemt word er van je verwacht dat je in de nabije toekomst ook iets anders aanbied. Zo bouw je een hoeveelheid aan punten op die de aanbieders (ook mensen
        zoals jij) van planten kunnen zien wanneer jij interesse toont.<br>
		
		
      </p>
    </div>
  </div>
</main>
<div class="">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="display-4">Recent geplaatst
        </h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <h1 class="">Stekjes
        </h1>
      </div>
    </div>
  </div>
</div>
<div class="m-2">
  <div class="container">
      <?php getList('Stek');?>
  </div>
</div>
<div class="">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="">Zaden
        </h1>
      </div>
    </div>
  </div>
</div>
<div class="m-2">
  <div class="container">
      <?php getList('Zaad');?>
  </div>
</div>
<div class="">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="">Hele Planten
        </h1>
      </div>
    </div>
  </div>
</div>
<div class="m-2">
  <div class="container">
      <?php getList('Plant');?>
  </div>
</div>


<?php include_once("template/footer.php")?>
