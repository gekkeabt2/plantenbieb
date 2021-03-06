<?php 
// Include the base files and check if user is logged in //
include_once("../template/header.php");
include_once("../includes/config.php");
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != true){
	header("location: ../users/login");
    exit;
}

// Set the variables //
$title = $kind = $category = $description = $amount = $picture = $error = $success = "";

// Get the information of the offer //
$offers = $database->select("offers", ['offer_amount','offer_title', 'offer_description', 'offer_picture', 'offer_id','offer_kind','offer_category'], ["AND"=>["offer_id[=]"=>$_GET["id"],"offer_user[=]"=>$_SESSION["id"]]]);
$title = $offers[0]["offer_title"];
$category = $offers[0]["offer_category"];
$kind = $offers[0]["offer_kind"];	
$amount = $offers[0]["offer_amount"];	
$description = $offers[0]["offer_description"];	
$picture = $offers[0]["offer_picture"];	



// Check if the POST is set to be deleted //
if(isset($_POST["submit"])&&$_POST["submit"]=="Verwijderen"){
	// Run the query to delete the offer //
	$database->delete("offers", ["offer_id" => $_GET["id"]]);
	// Delete the image //
	unlink("../uploads/".$picture);
	// Show succes/Redirect the user //
	$success = "Gefeliciteerd! Uw aanbod is met success verwijderd!";
	header("location: ../users/profile.php");
}else{



// Check if the offer has to be updated //
if($_SERVER["REQUEST_METHOD"] == "POST"){
	// Get the new data //
	$title = $_POST['title']; 
	if(isset($_POST["kind"])) $kind = $_POST['kind']; 
	if(isset($_POST["category"])) $category = $_POST['category']; 
	$description = $_POST['description']; 
	$amount = $_POST['amount']; 
	$user = $_SESSION["id"];
	
	// Image upload
	if($_FILES['fileToUpload']['name'] == ""){
	}else{		
	$picture = $randomname = basename(generateRandomString().$_FILES["fileToUpload"]["name"]);
		
		$target_dir = "../uploads/";
		$target_file = $target_dir . $randomname ;
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				//echo "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				//echo "File is not an image.";
				$uploadOk = 0;
			}
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			//echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				//echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			} else {
				//echo "Sorry, there was an error uploading your file.";
			}
		}
	}
	
	// Check if the necessary fields are filled in //
	if($title==""||$kind==""||$category==""||$description==""||$amount==""){
		// Throw error //
		$error = "U heeft zo te zien nog niet alle velden ingevuld/geselecteerd.";
	}else{
		// Update the database //
		$data = $database->update("offers", [
			"offer_title" => $title,
			"offer_kind" => $kind,
			"offer_category" => $category,
			"offer_description" => $description,
			"offer_amount" => $amount,
			"offer_picture" => $picture
		], [
			"offer_id[=]" => $_GET['id']
		]);
		// Show success! //
		$success = "Gefeliciteerd! Uw aanbod is met success aangepast!";
	}
	
}
}
?> 


<h1 class="display-4">Bewerk aanbod</h1>

<?php if($error!=""){ ?>
<div class="alert alert-warning"><?php echo $error; ?></div>
<?php } ?>
<?php if($success!=""){ ?>
<div class="alert alert-success"><?php echo $success; ?></div>
<?php } ?>


<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?id=".$_GET["id"]); ?>" method="post"  enctype="multipart/form-data">
	<div class="form-group">
	<label>Plantnaam</label>
	<input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
	</div>
	<div class="row">
		<div class="col">
			<div class="form-group">
				<label>Soort</label><br>
				<select class="js-example-basic-single form-control" name="kind">
					<option value="" selected disabled hidden value="">Maak een keuze</option>
					<option <?php if (isset($kind) && $kind=="Stek") echo "selected";?> value="Stek">Stek</option>
					<option <?php if (isset($kind) && $kind=="Zaad") echo "selected";?> value="Zaad">Zaad</option>
					<option <?php if (isset($kind) && $kind=="Plant") echo "selected";?> value="Plant">Plant</option>
				</select> 
			</div>

			<div class="form-group">
				<label>Omschrijving van uw aanbod (max 3000 karakters)</label><br>
				<textarea style="height:300px" class="form-control" name="description" maxlength="3000"><?php echo $description; ?></textarea>
			</div>
		</div>
		<div class="col">
			<div class="form-group">
				<label>Categorie</label><br>
				<select class="js-example-basic-single form-control" name="category">
					<option value="" selected disabled hidden>Maak een keuze</option>
					<?php
					// Get a list of the categories //
					$categories = $database->select('categories','*',["AND"=>["cat_parent[=]"=>0,"cat_visible[=]"=>1]]);
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
			<div class="form-group">
				<label>Beschikbare hoeveelheid</label>
				<input type="text" name="amount" class="form-control" value="<?php echo $amount; ?>">
			</div>  
			<div class="form-group">
				<label>Foto</label>
				<input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
				<br><img id="image_upload_preview" src="<?php if($picture!=""){echo "uploads/" . $picture;}else{ echo "http://placehold.it/200x200";} ?>" alt="your image"  width="200px"/>
			</div>
		</div>
	</div>
	<div class="form-group">
		<input type="submit" name="submit" class="btn btn-primary" value="Publiceren">
		<input type="submit" name="submit" class="btn btn-danger" value="Verwijderen" onclick="return confirm('Weet u zeker dat u dit wilt verwijderen?');">
	</div>
</form>


<?php include_once("../template/footer.php"); ?>

<script>
function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			$('#image_upload_preview').attr('src', e.target.result);
		}

		reader.readAsDataURL(input.files[0]);
	}
}

$("#fileToUpload").change(function () {
	readURL(this);
});

</script>
 