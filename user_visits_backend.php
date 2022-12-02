<?php

session_start();

include "Database_connection.php";

if($_SERVER["REQUEST_METHOD"]=="POST" && $_SESSION['status'] == true){

  $datetime = date('Y-m-d H:i:s');
  $JSON = array();
  $user_id = $_SESSION['user_id_logged_in'];

  $query = mysqli_query($db,"SELECT * FROM user_visits WHERE id_user = '$user_id' && DATEDIFF('$datetime', Date_of_upload)<=14");

  while($row = mysqli_fetch_assoc($query)){
    array_push($JSON,$row);
  }

  echo json_encode($JSON,true);
}
