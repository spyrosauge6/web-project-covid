<?php

session_start();

include "Database_connection.php";

if($_SERVER["REQUEST_METHOD"]=="POST" && $_SESSION['status'] == true){

  $user_id = $_SESSION['user_id_logged_in'];
  $datetime = date('Y-m-d H:i:s');
  $JSON = array();
  $JSON_visits = array();

  $positive_users = mysqli_query($db,"SELECT id_user, date_of_infection FROM covid_cases WHERE id_user NOT IN(SELECT id_user FROM covid_cases WHERE id_user='$user_id') && DATEDIFF('$datetime', date_of_infection)<=7");

  while($row = mysqli_fetch_assoc($positive_users)){
    array_push($JSON,$row);
  }


  $a = date('Y-m-d H:i:s', strtotime('-7 days', strtotime($JSON[0]['date_of_infection'])));

  for($i=0; $i<sizeof($JSON);$i++){

    $date_of_infection = date('Y-m-d H:i:s', strtotime('-7 days', strtotime($JSON[$i]['date_of_infection'])));
    $users_id = $JSON[$i]['id_user'];

    $positive_visits = mysqli_query($db,"SELECT * FROM user_visits WHERE (id_user = '$users_id') && (Date_of_upload BETWEEN '$date_of_infection' AND '$datetime')");

    while($row = mysqli_fetch_assoc($positive_visits)){
      array_push($JSON_visits,$row);
    }
  }

  echo json_encode($JSON_visits,true);
}
