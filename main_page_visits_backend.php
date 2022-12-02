<?php
session_start();

include 'Database_connection.php';


if($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['user_id_logged_in'] == 13){
    $JSON=array();
    $query=mysqli_query($db,"SELECT id_user,Address_store,Name_store,Date_of_upload,estimation_of_user FROM user_visits ORDER BY 'Date_of_upload' DESC ");

    while($row=mysqli_fetch_assoc($query)){

        array_push($JSON,$row);
    }
    echo json_encode($JSON,true);
} 
?>
