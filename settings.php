<?php include('api.php'); ?>
<?php
if(!isset($_COOKIE['user_id'])){
  setcookie("user_id","0", time() + (86400 * 30), "/");
}
else if(isset($_COOKIE['user_id'])){
  $user_id=$_COOKIE['user_id'];
  if($user_id==0){
    header("Location:http://localhost/swasthya/index.php");
  }
}
if($user_id==0){
    header("Location:http://localhost/swasthya/index.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<title>login</title>
</head>
<body>
	<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="#">Swasthya</a>

  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Search</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Signup.php">Signup</a>
      </li>
      <?php
      if(isset($_COOKIE['user_id'])){
      $user=$_COOKIE['user_id'];
      if($user>0){
      echo "<li class='nav-item'>";
      echo "<a class='nav-link' href='profiles.php'>Profile</a>";
      echo "</li>";
    }
    }
      ?>
    </ul>
  </div>
</nav>
<div style="float: right; padding-right: 20px; background-color: #ffe6ff; text-align: center;">
<?php
    echo "<br>";
    if(isset($_COOKIE['profile_id'])){
        $user=$_COOKIE['profile_id'];
        if($user!="0"){
        echo "logged in";
        echo "<form method='POST'>";
        echo "<button name='logout'>Log out</button>";
        echo "</form>";
      }
    }
    
?>
</div>
<?php
 if(isset($_POST['logout'])) { 
  if (isset($_COOKIE['profile_id'])) {
    unset($_COOKIE['profile_id']); 
    setcookie('profile_id', "0", -1, '/'); 
    header("Location:http://localhost/swasthya/index.php");
} else {
    return false;
}
}
?>
<div style="padding: 60px;">
<?php 
$results= getUserData(1);
$row = mysqli_fetch_assoc($results);
echo "<form method='POST'>";
echo "email <input type='text' name='phone' placeholder='".$row['show_phone']."''>";
echo "<br>";
echo "<br>";
echo "phone <input type='text' name='email' placeholder='".$row['show_email']."''>";
echo "<br>";
echo "<br>";
echo "speciality";
echo "<input type='text' name='location' placeholder='".$row['show_location']."'>";
echo "<button name='submit' value='submit'>submit</button>";
echo "</form>";
if(isset($_POST['submit'])){
  echo "success";
  if(updateDetail($_POST['show_phone'],$_POST['show_email'],$_POST['show_location'],$_COOKIE['user_id'])){
    echo "success";
    header("Location:http://localhost/swasthya/index.php");
  }
}
?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</body>
</html>