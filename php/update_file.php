
<?php
	
	header('Content-Type: text/html; charset=utf-8');

	$host="104.236.243.205"; // Host name 
	$username="deepak"; // Mysql username 
	$password="rohan"; // Mysql password 
	$db_name="ecommerce_transactions"; //DB Name
	$state = $_POST["state"];
	$hash = $_POST["hash"];
	$flag = $_POST["flag"];
	
	$connect_id=mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	mysql_select_db("$db_name",$connect_id) or die("NoDatabase");
	
	$latitude=array();
	$longitude=array();
	$tweets=array();
	$name=array();
	$top_hash=array();
	$selected_datetime=array();
	$selected_count=array();
	$toptag_datetime=array();
	$toptag_count=array();
	$following=array();
	$followers=array();
	$image_url=array();
	$tweeted_at=array();
		
	$myfile1 = fopen("../data/coffee1.csv","w");
	
	fputs($myfile1,"latitude,longitude,group");
	fputs($myfile1,PHP_EOL);	
		
	if($state=="New York"){
		$location = "SELECT `longitude`,`latitude`,`username`,`tweet`,`following`,`followers`,`image_url`,DATE(`tweeted_at`) FROM `tweeps`";
		mysql_query('SET CHARACTER SET utf8');
		$result = mysql_query($location);
		
		while($row = mysql_fetch_array($result)){
			array_push($longitude,$row[0]);
			array_push($latitude,$row[1]);
			array_push($name,$row[2]);
			array_push($tweets,$row[3]);
			array_push($following,$row[4]);
			array_push($followers,$row[5]);
			array_push($image_url,$row[6]);
			array_push($tweeted_at,$row[7]);
		}
		
		$get_tags = "SELECT `hash_tags`,COUNT(*) FROM `hashtables` GROUP BY `hash_tags` ORDER BY COUNT(*) DESC LIMIT 11";
		$result = mysql_query($get_tags);
	
		while($row1 = mysql_fetch_array($result)){
			array_push($top_hash,$row1[0]);
		}
		
		if($flag=="state"||$hash=="")
			$hash = $top_hash[0];
		
		$tags = "SELECT t.`longitude`,t.`latitude`,t.`username` FROM `tweeps` t,`hashtables` h WHERE t.unique_id=h.unique_id_tweet AND h.`hash_tags`='$top_hash[0]'";
		$result2 = mysql_query($tags);	
		
		while($row1 = mysql_fetch_array($result2)){
			fputs($myfile1,$row1[0].",".$row1[1].",0");	
			fputs($myfile1,PHP_EOL);
		}
			
		$tags = "SELECT t.`longitude`,t.`latitude`,t.`username` FROM `tweeps` t,`hashtables` h WHERE t.unique_id=h.unique_id_tweet AND h.`hash_tags`='$hash'";
		$result2 = mysql_query($tags);	
		
		while($row1 = mysql_fetch_array($result2)){
			fputs($myfile1,$row1[0].",".$row1[1].",1");	
			fputs($myfile1,PHP_EOL);
		}
		
		$time = "SELECT t.tweeted_at,COUNT(t.tweeted_at) from tweeps t,hashtables h where t.unique_id=h.unique_id_tweet and h.hash_tags='$hash' group by round(UNIX_TIMESTAMP(t.tweeted_at) / 1)";
		$result3 = mysql_query($time);
		while($row2 = mysql_fetch_array($result3)){
			array_push($selected_datetime,$row2[0]);
			array_push($selected_count,$row2[1]);
			
		}
		
		$top_time = "SELECT t.tweeted_at,COUNT(t.tweeted_at) from tweeps t,hashtables h where t.unique_id=h.unique_id_tweet and h.hash_tags='$top_hash[0]' group by round(UNIX_TIMESTAMP(t.tweeted_at) / 1)";
		$result4 = mysql_query($top_time);
		while($row3 = mysql_fetch_array($result4)){
			array_push($toptag_datetime,$row3[0]);
			array_push($toptag_count,$row3[1]);
			
		}
	}
	
	else if($state=="Illinois"){
		$location = "SELECT `longitude`,`latitude`,`username`,`tweet`,`following`,`followers`,`image_url`,DATE(`tweeted_at`) FROM `illinois_tweep`";
		mysql_query('SET CHARACTER SET utf8');
		$result = mysql_query($location);
		
		while($row = mysql_fetch_array($result)){
			array_push($longitude,$row[0]);
			array_push($latitude,$row[1]);
			array_push($name,$row[2]);
			array_push($tweets,$row[3]);
			array_push($following,$row[4]);
			array_push($followers,$row[5]);
			array_push($image_url,$row[6]);
			array_push($tweeted_at,$row[7]);
		}
		
		$get_tags = "SELECT `hash_tags`,COUNT(*) FROM `illinois_hashtags` GROUP BY `hash_tags` ORDER BY COUNT(*) DESC LIMIT 11";
		$result = mysql_query($get_tags);
	
		while($row1 = mysql_fetch_array($result)){
			array_push($top_hash,$row1[0]);
		}
		
		if($flag=="state"||$hash=="")
			$hash = $top_hash[0];
		
		$tags = "SELECT t.`longitude`,t.`latitude`,t.`username` FROM `illinois_tweep` t,`illinois_hashtags` h WHERE t.unique_id=h.unique_id_tweet AND h.`hash_tags`='$top_hash[0]'";
		$result2 = mysql_query($tags);	
		
		while($row1 = mysql_fetch_array($result2)){
			fputs($myfile1,$row1[0].",".$row1[1].",0");	
			fputs($myfile1,PHP_EOL);
		}
			
		$tags = "SELECT t.`longitude`,t.`latitude`,t.`username` FROM `illinois_tweep` t,`illinois_hashtags` h WHERE t.unique_id=h.unique_id_tweet AND h.`hash_tags`='$hash'";
		$result2 = mysql_query($tags);	
		
		while($row1 = mysql_fetch_array($result2)){
			fputs($myfile1,$row1[0].",".$row1[1].",1");	
			fputs($myfile1,PHP_EOL);
		}
		
		$time = "SELECT t.tweeted_at,COUNT(t.tweeted_at) from illinois_tweep t,illinois_hashtags h where t.unique_id=h.unique_id_tweet and h.hash_tags='$hash' group by round(UNIX_TIMESTAMP(t.tweeted_at) / 1)";
		$result3 = mysql_query($time);
		while($row2 = mysql_fetch_array($result3)){
			array_push($selected_datetime,$row2[0]);
			array_push($selected_count,$row2[1]);
			
		}
		
		$top_time = "SELECT t.tweeted_at,COUNT(t.tweeted_at) from illinois_tweep t,illinois_hashtags h where t.unique_id=h.unique_id_tweet and h.hash_tags='$top_hash[0]' group by round(UNIX_TIMESTAMP(t.tweeted_at) / 1)";
		$result4 = mysql_query($top_time);
		while($row3 = mysql_fetch_array($result4)){
			array_push($toptag_datetime,$row3[0]);
			array_push($toptag_count,$row3[1]);
			
		}
	}
	
	else if($state=="North Carolina"){
		$location = "SELECT `longitude`,`latitude`,`username`,`tweet`,`following`,`followers`,`image_url`,DATE(`tweeted_at`) FROM `nc_tweeps`";
		mysql_query('SET CHARACTER SET utf8');
		$result = mysql_query($location);
		
		while($row = mysql_fetch_array($result)){
			array_push($longitude,$row[0]);
			array_push($latitude,$row[1]);
			array_push($name,$row[2]);
			array_push($tweets,$row[3]);
			array_push($following,$row[4]);
			array_push($followers,$row[5]);
			array_push($image_url,$row[6]);
			array_push($tweeted_at,$row[7]);
		}
		
		$get_tags = "SELECT `hash_tags`,COUNT(*) FROM `nc_hashtags` GROUP BY `hash_tags` ORDER BY COUNT(*) DESC LIMIT 11";
		$result = mysql_query($get_tags);
	
		while($row1 = mysql_fetch_array($result)){
			array_push($top_hash,$row1[0]);
		}
		
		if($flag=="state"||$hash=="")
			$hash = $top_hash[0];
		
		$tags = "SELECT t.`longitude`,t.`latitude`,t.`username` FROM `nc_tweeps` t,`hashtables` h WHERE t.unique_id=h.unique_id_tweet AND h.`hash_tags`='$top_hash[0]'";
		$result2 = mysql_query($tags);	
		
		while($row1 = mysql_fetch_array($result2)){
			fputs($myfile1,$row1[0].",".$row1[1].",0");	
			fputs($myfile1,PHP_EOL);
		}
			
		$tags = "SELECT t.`longitude`,t.`latitude`,t.`username` FROM `nc_tweeps` t,`hashtables` h WHERE t.unique_id=h.unique_id_tweet AND h.`hash_tags`='$hash'";
		$result2 = mysql_query($tags);	
		
		while($row1 = mysql_fetch_array($result2)){
			fputs($myfile1,$row1[0].",".$row1[1].",1");	
			fputs($myfile1,PHP_EOL);
		}
		
		$time = "SELECT t.tweeted_at,COUNT(t.tweeted_at) from nc_tweeps t,nc_hashtags h where t.unique_id=h.unique_id_tweet and h.hash_tags='$hash' group by round(UNIX_TIMESTAMP(t.tweeted_at) / 1)";
		$result3 = mysql_query($time);
		while($row2 = mysql_fetch_array($result3)){
			array_push($selected_datetime,$row2[0]);
			array_push($selected_count,$row2[1]);
			
		}
		
		$top_time = "SELECT t.tweeted_at,COUNT(t.tweeted_at) from nc_tweeps t,nc_hashtags h where t.unique_id=h.unique_id_tweet and h.hash_tags='$top_hash[0]' group by round(UNIX_TIMESTAMP(t.tweeted_at) / 1)";
		$result4 = mysql_query($top_time);
		while($row3 = mysql_fetch_array($result4)){
			array_push($toptag_datetime,$row3[0]);
			array_push($toptag_count,$row3[1]);
			
		}
	}
	
	else{
		$location = "SELECT `longitude`,`latitude`,`username`,`tweet`,`following`,`followers`,`image_url`,DATE(`tweeted_at`) FROM `tweep_california`";
		mysql_query('SET CHARACTER SET utf8');
		$result = mysql_query($location);
		
		while($row = mysql_fetch_array($result)){
			array_push($longitude,$row[0]);
			array_push($latitude,$row[1]);
			array_push($name,$row[2]);
			array_push($tweets,$row[3]);
			array_push($following,$row[4]);
			array_push($followers,$row[5]);
			array_push($image_url,$row[6]);
			array_push($tweeted_at,$row[7]);
		}
		
		$get_tags = "SELECT `hash_tags`,COUNT(*) FROM `hashtags_california` GROUP BY `hash_tags` ORDER BY COUNT(*) DESC LIMIT 11";
		$result = mysql_query($get_tags);
	
		while($row1 = mysql_fetch_array($result)){
			array_push($top_hash,$row1[0]);
		}
		
		if($flag=="state"||$hash=="")
			$hash = $top_hash[0];
		
		$tags = "SELECT t.`longitude`,t.`latitude` FROM `tweep_california` t,`hashtags_california` h WHERE t.unique_id=h.unique_id_tweet AND h.`hash_tags`='$top_hash[0]'";
		$result2 = mysql_query($tags);	
		
		while($row1 = mysql_fetch_array($result2)){
			fputs($myfile1,$row1[0].",".$row1[1].",0");	
			fputs($myfile1,PHP_EOL);
		}
			
		$tags = "SELECT t.`longitude`,t.`latitude` FROM `tweep_california` t,`hashtags_california` h WHERE t.unique_id=h.unique_id_tweet AND h.`hash_tags`='$hash'";
		$result2 = mysql_query($tags);	
		
		while($row1 = mysql_fetch_array($result2)){
			fputs($myfile1,$row1[0].",".$row1[1].",1");	
			fputs($myfile1,PHP_EOL);
		}	
	
		$time = "SELECT t.tweeted_at,COUNT(t.tweeted_at) from tweep_california t,hashtags_california h where t.unique_id=h.unique_id_tweet and h.hash_tags='$hash' group by round(UNIX_TIMESTAMP(t.tweeted_at) / 300)";
		$result3 = mysql_query($time);
		while($row2 = mysql_fetch_array($result3)){
			array_push($selected_datetime,$row2[0]);
			array_push($selected_count,$row2[1]);
			
		}
		
		$top_time = "SELECT t.tweeted_at,COUNT(t.tweeted_at) from tweep_california t,hashtags_california h where t.unique_id=h.unique_id_tweet and h.hash_tags='$top_hash[0]' group by round(UNIX_TIMESTAMP(t.tweeted_at) / 300)";
		$result4 = mysql_query($top_time);
		while($row3 = mysql_fetch_array($result4)){
			array_push($toptag_datetime,$row3[0]);
			array_push($toptag_count,$row3[1]);
			
		}
	}
	
	echo json_encode(array($longitude,$latitude,$top_hash,$tweets,$name,$selected_datetime,$selected_count,$toptag_datetime,$toptag_count,$following,$followers,$image_url,$tweeted_at));
?>