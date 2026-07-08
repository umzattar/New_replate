<?php
include_once 'session.php';
include_once 'reportclass.php';
$api = new Reports();
$UserName = '';
$UserId=(int)0;
$type =(int)0;
$IsUnLogin=(!isset($_SESSION['Id']) || ($_SESSION['Id'] == ''));
//start session 
if ($IsUnLogin) {
} else {
  $UserId =(int)$_SESSION['Id'];
  $UserName =$_SESSION['Name'];
}
if (isset($_GET['type'])) {
	$type = (int)$_GET['type'];
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>WE CARE | Reports</title>
		 <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css" />
         <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
         
        <!-- Bootstrap icons-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
		 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- Theme CSS Bootstrap-->
        <link href="css/bootstrap.min.css" rel="stylesheet" />
		<!-- Theme CSS Bootstrap-->
        <link href="css/styles.css" rel="stylesheet" />
		<style>
		
        .filter-container {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .filter-container h3 {
            font-weight: bold;
            font-size: 1.2em;
        }
        
        .chart-section {
            margin-bottom: 2rem;
        }
       .chart-container {
            border: 1px solid #ccc;
            padding: 10px;
            transition: width 0.5s, height 0.5s;
        }
        .zoomed {
            width: 100%;
            height: 500px;
        }
       
    </style>
    </head>
    <body>
        <!-- Navigation-->
		
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="index.php">WE CARE <i class="fas fa-leaf me-1"></i></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link" aria-current="page" href="index.php">Home</a></li>
                    
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Resturants</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="foods.php?restid=0">All Foods</a></li>
                                <li><hr class="dropdown-divider" /></li>
								<?php 
		                           $query = "select * from resturants where state=1 order by id";
                                   $result = $db->getData($query);
                                   while ($rows = mysqli_fetch_array($result)) {
		                                  $resid = $rows['id'];
                                          $resname = $rows['name'];
                                    ?>
								 <li>
								  <a class="dropdown-item" href="foods.php?restid=<?php echo $resid; ?>&restname=<?php echo $resname; ?>">
								    <?php echo $resname; ?>
								  </a>
								</li>
								   <?php }?>
                            </ul>
                        </li>
						<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Reports</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
							    <li><a class="dropdown-item" href="reports.php">Top Resturants && Foods</a></li>
                                <li><a class="dropdown-item" href="reports.php?type=1">Top Resturants</a></li>
                                <li><a class="dropdown-item" href="reports.php?type=2">Top Foods</a></li>
								
                            </ul>
                        </li>
						<li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
						<li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
						<?php if ($IsUnLogin){?>
		                      <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
		                 <?php } else {?>
			               <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Account <?php echo $UserName; ?></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="myaccount.php">Profile</a></li>
								<li><a class="dropdown-item" href="myorders.php">My Orders</a></li>
                                <li><hr class="dropdown-divider" /></li>
								<li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                          </li>
					     <?php } ?>
                    </ul>
                    <?php if (!$IsUnLogin){
			             $ccart='';
			             $query="select * from mycart where usrid=$UserId and type=1";
			             $cont_cart = $db->getRows($query);
			             if($cont_cart>0)
				             $ccart=$cont_cart;
						?>
                    <div class="d-flex">
                        <button class="btn btn-outline-dark btn-shopping-cart" type="submit">
                            <i class="fas fa-shopping-cart me-1"></i>
                             Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill"><?php echo $ccart;?></span>
                        </button>
                    </div>
					 <?php } ?>
                </div>
            </div>
        </nav>
        
		<?php
		  $v_date = date("Y-m-d");
          $restaurant_data=$api->getAllRestaurantsOrders($db,$v_date,$v_date);
		  $item_data=$api->getAllItemsOrders($db,$v_date,$v_date);
		?>
 <section class="container min-vh-100 my-4">
 <div class="container mt-4">
  <div class="row mb-3">
  
  <div class="col-lg-3">
  <div class="filter-container">
            <h3>Filter</h3>
            <div class="mb-3">
                <label for="startDate" class="form-label">Start Date</label>
                <input type="date" id="startDate" class="form-control" value="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="mb-3">
                <label for="endDate" class="form-label">End Date</label>
                <input type="date" id="endDate" class="form-control" value="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="mb-3">
                <label for="frequency" class="form-label">Frequency</label>
                <select id="frequency" class="form-control">
                    <option value="none">None</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                </select>
            </div>
			<div class="mb-3">
                <label for="orderby" class="form-label">Order By</label>
                <select id="orderby" class="form-control">
                    <option value="request_count">Request Count</option>
                    <option value="quantity">Quantity</option>
                    <option value="amount">Amount</option>
                </select>
            </div>
            <button id="filterBtn" class="btn btn-dark w-100">Filter</button>
   </div>
   
   </div>
   
    <div class="col-lg-9">
	<!-- Right Chart Section -->
        <div class="chart-container">
		    <?php 
			 $hideRest='';
			 $hideItm='';
			 if($type==1)
			 {
				
			    $hideItm=' d-none';
			 }
			 else if($type==2)
			 {
				 $hideRest=' d-none';
			 }
			?>
            <div class="chart-section text-center <?php echo $hideRest;?>">
                <h2>Top 10 Orders Restaurants</h2>
                <button id="zoomRestaurantBtn" class="btn btn-primary d-none">Zoom Restaurant Chart</button>
                <div id="restaurantChartContainer" class="mt-3">
                    <canvas id="restaurantChart"></canvas>
                </div>
            </div>
            
			
            <div class="chart-section text-center <?php echo $hideItm;?>">
                <h2 class="mt-5">Top 10 Orders Items</h2>
                <button id="zoomItemBtn" class="btn btn-primary d-none">Zoom Item Chart</button>
                <div id="itemChartContainer" class="mt-3">
                    <canvas id="itemChart"></canvas>
                </div>
            </div>
			
        </div>
    </div>
	</div>	
  </div>	  
</section>

		
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; www.WECARE.com 2024</p></div>
        </footer>
		
		
		<script src="js/jquery.min.js"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
		<!-- Bootstrap core JS-->
        <script src="js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
		<script>
		$(document).ready(function() {
			
		 $('.btn-shopping-cart').on('click', function(e) {
            e.preventDefault(); // Prevent the default anchor behavior
            const a = document.createElement('a');
            a.href = 'cards.php';
			a.target='_blank';
            a.click();
			
        });
		
	 });
	 
$(document).ready(function () {
	
	let restaurantChart;
   let itemChart;
   
   // Toggle Zoom on Restaurant Chart
        document.getElementById('zoomRestaurantBtn').addEventListener('click', function() {
            document.getElementById('restaurantChartContainer').classList.toggle('zoomed');
        });

        // Toggle Zoom on Item Chart
        document.getElementById('zoomItemBtn').addEventListener('click', function() {
            document.getElementById('itemChartContainer').classList.toggle('zoomed');
        });

	// PHP Data to JavaScript
const restaurantData = <?php echo json_encode($restaurant_data); ?>;
const itemData = <?php echo json_encode($item_data); ?>;

// Restaurant Chart Data
const restaurantNames = restaurantData.map(data => `${data.restaurant_name} (${data.period})`);
const restaurantRequests = restaurantData.map(data => data.request_count);
const restaurantRevenue = restaurantData.map(data => data.total_revenue);
const restaurantQty = restaurantData.map(data => data.total_qty);

// Item Chart Data
const itemNames = itemData.map(data => `${data.item_name} (${data.period})`);
const itemRequests = itemData.map(data => data.request_count);
const itemRevenue = itemData.map(data => data.total_revenue);
const itemQty = itemData.map(data => data.total_qty);

// Initialize Restaurant Chart
restaurantChart = new Chart(document.getElementById('restaurantChart'), {
    type: 'bar',
    data: {
        labels: restaurantNames,
        datasets: [
            { label: 'Orders', data: restaurantRequests, backgroundColor: 'rgba(75, 192, 192, 0.6)' },
            { label: 'Amount', data: restaurantRevenue, backgroundColor: 'rgba(255, 159, 64, 0.6)' },
            { label: 'Quantity', data: restaurantQty, backgroundColor: 'rgba(153, 102, 255, 0.6)' }
        ]
    },
    options: { responsive: true, plugins: { legend: { position: 'top' } } }
});

// Initialize Item Chart
itemChart = new Chart(document.getElementById('itemChart'), {
    type: 'bar',
    data: {
        labels: itemNames,
        datasets: [
            { label: 'Orders', data: itemRequests, backgroundColor: 'rgba(75, 192, 192, 0.6)' },
            { label: 'Amount', data: itemRevenue, backgroundColor: 'rgba(255, 159, 64, 0.6)' },
            { label: 'Quantity', data: itemQty, backgroundColor: 'rgba(153, 102, 255, 0.6)' }
        ]
    },
    options: { responsive: true, plugins: { legend: { position: 'top' } } }
});

    $('#filterBtn').click(function () {
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();
        const frequency = $('#frequency').val();
		const orderby = $('#orderby').val();
		const UserId=0;

        $.ajax({
            url: 'fetch_report.php',
            type: 'POST',
            data: { startDate, endDate, frequency,orderby,UserId },
            success: function (data) {
				//console.log(data);
                const parsedData = JSON.parse(data);
                updateCharts(parsedData.restaurantData, parsedData.itemData);
            }
        });
    });

    function updateCharts(restaurantData, itemData) {
        // Update restaurant chart data and re-render
        restaurantChart.data.labels = restaurantData.map(data => `${data.restaurant_name} (${data.period})`);
        restaurantChart.data.datasets[0].data = restaurantData.map(data => data.request_count);
        restaurantChart.data.datasets[1].data = restaurantData.map(data => data.total_revenue);
        restaurantChart.data.datasets[2].data = restaurantData.map(data => data.total_qty);
        restaurantChart.update();

        // Update item chart data and re-render
        itemChart.data.labels = itemData.map(data => `${data.item_name} (${data.period})`);
        itemChart.data.datasets[0].data = itemData.map(data => data.request_count);
        itemChart.data.datasets[1].data = itemData.map(data => data.total_revenue);
        itemChart.data.datasets[2].data = itemData.map(data => data.total_qty);
        itemChart.update();
    }
});


</script>

    </body>
</html>
