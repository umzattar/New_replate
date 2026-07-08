<?php
include_once 'session.php';
include_once 'mypoints.php';
include_once 'sendEmail.php';
$sendmail = new sendEmail();
$mypoint = new MyPoints();
	$usrid = $_SESSION['Id'];
	 $UName = $_POST['name'];
	 $Email = $_POST['email'];
	 $Address = $_POST['address'];
	 
    $Total =(float) $_POST['Total'];
    $Tax = (float)$_POST['Tax'];
    $Fee = (float)$_POST['Fee'];
	$Discount = (float)$_POST['Discount'];
	$netTotal = (float)$_POST['netTotal'];
	$StatPoints = (float)$_POST['StatPoints'];
	$v_date = date("Y-m-d H:i:s");
    $ordercode = substr(number_format(time() * rand(), 0, '', ''), 0, 8);
	
	$query = "INSERT INTO orders (usrid,name,email,address, total, tax, fee,discount_points, netTotal,ordercode,v_date)"
            . "values($usrid,'$UName','$Email','$Address',$Total,$Tax,$Fee,$Discount,$netTotal,'$ordercode','$v_date')";
        $result = $db->insert($query);
 if ($result) {
	 if($StatPoints==1)
	 {
		 if($mypoint->isAllowPoint())
		 {
			 $valueCheck=$mypoint->getValueOrder();
		    if ($netTotal >= $valueCheck) {
				$Bonuspoint=$mypoint->getBonuspoint();
                 $query = "INSERT INTO mypoints (userid, ordercode, v_date, total, countpoints) 
                 VALUES ($usrid, '$ordercode', '$v_date', $netTotal,$Bonuspoint)";
                 $result= $db->insert($query);
            }
		 }
	 }
	 else
	 {
		 if($Discount>0)
		 {
			  $query = "UPDATE mypoints SET state = 1,code_discount_points='$ordercode' WHERE userid = $usrid AND state = 0";
			  $result=$db->update($query);
		 }
	 }
	 if ($result) {
		 
		 $subject = "Order Confirmation - Order #$ordercode";
		   $messageBody= "<div style=\"background-color: #f1f1f1; padding: 20px;\">";
		   $messageBody .="<h3 style=\"color: #333333; font-size: 20px; margin-bottom: 10px;\">";
           $messageBody .= "Dear Customer | $UName</h3>";
		   $messageBody .="<h3 style=\"color: #333333; font-size: 20px; margin-bottom: 10px;\">";
           $messageBody .= "Your order (Order Number: #$ordercode) has been successfully.</h3>";
		   $messageBody .="<h3 style=\"color: #3f32e9; font-size: 18px; margin-bottom: 10px;\">Ordered Products:</h3>";
		   $messageBody .= "<ul style=\"list-style-type: none; margin: 0; padding: 0;\">";
		   
    $cardsData = json_decode($_POST['cardsData']);
	$count=(int)0;
    foreach ($cardsData as $card) {
		$foodid = $card->foodid;
		$foodName = $card->foodName;
		$quantity = $card->quantity;
		$price = $card->price;
		$sumTotal = $card->sumTotal;
		
		$query = "INSERT INTO orders_details (usrid,ordercode,foodid,qty,price, total,v_date)"
            . "values($usrid,'$ordercode',$foodid,$quantity,$price,$sumTotal,'$v_date')";
		
        $result1 = $db->insert($query);
		if ($result1) {
			$query = "delete from mycart where foodid=$foodid and usrid=$usrid and type=1";
            $db->deletedb($query);
			$count=$count+1;
			 $messageBody .= "<li><strong>$count . $foodName :</strong> Qty:$quantity - Price $$price</li>";
		}
	}
	if ($result) {
		   $messageBody .= "</ul>";
		   $messageBody .="<h3 style=\"color: #3f32e9; font-size: 18px; margin-bottom: 5px;\">sub Total=$Total</h3>";
		   $messageBody .="<h3 style=\"color: #3f32e9; font-size: 18px; margin-bottom: 5px;\">Tax(10%)=$Tax</h3>";
		   $messageBody .="<h3 style=\"color: #3f32e9; font-size: 18px; margin-bottom: 5px;\">Fee=$Fee</h3>";
		   $messageBody .="<h3 style=\"color: #3f32e9; font-size: 18px; margin-bottom: 5px;\">Discount=$Discount</h3>";
		   $messageBody .="<h3 style=\"color: #3f32e9; font-size: 18px; margin-bottom: 5px;\">net Total=$netTotal</h3>";
		   $messageBody .="<div style=\"color: #333333; font-size: 16px; margin-bottom: 5px;\">";
		   $messageBody .= "<h3>Thank you for shopping with us!</h3>";
           $messageBody .= "<h3 style=\"color: #3f32e9; text-align: center; \">Best regards,WE CARE</h3></div>";
		   $messageBody .= "</div>";
		   $isSending = $sendmail->sendMessageEmail($Email, $UName, $subject, $messageBody);
		
            echo "success:".$ordercode;
            exit();
        }
	 }
	 else
	 {
		 $query = "delete from orders where ordercode='$ordercode' and usrid=$usrid";
         $db->deletedb($query);
	 }
}
		
    