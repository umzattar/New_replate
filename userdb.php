<?php
$type=(int)0;
$UserName="";
$UsrId=(int)0;
$IsValidate=(int)0;

$IsUnLogin=(!isset($_SESSION['Id']) || ($_SESSION['Id'] == ''));
if($IsUnLogin)
{
include_once 'dbcon.php';
$db = new Conn();
$db->getConnection();
session_start();
}
else
{
 include_once 'session.php';
}

if (isset($_POST['type'])) {
	$type=(int)$_POST['type'];
}
if ($type==1)  //Login 
{
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $query = "select * from users where email='$email'";
    $row = $db->SelectQuery($query);
	if ($row){
              if (isset($row['PassWord']) && password_verify($pass, $row['PassWord'])) {
                $IsActive = $row['IsActive'];
                $UsrId = $row['UserId'];
                $UserName=$row['UserName'];
		        $IsValidate=1;
                if ($IsActive == 0) {
                     echo "The current user is not active";
                     exit();
                }
              } 
			  else {
                        echo "There is an error in the password and email. ";
						exit();
			       }
            }      
			else {
                   echo "There is an error in the password and email. ";
				   exit();
                 }
}
else if ($type==2) //SignUp 
{
    $email = $_POST['email'];
    $pass = $_POST['password'];
	$hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
    $name = $_POST['name'];
    $query = "select * from users where email='$email' or UserName='$name'";
    $num_row = $db->getRows($query);
    if ($num_row > 0) {
         echo "the email or name already exists";
		 exit();
	}
    $query="insert into users(AccountType,UserName,Email,PassWord,IsActive)values(1,'$name','$email','$hashedPassword',1)";
    $result=$db->insert($query);
    if($result)
    {
		$query="select UserId,UserName from users where email='$email'";
		$row =$db->SelectQuery($query);
		$UsrId = $row['UserId'];
        $UserName=$row['UserName'];
		$IsValidate=1;
    }
}
else if ($type==3) //Save Account 
{
    $oldPassword = $_POST['oldPassword'];
	$newPassword = $_POST['newPassword'];
    $name = $_POST['name'];
    $email= $_POST['email'];
	$UsrId=(int)$_POST['UsrId'];
	
	$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
	   $query = "SELECT * FROM users WHERE UserId=$UsrId";
       $row = $db->SelectQuery($query);
	if ($row) {
		$IsVerify=1;
	   if (isset($row['PassWord']) && !empty($row['PassWord']) && $row['PassWord'] !== null) {
		   $IsVerify=0;
       if (password_verify($oldPassword, $row['PassWord'])) 
		   $IsVerify=1;
	   }
	   if($IsVerify==1)
	   {
		$query="update users set PassWord='$hashedPassword',UserName='$name' where UserId=$UsrId";
		$result = $db->update($query);
        if ($result) {
           $UserName=$name;
		   $IsValidate=1;
        }
	   }
	   else
	   {
		   echo "There is an error in the old password.";
		   exit();
	   }
	 }  else {
	      echo "try again.";
	      exit();
	 }
}

if($IsValidate==1)
{
	    $_SESSION['Id'] = $UsrId;
        $_SESSION['Name']=$UserName;
		//$_SESSION['Password']=$pass;
		
		$_SESSION['Email']=$email;
        $_SESSION['start'] = time();
        $_SESSION['expire'] = $_SESSION['start'] + ((60 * 60) * 24 * 30);
        echo "success";
        exit();
}
