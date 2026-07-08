<?php
include_once 'session.php';
$UserName = '';
$UserId=(int)0;
$IsUnLogin=(!isset($_SESSION['Id']) || ($_SESSION['Id'] == ''));
//start session 
if ($IsUnLogin) {
} else {
  $UserId =(int)$_SESSION['Id'];
  $UserName =$_SESSION['Name'];
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>WE CARE | MyOrders</title>
		 <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css" />
         <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
         
        <!-- Bootstrap icons-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <!-- Theme CSS Bootstrap-->
        <link href="css/bootstrap.min.css" rel="stylesheet" />
		<!-- Theme CSS Bootstrap-->
        <link href="css/styles.css" rel="stylesheet" />
		<style>
.order-card {
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
	 overflow: hidden; /* Ensures the triangle does not overflow the card */
    position: relative;
}

.order-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
.triangle-accepted {
    position: absolute;
    top: 0;
    right: 0;
    width: 0;
    height: 0;
    border-top: 50px solid #28a745; /* Green for Accepted */
    border-left: 50px solid transparent;
}

.triangle-rejected {
    position: absolute;
    top: 0;
    right: 0;
    width: 0;
    height: 0;
    border-top: 50px solid #dc3545; /* Red for Rejected */
    border-left: 50px solid transparent;
}

.triangle-review {
    position: absolute;
    top: 0;
    right: 0;
    width: 0;
    height: 0;
    border-top: 50px solid #ffc107; /* Yellow for Under Review */
    border-left: 50px solid transparent;
}

.triangle-payment {
    position: absolute;
    top: 0;
    right: 0;
    width: 0;
    height: 0;
    border-top: 50px solid #007bff; /* Blue for Paymented */
    border-left: 50px solid transparent;
}


.order-header {
    font-weight: bold;
}

.border-state-accepted {
    border-color: #28a745 !important; /* Green */
}

.border-state-rejected {
    border-color: #dc3545 !important; /* Red */
}

.border-state-review {
    border-color: #ffc107 !important; /* Yellow */
}

.border-state-payment {
    border-color: #007bff !important; /* Blue */
}

.order-footer button {
    width: 48%;
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
        
	

  <section class="container  min-vh-100 py-5"> 
 <div class="container mt-4">
   <div class="text-center mb-5">
            <h2><i class="fas fa-calendar-check text-warning"></i> Your Orders</h2>
   </div>
   <div class="row g-3">
	<?php
		 $query = "SELECT ordercode, netTotal, v_date,state,payment, 
            (SELECT countpoints FROM mypoints 
             WHERE ordercode = f.ordercode 
             AND usrid = f.usrid) AS countpoints 
          FROM orders f 
          WHERE usrid = $UserId 
          ORDER BY v_date DESC";
		  
         $result = $db->getData($query);
		 $count =(int)0;
         while ($rows = mysqli_fetch_array($result)) {
		    $netTotal = (float)$rows['netTotal'];
		    $ordercode = $rows['ordercode'];
            $v_date = date('Y-m-d', strtotime($rows['v_date']));
			$countpoints = (int)$rows['countpoints'];
			$state = (int)$rows['state'];
			$payment = (int)$rows['payment'];
			$stateClass='';
			$stateColor='';
			$varstate='';
			
			if($state==1){
				
				$stateClass='border-state-accepted';
				$stateColor='text-success';
			    $varstate='Accepted';
				$triangleClass = 'triangle-accepted';
			}
			else if($state==2){
				$stateClass='border-state-rejected';
				$stateColor='text-danger';
			    $varstate='Rejected';
				$triangleClass = 'triangle-rejected';
			}
			else{
				$stateClass='border-state-review';
				$stateColor='text-warning';
			    $varstate='Under review';
				$triangleClass = 'triangle-review';
			}
			if($payment==1&&$state==1)
			{
				$stateClass='border-state-payment';
				$stateColor='text-primary';
			    $varstate='Paymented';
				$triangleClass = 'triangle-payment';
			}
			$count +=1;
		
    ?>
	
	  
		<div class="col-md-6 col-lg-4">
            <div class="order-card border <?php echo $stateClass;?> p-3 rounded position-relative">
			    <div class="<?php echo $triangleClass;?>"></div>
                <div class="order-header border-bottom <?php echo $stateClass;?> pb-2 mb-2">
                    <h5 class="mb-0">Order #<?php echo $count;?></h5>
                    <small class="text-muted">State: <span class="<?php echo $stateColor;?>"><?php echo $varstate;?></span></small>
                </div>
                <div class="order-body">
                    <p class="mb-2"><strong>Order Code:</strong> <?php echo $ordercode;?></p>
                    <p class="mb-2"><strong>Date:</strong> <?php echo $v_date;?></p>
                    <p class="mb-2"><strong>Total:</strong> <?php echo $netTotal;?></p>
                </div>
                <div class="order-footer d-flex justify-content-between">
                    <button class="btn btn-warning text-dark btn-sm btn-view" data-code="<?php echo $ordercode;?>">View</button>
					<?php 
					if($varstate=='Accepted'){?> 
                    <button class="btn btn-dark text-warning btn-sm btn-payment" data-code="<?php echo $ordercode;?>">Payment</button>
					 <?php }?> 
                </div>
            </div>
        </div>
		
        
     <?php }?>   
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
			
		$(document).on('click', '.btn-view[data-code]', function() {
             let orderCode = $(this).data('code');
			const a = document.createElement('a');
            a.href = 'myorder.php?ordercode='+orderCode;
			a.target='_blank';
            a.click();
              
          });
		  
		  $(document).on('click', '.btn-payment[data-code]', function() {
             let orderCode = $(this).data('code');
			const a = document.createElement('a');
            a.href = 'payment.php?ordercode='+orderCode;
			a.target='_blank';
            a.click(); 
          });
		  
		 $('.btn-shopping-cart').on('click', function(e) {
            e.preventDefault(); // Prevent the default anchor behavior
            const a = document.createElement('a');
            a.href = 'cards.php';
			a.target='_blank';
            a.click();
			
        });
		
	 });
		</script>
    </body>
</html>
