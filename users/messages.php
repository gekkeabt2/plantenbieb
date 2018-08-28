<?php
include_once "../template/header.php";
include_once("../includes/config.php");
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
}
else {
	header("location: ../users/login");
    exit;
}

$error = $succes = $disabled = $messages = $error2 = $id = "";

// Get the list of conversations the user has
$user_from_id = $_SESSION["id"];
if (isset($_GET["id"]) && $_GET["id"] != "") {
    $id = $_GET["id"];
    $user_to_id = $_GET["id"];
    $user = $database->select("users", ['user_id', 'user_mail', 'user_zip', 'user_bio', 'user_name', 'user_created_at'], ["user_id" => $_GET["id"]]);
    $messages_list = $pdo->query("SELECT * FROM conversations WHERE (conv_u1 = $user_from_id AND conv_u2 = $user_to_id) OR (conv_u1 = $user_to_id AND conv_u2 = $user_from_id)")->fetchAll();
    if (count($user) != 0) {
        if (count($messages_list) != 0) {
        }
        else {
            if ($_GET["id"] == $_SESSION["id"]) {
                $error = "Je kan geen berichten naar jezelf sturen helaas.";
                $disabled = "disabled";

            }
            else {
                $database->insert("conversations", ["conv_u1" => $_GET["id"], "conv_u2" => $user_from_id]);

            }
        }

    }
    else {
        $error = "Geen gebruiker gevonden waar u mee wilt praten.";
    }
}
// Renew the list in case there is a query added
$messages_list = $pdo->query("SELECT * FROM conversations WHERE (conv_u1 = $user_from_id OR conv_u2 = $user_from_id)")->fetchAll();

// Get the messages sent in the chat
if (isset($_GET["id"]) && $_GET["id"] != "") {
    $user = $database->select("users", ['user_id', 'user_mail', 'user_zip', 'user_bio', 'user_name', 'user_created_at'], ["user_id" => $_GET["id"]]);
    if (count($user) != 0) {
        $user_to_name = $user[0]["user_name"];
        $user_to_id = $user[0]["user_id"];
        if ($user_to_id == $user_from_id) {
            $error = "Je kan geen berichten naar jezelf sturen helaas.";
            $disabled = "disabled";
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $input_text = $_POST["input_text"];
            $database->insert("messages", ["message_offer" => $_GET["id"], "message_from" => $user_from_id, "message_to" => $user_to_id, "message_content" => $_POST["input_text"]]);
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit();
        }
        $messages = $pdo->query("SELECT * FROM messages WHERE (message_to = $user_from_id or message_to = $user_to_id) AND (message_from = $user_from_id or message_from = $user_to_id) ORDER BY message_date ASC")->fetchAll();

        $data = $database->update("messages", ["message_read" => "1"], ["message_to[=]" => $user_from_id, "message_from[=]" => $user_to_id]);
        $success = "Gegevens zijn met succes aangepast.";
    }
}
?>
    <div class="container">
	<div class="row">
        <div class="col-md-12">
          <h1 class="display-4">Berichten</h1>
		  <?php if ($error != "") { ?>
      <div class="alert alert-warning">
        <?php
    echo $error; ?>
      </div>
      <?php
} ?>
        </div>
      </div>
<div class="messaging">
      <div class="inbox_msg">
        <div class="inbox_people">
          <div class="headind_srch">
            <div class="recent_heading">
              <h4>Gesprekken</h4>
            </div>
          </div>
          <div class="inbox_chat">  

			<?php foreach ($messages_list as $conv) {
    if ($conv["conv_u1"] == $_SESSION["id"]) {
        $user_id = $conv["conv_u2"];
    }
    else {
        $user_id = $conv["conv_u1"];
    }
    $user = $database->select("users", ['user_id', 'user_mail', 'user_zip', 'user_bio', 'user_name', 'user_created_at'], ["user_id" => $user_id]);
    $user_id = $user[0]["user_id"];
    $user_name = $user[0]["user_name"];
    $messages_spec = $pdo->query("SELECT * FROM messages WHERE message_to = " . $_SESSION["id"] . " AND message_from = " . $user_id . " AND message_read = 0")->fetchAll();
    $unread = count($messages_spec);
?>
            <a href="users/messages.php?id=<?php if ($conv["conv_u1"] == $_SESSION["id"]) {
        echo $conv["conv_u2"];
    }
    else {
        echo $conv["conv_u1"];
    } ?>">
			<div class="chat_list <?php if (isset($_GET["id"]) && $_GET["id"] != "") {
        if ($_GET["id"] == $user_id) {
            echo "active_chat";
        }
    } ?>"  >
              <div class="chat_people">
               <div class="chat_ib">
                  <h5><?php echo $user_name; ?> </h5><span style="font-size:12px" class=""><?php echo substr($conv["conv_startdate"], 0, 10); ?> - <?php echo $unread; ?> nieuwe bericht(en)</span>
                </div>
              </div>
            </div> 
			</a>
			<?php
} ?>


			
          </div>
        </div>
        <div class="mesgs">
		<?php if (isset($_GET["id"]) && $_GET["id"]) {
    $user = $database->select("users", ['user_id', 'user_mail', 'user_zip', 'user_bio', 'user_name', 'user_created_at'], ["user_id" => $_GET["id"]]);
    if (count($user) != 0) { ?>
		<div class="">
			  <h4><a href="<?php echo "../listings/public_profile.php?id=" . $_GET["id"] ?>"><?php if ($conv["conv_u1"] == $_SESSION["id"]) {
            $user_id = $conv["conv_u2"];
        }
        else {
            $user_id = $conv["conv_u1"];
        }

        $user_name = $user[0]["user_name"];
        echo $user_name;
?></a></h4>
            
          
		  </div>
		  <?php
    }
} ?>
          <div id="msg_history" class="msg_history">
			
			<?php if ($messages != "") {
    foreach ($messages as $message) { ?>
			
             <div class="<?php if ($message["message_from"] == $_SESSION["id"]) {
            echo "outgoing";
        }
        else {
            echo "incoming";
        } ?>_msg">
			<div class="<?php if ($message["message_from"] == $_SESSION["id"]) {
            echo "sent";
        }
        else {
            echo "received";
        } ?>_msg">
                <div class="received_withd_msg">
				<p><?php echo $message["message_content"]; ?></p>
                <span class="time_date"><?php echo $message["message_date"]; ?></span> </div>
				</div>
            </div>			
			<?php
    }
}
else {
    $error2 = "Selecteer een gesprek hiernaast of start een gesprek door contact op te nemen via een advertentie.";
    $disabled = "disabled";
} ?>
          </div>
		  		  <?php if ($error2 != "") { ?>
      <div class="alert alert-warning">
        <?php
    echo $error2; ?>
      </div>
      <?php
} ?>
          <div class="type_msg">
            <div class="input_msg_write">
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>" method="post">
				<input <?php echo $disabled; ?> name="input_text" type="text" class="write_msg" placeholder="Type hier een bericht" />
				<button <?php echo $disabled; ?> class="msg_send_btn" type="submit"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
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
