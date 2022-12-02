
<?php
session_start();
include "Database_connection.php";

if($_SERVER["REQUEST_METHOD"]=="POST" && $_SESSION['status'] == true){

  //Get data from javascript
  $JSON = $_POST['json'];

  //current datetime
  $today_datetime = date('Y-m-d H:i:s');

  //store info
  $store_latitude = $JSON['loc'][0];
  $store_longitude = $JSON['loc'][1];
  $store_name = $JSON['name'];
  $store_address = $JSON['address'];
  $store_id = $JSON['id'];
  $estimation = $JSON['estimation'];

  //Get current logged user id in order to know which user uploaded his Visit
  $client_id = $_SESSION['user_id_logged_in'];

   mysqli_query($db,"INSERT INTO user_visits(id_user,id_store,Address_store,Name_store,lat_store,lng_store,Date_of_upload,estimation_of_user) VALUES('$client_id','$store_id','$store_address','$store_name','$store_latitude','$store_longitude','$today_datetime','$estimation')");
}


  ?>
