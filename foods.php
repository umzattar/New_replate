<?php
include_once 'session.php';
$UserName = '';
$UserId=(int)0;
$IsUnLogin=(!isset($_SESSION['Id']) || ($_SESSION['Id'] == ''));
$restid=(int)0;
$restname='';
//start session 
if ($IsUnLogin) {
} else {
  $UserId =(int)$_SESSION['Id'];
  $UserName =$_SESSION['Name'];
}
if (isset($_GET['restid'])) {
	$restid = (int)$_GET['restid'];
}
if($restid==0)
	$restname='Our Featured Restaurants';
else
{
	$restname = $_GET['restname'];
	$restname=$restname.' Restaurant Food';
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>WE CARE | Foods</title>
		 <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css" />
         <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
         
        <!-- Bootstrap icons-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <!-- Theme CSS Bootstrap-->
        <link href="css/bootstrap.min.css" rel="stylesheet" />
		<!-- Theme CSS Notification-->
		<link rel="stylesheet" href="css/notify.min.css">
		<!-- Theme CSS Bootstrap-->
        <link href="css/styles.css" rel="stylesheet" />
		<style>

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
                            <a class="nav-link dropdown-toggle active" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Resturants</a>
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
        
	 <div class="container  min-vh-100 my-4">
    <!-- Restaurant List -->
	<h3 class="text-center mb-4"><?php echo $restname; ?></h3>

                <div class="row">
				
				  <?php
      $query = "select *,(select name from resturants where id=f.rest_id)RestName from foods f where state=1";
	  if($restid>0)
		  $query =$query ." and rest_id=$restid";
      $result = $db->getData($query);
	  $count=(int)0;
      while ($rows = mysqli_fetch_array($result)) {
        $id = (int)$rows['id'];
		$drestid = (int)$rows['rest_id'];
		$RestName = $rows['RestName'];
        $name = $rows['title'];
        $description = $rows['description'];
		$details = $rows['details'];
		$Price = (float)$rows['Price'];
		$imagePath = $rows['imagePath'];
        
      ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="<?php echo $imagePath;?>" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
									<h5 class="fw-bolder"><?php echo $RestName;?></h5>
                                    <h6 class="fw-bolder"><?php echo $name;?></h6>
									<!-- Product reviews-->
                                    <div class="d-flex justify-content-center small text-warning mb-2">
                                          <i class="fas fa-star"></i>
                                          <i class="fas fa-star"></i>
                                          <i class="fas fa-star"></i>
                                          <i class="fas fa-star"></i>
                                          <i class="fas fa-star"></i>
                                    </div>
                                    <!-- Product price-->
                                    $<?php echo $Price;?>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                               <div class="text-center">
							     <a class="btn btn-outline-dark mt-auto btn-cards" 
								    href="javascript:void(0)"  data-foodid="<?php echo $id; ?>" >Add to cart</a>
							   </div>
                            </div>
                        </div>
                    </div>
            <?php } ?>        
					
                </div>
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
		<script src="js/notify.min.js"></script>
		<script>
		$(document).ready(function() {
			
		
		 $('.btn-shopping-cart').on('click', function(e) {
            e.preventDefault(); // Prevent the default anchor behavior
            const a = document.createElement('a');
            a.href = 'cards.php';
			a.target='_blank';
            a.click();
			
        });
	   
	    $('.btn-cards').on('click', function(e) {
    e.preventDefault(); // Prevent the default anchor behavior
    var foodid = $(this).data('foodid');
	var isUnLogin = <?php echo json_encode($IsUnLogin); ?>;
	if (isUnLogin) {
	    notify('info', 'WE-CARE Message', 'Please log in to your account!');
    } else {
		
		let cartNumber =0;
		if($(".cart-number").text()!="")
		  cartNumber=parseInt($(".cart-number").text());
		
	$.ajax ({
         type:'post',
         url:'opreationsdb.php',
         data:{
	         foodid:foodid,
	         IsAdd:1,
	         type:1
            },
        success:function(response) {
       if(response=="success"){
		       $(".cart-number").text(cartNumber + 1);
		   notify('success', 'WE-CARE Message', 'The Food has been successfully added to the cart.');
        }
       else {
	       notify('error', 'WE-CARE Message',response);
        }
      }
    });
    }
  });
  
  });
		</script>
    </body>
</html>
