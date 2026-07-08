<?php
include_once 'session.php';
include_once 'mypoints.php';
$mypoint = new MyPoints();
$ordercode='';
$UserName = '';
$UserId=(int)0;
$IsUnLogin=(!isset($_SESSION['Id']) || ($_SESSION['Id'] == ''));
//start session 
if ($IsUnLogin) {
/*header('location:index.php');*/
} else {
  $UserId =(int)$_SESSION['Id'];
  $UserName =$_SESSION['Name'];
}
if (isset($_GET['ordercode'])) {
	$ordercode=$_GET['ordercode'];
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>WE CARE | Order</title>
		 <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css" />
         <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
         
        <!-- Bootstrap icons-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <!-- Theme CSS Bootstrap-->
        <link href="css/bootstrap.min.css" rel="stylesheet" />
		<!-- Theme CSS Notification-->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"
        integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		
		<link rel="stylesheet" href="css/notify.min.css">
		<!-- Theme CSS Bootstrap-->
        <link href="css/styles.css" rel="stylesheet" />
		<style>
 .cart-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 1.5rem;
        }
        .cart-title {
            font-weight: bold;
            font-size: 1.8em;
            text-align: center;
            margin-bottom: 1.5rem;
        }
		.cart-header { 
		display: flex; 
		justify-content: 
		space-between; 
		align-items: center; 
		border-bottom: 1px solid #ddd; 
		padding: 1rem 0; 
		margin-bottom: 1.5rem; 
		}
        .cart-header h4 { 
		margin: 0; 
		font-size: 1.2em; 
		}
		
        .cart-item {
            display: flex;
            gap: 1rem;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #ddd;
        }
        .cart-item img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
        }
        .cart-item-info {
            flex-grow: 1;
        }
        .cart-item-actions {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
		.header-icon
		{
			cursor: pointer;
		}
        .total-section {
            border-top: 1px solid #ddd;
            padding-top: 1.5rem;
            font-size: 1.1em;
        }
        
	.order-info-container {
    border: 2px solid #ddd;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    
    margin: auto;
}

.section-title {
    font-size: 1.4rem;
    color: #333;
    text-align: center;
}

.orderForm .form-group label {
    font-weight: 600;
    color: #555;
}

.orderForm .form-group input {
    border-radius: 5px;
    padding: 10px;
}

.orderForm .checkout-btn {
    margin-top: 20px;
    border-radius: 5px;
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
                            <span class="badge bg-dark text-white ms-1 rounded-pill cart-number"><?php echo $ccart;?></span>
                        </button>
                    </div>
					 <?php } ?>
                </div>
            </div>
        </nav>
		
	
    <div class="container cart-container min-vh-100 py-3">
    <h2 class="cart-title">WE CARE <i class="fas fa-leaf me-1"></i></h2>
	 <?php
	  $query = "select total,tax,fee,discount_points,netTotal,v_date,name,email,address,state,payment 
	  from orders f where ordercode='$ordercode' and usrid=$UserId";
      $result = $db->getData($query);
	  
	  $tTotal=(float)0;
	  $sumTotal=(float)0;
	  $netTotal=(float)0;
	  $PrcntTax=(float)10;
	  $ProfitDiscount=(float)0;
	  $valueDiscount=(float)0;
	  $Tax=(float)0;
	  $Fee=(float)3;
	  $state=(int)0;
	  $payment=(int)0;
	  $name='';
	  $email='';
	  $address='';
      while ($hrows = mysqli_fetch_array($result)) {
		  $name=$hrows['name'];
	      $email=$hrows['email'];
	      $address=$hrows['address'];
	      $state = (int)$hrows['state'];
		  $payment = (int)$hrows['payment'];
		  $stateClass='';
		  $varState='';
			if($state==1){
				$stateClass = 'fas fa-check-circle text-success';//Accepted
				$varState='Accepted';
			}
			else if($state==2){
				$stateClass = 'fas fa-times-circle text-danger';//Rejected
				$varState='Rejected';
			}
			else{
				$stateClass = 'fas fa-hourglass-half text-warning';//Under review
				$varState='Under Review';
			}
			if($payment==1&&$state==1)
			{
				$stateClass='fas fa-credit-card text-primary';//Accepted and Paymented
				$varState='Accepted and Paymented';
			}
			
		  $tnetTotal=(float)0;
		  $v_date = date('Y-m-d H:m:s', strtotime($hrows['v_date']));
		  $tTotal = (float)$hrows['total'];
		  $Tax = (float)$hrows['tax'];
		  $Fee = (float)$hrows['fee'];
		  $valueDiscount = (float)$hrows['discount_points'];
		  if($Tax)
		  $PrcntTax=($tTotal/$Tax);
	      $netTotal= (float)$hrows['netTotal'];
		  
	  
	     $tnetTotal=$tTotal+$Tax+$Fee;
			  if($valueDiscount>0)
			  {
				$ProfitDiscount=($valueDiscount/$tnetTotal)*100;
			  }		
		  ?>
    <!-- Header Section -->
    <div class="cart-header">
        <div>
			<p class="mb-1"><strong>Order Code :</strong>  <?php echo $ordercode ;?></p>
            <p class="mb-1"><strong>Address Delivery:</strong>  <?php echo $address ;?></p>
            <p><strong>Customer Name:</strong> <?php echo $name ;?></p>
        </div>
        <i class="fa fa-print header-icon print-btn"></i>
    </div>
    <!-- Cart Items -->
	
	 <?php
      $query = "select foodid,qty,price,total,(select title from foods where id=f.foodid)title"
	  .",(select name from resturants where id=(select rest_id from foods where id=f.foodid))RestName"
	  .",(select imagePath from foods where id=f.foodid)imagePath "
	  ." from orders_details f where ordercode='$ordercode' and usrid=$UserId";
      $results = $db->getData($query);
	  $count=(int)0;

      while ($rows = mysqli_fetch_array($results)) {
        $id = (int)$rows['foodid'];
        $fodname = $rows['title'];
		$RestName = $rows['RestName'];
		$Price = (float)$rows['price'];
		$Qty = (float)$rows['qty'];
		$Total = (float)$rows['total'];
		$imagePath = $rows['imagePath'];
        $sumTotal=$sumTotal+$Total;
      ?>
	  
    <div class="cart-item"  data-productid="<?php echo $id; ?>">
        <img src="<?php echo $imagePath;?>" alt="<?php echo $fodname;?>">
        <div class="cart-item-info">
            <h5><?php echo $fodname;?></h5>
            <p class="mb-1 text-muted">Restaurant: <?php echo $RestName;?></p>
            <p>Unit Price: <span class="price">$<?php echo $Price;?></span></p>
        </div>
        <div class="cart-item-actions">
		    
            <input type="number" class="form-control w-50 quantity-input" min="1" value="<?php echo $Qty;?>" disabled>
			
            <p class="mt-2"><strong>Total: <span class="amount">$<?php echo $Total;?></span></strong></p>
        </div>
    </div>
    <?php } ?>   
	 
    <!-- Total Section -->	
    <div class="total-section">
        <ul class="list-unstyled">
            <li>Subtotal: <span class="float-end total">$<?php echo $tTotal; ?></span></li>
            <li>Tax (10%): <span class="float-end tax">$<?php echo $Tax; ?></span></li>
            <li>Delivery Fee: <span class="float-end fee">$<?php echo $Fee; ?></span></li>
			 <?php if($valueDiscount>0){?>
            <li>ProfitDiscount: <span class="float-end discount">$<?php echo $valueDiscount; ?></span></li>
			 <?php } ?>
            <li><strong>Total:</strong> <span class="float-end netTotal"><strong>$<?php echo $netTotal; ?></strong></span></li>
        </ul>
		
    </div>
	

    <!-- form Order -->
<div class="container order-info-container">
    <h3 class="section-title mb-4">Order Information <i class="<?php echo $stateClass;?>"></i> <?php echo $varState;?></h3>

    <form id="orderForm" class="orderForm">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" value="<?php echo $name ;?>" placeholder="Enter your name" disabled>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" value="<?php echo $email ;?>" placeholder="Enter your email" disabled>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" value="<?php echo $address ;?>" placeholder="Enter your address" disabled>
        </div>
        
        
    </form>
</div>
	<?php } ?> 
</div>
       
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
		<!-- Core Notification JS-->
		<script src="js/notify.min.js"></script>
		
<script>

const orderbtn = document.querySelector('.checkout-btn');
$(document).ready(function() {
	
	 $('#errorMessage').addClass('d-none');
     $('#successMessage').addClass('d-none');
	 
	 window.jsPDF = window.jspdf.jsPDF;
	
		
function convertHTMLToPDF() {
  var ordercode=<?php echo $ordercode; ?>;
		
	const { jsPDF } = window.jspdf;
    var doc = new jsPDF('1', 'mm', [1200, 1210]);
	var pdfjs = document.querySelector('.cart-container');
	
  doc.html(pdfjs, {
    callback: function(doc) {
      doc.save("order"+ordercode+".pdf");
    },
    x: 10,
    y: 10
  });
}

   $('.print-btn').on('click', function(e) {
        e.preventDefault();
		convertHTMLToPDF();
        
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