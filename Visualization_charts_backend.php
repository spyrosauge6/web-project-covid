<?php
session_start();

include 'Database_connection.php';



if($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['status'] == true){
  $JSON_positive_users = array();
  $JSON_a = array();
  $JSON_b = array();
  $JSON_c = array();


  $query_a = mysqli_query($db,"SELECT count(*) as 'positive_visits' FROM user_visits");

  while($row = mysqli_fetch_assoc($query_a)){
    array_push($JSON_a,$row);
  }

  $query_b = mysqli_query($db, "SELECT count(*) as 'positive_users' FROM covid_cases");

  while($row = mysqli_fetch_assoc($query_b)){
    array_push($JSON_b,$row);
  }

  $extra_query = mysqli_query($db, "SELECT * FROM covid_cases");

  while($row = mysqli_fetch_assoc($extra_query)){
    array_push($JSON_positive_users,$row);
  }

  for($i=0;$i<sizeof($JSON_positive_users);$i++){
    $users_id = $JSON_positive_users[$i]['id_user'];
    $date_of_infection = $JSON_positive_users[$i]['date_of_infection'];
    $date_of_infection_minus_7 = date('Y-m-d H:i:s', strtotime('-7 days', strtotime($JSON_positive_users[$i]['date_of_infection'])));
    $date_of_infection_plus_14 = date('Y-m-d H:i:s', strtotime('14 days', strtotime($JSON_positive_users[$i]['date_of_infection'])));


    $positive_visits = mysqli_query($db,"SELECT * FROM user_visits WHERE (id_user = '$users_id') && (Date_of_upload BETWEEN '$date_of_infection_minus_7' AND '$date_of_infection_plus_14')");

    while($row = mysqli_fetch_assoc($positive_visits)){
      array_push($JSON_c,$row);
    }
  }

  echo json_encode(array_merge($JSON_a,$JSON_b,$JSON_c),true);

}
