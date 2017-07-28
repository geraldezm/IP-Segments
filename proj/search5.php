<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="all" href="css/style.css">
    <link rel="stylesheet" type="text/css" media="all" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" media="all" href="css/bootstrap.min.css">
    <script src="boostrap.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-inverse" id="nav">
        <ul class="nav navbar-nav" id="navb">
            <li><a href="index.php">Search</a></li>
            <li><a href="ipseg.php">IP Segments</a></li>
        </ul>
    </nav>

<div class="container">


<?php

require_once 'db.php';

	$db = new mysqli('localhost', 'root', '', 'ip_segments');

	echo "<table class='table table-hover'>";
	echo "<thead><h1>Elastic</h1></thead><br>";
	echo "<td>";

	/*****
	* Elastic search block
	*****/
	if (isset($_GET['keywords'])) {

		#$keywords is the user input
		$keywords = $db->escape_string($_GET['keywords']);

		#Checks if the input is an IP (w/ the assumption that if it contains ".", it can be considered an IP)
		$isIP = substr_count($keywords,".");

		#If it is an IP address, do this
		if ($isIP){

			$query = $db->query("SELECT ec_dc, ecpub_ip, ecpri_ip FROM elastic_cloud");

			echo "<td>";
			if ($query->num_rows) {	

				while($r = $query->fetch_object()){

					#If there is no input (blank input), do this
					if($keywords == ""){
						echo "Owner:".$r->ec_dc."<br>";
						echo "Public Range:".$r->ecpub_ip."<br>";
						echo "Private Range:".$r->ecpri_ip."<br>";
						echo "<br><br>";
					}

					#If there is input, do this
					else{

						#Initialize the arrays (refer to the functions at the botto of the source code)
						$networkList = [];
						$xList = [];
						$zeroList = [];
						$subNetwork = [];
						$subX = [];
						$subZero = [];


						$networkList = listNetworkAdd($keywords);
						$xList = listXAdd($networkList);
						$zeroList = listZeroAdd($networkList);

						$subNetwork = addSubnet($networkList);
						$subX = addSubnet($xList);
						$subZero = addSubnet($zeroList);

						#If there is a range in the IP segment, do this
						if (withRange($r->ecpub_ip) == true){
							#Get the IP addresses inside the range
							$newPub = ipRange($r->ecpub_ip);
							$match = 0;

							if(sizeof($newPub) > 1){
								foreach ($newPub as $a) {

									/*************************************
									* Check if IP address (db side) has a slash notation for subnet mask
									* If it contains "/", get the substring before the slash (i.e. "192.168.1.0/24" -> "192.168.1.0")
									*************************************/
									$str = $a;
									$pos = strpos($str, "/");
									if ($pos !== false)
										$str = substr($str, 0, $pos);

									#Check if the substring is contained in the search input. If yes, print
									if(strpos($keywords, $str) !== false){
										echo "Owner:".$r->ec_dc."<br>";
										echo "Public Range:".$r->ecpub_ip."<br>";
										echo "Private Range:".$r->ecpri_ip."<br>";
										echo "<br><br>";

									}

									#If the substring is not contained in the search input, do this
									else {
										for($i = 0; $i < sizeof($networkList); $i++){

											#Compare every IP in the range to the list of IPs in the arrays, if there is a match, print.
												#Break is to avoid repeated prints
											if ((($a == $networkList[$i]) && (strpos($keywords, $a) !== false)) || (($a == $xList[$i]) && (strpos($keywords, $a) !== false)) || (($a == $zeroList[$i]) && (strpos($keywords, $a) !== false)) || (($a == $subNetwork[$i]) && (strpos($keywords, $a) !== false)) || (($a == $subX[$i]) && (strpos($keywords, $a) !== false)) || (($a == $subZero[$i]) && (strpos($keywords, $a) !== false))){
												echo "Owner:".$r->ec_dc."<br>";
												echo "Public Range:".$r->ecpub_ip."<br>";
												echo "Private Range:".$r->ecpri_ip."<br>";
												echo "<br><br>";
												$match = 1;
												break;
											}

											if ($match)
												break;

										}	

									}	

									if ($match)
										break;							
								}
							}
						}

						#If there is no range in the IP segment in the public list, do this
						else if (withRange($r->ecpub_ip) == false){
							$b = $r->ecpub_ip;
							for($i = 0; $i < sizeof($networkList); $i++){

								#Compare the IP segment in the DB to every IP in the arrays, if match, print. Break to avoid repeated prints
								if(($b == $networkList[$i]) || ($b == $xList[$i]) || ($b == $zeroList[$i]) || ($b == $subNetwork[$i]) || ($b == $subX[$i]) || ($b == $subZero[$i])){
									echo "Owner:".$r->ec_dc."<br>";
									echo "Public Range:".$r->ecpub_ip."<br>";
									echo "Private Range:".$r->ecpri_ip."<br>";
									echo "<br><br>";
									break;
								}

							}

						}

						#If there is a range in the IP segment in the private list, do this
						if (withRange($r->ecpri_ip) == true){
							#Get the IP addresses inside the range
							$newPri = ipRange($r->ecpri_ip);

							if(sizeof($newPri) > 1){
								foreach ($newPri as $c) {

									/*************************************
									* Check if IP address (db side) has a slash notation for subnet mask
									* If it contains "/", get the substring before the slash (i.e. "192.168.1.0/24" -> "192.168.1.0")
									*************************************/
									$str = $c;
									$pos = strpos($str, "/");
									if ($pos !== false)
										$str = substr($str, 0, $pos);

									#Check if the substring is contained in the search input. If yes, print
									if(strpos($keywords, $str) !== false){
										echo "Owner:".$r->ec_dc."<br>";
										echo "Public Range:".$r->ecpub_ip."<br>";
										echo "Private Range:".$r->ecpri_ip."<br>";
										echo "<br><br>";

									}
								}
							}
						}

						#If there is no range in the IP segment in the private list, do this
						else if (withRange($r->ecpri_ip) == false){
							$d = $r->ecpri_ip;
							for($i = 0; $i < sizeof($networkList); $i++){

								#Compare the IP segment in the DB to every IP in the arrays, if match, print. Break to avoid repeated prints
								if(($d == $networkList[$i]) || ($d == $xList[$i]) || ($d == $zeroList[$i]) || ($d == $subNetwork[$i]) || ($d == $subX[$i]) || ($d == $subZero[$i])){
									echo "Owner:".$r->ec_dc."<br>";
									echo "Public Range:".$r->ecpub_ip."<br>";
									echo "Private Range:".$r->ecpri_ip."<br>";
									echo "<br><br>";
									break;
								}

							}

						}


					}

				}	
			}
		}

		#If input is NOT an IP address, do this
		else{

			#query if the user input is 'LIKE' the name in the Db
			$query = $db->query("SELECT ec_dc, ecpub_ip, ecpri_ip FROM elastic_cloud WHERE ec_dc like '%".$keywords."%'");

			if ($query->num_rows) {
				while ($r = $query->fetch_object()) {
					echo "Owner:".$r->ec_dc."<br>";
					echo "Public Range:".$r->ecpub_ip."<br>";
					echo "Private Range:".$r->ecpri_ip."<br>";
					echo "<br><br>";
				}
			}
		}

	}

	echo "</td>";	
	echo "</table>";

	echo "<table class='table table-hover'>";
	echo "<thead><h1>Opencloud Availabilty Zone</h1></thead>";
	echo "<td>";

	/*****
	* Opencloud Availability Zone block
	*****/
	if (isset($_GET['keywords'])) {

		#keywords is the user input
		$keywords = $db->escape_string($_GET['keywords']);

		#Checks if the input is an IP (w/ the assumption that if it contains ".", it can be considered an IP)
		$isIP = substr_count($keywords,".");

		#If the input is an IP address, do this
		if($isIP){
		
			$query = $db->query("SELECT oc_az, ocazpub_ip, ocazpri_ip FROM opencloud_az");
			echo "<table class='table table-hover'>";
			echo "<td>";
		
			if ($query->num_rows) {
				while ($r = $query->fetch_object()) {

					#If no input, display every IP segment
					if($keywords == ""){
						echo "Owner:".$r->oc_az."<br>";
						echo "Public Range:".$r->ocazpub_ip."<br>";
						echo "Private Range:".$r->ocazpri_ip."<br>";
						echo "<br><br>";
					}

					#If there is input, do this
					else{
						#Initialize the arrays (refer to functions at the bottom)
						$networkList = [];
						$xList = [];
						$zeroList = [];
						$subNetwork = [];
						$subX = [];
						$subZero = [];


						$networkList = listNetworkAdd($keywords);
						$xList = listXAdd($networkList);
						$zeroList = listZeroAdd($networkList);

						$subNetwork = addSubnet($networkList);
						$subX = addSubnet($xList);
						$subZero = addSubnet($zeroList);

						#If there is a range in the IP segment in the public list, do this
						if (withRange($r->ocazpub_ip) == true){
							#Get the IP addresses inside the range
							$newPub = ipRange($r->ocazpub_ip);
							$match = 0;

							if(sizeof($newPub) > 1){
								foreach ($newPub as $a) {

									/*************************************
									* Check if IP address (db side) has a slash notation for subnet mask
									* If it contains "/", get the substring before the slash (i.e. "192.168.1.0/24" -> "192.168.1.0")
									*************************************/
									$str = $a;
									$pos = strpos($str, "/");
									if ($pos !== false)
										$str = substr($str, 0, $pos);

									#Check if the substring is contained in the search input. If yes, print
									if(strpos($keywords, $str) !== false){
										echo "Owner:".$r->oc_az."<br>";
										echo "Public Range:".$r->ocazpub_ip."<br>";
										echo "Private Range:".$r->ocazpri_ip."<br>";
										echo "<br><br>";

									}

									#If the substring is not contained in the search input, do this
									else {
										for($i = 0; $i < sizeof($networkList); $i++){

											#Compare every IP in the range to the list of IPs in the arrays, if there is a match, print.
											#Break is to avoid repeated prints
											if (($a == $networkList[$i]) || ($a == $xList[$i]) || ($a == $zeroList[$i]) || ($a == $subNetwork[$i]) || ($a == $subX[$i]) || ($a == $subZero[$i])){
												echo "Owner:".$r->oc_az."<br>";
												echo "Public Range:".$r->ocazpub_ip."<br>";
												echo "Private Range:".$r->ocazpri_ip."<br>";
												echo "<br><br>";
												$match = 1;
												break;
											}

											if ($match)
												break;

										}	

									}
								}
							}
						}
						#If there is no range in the IP segment in the public list, do this
						else if (withRange($r->ocazpub_ip) == false){
							$b = $r->ocazpub_ip;
							for($i = 0; $i < sizeof($networkList); $i++){

								#Compare the IP segment in the DB to every IP in the arrays, if match, print. Break to avoid repeated prints
								if(($b == $networkList[$i]) || ($b == $xList[$i]) || ($b == $zeroList[$i]) || ($b == $subNetwork[$i]) || ($b == $subX[$i]) || ($b == $subZero[$i])){
									echo "Owner:".$r->oc_az."<br>";
									echo "Public Range:".$r->ocazpub_ip."<br>";
									echo "Private Range:".$r->ocazpri_ip."<br>";
									echo "<br><br>";
									break;
								}

							}

						}

						#If there is a range in the IP segment in the private list, do this
						if (withRange($r->ocazpri_ip) == true){
							#Get the IP addresses inside the range
							$newPri = ipRange($r->ocazpri_ip);

							if(sizeof($newPri) > 1){
								foreach ($newPri as $c) {

									/*************************************
									* Check if IP address (db side) has a slash notation for subnet mask
									* If it contains "/", get the substring before the slash (i.e. "192.168.1.0/24" -> "192.168.1.0")
									*************************************/
									$str = $c;
									$pos = strpos($str, "/");
									if ($pos !== false)
										$str = substr($str, 0, $pos);

									#Check if the substring is contained in the search input. If yes, print
									if(strpos($keywords, $str) !== false){
										echo "Owner:".$r->oc_az."<br>";
										echo "Public Range:".$r->ocazpub_ip."<br>";
										echo "Private Range:".$r->ocazpri_ip."<br>";
										echo "<br><br>";

									}
								}
							}
						}

						#If there is no range in the IP segment in the private list, do this
						else if (withRange($r->ocazpri_ip) == false){
							$d = $r->ocazpri_ip;
							for($i = 0; $i < sizeof($networkList); $i++){

								#Compare the IP segment in the DB to every IP in the arrays, if match, print. Break to avoid repeated prints
								if(($d == $networkList[$i]) || ($d == $xList[$i]) || ($d == $zeroList[$i]) || ($d == $subNetwork[$i]) || ($d == $subX[$i]) || ($d == $subZero[$i])){
									echo "Owner:".$r->oc_az."<br>";
									echo "Public Range:".$r->ocazpub_ip."<br>";
									echo "Private Range:".$r->ocazpri_ip."<br>";
									echo "<br><br>";
									break;
								}

							}

						}


					}

				}
			}
		}

		#If input is not at IP address, do this
		else{

			#query if the user input is 'LIKE' the name in the Db
			$query = $db->query("SELECT oc_az, ocazpub_ip, ocazpri_ip FROM opencloud_az WHERE oc_az like '%".$keywords."%'");

			if ($query->num_rows) {
				while ($r = $query->fetch_object()) {
					echo "Owner:".$r->oc_az."<br>";
					echo "Public Range:".$r->ocazpub_ip."<br>";
					echo "Private Range:".$r->ocazpri_ip."<br>";
					echo "<br><br>";
				}
			}

		}
	}

	echo "</td>";
	echo "</table>";

	echo "<table class='table table-hover'>";
	echo "<thead><h1>Data Center</h1></thead>";
	echo "<td>";

	/*****
	*Data Center block
	*****/ 
	if (isset($query)) {

		#keywords is the user input
		$keywords = $db->escape_string($_GET['keywords']);

		#Checks if the input is an IP (w/ the assumption that if it contains ".", it can be considered an IP) 
		$isIP = substr_count($keywords,".");

		#If the input is an IP address, do this 
		if ($isIP){

			$query = $db->query("SELECT dc, ip_range FROM dc");

			if ($query->num_rows) {
				while ($r = $query->fetch_object()) {

					#If no input, display every IP segment
					if($keywords == ""){
						echo "Owner:".$r->dc."<br>";
						echo "IP Range:".$r->ip_range."<br>";
						echo "<br><br>";
					}

					#If there is input, do this
					else{

						#Initialize the arrays (refer to functions at the bottom)
						$networkList = [];
						$xList = [];
						$zeroList = [];
						$subNetwork = [];
						$subX = [];
						$subZero = [];


						$networkList = listNetworkAdd($keywords);
						$xList = listXAdd($networkList);
						$zeroList = listZeroAdd($networkList);

						$subNetwork = addSubnet($networkList);
						$subX = addSubnet($xList);
						$subZero = addSubnet($zeroList);

						#If there is a range in the IP segment in the ip list, do this
						if (withRange($r->ip_range) == true){
							#Get the IP addresses inside the range
							$newRange = ipRange($r->ip_range);
							$match = 0;

							if(sizeof($newRange) > 1){
								foreach ($newRange as $a) {

									/*************************************
									* Check if IP address (db side) has a slash notation for subnet mask
									* If it contains "/", get the substring before the slash (i.e. "192.168.1.0/24" -> "192.168.1.0")
									*************************************/
									$str = $a;
									$pos = strpos($str, "/");
									if ($pos !== false)
										$str = substr($str, 0, $pos);

									#Check if the substring is contained in the search input. If yes, print
									if(strpos($keywords, $str) !== false){
										echo "Owner:".$r->dc."<br>";
										echo "IP Range:".$r->ip_range."<br>";
										echo "<br><br>";

									}

									#If the substring is not contained in the search input, do this
									else {
										for($i = 0; $i < sizeof($networkList); $i++){

											#Compare the IP segment in the DB to every IP in the arrays, if match, print. Break to avoid repeated prints
											if (($a == $networkList[$i]) || ($a == $xList[$i]) || ($a == $zeroList[$i]) || ($a == $subNetwork[$i]) || ($a == $subX[$i]) || ($a == $subZero[$i])){
												echo "Owner:".$r->dc."<br>";
												echo "IP Range:".$r->ip_range."<br>";
												echo "<br><br>";
												$match = 1;
												break;
											}

											if ($match)
												break;

										}	

									}								
								}
							}


						}

						#If there is no range in the IP segment in the ip list, do this
						else if (withRange($r->ip_range) == false){
							$b = $r->ip_range;
							for($i = 0; $i < sizeof($networkList); $i++){

								#Compare the IP segment in the DB to every IP in the arrays, if match, print. Break to avoid repeated prints
								if(($b == $networkList[$i]) || ($b == $xList[$i]) || ($b == $zeroList[$i]) || ($b == $subNetwork[$i]) || ($b == $subX[$i]) || ($b == $subZero[$i])){
									echo "Owner:".$r->dc."<br>";
									echo "Public Range:".$r->ip_range."<br>";
									echo "<br><br>";
									break;
								}

							}

						}


					}
				}
			}
		}

		#If input is NOT an IP address, do this 
		else{
			#query if the user input is 'LIKE' the name in the Db
			$query = $db->query("SELECT dc, ip_range FROM dc WHERE dc like '%".$keywords."%'");

			if ($query->num_rows) {
				while ($r = $query->fetch_object()) {
					echo "Owner:".$r->dc."<br>";
					echo "Public Range:".$r->ip_range."<br>";
					echo "<br><br>";
				}
			}

		}
	}

	echo "</td>";
	echo "</table>";

	echo "<table class='table table-hover'>";
	echo "<thead><h1>Global IP List</h1></thead>";
	echo "<td>";

	/*****
	*Global IP block
	*****/ 
	if (isset($query)) {

		#keywords is the user input
		$keywords = $db->escape_string($_GET['keywords']);

		#Checks if the input is an IP (w/ the assumption that if it contains ".", it can be considered an IP) 
		$isIP = substr_count($keywords,".");

		#If the input is an IP address, do this
		if($isIP){

			$query = $db->query("SELECT regional, site, users, device_ip, network FROM global_ip");

			if ($query) {
			if ($query->num_rows) {

				while ($r = $query->fetch_object()) {
					#If no input, display every IP segment
					if($keywords == ""){
						echo "Regional:".$r->regional."<br>";
						echo "Site:".$r->site."<br>";
						echo "User:".$r->users."<br>";
						echo "Device IP:".$r->device_ip."<br>";
						echo "Network:".$r->network."<br>";
						echo "<br><br>";
					}

					#If there is input, do this
					else{

						#Initialize the arrays (refer to functions at the bottom)
						$networkList = [];
						$xList = [];
						$zeroList = [];
						$subNetwork = [];
						$subX = [];
						$subZero = [];


						$networkList = listNetworkAdd($keywords);
						$xList = listXAdd($networkList);
						$zeroList = listZeroAdd($networkList);

						$subNetwork = addSubnet($networkList);
						$subX = addSubnet($xList);
						$subZero = addSubnet($zeroList);

						#If there is a range in the IP segment in the device list, do this
						if (withRange($r->device_ip) == true){
							#Get the IP addresses inside the range
							$devIP = ipRange($r->device_ip);
							$match = 0;

							if(sizeof($devIP) > 1){
								foreach ($devIP as $a) {

									/*************************************
									* Check if IP address (db side) has a slash notation for subnet mask
									* If it contains "/", get the substring before the slash (i.e. "192.168.1.0/24" -> "192.168.1.0")
									*************************************/
									$str = $a;
									$pos = strpos($str, "/");
									if ($pos !== false)
										$str = substr($str, 0, $pos);

									#Check if the substring is contained in the search input. If yes, print
									if(strpos($keywords, $str) !== false){
										echo "Regional:".$r->regional."<br>";
										echo "Site:".$r->site."<br>";
										echo "User:".$r->users."<br>";
										echo "Device IP:".$r->device_ip."<br>";
										echo "Network:".$r->network."<br>";
										echo "<br><br>";

									}

									#If the substring is not contained in the search input, do this
									else {
										for($i = 0; $i < sizeof($networkList); $i++){

											#Compare the IP segment in the DB to every IP in the arrays, if match, print. Break to avoid repeated prints
											if (($a == $networkList[$i]) || ($a == $xList[$i]) || ($a == $zeroList[$i]) || ($a == $subNetwork[$i]) || ($a == $subX[$i]) || ($a == $subZero[$i])){
												echo "Regional:".$r->regional."<br>";
												echo "Site:".$r->site."<br>";
												echo "User:".$r->users."<br>";
												echo "Device IP:".$r->device_ip."<br>";
												echo "Network:".$r->network."<br>";
												echo "<br><br>";
												$match = 1;
												break;
											}

											if ($match)
												break;

										}	

									}
									if ($match)
											break;						
								}
							}
						}

						#If there is no range in the IP segment in the device list, do this
						else if (withRange($r->device_ip) == false){
							$b = $r->device_ip;
							for($i = 0; $i < sizeof($networkList); $i++){

								#Compare the IP segment in the DB to every IP in the arrays, if match, print. Break to avoid repeated prints
								if(($b == $networkList[$i]) || ($b == $xList[$i]) || ($b == $zeroList[$i]) || ($b == $subNetwork[$i]) || ($b == $subX[$i]) || ($b == $subZero[$i])){
									echo "Regional:".$r->regional."<br>";
									echo "Site:".$r->site."<br>";
									echo "User:".$r->users."<br>";
									echo "Device IP:".$r->device_ip."<br>";
									echo "Network:".$r->network."<br>";
									echo "<br><br>";
									break;
								}

							}

						}

						#If there is a range in the IP segment in the network list, do this
						if (withRange($r->network) == true){
							#Get the IP addresses inside the range
							$net = ipRange($r->network);

							if(sizeof($net) > 1){
								foreach ($net as $c) {

									/*************************************
									* Check if IP address (db side) has a slash notation for subnet mask
									* If it contains "/", get the substring before the slash (i.e. "192.168.1.0/24" -> "192.168.1.0")
									*************************************/
									$str = $c;
									$pos = strpos($str, "/");
									if ($pos !== false)
										$str = substr($str, 0, $pos);

									#Check if the substring is contained in the search input. If yes, print
									if(strpos($keywords, $str) !== false){
										echo "Regional:".$r->regional."<br>";
										echo "Site:".$r->site."<br>";
										echo "User:".$r->users."<br>";
										echo "Device IP:".$r->device_ip."<br>";
										echo "Network:".$r->network."<br>";
										echo "<br><br>";

									}
								}
							}
						}

						#If there is no range in the IP segment in the network list, do this
						else if (withRange($r->network) == false){
							$d = $r->network;
							for($i = 0; $i < sizeof($networkList); $i++){

								#Compare the IP segment in the DB to every IP in the arrays, if match, print. Break to avoid repeated prints
								if(($d == $networkList[$i]) || ($d == $xList[$i]) || ($d == $zeroList[$i]) || ($d == $subNetwork[$i]) || ($d == $subX[$i]) || ($d == $subZero[$i])){
									echo "Regional:".$r->regional."<br>";
									echo "Site:".$r->site."<br>";
									echo "User:".$r->users."<br>";
									echo "Device IP:".$r->device_ip."<br>";
									echo "Network:".$r->network."<br>";
									echo "<br><br>";
									break;
								}

							}

						}


					}
				}
			}
		}
	}

	#If input is NOT an IP address, do this 
	else{
		#query if the user input is 'LIKE' the name in the Db 
		$query = $db->query("SELECT regional, site, users, device_ip, network FROM global_ip WHERE regional like '%".$keywords."%' or site like '%".$keywords."%' or users like '%".$keywords."%'");

		if ($query->num_rows) {
			while ($r = $query->fetch_object()) {
				echo "Regional:".$r->regional."<br>";
				echo "Site:".$r->site."<br>";
				echo "User:".$r->users."<br>";
				echo "Device IP:".$r->device_ip."<br>";
				echo "Network:".$r->network."<br>";
				echo "<br><br>";
			}
		}

	}
}


echo "</td>";

echo "</table>";


	/***** 
   	**   Function to check if the IP segment in the database has a range
   	**   	e.g. 150.70.176-191 (separated by either a  "-" or a "~")
   	*****/
	function withRange($ip){

		$ipadd = explode(".", $ip);
		$withRange = false;

		for ($i = 0; $i < sizeof($ipadd); $i++){
			if((strpos(($ipadd[$i]), "-") == true) || (strpos($ipadd[$i], "~") == true))
				$withRange = true; 
		}
		

		return $withRange;

	}

	/***** 
    *   Function to compute for an ip range.
    *     i.e. Search input = 150.70.180.x, where "x" is any number from 0 to 255 
    *            Object in database = 150.70.176-191
    *   Since the object in the database has a range (specified by the use of a "-" or a "~")
    *   searching for the ip address will yield no results.
    * 
    *   This function will compute for a list of all ip addresses that can be found within the range specified.
    *   Then, we can traverse the list and compare each item to the search input
    *****/
    #Parameter is the search input
    function ipRange($ip){

        $ipArray = [];

        $ipadd = explode(".", $ip);

        #For loop that traverses the closely matching objects in the db
        #to check if it is composed of a range (specified with a "-" or a "~")
        for ($i = 0; $i < sizeof($ipadd); $i++){
        	if(strpos(($ipadd[$i]), "-") == true){
            	$octet = $i;
                $iprange = explode("-",$ipadd[$i]);
                $min = $iprange[0];
                $max = $iprange[1]; 
        	}
        	else if(strpos(($ipadd[$i]), "~") == true){
            	$octet = $i;
                $iprange = explode("~",$ipadd[$i]);
                $min = $iprange[0];
                $max = $iprange[1]; 
        	}

        }


        for($i = $min; $i <= $max; $i++){
            $ipadd[$octet] = $i;
           
            for ($j = 0; $j < sizeof($ipadd); $j++){

                $address = implode(".", $ipadd);
            }
            
            $ipArray[] = $address;
           
        }

        #Return the list of all IP addresses in the range
        return $ipArray;

    } 

   /***** 
   *   Functions included:
   *     -networkAdd
   *     -listNetworkAdd
   *     -listXAdd
   *     -listZeroAdd
   *     -addSubnet
   *  
   * These functions are used to compute for possible network addresses for a search input.
   *	Note: Only network addresses with subnet masks /8 - /32 are considered
   *
   *	This was found necessary as there are some values in the database with a subnet and some without a subnet indicated.
   *	There are also some values with a wildcard "x" and some values that are a compressed version of an IP (e.g. 10.42/16)
   *	which prompted for further computation to take into account these kinds of values.
   *****/


   	#Gets the network address of an IP address, with a specific subnet mask.
	function networkAdd($ipvar, $subnet){
		# $octetbit array is used in computing on how many '1' bits are in a specific octet of the IP address
		$octetbit = [128, 64, 32, 16, 8, 4, 2, 1];

		#To check which octet is the subnet mask located(in terms of count of 8),
    	#which will help in computing for the network address of the IP address
		$octetindex = floor((int)$subnet/8);

	    #To check the bits that overflowed from the biggest 8 count from the previous variable
	    #i.e. if the subnet is /25, 3 octets from the left are all 1s and in the 4th octet,
	    #the first bit from the left is set to 1 while the rest are set to 0 
		$octetrem = (int)$subnet%8;

		if ($octetindex == 4)
			return (implode(".", $ipvar));

	    #modresult is to maintain count for which bits will be set to '1' to get the value
	    #i.e. if the value is 3, then the 2nd bit from the right will be set to '1' and a value of
	    #1 will remain, making the 1st bit from the right, be set to '1' as well for a total value of 3
		$modresult = (int)$ipvar[$octetindex];
		$netconstant = 0;
		$i = 0;

		if ($octetrem == 0)
			for ($i = $octetindex; $i < 4; $i++ )
				$ipvar[$i] = "0";

		else if ($octetrem > 0){
			while ($i < $octetrem){
				if ($modresult >= $octetbit[$i]){
					$netconstant += $octetbit[$i];
					$modresult = $modresult % $octetbit[$i];
				}

				$i++;
			}

			$ipvar[$octetindex] = (string)$netconstant;

			for($j = $octetindex+1; $j < 4; $j++)
				$ipvar[$j] = "0";
		}

		$netadd = implode(".", $ipvar);

		return $netadd;

	}

	#Returns a list of all network addresses of an IP address with a subnet from /8 - /32
	function listNetworkAdd($searchadd){
    #sends the deconstructed IP to the networkAdd function

		$iplist = explode(".", $searchadd);

		$networkList = [];

		for($i = 8; $i < 33; $i++){
			$ipvar = explode(".", $searchadd);
			$temp = networkAdd($ipvar, $i);
			$networkList[] = $temp;
		}

		#echo"All network addresses</br>";

		return $networkList;
	}

	#Returns a list of all network addresses of an Ip address with an "x" replacing the trailing 0s (in the dotted decimal form)
	function listXAdd($networkList){
	#Checks for all the .0s in the network address and sets them to 'x'

		$xList = [];

		foreach($networkList as $m){
			$xadd = explode(".", $m);
			for($k = 3; $k > -1; $k--){
				if ($xadd[$k] == "0"){
					if ($k == 3){
						$xadd[$k] = "x";
					}
					else if ($xadd[$k+1] == "x"){
						$xadd[$k] = "x";
					}
				}
			}

			$xList[] = implode(".", $xadd);
		}

		#echo "</br></br> Network address w/ x </br>";

		return $xList;
	}

	#Returns a list of all network addresses of an Ip address with NO traling 0s (in dotted decimal form) e.g. 10.42/16
	function listZeroAdd($networkList){
	#Checks for all the .0s in the network address and omits the zero

		$zeroList = [];

		foreach ($networkList as $m){
			$zeroadd = explode(".", $m);
			for($k = 3; $k > -1; $k--){
				if ($zeroadd[$k] == "0"){
					if ($k == 3){
						array_splice($zeroadd, $k, $k);
					}
					else if ($zeroadd[sizeof($zeroadd)-1] == "0"){
						array_splice($zeroadd, sizeof($zeroadd)-1,sizeof($zeroadd)-1);
					}
				}

			}

			$zeroList[] = implode(".", $zeroadd);

		}

		return $zeroList;

	}

	#Returns the IP address complete with its subnet mask i.e. "IP Address" + "/" + "Subnet Mask"
	#This was found needed because of some ip segments having a subnet mask indicated and other ip segments without a subnet mask indicated
	function addSubnet($addList){
		$subList = [];

		for ($i = 0, $j = 8; $i < sizeof($addList), $j < 33; $i++, $j++){
			$address = $addList[$i] . "/" . $j;
			$subList[] = $address;
		}

		return $subList;
	}
?>

<table>

</div>

</body>
</html>