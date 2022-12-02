<?php
session_start();

include 'Database_connection.php';

if($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['status'] == true){
  $JSON = array();
  $name_today = date("l");
  $query = mysqli_query($db,"SELECT s.types_store,s.id_store,s.lat_store,s.lng_store,s.Name_store,s.Address_store,d.data_hour_0,d.data_hour_1,d.data_hour_2,d.data_hour_3,d.data_hour_4,d.data_hour_5,d.data_hour_6,d.data_hour_7,d.data_hour_8,d.data_hour_9,d.data_hour_10,d.data_hour_11,d.data_hour_12,d.data_hour_13,d.data_hour_14,d.data_hour_15,d.data_hour_16,d.data_hour_17,d.data_hour_18,d.data_hour_19,d.data_hour_20,d.data_hour_21,d.data_hour_22,d.data_hour_23,d.data_day FROM stores AS s INNER JOIN data_pop AS d WHERE s.id_store=d.id_store AND d.data_day='$name_today';");

  while($row = mysqli_fetch_assoc($query)){
    array_push($JSON, array('Id'=>$row['id_store'], 'types'=>$row['types_store'], 'loc' => [$row['lat_store'], $row['lng_store']], 'name'=>$row['Name_store'], 'address'=>$row['Address_store'], 'popular_times'=>[$row['data_hour_0'], $row['data_hour_1'], $row['data_hour_2'], $row['data_hour_3'], $row['data_hour_4'], $row['data_hour_5'], $row['data_hour_6'], $row['data_hour_7'], $row['data_hour_8'], $row['data_hour_9'], $row['data_hour_10'], $row['data_hour_11'], $row['data_hour_12'], $row['data_hour_13'], $row['data_hour_14'], $row['data_hour_15'], $row['data_hour_16'], $row['data_hour_17'], $row['data_hour_18'], $row['data_hour_19'], $row['data_hour_20'], $row['data_hour_21'], $row['data_hour_22'], $row['data_hour_23']], 'day'=>$row['data_day']));
  }

  echo json_encode($JSON, true);
}

?>
