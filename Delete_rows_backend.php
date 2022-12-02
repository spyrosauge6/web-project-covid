<?php
session_start();

include 'Database_connection.php';


if($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['user_id_logged_in'] == 13){

    $val = $_POST['bool_value'];
    if($val == true){
        if (mysqli_query($db, "DELETE FROM stores")){
            echo "Deletion is completed";
        } else{
            echo "Error: ". $result . "<br>" . mysqli_error($result). "<br>";
        }
    }
}
  
?>