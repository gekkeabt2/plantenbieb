<?php 

include_once("../template/header.php");
include_once("../includes/config.php");

$title = $kind = $category = $zip = $cat_que = $kind_que = $max_distance = "";


if(isset($_GET["kind"])&&$_GET["kind"]!=""){
	$kind = $_GET["kind"];
}
if(isset($_GET["zip"])&&$_GET["zip"]!=""){
	$zip = preg_replace('/\s+/', '', $_GET["zip"]);
	$zip_val1 = getLnt($zip);
	
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
$sql_offers = "SELECT * FROM offers WHERE (offer_title like '%$title%' or offer_description like '%$title%')" . $cat_que . $kind_que;$result_offers = $link->query($sql_offers);

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
					  $sql = "SELECT * FROM categories WHERE cat_parent = 0 AND cat_visible = 1";$result = $link->query($sql);
						if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {			
								echo "<optgroup label='". $row['cat_name'] . "'>";
								$sql2 = "SELECT * FROM categories WHERE cat_parent = " . $row["cat_id"]; $result2 = $link->query($sql2);
								if ($result->num_rows > 0) {
									while($row2 = $result2->fetch_assoc()) {
									echo "<option " . (($row2["cat_id"]==$category)?'selected':"") ." value=" . $row2["cat_id"] . ">" . $row2["cat_name"] . "</option>";
								}}
								echo "</optgroup>";						
							}					
						} else {
							echo "0 Resultaten";
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
			if ($result_offers->num_rows > 0) {
				while($row_offers = $result_offers->fetch_assoc()) {
					
					$sql_user = "SELECT * FROM users WHERE user_id = ". $row_offers['offer_user'] ."";$result_user = $link->query($sql_user);
					
					if(isset($_GET["zip"])&&$_GET["zip"]!=""){while($row_users = $result_user->fetch_assoc()) {$zip_val2 = getLnt($row_users["user_zip"]); $distance = round(distance($zip_val1["lat"], $zip_val1["lng"], $zip_val2["lat"], $zip_val2["lng"], "K"),2);}}
					?>
					<a style="<?php if(isset($_GET["max_distance"])&&$_GET["max_distance"]!=""&&isset($distance)&&$distance!=""&&$distance>$_GET["max_distance"]){ ?>display:none<?php }?>" href="<?php echo "product_view.php?id=".$row_offers['offer_id']; ?>" class="list-group-item list-group-item-action flex-column align-items-start">
					<div class="row">
					<div class="col-9">
					  <div class="d-flex w-100 justify-content-between">
						<h5 class="mb-1"><?php echo $row_offers["offer_title"];?> </h5>
						<small><?php if(isset($distance)){echo $distance; ?> km hemelsbreed<?php } ?></small>  
					  </div>
					   <p class="mb-1"><?php $maxLength = 400; $offer_description = substr( $row_offers["offer_description"], 0, $maxLength);  echo $offer_description; ?></p>
					<?php $sql_user = "SELECT * FROM users WHERE user_id = ". $row_offers['offer_user'] ."";$result_user = $link->query($sql_user); ?>
					<small>Aangeboden door: <?php while($row_users = $result_user->fetch_assoc()) {echo $row_users["user_name"];}?></small>
					</div>
					<div class="col-md-auto">
					<?php if($row_offers["offer_picture"]==""){?>
						<img width="200px" src="<?php echo "../uploads/stock.jpg" ?>">
					
					<?php }else{?>
						<img width="200px" src="<?php echo "../uploads/" .$row_offers["offer_picture"] ?>">
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
  
  <?php include_once("../template/footer.php"); ?>