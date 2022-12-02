<?php

session_start();

include "Database_connection.php";

if($_SERVER["REQUEST_METHOD"]=="POST" && $_SESSION['status'] == true){
  $JSON = array();

  $query = mysqli_query($db,'SELECT id_store,estimation_of_user,Name_store FROM user_visits');

  while($row = mysqli_fetch_assoc($query)){
    array_push($JSON,$row);
  }

  echo json_encode($JSON,true);
}
