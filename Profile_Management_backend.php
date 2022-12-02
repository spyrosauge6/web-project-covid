<?php


session_start();

include 'Database_connection.php';



if($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['status'] == true){

  $username = $_POST['username'];
  $password = $_POST['password'];
  $old_password = $_POST['old_password'];
  $user_id = $_SESSION['user_id_logged_in'];

  $query = mysqli_query($db,"SELECT id,password,username FROM users WHERE id='$user_id' ");

  if(mysqli_num_rows($query)>0){
    while($row = mysqli_fetch_assoc($query)){

      $password1 = $row['password'];
      $id = $row['id'];
      $username_from_mysql = $row['username'];

    }
  }

  $user_check = mysqli_query($db,"SELECT username,id FROM users WHERE username = '$username'");

  while($row = mysqli_fetch_assoc($user_check)){
    $id_check = $row['id'];
    $username_check = $row['username'];
  }



  if(mysqli_num_rows($user_check)==0){
    if(password_verify($old_password,$password1)){

      $hashed_password = password_hash($password,PASSWORD_DEFAULT);
      mysqli_query($db,"UPDATE users SET username = '$username', password = '$hashed_password' WHERE id='$user_id' ");
      echo 1;//All fine

    } else {
      echo 2;//Wrong pass old
    }
  } elseif(mysqli_num_rows($user_check)>0 && $user_id == $id){

    if(password_verify($old_password,$password1)){

      $hashed_password = password_hash($password,PASSWORD_DEFAULT);
      mysqli_query($db,"UPDATE users SET password = '$hashed_password' WHERE id = '$user_id'");
      echo 4;//All fine

    }else{
      echo 2;
    }
  }else{//Put another username
    echo 3;
  }
















}
