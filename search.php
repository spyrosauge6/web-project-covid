<?php

include 'Database_connection.php';

$data = array();
$today = date("l");//Current day

if(!isset($_GET['q']) or empty($_GET['q']))
	die( json_encode(array('ok'=>0, 'errmsg'=>'specify q parameter') ) );

$query = mysqli_query($db,"SELECT s.types_store,s.id_store,s.lat_store,s.lng_store,s.Name_store,s.types_store,s.Address_store,d.data_hour_0,d.data_hour_1,d.data_hour_2,d.data_hour_3,d.data_hour_4,d.data_hour_5,d.data_hour_6,d.data_hour_7,d.data_hour_8,d.data_hour_9,d.data_hour_10,d.data_hour_11,d.data_hour_12,d.data_hour_13,d.data_hour_14,d.data_hour_15,d.data_hour_16,d.data_hour_17,d.data_hour_18,d.data_hour_19,d.data_hour_20,d.data_hour_21,d.data_hour_22,d.data_hour_23,d.data_day FROM stores AS s INNER JOIN data_pop AS d WHERE s.id_store=d.id_store && d.data_day = '$today' ");

while($row = mysqli_fetch_assoc($query)){
	array_push($data, array('loc'=>[$row['lat_store'], $row['lng_store']],'types'=>$row['types_store'], 'store_name'=>$row['Name_store'],'id'=>$row['id_store'], 'address'=>$row['Address_store'], 'popular_times'=>[$row['data_hour_0'], $row['data_hour_1'], $row['data_hour_2'], $row['data_hour_3'], $row['data_hour_4'], $row['data_hour_5'], $row['data_hour_6'], $row['data_hour_7'], $row['data_hour_8'], $row['data_hour_9'], $row['data_hour_10'], $row['data_hour_11'], $row['data_hour_12'], $row['data_hour_13'], $row['data_hour_14'], $row['data_hour_15'], $row['data_hour_16'], $row['data_hour_17'], $row['data_hour_18'], $row['data_hour_19'], $row['data_hour_20'], $row['data_hour_21'], $row['data_hour_22'], $row['data_hour_23']]));
}

function searchInit($text)	//search initial text in titles
{
	$reg = "/^".$_GET['q']."/i";	//initial case insensitive searching
	return (bool)@preg_match($reg, $text['store_name']);
}


$fdata = array_filter($data, 'searchInit');	//filter data
$fdata = array_values($fdata);	//reset $fdata indexs

$JSON = json_encode($fdata,true);



if(isset($_GET['callback']) and !empty($_GET['callback']))	//support for JSONP request
	echo $_GET['callback']."($JSON)";
else
	echo $JSON;	//AJAX request



?>
