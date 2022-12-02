<?php


session_start();

include 'Database_connection.php';





if($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['status'] == true){

  $JSON = array();

  $date = $_POST['date']; 

  $user_id = $_SESSION['user_id_logged_in']; 

  mysqli_query($db,"INSERT INTO covid_cases(id_user,covid_case,date_of_infection) VALUES('$user_id',1,'$date')"); 
}
