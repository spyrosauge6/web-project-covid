<?php
session_start();

include 'Database_connection.php';


if($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['user_id_logged_in'] == 13){
    $JSON=array();
    $query=mysqli_query($db,"SELECT id_case,id_user,date_of_infection FROM covid_cases ORDER BY covid_cases.date_of_infection DESC");

    while($row=mysqli_fetch_assoc($query)){

        array_push($JSON,$row);
    }
    echo json_encode($JSON,true);
} 
?>
