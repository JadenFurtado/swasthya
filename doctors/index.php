<?php
include('userData.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 <!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<title>Doctors</title>
<style type="text/css">

	 th {text-align: left;}
   
   body{
        font-family: Arail, sans-serif;
    }
    /* Formatting search box */
    .search-box{
        width: 350px;
        position: relative;
        display: inline-block;
        font-size: 14px;
    }
    .search-box input[type="text"]{
        height: 32px;
        padding: 5px 10px;
        border: 1px solid #CCCCCC;
        font-size: 14px;
    }
    .result{
        position: absolute;        
        z-index: 999;
        top: 100%;
        left: 0;
    }
    .search-box input[type="text"], .result{
        width: 100%;
        box-sizing: border-box;
    }
    /* Formatting result items */
    .result table{
        background:  #99ff99;
        margin: 0;
        padding: 7px 10px;
        border: 1px solid #CCCCCC;
        border-top: none;
        cursor: pointer;
    }
    .result p:hover{
        background: #f2f2f2;
    }
    .mySlides {display:none;}
    .images{
      height: 200px;
      width: 200px;
    }
    .table{
      cursor: pointer;
    }
</style>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    $('.search-box input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.get("backend-search.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });
    
    // Set search input value on click of result item
$(document).on("click", ".result table td", function(){
    $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
    $(this).parent(".result").empty();
    });
});
</script>
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
        <a class="nav-link" href="http://localhost/swasthya/index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="http://localhost/swasthya/search/index.php">Search</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="http://localhost/swasthya/fitness/">Fitness</a>
      </li>
      <?php
      if(!isset($_SESSION['profile_id'])){
      echo "<li class='nav-item'>";
      echo "<a class='nav-link' href='http://localhost/swasthya/signup/index.php'>Sign up</a>";
      echo "</li>";
    }
      if(isset($_SESSION['profile_id'])){
      echo "<li class='nav-item'>";
      echo "<a class='nav-link' href='http://localhost/swasthya/profile.php'>Profile</a>";
      echo "</li>";
    }
      ?>
      <li class="nav-item">
        <a class="nav-link" href="http://localhost/swasthya/aboutUs.php">About us</a>
      </li>
    </ul>
  </div>
</nav>
<br>
<!-- body start here! -->
<div style="padding: 10px;">
  <div>
    <img class="img-fluid"src="http://localhost/swasthya/images/doc1.jpg">
  </div>   
</div>
<br>
<?php lastTen(); ?>
<div style="padding: 5px;">
 latest registrations
</div>
<div align="center">
  <div style="background-color: grey; padding: 5px; width: 180px; height: 250px;">
    <img height="75px;" width="75px" src="http://localhost/swasthya/dp/def.jpg" alt="dp_image">
    <div>
      name:doc name
      <br>
      <table>
        <tr>
          <td>
            speciality
          </td>
          <td>
            qualifi
          </td>
          <td>
            years
          </td>
        </tr>
      </table>
    </div>
    <button>see profile</button>
  </div>
</div>
<div>
  
<div style="padding:5px; ">
  <div style="background-color:  #0066cc">
  <i>as we are in testing phase, real doctor/hospital profiles do not exist. just click search to view all profiles on this site...</i>
</div>
  <br>
  <br>
  <div>
 <?php
$cookie_name="token";
if(!isset($_COOKIE['token'])){
$val= bin2hex(random_bytes(32));
setcookie($cookie_name,$val, time() + (86400 * 30), "/");
$token=$_COOKIE['token'];
}
$token=$_COOKIE['token'];
echo "<form method='POST'>";
echo "<div class='search-box'>";
echo "<input type='text' autocomplete='off' placeholder='Search for doctors, speciality, clinic, hospital...' name='search'>";
echo "<div class='result'></div>";
echo "</div>";
echo "<button name='sub'>search</button>";
echo "<input type='hidden' name='token' value='".$token."'>";
echo "</form>";
?>
</div>
<br>
<br>
<div style="height: 300px; width: 500px; overflow: auto; padding-right: 10px; padding-left: 15px; margin-left: -10px;">
<table style="width:100% ; background-color:  #b3d9ff;">
  <?php
  if(isset($_POST["sub"])){
    $search=$_POST["search"];
    $search=filter_var($search, FILTER_SANITIZE_STRING);
    if (!empty($_POST['token'])) {
    if (hash_equals($_COOKIE['token'], $_POST['token'])) {
    $posts=getDoctor($search);
    echo "<tr style='background-color: #00264d; color:white;'>";
    echo "<th>Doctor name</th>";
    echo "<th>speciality</th>";
    echo "<th>cons-charges</th>";
    echo "</tr>";
    while ($row = mysqli_fetch_array($posts)) { 
      $url=$row['profile_url'];
      
            echo "<tr>"; 
            echo "<td>".$row['fullName']."</td>";
            echo "<td>".$row['speciality']."</td>";
            echo "<td>".$row['consultingCharges']."</td>";
            echo "<td>";
            echo "<form method='GET' action='http://localhost/swasthya/profile/profile.php'>";
            echo "<div style='background-color:#00264d'>";
            echo "<button name='profile' value='submit'>view profile</button>";
            echo "</div>";
            echo "<input type='hidden' name='id' value='$url' />";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        } 
      }
    }
}
?>
</table>
</div>
</div>
</div>
<!-- <br>
<div style="padding: 15px;">
  <div style="height: 200px; width: 150px; background-color: grey;">
    physicians
  </div>
  <br>
   <div style="height: 200px; width: 150px; background-color: grey;">
    oncologist
  </div>
  <br>
  <div style="height: 200px; width: 150px; background-color: grey;">
    dentist
  </div>
</div> -
<div style="padding: 20px;">
  <table style="width: 100%" class="table">
    <tr class="search">
      <td>
        <img style="height: 100px; width: 100px;" class="img-fluid" src="http://localhost/swasthya/images/search.png">
      </td>
      <td>
        <h4>search for doctors</h4>
      </td>
    </tr>
    <tr class="login">
      <td>
        <img style="height: 100px; width: 100px;" class="img-fluid" src="http://localhost/swasthya/images/docIcon.png">
      </td>
      <td>
        <h4>doctor's space</h4>
      </td>
    </tr>
  </table>
-->

  <script type="text/javascript">
    /*
    $(document).ready(function(){
      $(".search").on("click",function(){
        window.location.href="http://localhost/swasthya/search/";
      });
       $(".login").on("click",function(){
        */
        <?php
        //if(!isset($_SESSION['profile_id'])){
        //echo "window.location.href='http://localhost/swasthya/signup/index.php'";
      //}
      //else{
        //echo "window.location.href='http://localhost/swasthya/profiles.php'";
        //}
        ?>
        /*
      });
    });
    */
  </script>
  <br>
<!-- ///////////////footer here///////////////////////////// -->
<div style="text-align: left;color: white; background-color:#001a33;">
    <div style="text-align: center;">
      <b>swasthya</b>
    </div>
    <br>
    <div style="margin-right: 10px;">
<table>
  <tr>
<td>
  <a class="nav-link" style="display: block; color: white;" href="aboutUs.php">About us</a>
</td>
<td>
  <a class="nav-link" style="display: block; color: white;" href="aboutUs.php">Doctors</a>
</td>
<td>
  <a class="nav-link" style="display: block; color: white;" href="aboutUs.php">Hospitals</a>
</td>
<td>
  <a class="nav-link" style="display: block; color: white;" href="aboutUs.php">Speciality</a>
</td>
<td>
  <a class="nav-link" style="display: block; color: white;" href="aboutUs.php">clinics</a>
</td>
</tr>
  </table>
</div>
    <br>
</div>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>