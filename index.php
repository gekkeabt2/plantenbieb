<?php 
include_once("template/header.php"); 
require_once("includes/config.php"); 
// Get a list of the specified kind //
function getList($kind) {
	$offers = $GLOBALS['database']->select("offers", ['offer_picture','offer_title','offer_id','offer_user','offer_category','offer_description'], ["offer_kind" => $kind,'LIMIT' => 3]);
	if(count($offers)=="0"){
	echo "Geen resultaten gevonden, wees de eerste die iets toevoegt!";
	}else{
	foreach($offers as $data)
	{
	$offer_cat = $GLOBALS['database']->select("categories", ['cat_name'], ["cat_id" => $data["offer_category"]]);
	$offer_user = $GLOBALS['database']->select("users", ['user_zip'], ["user_id" => $data["offer_user"]]);
?>
<div class="col-4">
  <div class="card">
    <ul class="list-group list-group-flush">
      <li class="list-group-item">
        <h4>
          <?php echo $data["offer_title"]; ?>
        </h4>
      </li>
      <img class="card-img-top" src="<?php if($data["offer_picture"]!=""){echo "uploads/".$data["offer_picture"];}else{echo "uploads/stock.jpg";} ?>" alt="Card image cap">
      <li class="list-group-item">
        <?php echo $offer_cat[0]["cat_name"] ?>
      </li>
      <li class="list-group-item">
        <?php echo substr($data["offer_description"],0,100); ?>
      </li>
      <li class="list-group-item">Postcode: 
        <?php echo $offer_user[0]["user_zip"];?>
      </li>
    </ul>
    <div class="card-body">
      <a href="<?php echo "listings/product_view.php?id=".$data["offer_id"]; ?>" class="card-link">Bekijk aanbod
      </a>
    </div>
  </div>
</div>
<?php
}}
}
?>


<main role="main">
  <div class="jumbotron p-2">
    <div class="col-sm-8 mx-auto">
      <h1>Bij de PlantenBieb vind je het voor niets!
      </h1>
      <p>Door middel van deze website willen we de tussenpersoon tussen natuur en consument vervangen door een andere consument. Door jouw zaden/stekjes/planten aan te bieden die jij niet (meer) nodig hebt kan je een ander blij maken. Zo weet de afnemer
        waar die aan toe is en dat de zaden op natuurlijke wijze verkregen zijn. En ook jij kan natuurlijk kijken bij het aanbod wat er te vinden valt voor je tuin!
        <br>
        <br>De website werkt door middel van een "geven en nemen" policy: Als jij wat van iemand neemt word er van je verwacht dat je in de nabije toekomst ook iets anders aanbied. Zo bouw je een hoeveelheid aan punten op die de aanbieders (ook mensen
        zoals jij) van planten kunnen zien wanneer jij interesse toont.
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
    <div class="row">
      <?php getList('Stek');?>
    </div>
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
    <div class="row">
      <?php getList('Zaad');?>
    </div>
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
    <div class="row">
      <?php getList('Plant');?>
    </div>
  </div>
</div>


<?php include_once("template/footer.php")?>
