<?php
session_start();

include 'Database_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"){   

  $username=$_POST["username"]; 
  $password=$_POST["password"];

  $query = mysqli_query($db, "SELECT * FROM users WHERE username = '$username'"); 

  if(mysqli_num_rows($query) === 1){  

    $row = mysqli_fetch_assoc($query);  

    if(password_verify($password,$row['password'])){ 
      $_SESSION['user_id_logged_in'] = $row['id'];
      $_SESSION['status'] = true;                   

      $user_id = $_SESSION['user_id_logged_in'];  
      $role_id = mysqli_query($db,"SELECT id_role FROM user_roles WHERE id_user='$user_id' ");  
      $row = mysqli_fetch_assoc($role_id);  

      if($row['id_role'] == 0){
        echo 0;//user login
      }else{
        echo 1;//admin login
      }
    }else {
      echo 2;//wrong pass
    }
  }else{
    echo 3;//not user in db
  }
}







?>
