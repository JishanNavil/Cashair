<?php
session_start();

$username = $password = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = validate($_POST["username"]);
  $password = validate($_POST["password"]);
}
function validate($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
$isValidate = true;
if ($username == "") {
  echo "Username is required <br>";
  $isValidate = false;
}
if ($password == "") {
  echo "Password is required <br>";
  $isValidate = false;
}
if ($isValidate) {

  $string = file_get_contents("../model/profile.json");
  $json_a = json_decode($string, true);
  $isLogin = false;
  foreach ($json_a as  $value) {
    // var_dump($value);
    if ($value["username"] == $username && $value["password"] == $password) 
    {
      setcookie("user",$username , time() + (86400 * 30) , "/",);
      $isLogin = true;
      break;
    }
  }

  if (!$isLogin) {
    echo "Username or Password is incorrect";
  } else {
    $_SESSION["username"] = $username;
    header("location: ../view/cashier_dashboard.html");
  }
}
