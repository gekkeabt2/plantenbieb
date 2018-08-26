<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="https://v40.pingendo.com/assets/4.0.0/default/theme.css" type="text/css"> </head>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../includes/chatbox.css" type="text/css">


<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
      <i class="fa d-inline fa-lg fa-leaf"></i>&nbsp;
      <a class="navbar-brand" href="/index.php">PlantenBieb - Beta</a>
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarsExample09" aria-controls="navbarsExample09" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="navbar-collapse collapse" id="navbarsExample09" style="">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="/index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/about.php">Over</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/listings/products.php">Aanbod</a>
          </li>
        </ul>
        <form class="form-inline my-2 my-md-0" action="../listings/products.php" method="get">
          <input class="form-control" type="text" placeholder="Zoeken" name="title" aria-label="Search"> &nbsp;&nbsp;
          <button type="submit" class="btn btn-secondary"><i class="fa d-inline fa-lg fa-search"></i></button>&nbsp;&nbsp;
		  <a class="btn btn-primary" href="/listings/product_add.php" role="button"><i class="fa d-inline fa-lg fa-plus"></i></a>&nbsp;&nbsp;
		  <?php session_start(); if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){ ?>
          <a class="btn btn-primary" href="/users/messages.php" role="button">
            <i class="fa d-inline fa-lg fa-comments"></i> (2) </a>
          </a>&nbsp;&nbsp;
        </form>
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown09" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa d-inline fa-lg fa-user-circle-o"></i> Mijn account&nbsp;</a>
            <div class="dropdown-menu" aria-labelledby="dropdown09">
              <a class="dropdown-item" href="/users/profile.php">Mijn profiel</a>
              <a class="dropdown-item" href="/users/logout.php">Uitloggen</a>
            </div>
          </li>
        </ul>
		  <?php }else{ ?>
		  
        <form class="form-inline my-2 my-md-0">
         <a class="btn btn-primary" href="/users/register.php" role="button">
            Registreren
          </a>&nbsp;&nbsp;
          <a class="btn btn-primary" href="/users/login.php" role="button">
            Inloggen </a>
        </form>
		  <?php } ?>
		  
      </div>
    </nav>
  <div class="container">
    <br>