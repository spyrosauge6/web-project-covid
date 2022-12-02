<?php
session_start();

include 'Database_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"){
  $username = $_POST['username'];
  $password = $_POST['password'];
  $email = $_POST['email'];



  $query = mysqli_query($db,"SELECT * FROM users WHERE username = '$username' OR email = '$email'");

  if(mysqli_num_rows($query) != 0){
    echo 1;
  }else{
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($db,"INSERT INTO users(username,email,password) VALUES ('$username','$email','$hashed_password')");

    $result = mysqli_query($db,"SELECT id FROM users WHERE username = '$username' ");

    while($row=mysqli_fetch_assoc($result)){
      $id = $row["id"];
      mysqli_query($db,"INSERT INTO user_roles VALUES ('$id','0')");
    }

    echo 0;
  }
}

?>
