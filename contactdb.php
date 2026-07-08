<?php
include_once 'session.php';
$email = $_POST['email'];
$name = $_POST['name'];
$message = $_POST['message'];
$subject = $_POST['subject'];
$query = "insert into Messages(name,email,message,subject)values('$name','$email','$message','$subject')";
$result = $db->insert($query);
if ($result) {
  echo "success";
  exit();
}

