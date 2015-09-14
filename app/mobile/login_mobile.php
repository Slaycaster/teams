<?php
$con=mysqli_connect("localhost","root","","teams_db");
if (mysqli_connect_errno($con))
{
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$username = $_POST['username'];
$password = $_POST['password'];
$result = mysqli_query($con,"SELECT * FROM employs where employee_number='$username' and password='$password'");
$row = mysqli_fetch_array($result);

$department_query = mysqli_query($con, "SELECT name FROM departments WHERE id=". $row['department_id'] .";");
$department_name = mysqli_fetch_array($department_query);

$firstname = $row['fname'];
if (preg_match('/\s/',$firstname)) //checks if theres whitespace in firstname
{
	$fname = preg_replace('/\s+/', '', $firstname);
} else
{
	$fname = $row['fname'];
}
$lname = $row['lname'];
$email = $row['email'];
$id = $row['id'];
$qrcode = $row['qr_code'];
$department = $department_name['name'];
$jobtitle_name = $row['jobtitle_name'];
if($row){
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
}
else
{
	echo 'err';
}
mysqli_close($con);
?>