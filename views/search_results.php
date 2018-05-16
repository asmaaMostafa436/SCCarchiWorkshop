<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="sadeem">
 
    <title>MVC Server Example</title>
  </head>
  <body>
      <h2>MVC Server Example</h2>
<form action ="/mvcserver/welcome/search" method="get">
    Enter Name: <input type="text" name="username" />
</form>
  <h2> Result:</h2>
    <table style="width:100%">
    <th>ID</th>
    <th>Name</th>
    <th>Age</th>
    <th>Gender</th>
    <?php 
    foreach($users as $user): ?>
        <tr><td><?php echo $user['id']; ?></td>
        <td><?php echo $user['name']; ?></td>
        <td><?php echo $user['age']; ?></td>
        <td><?php echo $user['gender']; ?></td></tr>
    <?php endforeach; ?>
    </table>
    </body>
</html>
