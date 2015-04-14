<?php
$dbname = "admin";
$connection = new Mongo();

$longitude = array();
$latitude = array();
$user = array();
$tweet = array();

$connecting_string =  sprintf('mongodb://%s:%d/%s', "104.236.243.205", 27017,"admin");
$connection=  new Mongo($connecting_string,array('username'=>"deeepak",'password'=>"rohan"));

$dbname = $connection->selectDB('admin');
$collection = $dbname->selectCollection('tweeps');

$result = $collection->find();

foreach($result as $data){
	array_push($longitude,$data["longitude"]);
	array_push($longitude,$data["latitude"]);
	array_push($tweet,$data["tweet"]);
	array_push($user,$data["username"]);
}

echo json_encode(array($longitude,$latitude,$tweet,$user));
?>