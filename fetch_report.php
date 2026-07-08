<?php 
    include_once 'session.php'; // Include database connection
	include_once 'reportclass.php';
	
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $api = new Reports();
    
    $startDate = $_POST['startDate'] ?? null;
    $endDate = $_POST['endDate'] ?? null;
    $frequency = $_POST['frequency'] ?? 'none';
	$orderby = $_POST['orderby'] ?? 'none';
	$UserId = $_POST['UserId'] ?? 0;

    $restaurantData = $api->getAllRestaurantsOrders($db, $startDate, $endDate, $frequency,$orderby,$UserId);
    $itemData = $api->getAllItemsOrders($db, $startDate, $endDate, $frequency,$orderby,$UserId);

    
    echo json_encode(['restaurantData' => $restaurantData, 'itemData' => $itemData]);
}
?>
