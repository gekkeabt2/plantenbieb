<?php 
// Include the base files //
include_once("../template/header.php");
include_once("../includes/config.php");
$title = $kind = $category = $zip = $cat_que = $kind_que = $max_distance = "";

// Check if data is filled in and eventuele create a query //
if(isset($_GET["kind"])&&$_GET["kind"]!=""){
	$kind = $_GET["kind"];
}
if(isset($_GET["zip"])&&$_GET["zip"]!=""){
	$zip = preg_replace('/\s+/', '', $_GET["zip"]);
}
if(isset($_GET["max_distance"])&&$_GET["max_distance"]!=""){
	$max_distance =$_GET["max_distance"];
}
if(isset($_GET["category"])&&$_GET["category"]!=""){
	$category = $_GET["category"];
}
if(isset($_GET["title"])&&$_GET["title"]!=""){
	$title = $_GET["title"];
}
if($category!=""){$cat_que = "AND offer_category = $category";};
if($kind!=""){$kind_que = " AND offer_kind = '$kind'";};

// Get the resulting offers from the database //
$result_offers = $pdo->query("SELECT * FROM offers WHERE (offer_title like '%$title%' or offer_description like '%$title%')" . $cat_que . $kind_que)->fetchAll();
?>
<h1 class="display-4">Aanbod</h1>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label>Soort</label><br>
                <select class="js-example-basic-single form-control" name="kind">
						<option value="" selected value="">Alles</option>
						<option <?php if (isset($kind) && $kind=="Stek") echo "selected";?> value="Stek">Stek</option>
						<option <?php if (isset($kind) && $kind=="Zaad") echo "selected";?> value="Zaad">Zaad</option>
						<option <?php if (isset($kind) && $kind=="Plant") echo "selected";?> value="Plant">Plant</option>
					</select>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label>Categorie</label><br>
                <select class="js-example-basic-single form-control" name="category">
						<option value="" selected value="">Alles</option>
					  <?php
						// Select the categories from database //
						$categories = $database->select('categories','*',["AND"=>["cat_parent[=]"=>0,"cat_visible[=]"=>1]]);
						// Loop the data! //
						foreach($categories as $data){
							echo "<optgroup label='". $data['cat_name'] . "'>";
							$sub_categories = $database->select('categories','*',["AND"=>["cat_parent[=]"=>$data['cat_id'],"cat_visible[=]"=>1]]);
							foreach($sub_categories as $data2){
							echo "<option " . (($data2["cat_id"]==$category)?'selected':"") ." value=" . $data2["cat_id"] . ">" . $data2["cat_name"] . "</option>";
							}
							echo "</optgroup>";		
						}
					  ?>
					</select>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label>Plantnaam/Omschrijving</label>
                <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label>Uw Postcode</label>
                <input type="text" name="zip" class="form-control" value="<?php echo $zip; ?>">
            </div>
        </div>

        <div class="col">
            <div class="form-group">
                <label>Max afstand (hemelsbreed)</label>
                <input type="text" name="max_distance" class="form-control" value="<?php echo $max_distance; ?>">
            </div>
        </div>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Zoeken">
        <input type="reset" class="btn btn-default" value="Reset">
    </div>
</form>

<div class="list-group">
    <?php
		if(count($result_offers)!=0){
			foreach($result_offers as $offer_data){
					// Get the user data //
					$user = $database->select("users", ['user_zip', 'user_name'], ["user_id" => $offer_data['offer_user']]);
					$user = $user[0];
					// Check if there is need to measure the distance between provider and customer //
					if(isset($zip)&&$zip!=""){
						$url = "https://nl.afstand.org/route.json?stops=".$user["user_zip"]."|".$zip;
						$result_string = file_get_contents($url);
						$distance = json_decode($result_string, true);
						$distance = $distance["distance"];
					}
					?>
        <a style="<?php if(isset($_GET[" max_distance "])&&$_GET["max_distance "]!=" "&&isset($distance)&&$distance!=" "&&$distance>$_GET["max_distance "]){ ?>display:none<?php }?>" href="<?php echo " listings/product_view?id=".$offer_data['offer_id']; ?>" class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="row">
                <div class="col-9">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">
                            <?php echo $offer_data["offer_title"];?> </h5>
                        <small><?php if(isset($distance)){echo $distance; ?> km hemelsbreed<?php } ?></small>
                    </div>
                    <p class="mb-1">
                        <?php $maxLength = 400; $offer_description = substr( $offer_data["offer_description"], 0, $maxLength);  echo $offer_description; ?>
                    </p>
                    <small>Aangeboden door: <?php echo $user["user_name"];?></small>
                </div>
                <div class="col-md-auto">
                    <?php if($offer_data["offer_picture"]==""){?>
                    <img width="200px" src="<?php echo " uploads/stock.jpg " ?>">
                    <?php }else{?>
                    <img width="200px" src="<?php echo " uploads/" .$offer_data["offer_picture"] ?>">
                    <?php } ?>
                </div>
            </div>
        </a>
        <?php			
		}}else{
				echo "Geen resultaten gevonden :(";
			}
		?>
</div>
  
  <?php include_once("../template/footer.php"); ?>