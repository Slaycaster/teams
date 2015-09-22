<?php

//http://stackoverflow.com/questions/18382740/cors-not-working-php
	// Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }

    $con = mysqli_connect("localhost","root","","teams_db");
	if (mysqli_connect_errno($con))
	{
	   echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
    //http://stackoverflow.com/questions/15485354/angular-http-post-to-php-and-undefined
    $postdata = file_get_contents("php://input");
	if (isset($postdata)) {
		$request = json_decode($postdata);
		$username = $request->user;
		$password = $request->pass;
	}
	else {
		echo "Not called properly with username parameter!";
	}
	
	//Query Employee Info
	$result = mysqli_query($con,"SELECT * FROM employs where employee_number='$username' and password='$password'");
	$row = mysqli_fetch_array($result);

	
if($row){

	//Query Employee's Department
	$department_query = mysqli_query($con, "SELECT name FROM departments WHERE id=". $row['department_id'] .";");
	$department_name = mysqli_fetch_array($department_query);

	//Query Employee's Job Title
	$jobtitle_query = mysqli_query($con, "SELECT jobtitle_name FROM jobtitles WHERE id=". $row['jobtitle_id'] .";");
	$jobtitle_name = mysqli_fetch_array($jobtitle_query);

	
	$fname = $row['fname'];
	

$emp_number = $row['employee_number'];
$emp_pass = $row['password'];
$lname = $row['lname'];
$email = $row['email'];
$id = $row['id'];
$picture_path = $row['picture_path'];
$qrcode = $row['qr_code'];
$department = $department_name['name'];
$jobtitle_name = $jobtitle_name['jobtitle_name'];

	/*
	echo $fname; //0
	echo ",";
	echo $lname; //1
	echo ",";
	echo $email; //2
	echo ",";
	echo $id; //3
	echo ",";
	echo $department; //4
	echo ",";
	echo $jobtitle_name; //5
	echo ",";
	echo $firstname; //6
	echo ",";
	echo $qrcode; //7
	*/
	$employee = array(
		"id" => $id,
		"employee_number" => $emp_number,
		"password" => $emp_pass,
		"fname" => $fname,
		"lname" => $lname,
		"picture_path" => $picture_path,
		"department" => $department,
		"jobtitle" => $jobtitle_name,
		"qrcode" => $qrcode
	);

	echo $json_response = json_encode($employee);
}
else
{
	echo 'err';
}
mysqli_close($con);
?>