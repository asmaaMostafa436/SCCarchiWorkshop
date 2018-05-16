<?php
//header('Access-Control-Allow-Origin: https://sccworkshop.000webhostapp.com');  
DEFINE('DB_USER','webdev');
DEFINE('DB_PSWD','1234');
DEFINE('DB_HOST','localhost');
DEFINE('DB_NAME','workshop_users');
$conn=mysqli_connect(DB_HOST,DB_USER,DB_PSWD,DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if(isset($_GET['username']))
{
$sql = "SELECT * FROM users where name='".$_GET['username']."'";
$row = $conn->query($sql);
$output=array();
if ($row->num_rows > 0) 
{
    while($data = $row->fetch_assoc())
    $output[]=$data;
    }
           echo json_encode($output);

}//end get users
?>
  