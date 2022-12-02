<?php
session_start();


//connect to db
include 'Database_connection.php';

if($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['status'] == true){
  //Here I get the data from javascript
  $JSON_data = $_POST['data'];


  //I make the data into JSON form for php
  $JSON_data = json_decode($JSON_data, true);

  //I get the current datetime
  $current_datetime = date('Y-m-d H:i:s');

  //counter for the number of loops
  $count = 0;

  print_r($JSON_data);


  for($i=0; $i<sizeof($JSON_data); $i++){

    //In case there is a mistake to the json data it every data will be initialized
    $store_id = "null";
    $store_name = "null";
    $store_address = "null";
    $store_rating = "null";
    $store_rating_n = "null";
    $store_types = "null";
    $store_lat = "null";
    $store_lng = "null";

    if(isset($JSON_data[$i]['id'])){
          $store_id = $JSON_data[$i]['id'];
    }

    if(isset($JSON_data[$i]['name'])){
          $store_name = $JSON_data[$i]['name'];
    }

    if(isset($JSON_data[$i]['address'])){
          $store_address = $JSON_data[$i]['address'];
    }

    if(isset($JSON_data[$i]['rating'])){
          $store_rating = $JSON_data[$i]['rating'];
    }

    if(isset($JSON_data[$i]['rating_n'])){
          $store_rating_n = $JSON_data[$i]['rating_n'];
    }

    if(isset($JSON_data[$i]['types'])){
          $store_types = $JSON_data[$i]['types'];
    }

    if(isset($JSON_data[$i]['lat'])){
          $store_lat = $JSON_data[$i]['lat'];
    }

    if(isset($JSON_data[$i]['lng'])){
          $store_lng = $JSON_data[$i]['lng'];
    }



    $sql = "INSERT INTO stores (id_store, Name_store, Address_store, Rating_store, Rating_number_store, lat_store, lng_store, types_store, Date_of_upload) VALUES ('$store_id', '$store_name', '$store_address', '$store_rating', '$store_rating_n', '$store_lat',  '$store_lng','$store_types','$current_datetime')";
    mysqli_query($db, $sql);

    for($j=0; $j<sizeof($JSON_data[$i]['days_name']); $j++){


      $day_name = $JSON_data[$i]['days_name'][$j];
      $day_hour_0 = $JSON_data[$i]['days_data'][$j][0];
      $day_hour_1 = $JSON_data[$i]['days_data'][$j][1];
      $day_hour_2 = $JSON_data[$i]['days_data'][$j][2];
      $day_hour_3 = $JSON_data[$i]['days_data'][$j][3];
      $day_hour_4 = $JSON_data[$i]['days_data'][$j][4];
      $day_hour_5 = $JSON_data[$i]['days_data'][$j][5];
      $day_hour_6 = $JSON_data[$i]['days_data'][$j][6];
      $day_hour_7 = $JSON_data[$i]['days_data'][$j][7];
      $day_hour_8 = $JSON_data[$i]['days_data'][$j][8];
      $day_hour_9 = $JSON_data[$i]['days_data'][$j][9];
      $day_hour_10 = $JSON_data[$i]['days_data'][$j][10];
      $day_hour_11 = $JSON_data[$i]['days_data'][$j][11];
      $day_hour_12 = $JSON_data[$i]['days_data'][$j][12];
      $day_hour_13 = $JSON_data[$i]['days_data'][$j][13];
      $day_hour_14 = $JSON_data[$i]['days_data'][$j][14];
      $day_hour_15 = $JSON_data[$i]['days_data'][$j][15];
      $day_hour_16 = $JSON_data[$i]['days_data'][$j][16];
      $day_hour_17 = $JSON_data[$i]['days_data'][$j][17];
      $day_hour_18 = $JSON_data[$i]['days_data'][$j][18];
      $day_hour_19 = $JSON_data[$i]['days_data'][$j][19];
      $day_hour_20 = $JSON_data[$i]['days_data'][$j][20];
      $day_hour_21 = $JSON_data[$i]['days_data'][$j][21];
      $day_hour_22 = $JSON_data[$i]['days_data'][$j][22];
      $day_hour_23 = $JSON_data[$i]['days_data'][$j][23];

      $result = "INSERT INTO data_pop(id_store,data_day,data_hour_0,data_hour_1,data_hour_2,data_hour_3,data_hour_4,data_hour_5,data_hour_6,data_hour_7,data_hour_8,data_hour_9,data_hour_10,data_hour_11,data_hour_12,data_hour_13,data_hour_14,data_hour_15,data_hour_16,data_hour_17,data_hour_18,data_hour_19,data_hour_20,data_hour_21,data_hour_22,data_hour_23) VALUES ('".$JSON_data[$i]['id']."', '$day_name', '$day_hour_0', '$day_hour_1', '$day_hour_2', '$day_hour_3','$day_hour_4','$day_hour_5', '$day_hour_6', '$day_hour_7', '$day_hour_8', '$day_hour_9', '$day_hour_10', '$day_hour_11', '$day_hour_12', '$day_hour_13', '$day_hour_14', '$day_hour_15', '$day_hour_16', '$day_hour_17', '$day_hour_18', '$day_hour_19', '$day_hour_20', '$day_hour_21', '$day_hour_22', '$day_hour_23')";
      if (mysqli_query($db, $result)) {
        echo "New record created successfully";
      }


    }
  }
}




?>
