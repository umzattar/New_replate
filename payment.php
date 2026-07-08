<?php
include_once 'session.php';
$UserName = '';
$UserId=(int)0;
$ordercode='';
$IsUnLogin=(!isset($_SESSION['Id']) || ($_SESSION['Id'] == ''));
//start session 
if ($IsUnLogin) {
} else {
  $UserId =(int)$_SESSION['Id'];
  $UserName =$_SESSION['Name'];
  
  if (isset($_GET['ordercode'])) {
	$ordercode=$_GET['ordercode'];
}
}
if($ordercode=='')
{
	header("location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>WE CARE | Payment</title>
		 <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css" />
         <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
         
        <!-- Bootstrap icons-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <!-- Theme CSS Bootstrap-->
        <link href="css/bootstrap.min.css" rel="stylesheet" />
		<!-- Theme CSS Bootstrap-->
        <link href="css/styles.css" rel="stylesheet" />
		<style>
        .payment-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            margin: 30px auto;
        }
        .payment-header {
            border-bottom: 2px solid #007bff;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .payment-header h2 {
            color: var(--yellow);
        }
        .payment-summary {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #f8f9fa;
        }
        .credit-card-icon {
            font-size: 1.5rem;
            margin-right: 10px;
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
        
	

  <section class="container  min-vh-100 py-4"> 
  
  <?php 
		
		  $state = (int)0;
		  $ispayment = (int)0;
		  $id = (int)0;
		  $qty  = (int)0;
		  $total  = (float)0;
		  $vdate='';
          $name = '';
          $email = '';
		  $address = '';
		  $varstate='';
		  $disabled='';
		  $code='';
          if($ordercode!="")
			{
		      $query = "select id,ordercode,UsrId,name,email,address,v_date,netTotal,state,payment"
			  ." from orders g where ordercode='$ordercode' and UsrId=$UserId";
				
               $rowprd = $db->SelectQuery($query);
			   $state = (int)$rowprd['state'];
			   $id = (int)$rowprd['id'];
			   $ispayment = (int)$rowprd['payment'];
			   $vdate =  date('Y-m-d', strtotime($rowprd['v_date']));
               $name = $rowprd['name'];
               $email = $rowprd['email'];
		       $address = $rowprd['address'];
			   $code = $rowprd['ordercode'];
			   $total = (float)$rowprd['netTotal'];
               $qty = 1;
			   $disabled='disabled';			   
			}
			?>
        <div class="payment-container">
            <!-- Header -->
            <div class="payment-header text-center">
                <h2> <i class="fa fa-credit-card text-dark credit-card-icon"></i>Secure Payment</h2>
                <p>Complete your order by paying securely</p>
            </div>
            <!-- Payment Summary -->
            <div class="payment-summary">
                <h5>Order Details</h5>
                <ul class="list-unstyled">
                    <li><strong>Order #:</strong> <?php echo $code; ?></li>
                    <li><strong>Date:</strong> <?php echo $vdate; ?></li>
                    <li><strong>Total Amount:</strong> <span class="text-success">$<?php echo $total; ?></span></li>
                </ul>
            </div>
			<form class="paypal mt-4" action="payment/request.php" method="post" id="payment-form">
                <input type="hidden" name="ordercode" value="<?php echo $code; ?>">
                <input type="hidden" name="amount" value="<?php echo $total; ?>">
				<input type="hidden" name="quantity" value="<?php echo $qty; ?>">
                <input type="hidden" name="item_number" value="<?php echo $id; ?>">
				<input type="hidden" name="item_name" value="<?php echo $code; ?>">
                <input type="hidden" name="bookEmail" value="<?php echo $email; ?>">
                <input type="hidden" name="bookName" value="<?php echo $name; ?>">
                <input type="hidden" name="currency_code" value="USD">
               <div class="text-center">
                <button type="submit" class="btn btn-dark text-warning w-100">Pay $<?php echo $total; ?></button>
               </div>
            </form>
				
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
		</script>
    </body>
</html>
