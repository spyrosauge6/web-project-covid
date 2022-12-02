<?php
session_start();

include 'Database_connection.php';



if($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['status'] == true && $_SESSION['user_id_logged_in'] == 13){

  $data = array();
  $data0 = array();
  $data1 = array();


  $query = mysqli_query($db,"SELECT types_store,id_store FROM stores");

  while($row = mysqli_fetch_assoc($query)){
    array_push($data,array('first_select'=>$row));
  }

  $query = mysqli_query($db,"SELECT types_store FROM user_visits INNER JOIN stores ON user_visits.id_store = stores.id_store");

  while($row = mysqli_fetch_assoc($query)){
    array_push($data0,array('second_select'=>$row));
  }


  $query = mysqli_query($db,"SELECT * FROM stores INNER JOIN user_visits ON stores.id_store = user_visits.id_store INNER JOIN covid_cases ON user_visits.id_user = covid_cases.id_user WHERE DATEDIFF(user_visits.Date_of_upload,covid_cases.date_of_infection)>= -7 && DATEDIFF(user_visits.Date_of_upload,covid_cases.date_of_infection)<= 14");

  while($row = mysqli_fetch_assoc($query)){
    array_push($data1,array('third_select'=>$row));
  }

  echo json_encode(array_merge($data,$data0,$data1),true);
}
