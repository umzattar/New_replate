<?php
class Reports
{
	public function getAllRestaurantsOrders($db, $startDate = null, $endDate = null, $frequency = 'none',$orderby = 'none',$usrid =0) {
    $dateCondition = "";
    if ($startDate && $endDate) {
        $dateCondition = "AND DATE(od.v_date) BETWEEN '$startDate' AND '$endDate'";
    }
	

    // Define date grouping and label for periods
	$dateOrdering = "''";
    $dateGrouping = "''";
    $periodLabel = "''";
	
    if ($frequency == 'weekly') {
        $dateGrouping = "YEAR(od.v_date), WEEK(od.v_date)";  // Group by year and week number
        $periodLabel = "CONCAT('Week ', WEEK(od.v_date, 1) - WEEK('$startDate', 1) + 1)";  // Label weeks as "Week 1", "Week 2", etc.
    } elseif ($frequency == 'monthly') {
        $dateGrouping = "YEAR(od.v_date), MONTH(od.v_date)";  // Group by year and month
        $periodLabel = "DATE_FORMAT(od.v_date, '%Y-%m')";      // Label months as "YYYY-MM"
    } elseif ($frequency == 'daily') {
        $dateGrouping = "DATE(od.v_date)";
        $periodLabel = "DATE_FORMAT(od.v_date, '%Y-%m-%d')";  // Label dates as "YYYY-MM-DD"
    }
	if ($orderby == 'request_count') {
		$dateOrdering="request_count";
	} elseif ($orderby == 'quantity') {
		$dateOrdering="total_qty";
	} elseif ($orderby == 'amount') {
		$dateOrdering="total_revenue";
	}

    // Query with dynamic period labeling based on frequency
    $query = "SELECT r.id AS restaurant_Id,r.name AS restaurant_name, COUNT(r.id) AS request_count,
                     SUM(od.total) AS total_revenue, SUM(od.qty) AS total_qty,
                     $periodLabel AS period
              FROM orders_details od
              JOIN foods f ON od.foodid = f.id
              JOIN resturants r ON f.rest_id = r.id
              WHERE 1=1 $dateCondition
              GROUP BY r.id, restaurant_name, $dateGrouping
              ORDER BY $dateOrdering DESC
              LIMIT 10";

    $result = $db->getData($query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

public function getAllItemsOrders($db, $startDate = null, $endDate = null, $frequency = 'none',$orderby = 'none',$usrid =0)
{
			$dateCondition = "";
            if ($startDate && $endDate) {
                    $dateCondition = "AND DATE(od.v_date) BETWEEN '$startDate' AND '$endDate'";
            }
			// Define date grouping and label for periods
	$dateOrdering = "''";
    $dateGrouping = "''";
    $periodLabel = "''";
    if ($frequency == 'weekly') {
        $dateGrouping = "YEAR(od.v_date), WEEK(od.v_date)";  // Group by year and week number
        $periodLabel = "CONCAT('Week ', WEEK(od.v_date, 1) - WEEK('$startDate', 1) + 1)";  // Label weeks as "Week 1", "Week 2", etc.
    } elseif ($frequency == 'monthly') {
        $dateGrouping = "YEAR(od.v_date), MONTH(od.v_date)";  // Group by year and month
        $periodLabel = "DATE_FORMAT(od.v_date, '%Y-%m')";      // Label months as "YYYY-MM"
    } elseif ($frequency == 'daily') {
        $dateGrouping = "DATE(od.v_date)";
        $periodLabel = "DATE_FORMAT(od.v_date, '%Y-%m-%d')";  // Label dates as "YYYY-MM-DD"
    }
	
	if ($orderby == 'request_count') {
		$dateOrdering="request_count";
	} elseif ($orderby == 'quantity') {
		$dateOrdering="total_qty";
	} elseif ($orderby == 'amount') {
		$dateOrdering="total_revenue";
	}
	      $query = "SELECT f.id AS item_Id,f.title AS item_name, COUNT(od.foodid) AS request_count 
		            ,SUM(od.total) AS total_revenue,SUM(od.qty) AS total_qty , $periodLabel AS period
                    FROM orders_details od 
                    JOIN foods f ON od.foodid = f.id 
					WHERE 1=1 $dateCondition 
                    GROUP BY f.id, item_name , $dateGrouping
                    ORDER BY $dateOrdering DESC 
                    LIMIT 10;";
		  $result = $db->getData($query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
		
}

?>