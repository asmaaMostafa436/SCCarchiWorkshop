<?php
session_start();//useless as session is not passed accross domains! destroyed once there is http connection
//yet used to use the session ID for setting the cookie, which can be passed between sub domains in the same domain!!!
header('Access-Control-Allow-Origin: https://sccworkshop.000webhostapp.com');//HAS to be defined not wild card as passing cookie should be between devices of the same domains  
header('Access-Control-Allow-Credentials: true');//essential for passing cookies
header('Content-Type: application/json');//useless but doesn't hurt to specify
$response=new \stdClass();//to initialize the json response
	$response->success = 4;//my default, developer can choose anything
	if(isset($_GET['request']))//my ugly way of making logout request, it does the job anyways:)
	{
	setcookie("user",null, -1,'/');//set the cookie to be in the past
	unset($_COOKIE["user"]);//double check the cookie is deleted by deleting it
		$response->success = 5;//just to redirect the user to login page if logout was successful
	}
else if(isset($_COOKIE["user"]))//if user is already logged in should just exit and no need to get username and password again
	$response->success = 1;//my definition of user is logged in
else
{
define("DBHOST","localhost");
define("DBUSER","id513978_webdev");
define("DBPWD","12345");
define("DBNAME","id513978_workshop_users");
$con = mysqli_connect(DBHOST,DBUSER,DBPWD,DBNAME);
if(mysqli_connect_errno($con))
{
//I want to set the following numbers(5 loggedout, 4 for server down, 3 for database error, 2 for incorrect pwd/usrname, 1 already logged in, 0 success)
	$response->success = 3;
}
else if(isset($_POST["usrname"]) && isset($_POST["pwd"]))
{
$username = $_POST['usrname'];
$password = $_POST['pwd']; 
$query = "SELECT * FROM user WHERE username = '$username'
			AND password = '$password'";
			
$result = mysqli_query($con,$query);

if(mysqli_num_rows($result)>0){
setcookie("user",session_id(), time()+432000,'/');//set the cookie when the user logs in for the first time
$response->success = 0;
	}
else
	$response->success = 2;//no result which means incorrect username or password
}//if database connection is successful
mysqli_close($con);
}//if new session
echo json_encode($response);//finally echo the result as json object