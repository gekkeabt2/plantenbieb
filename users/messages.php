<?php
// Include the base files and check if user is logged in //
include_once "../template/header.php";
include_once("../includes/config.php");
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
}
else {
	header("location: ../users/login");
    exit;
}
// Initialize PHPMailer //
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Set the variables //
$error = $succes = $disabled = $messages = $error2 = $user_to_id = "";

//// Get the list of conversations the user has and eventually make a new conversation if none exists ////
$user_from_id = $_SESSION["id"];
// Check if there is a desire to contact another user //
if (isset($_GET["id"]) && $_GET["id"] != "") {
    $user_to_id = $_GET["id"];
	// Get data from the conversation with the user //
    $user = $database->select("users", ['user_id', 'user_mail', 'user_zip', 'user_bio', 'user_name', 'user_created_at'], ["user_id" => $user_to_id]);
    $messages_list = $pdo->query("SELECT * FROM conversations WHERE (conv_u1 = $user_from_id AND conv_u2 = $user_to_id) OR (conv_u1 = $user_to_id AND conv_u2 = $user_from_id)")->fetchAll();
	// Check if the user exists //
	if (count($user) != 0) {
		// Check if conversation already exists //
        if (count($messages_list) != 0) {
        }
        else {
			// Check if the user wants to talk to him-/herself //
            if ($user_to_id == $_SESSION["id"]) {
				// Throw error //
                $error = "Je kan geen berichten naar jezelf sturen helaas.";
                $disabled = "disabled";
            }
            else {
				// Create a new conversation if none exists //
                $database->insert("conversations", ["conv_u1" => $user_to_id, "conv_u2" => $user_from_id]);
            }
        }
    }
    else {
		// Throw error //
        $error = "Geen gebruiker gevonden waar u mee wilt praten.";
    }
}
// Get the conversation list //
$messages_list = $pdo->query("SELECT * FROM conversations WHERE (conv_u1 = $user_from_id OR conv_u2 = $user_from_id)")->fetchAll();



//// Get the messages sent in the chat ////
// Check if there is a desire to contact another user //
if (isset($_GET["id"]) && $_GET["id"] != "") {
	// Get the data of the other user //
    $user = $database->select("users", ['user_id', 'user_mail', 'user_zip', 'user_bio', 'user_name', 'user_created_at'], ["user_id" => $_GET["id"]]);
    // Check if user exists //
	if (count($user) != 0) {
		// Assign the values to the variables //
        $user_to_name = $user[0]["user_name"];
        $user_to_id = $user[0]["user_id"];
        $user_to_mail = $user[0]["user_mail"];
		// Check if the user wants to talk to him-/herself //
        if ($user_to_id == $user_from_id) {
			// Throw error //
            $error = "Je kan geen berichten naar jezelf sturen helaas.";
            $disabled = "disabled";
        }
		// Check if a new message is sent with POST //
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $input_text = $_POST["input_text"];
			// Insert the message into the database //
            $database->insert("messages", ["message_offer" => $_GET["id"], "message_from" => $user_from_id, "message_to" => $user_to_id, "message_content" => $_POST["input_text"]]);
            
			
			// Send mail to user //
			$mail = new PHPMailer(TRUE);
			try {
			   $mail->setFrom('noreply@ahmedsy301.301.axc.nl', 'PlantenBieb');
			   $mail->addAddress($user_to_mail, $user_to_name);
			   $mail->Subject = 'Nieuw bericht op PlantenBieb';
			   $mail->isHTML(TRUE);
			   $mail->Body = "
			   <h2>PlantenBieb</h2>
			   <h5>Nieuw bericht op PlantenBieb</h5>
			   <p>
					Er is zojuist een nieuw bericht gestuurd naar jou. Log in op plantenbieb.nl om te reageren.
					<br><br>
					<b>Bericht van</b>: ".$_SESSION["name"]."<br>
					<b>Bericht</b>: ". $input_text."
					
					<br><br>
					======================
					<br><br>
					Groeten,<br>
					PlantenBieb!
			   
			   </p>   
			   ";
			   $mail->send();
			}catch (Exception $e){
			   echo $e->errorMessage();
			}catch (\Exception $e){
			   echo $e->getMessage();
			}
			$success = "Check je email voor je nieuwe wachtwoord." ;
			
			
			
			// Refresh the page to reset the POST values //
			header('Location: ' . $_SERVER['REQUEST_URI']);
            exit();
        }
		// Get the messages if no message is sent or after the message is sent //
        $messages = $pdo->query("SELECT * FROM messages WHERE (message_to = $user_from_id or message_to = $user_to_id) AND (message_from = $user_from_id or message_from = $user_to_id) ORDER BY message_date ASC")->fetchAll();
		
		// Update the messages received as read //
        $database->update("messages", ["message_read" => "1"], ["message_to[=]" => $user_from_id, "message_from[=]" => $user_to_id]);
    }else{
		// Error will be thrown at the section above when trying to create a new conversation //
	}
}
?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h1 class="display-4">Berichten</h1>
		<?php if ($error != "") { ?>
		<div class="alert alert-warning">
		<?php echo $error; ?>
		</div>
		<?php } ?>
    </div>
  </div>
  <div class="messaging">
    <div class="inbox_msg">
      <div class="inbox_people">
        <div class="headind_srch">
          <div class="recent_heading">
            <h4>Gesprekken
            </h4>
          </div>
        </div>
        <div class="inbox_chat">  
			<?php 
			// Display conversations //
			foreach ($messages_list as $conv) {
				// Check who is who //
				if ($conv["conv_u1"] == $_SESSION["id"]) {
					$user_id = $conv["conv_u2"];
				}else {
					$user_id = $conv["conv_u1"];
				}
				// Get the user details //
				$user = $database->select("users", ['user_id', 'user_mail', 'user_zip', 'user_bio', 'user_name', 'user_created_at'], ["user_id" => $user_id]);
				$user_id = $user[0]["user_id"];
				$user_name = $user[0]["user_name"];
				// Count unread messages //
				$messages_spec = $pdo->query("SELECT * FROM messages WHERE message_to = " . $_SESSION["id"] . " AND message_from = " . $user_id . " AND message_read = 0")->fetchAll();
				$unread = count($messages_spec);
			?>
			<a href="users/messages.php?id=<?php if($conv["conv_u1"] == $_SESSION["id"]) {echo $conv["conv_u2"];}else {echo $conv["conv_u1"];} ?>">
            <div class="chat_list <?php if (isset($_GET["id"]) && $_GET["id"] != "") {if ($_GET["id"] == $user_id) {echo "active_chat";}}?>"  >
				<div class="chat_people">
					<div class="chat_ib">
					  <h5>
						<?php echo $user_name; ?> 
					  </h5>
					  <span style="font-size:12px" class="">
						<?php echo substr($conv["conv_startdate"], 0, 10); ?> - 
						<?php echo $unread; ?> nieuwe bericht(en)
					  </span>
					</div>
				</div>
            </div> 
          </a>
			<?php } ?>
        </div>
      </div>
      <div class="mesgs">
			<?php 
			// Check if the GET value is set (to set the active chat) //
			if (isset($_GET["id"]) && $_GET["id"]!="") {
				// Get the data from the other user //
				$user = $database->select("users", ['user_id', 'user_mail', 'user_zip', 'user_bio', 'user_name', 'user_created_at'], ["user_id" => $_GET["id"]]);
				// Check if there is a result //
				if (count($user) != 0) { ?>
					<div class="">
						  <h4>
							<a href="<?php echo "../listings/public_profile.php?id=" . $_GET["id"] ?>">
								<?php 
								// Check which id should be checked for information //
								// If conv_u1 = current user, show conv_u2 else show conv_u1 //
								if ($conv["conv_u1"] == $_SESSION["id"]) {
									$user_id = $conv["conv_u2"];
								}
								else {
									$user_id = $conv["conv_u1"];
								}
								$user_name = $user[0]["user_name"];
								echo $user_name;
								?>
							</a>
						</h4>
					</div>
			<?php }} ?>
			
			
			<div id="msg_history" class="msg_history">
				<?php 
				if ($messages != "") {
					// Display the messages //
					foreach ($messages as $message) { ?>
						<div class="<?php if ($message["message_from"] == $_SESSION["id"]){  echo "outgoing";}else {echo "incoming";} ?>_msg">
							<div class="<?php if ($message["message_from"] == $_SESSION["id"]) {echo "sent";}else{echo "received";} ?>_msg">
								<div class="received_withd_msg">
									<p>
										<?php echo $message["message_content"]; ?>
									</p>
									<span class="time_date">
										<?php echo $message["message_date"]; ?>
									</span> 
								</div>
							</div>
						</div>			
				<?php }}else {
				// Show error when there is no chat selected //
				$error2 = "Selecteer een gesprek hiernaast of start een gesprek door contact op te nemen via een advertentie.";
				$disabled = "disabled";
				} ?>
			</div>
			<?php if ($error2 != "") { ?>
				<div class="alert alert-warning">
					<?php echo $error2; ?>
				</div>
			<?php } ?>
        <div class="type_msg">
          <div class="input_msg_write">
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $user_to_id; ?>" method="post">
				  <input 
						 <?php echo $disabled; ?> name="input_text" type="text" class="write_msg" placeholder="Type hier een bericht" />
				  <button 
						  <?php echo $disabled; ?> class="msg_send_btn" type="submit">
				  <i class="fa fa-paper-plane-o" aria-hidden="true">
				  </i>
				  </button>
				</form>
			</div>
		</div>
      </p>
  </div>
</div>
</div>
</div>


<?php include_once "../template/footer.php"; ?>

<script>
var objDiv = document.getElementById("msg_history");
objDiv.scrollTop = objDiv.scrollHeight;
</script>
