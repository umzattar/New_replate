<?php
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
include_once '../sendEmail.php';
$apiEmail = new sendEmail();
require 'config.php';

if (empty($_GET['paymentId']) || empty($_GET['PayerID'])) {
    throw new Exception('The response is missing the paymentId and PayerID');
}

$paymentId = $_GET['paymentId'];
$payment = Payment::get($paymentId, $apiContext);
$userId=$_SESSION['Id'];
$ordercode=$_SESSION['ordercode'];
$bookEmail=$_SESSION['bookEmail'];
$bookName=$_SESSION['bookName'];

$execution = new PaymentExecution();
$execution->setPayerId($_GET['PayerID']);

try {
    // Take the payment
    $payment->execute($execution, $apiContext);

    try {
        $dbm = new mysqli($dbConfig['host'], $dbConfig['username'], $dbConfig['password'], $dbConfig['name']);

        $payment = Payment::get($paymentId, $apiContext);

        $data = [
            'product_id' => $payment->transactions[0]->item_list->items[0]->sku,
            'transaction_id' => $payment->getId(),
            'payment_amount' => $payment->transactions[0]->amount->total,
            'currency_code' => $payment->transactions[0]->amount->currency,
            'payment_status' => $payment->getState(),
            'invoice_id' => $payment->transactions[0]->invoice_number,
            'product_name' => $payment->transactions[0]->item_list->items[0]->name,
			'description' => $payment->transactions[0]->description,
			'ordercode' => $ordercode,
			'UsrId' => $userId,
        ];
       if (addPayment($data) !== false && $data['payment_status'] === 'approved') {
            // Payment successfully added, redirect to the payment complete page.
			$inserids =$dbm->insert_id;
			$Id=(int)$data['product_id'];
			$query = "update orders set payment=1 where UsrId=$userId and ordercode ='$ordercode'";
			$result = $db->update($query);
			
			$email = $bookEmail;
			$invoice_id =$data['invoice_id'];
			$transaction_id =$data['transaction_id'];
			$payment_amount =$data['payment_amount'];
			$payment_status =$data['payment_status'];
			
			$product_name =$data['product_name'];
			$UserName = $bookName;
		    $subject = "Payment WE-CARE";
			 
		   $message = "<div style=\"background-color: #f1f1f1; padding: 20px;\">";
		   $message .="<h3 style=\"color: #333333; font-size: 20px; margin-bottom: 10px;\">";
           $message .= "Payment has been made successfully.</h3>";
		   
		   $message .="<h3 style=\"color: #1c3ab6; font-size: 18px; margin-bottom: 10px;\">";
           $message .= "Payment Information</h3>";
		   $message .= "<ul style=\"list-style-type: none; margin: 0; padding: 0;\">";
		   $message .= "<li><strong>Order Code:</strong>  $ordercode </li>";
		   $message .= "<li><strong>Reference Number :</strong>  $invoice_id </li>";
		   $message .= "<li><strong>Transaction ID:</strong>  $transaction_id </li>";
		   $message .= "<li><strong>Paid Amount:$</strong>  $payment_amount</li>";
		   $message .= "<li><strong>Payment Status:</strong>  $payment_status </li>";
		   $message .= "</ul>";
		   
		   $message .="<br/><h3 style=\"color: #1c3ab6; font-size: 18px; margin-bottom: 10px;\">";
           $message .= "Payment-Details Information</h3>";
		   $message .= "<table style=\"background-color: #ffffff;font-size: 1rem;\">
                       <thead style=\"background-color: #007bff;color: white;\">
            <tr>
                <th style=\"vertical-align: middle;\" scope=\"col\">Food ID</th>
                <th style=\"vertical-align: middle;\" scope=\"col\">Food Name</th>
                <th style=\"vertical-align: middle;\" scope=\"col\">Quantity</th>
                <th style=\"vertical-align: middle;\" scope=\"col\">Total</th>
            </tr>
        </thead>
        <tbody>";
		   
		   $query = "select total,tax,fee,discount_points,netTotal from orders f where UsrId=$userId and ordercode ='$ordercode'";
           $result = $db->getData($query);
		  while ($rows = mysqli_fetch_array($result)) {
		   $Total =(float) $rows['total'];
           $Tax = (float)$rows['tax'];
           $Fee = (float)$rows['fee'];
	       $Discount = (float)$rows['discount_points'];
	       $netTotal = (float)$rows['netTotal'];
	
		    $querydt = "SELECT UsrId,(foodid)id,(select title from foods where id=g.foodid)name"
					  ." ,qty,price from orders_details g where ordercode='$ordercode' and UsrId=$userId";
			$resultdt = $db->getData($querydt); 
			while ($rowsdt = mysqli_fetch_array($resultdt)) {
                    $proId = $rowsdt['id'];
                    $proname = $rowsdt['name'];
                    $price = (float)$rowsdt['price'];
                    $qty = (float)$rowsdt['qty'];
                    $total = $price * $qty;
				$message .="<tr>";
                $message .="<td style=\"vertical-align: middle;\" >$proId</td>";
                $message .="<td style=\"vertical-align: middle;\" >$proname</td>";
                $message .="<td style=\"vertical-align: middle;\" >$qty</td>";
                $message .="<td style=\"vertical-align: middle;\" >$$total</td>";
                $message .="</tr>";
			}
			
		   
		   $message .= "</tbody></table>";
		   $message .="<h3 style=\"color: #3f32e9; font-size: 18px; margin-bottom: 5px;\">sub Total=$Total</h3>";
		   $message .="<h3 style=\"color: #3f32e9; font-size: 18px; margin-bottom: 5px;\">Tax(10%)=$Tax</h3>";
		   $message .="<h3 style=\"color: #3f32e9; font-size: 18px; margin-bottom: 5px;\">Fee=$Fee</h3>";
		   $message .="<h3 style=\"color: #3f32e9; font-size: 18px; margin-bottom: 5px;\">Discount=$Discount</h3>";
		   $message .="<h3 style=\"color: #3f32e9; font-size: 18px; margin-bottom: 5px;\">net Total=$netTotal</h3>";
		   
		   $message .="<div style=\"color: #333333; font-size: 16px; margin-bottom: 5px;\">";
		   $message .= "<h3>Thank you, for trusting us!</h3>";
           $message .= "<h3 style=\"color: #3f32e9; text-align: center; \">Best regards,WE CARE</h3></div>";
		   $message .= "</div>";
			}
		   $sndmail=0;
		   try {
           $IsSend = $apiEmail->sendMessageEmail($email, $UserName, $subject, $message);
		   } catch (Exception $e) {}
            header("location:{$paypalConfig['success_url']}?payid=$inserids");
            exit(1);
        } else {
            // Payment failed
			header("location:{$paypalConfig['failed_url']}");
             exit(1);
        }

    } catch (Exception $e) {
        // Failed to retrieve payment from PayPal
		  // Capture the error message
            $errorMessage = htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
          // Output JavaScript alert with the error message
           echo "<script>alert('Error: " . $errorMessage . "');</script>";
    }

} catch (Exception $e) {
    // Failed to take payment

}

/**
 * Add payment to database
 *
 * @param array $data Payment data
 * @return int|bool ID of new payment or false if failed
 */
function addPayment($data)
{
    global $dbm;

    if (is_array($data)) {
        // Prepare statement with 10 columns (excluding the auto-incremented `id`)
        $stmt = $dbm->prepare(
            'INSERT INTO `payments` (product_id, transaction_id, payment_amount, currency_code, payment_status, invoice_id, product_name, ordercode, UsrId, createdtime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );

        $stmt->bind_param(
            'ssdssssiss', // Format string to match the values
            $data['product_id'],
            $data['transaction_id'],
            $data['payment_amount'],
            $data['currency_code'],
            $data['payment_status'],
            $data['invoice_id'],
            $data['product_name'],
            $data['ordercode'],
            $data['UsrId'],
            date('Y-m-d H:i:s')
        );

        $stmt->execute();
        $stmt->close();
        
        return $dbm->insert_id;
    }

    return false;
}
