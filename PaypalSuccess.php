<?php
include_once '../session.php';
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
        <title>WE CARE | Payment</title>
		 <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css" />
         <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
         
        <!-- Bootstrap icons-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <!-- Theme CSS Bootstrap-->
        <link href="../css/bootstrap.min.css" rel="stylesheet" />
		<!-- Theme CSS Bootstrap-->
        <link href="../css/styles.css" rel="stylesheet" />
		<style>
        		.wrapper {
  display: flex;
  flex-wrap: wrap;
  padding: 37px 0;
}

.status {
  border: 1px solid lavender;
  padding: 37px;
  width: 100%;
}
.status p {
  text-align: left;
  font-size: 18px;
  font-weight: 500;
}
.status h4 {
  text-align: left;
  font-size: 27px;
}
.table {
    background-color: #ffffff;
    font-size: 1rem;
}

.table thead {
    background-color: var(--yellow);
    color: white;
}

.table-hover tbody tr:hover {
    background-color: #f1f3f4;
}

.table-bordered th, .table-bordered td {
    vertical-align: middle;
}
 .total-section {
            border-top: 1px solid #ddd;
            padding-top: 1.5rem;
            font-size: 1.1em;
        }
       
    </style>
    </head>
    <body>
        <!-- Navigation-->
		
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="../index.php">WE CARE <i class="fas fa-leaf me-1"></i></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link" aria-current="page" href="../index.php">Home</a></li>
                    
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Resturants</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="../foods.php?restid=0">All Foods</a></li>
                                <li><hr class="dropdown-divider" /></li>
								<?php 
		                           $query = "select * from resturants where state=1 order by id";
                                   $result = $db->getData($query);
                                   while ($rows = mysqli_fetch_array($result)) {
		                                  $resid = $rows['id'];
                                          $resname = $rows['name'];
                                    ?>
								 <li>
								  <a class="dropdown-item" href="../foods.php?restid=<?php echo $resid; ?>&restname=<?php echo $resname; ?>">
								    <?php echo $resname; ?>
								  </a>
								</li>
								   <?php }?>
                            </ul>
                        </li>
						<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Reports</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
							    <li><a class="dropdown-item" href="../reports.php">Top Resturants && Foods</a></li>
                                <li><a class="dropdown-item" href="../reports.php?type=1">Top Resturants</a></li>
                                <li><a class="dropdown-item" href="../reports.php?type=2">Top Foods</a></li>
								
                            </ul>
                        </li>
						<li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
						<li class="nav-item"><a class="nav-link" href="../contact.php">Contact</a></li>
						<?php if ($IsUnLogin){?>
		                      <li class="nav-item"><a class="nav-link" href="../login.php">Login</a></li>
		                 <?php } else {?>
			               <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Account <?php echo $UserName; ?></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="../myaccount.php">Profile</a></li>
								<li><a class="dropdown-item" href="../myorders.php">My Orders</a></li>
                                <li><hr class="dropdown-divider" /></li>
								<li><a class="dropdown-item" href="../logout.php">Logout</a></li>
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
        
 <section class="bg-light py-5">
    <div class="container  min-vh-100 px-5 my-5">
        <div class="text-center mb-5">
	       <h1 class="text-info">Payment has been made successfully</h1>
        </div>
  <div class="wrapper">
  <?php 
    $paymentid = $_GET['payid'];
	$query="SELECT * FROM payments where id='$paymentid' ";
	$row = $db->SelectQuery($query);
  ?>
	  <div class="status">
      <h4>Payment Information</h4>
	  <p>Reference Order: <?php echo $row['ordercode']; ?></p>
      <p>Reference Number: <?php echo $row['invoice_id']; ?></p>
      <p>Transaction ID: <?php echo $row['transaction_id']; ?></p>
      <p>Paid Amount: $<?php echo $row['payment_amount']; ?></p>
      <p>Payment Status: <?php echo $row['payment_status']; ?></p>
	  <h4 style="color: #1c3ab6; font-size: 18px; margin-bottom: 10px;">Payment-Details Information</h4>
	  
    <table class="table table-bordered table-hover shadow-sm">
        <thead class="table-primary bg-danger">
            <tr>
                <th scope="col">Food ID</th>
                <th scope="col">Food Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
             $querydt = "SELECT g.UsrId,g.foodid AS id,p.title AS product_name,g.qty,(g.price *g.qty) as total
                         FROM  orders_details g JOIN foods p ON p.id = g.foodid 
                         WHERE  g.ordercode = (SELECT ordercode COLLATE utf8_unicode_ci FROM payments WHERE id = $paymentid AND UsrId = $UserId LIMIT 1) LIMIT 0, 25;";
			$resultdt = $db->getData($querydt); 
			while ($rowsdt = mysqli_fetch_array($resultdt)) {
                $proId = $rowsdt['id'];
                $proname = $rowsdt['product_name'];
                $qty = (int)$rowsdt['qty'];
                $total = (float)$rowsdt['total']; 
				?>
				
				<tr>
                <td><?php echo $proId;?></td>
                <td><?php echo $proname;?></td>
                <td><?php echo $qty;?></td>
                <td>$<?php echo $total;?></td>
                </tr>
               
           <?php } ?>
        </tbody>
    </table> 
	<?php
	  $query = "select total,tax,fee,discount_points,netTotal 
	  from orders f WHERE  ordercode = (SELECT ordercode COLLATE utf8_unicode_ci FROM payments WHERE id = $paymentid AND UsrId = $UserId LIMIT 1) LIMIT 0, 25;";
      $result = $db->getData($query);
	  
	  $tTotal=(float)0;
	  $sumTotal=(float)0;
	  $netTotal=(float)0;
	  $PrcntTax=(float)10;
	  $ProfitDiscount=(float)0;
	  $valueDiscount=(float)0;
	  $Tax=(float)0;
	  $Fee=(float)3;
      while ($hrows = mysqli_fetch_array($result)) {
		  
		  $tnetTotal=(float)0;
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
	  <?php }?>
    </div>
  </div>
  </div>
  </section>
		
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; www.WECARE.com 2024</p></div>
        </footer>
		
		
		<script src="../js/jquery.min.js"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
		<!-- Bootstrap core JS-->
        <script src="../js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="../js/scripts.js"></script>
		<script>
		$(document).ready(function() {
			
		 $('.btn-shopping-cart').on('click', function(e) {
            e.preventDefault(); // Prevent the default anchor behavior
            const a = document.createElement('a');
            a.href = '../cards.php';
			a.target='_blank';
            a.click();
			
        });
		
	 });
		</script>
    </body>
</html>
