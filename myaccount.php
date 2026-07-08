<?php
include_once 'session.php';
include_once 'mypoints.php';
$mypoint = new MyPoints();
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
        <title>WE CARE | MyAccount</title>
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
           .profile-header { background: #333 ; color: var(--yellow); padding: 20px; border-radius: 8px; }
        .section-title { font-weight: bold; color: #333; margin-top: 20px; }
        .card-custom { border-radius: 10px; padding: 15px; box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.2); }
        .order-table th, .order-table td { text-align: center; }
        
		.favorite-category {
    border-top: 1px solid #ddd;
    padding-top: 10px;
}
.favorite-item {
    padding: 10px;
    background-color: #f9f9f9;
    border-radius: 5px;
    margin-bottom: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.favorite-item i {
    color: #ffcc00;
    margin-right: 8px;
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
 
<section class="container px-4 px-lg-5"> 
 <div class="container mt-4">
    <!-- User Information -->
    <div class="profile-header text-center">
        <h2>WE CARE <i class="fas fa-leaf me-1"></i> User Profile</h2>
    </div>
     <?php  
	     $points = $mypoint->getTotalPoints($db, $UserId); 
	 ?>  
    <div class="card-custom mt-4 p-3">
	   <div class="d-flex align-items-center justify-content-between">
               <h5 class="section-title mb-0">Personal Information</h5>
               <span class="text-muted">You Have <?php echo $points; ?> Points</span>
       </div>

        <form id="userInfoForm">
		   
		  <div class="row">
		     <div class="col-lg-6">
               <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" id="userName" value="<?php echo $UserName;?>" placeholder="User's Name" required>
               </div>
			 </div>
			<div class="col-lg-6">
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" id="userEmail" value="<?php echo $_SESSION['Email'];?>" placeholder="User's Email" disabled>
              </div>
			</div>
		  </div>
		  
		 <div class="row">
		   <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Old Password</label>
                <input type="password" class="form-control" id="oldPassword" placeholder="Old Password" required>
            </div>
		   </div>
		  <div class="col-lg-6">
			<div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" class="form-control" id="newPassword" placeholder="Current Password" required>
            </div>
			</div>
		  </div>
            <div class="d-flex align-items-center">
                 <button type="button" class="btn btn-primary" id="editUserInfo">Edit</button>
                   <div id="messageContainer" class="ms-3">
                        <div id="successMessage" class="alert alert-success d-none" role="alert">
                            The message was sent successfully
                        </div>
						<div id="errorMessage" class="alert alert-danger d-none" role="alert">
                             Error submitting  try again.
                         </div>
                  </div>
            </div>
        </form>
    </div>

    <!-- User Orders -->
  <div class="card-custom mt-4 p-3">
    <h5 class="section-title">Previous Orders</h5>
    
    <!-- Table for larger screens -->
    <table class="table order-table d-none d-md-table">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Icon</th>
                <th>Order Code</th>
                <th>Date</th>
                <th>Total</th>
                <th>Points</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody>
		
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
			if($state==1){
				$stateClass = 'fas fa-check-circle text-success';//Accepted
			}
			else if($state==2){
				$stateClass = 'fas fa-times-circle text-danger';//Rejected
			}
			else{
				$stateClass = 'fas fa-hourglass-half text-warning';//Under review
			}
			if($payment==1&&$state==1)
			{
				$stateClass='fas fa-credit-card text-primary';//Accepted and Paymented
			}
			$count +=1;
    ?>
            <tr class="tbl-cards">
                <td><?php echo $count;?></td>
                <td><i class="<?php echo $stateClass;?>"></i></td>
                <td class="ordercode"><?php echo $ordercode;?></td>
                <td><?php echo $v_date;?></td>
                <td>$<?php echo $netTotal;?></td>
                <td><?php echo $countpoints;?></td>
                <td><button class="btn btn-dark btn-sm"  data-code="<?php echo $ordercode;?>">View</button></td>
            </tr>
	<?php }?>
        </tbody>
    </table>

    <!-- Card layout for smaller screens -->
    <div class="d-md-none">
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
			if($state==1){
				$stateClass = 'fas fa-check-circle text-success';//Accepted
			}
			else if($state==2){
				$stateClass = 'fas fa-times-circle text-danger';//Rejected
			}
			else{
				$stateClass = 'fas fa-hourglass-half text-warning';//Under review
			}
			if($payment==1&&$state==1)
			{
				$stateClass='fas fa-credit-card text-primary';//Accepted and Paymented
			}
			$count +=1;
    ?>
        <div class="order-card mb-3 p-2" style="border: 1px solid #ddd; border-radius: 8px;">
            <div><strong>Order #<?php echo $count;?></strong></div>
            <div><i class="<?php echo $stateClass;?>"></i> Order Code:<?php echo $ordercode;?></div>
            <div>Date: <?php echo $v_date;?></div>
            <div>Total: $<?php echo $netTotal;?></div>
            <div>Points: <?php echo $countpoints;?></div>
            <button class="btn btn-warning btn-sm mt-2" data-code="<?php echo $ordercode;?>">View</button>
        </div>
     <?php }?>   
    </div>
</div>


   <div class="card-custom mt-4 p-4">
    <h5 class="section-title">Your 10 Top Favorite Selections</h5>
    
    <!-- Favorite Restaurants -->
<div class="favorite-category mb-4">
    <label class="form-label">Favorite Restaurants</label>
    <div id="favorite-restaurants">
        <!-- Restaurants will be dynamically populated here -->
    </div>
</div>

<!-- Favorite Items -->
<div class="favorite-category">
    <label class="form-label">Favorite Items</label>
    <div id="favorite-items">
        <!-- Items will be dynamically populated here -->
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
		<script src="js/notify.min.js"></script>
		<script>
		
		$(document).ready(function() {
    // Fetch favorite restaurants and items
    const fetchFavorites = () => {
        $.ajax({
            url: "fetch_report.php",
            type: "POST",
            data: {
                startDate: null, // Example data
                endDate: null,
                frequency: "none",
                orderby: "none",
                UserId: <?php echo $UserId; ?> // Adjust based on session setup
            },
            dataType: "json",
            success: function(response) {
                // Populate favorite restaurants
                const restaurants = response.restaurantData;
                const restaurantContainer = $("#favorite-restaurants");
                restaurantContainer.empty();

                if (restaurants && restaurants.length > 0) {
                    restaurants.forEach(restaurant => {
                        restaurantContainer.append(`
                            <div class="favorite-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-utensils"></i> ${restaurant.restaurant_name}</span>
                                <button class="btn btn-outline-info btn-sm restaurantbtn" data-id="${restaurant.restaurant_Id}">Visit</button>
                            </div>
                        `);
                    });
                } else {
                    restaurantContainer.append(`<p>No favorite restaurants available.</p>`);
                }

                // Populate favorite items
                const items = response.itemData;
                const itemsContainer = $("#favorite-items");
                itemsContainer.empty();

                if (items && items.length > 0) {
                    items.forEach(item => {
                        itemsContainer.append(`
                            <div class="favorite-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-pizza-slice"></i> ${item.item_name}</span>
                                <button class="btn btn-outline-info btn-sm itembtn" data-id="${item.item_Id}">Order Again</button>
                            </div>
                        `);
                    });
                } else {
                    itemsContainer.append(`<p>No favorite items available.</p>`);
                }
            },
            error: function(error) {
                console.error("Error fetching favorite data:", error);
            }
        });
    };

    fetchFavorites();
});


	
$(document).on('click', '.restaurantbtn[data-id]', function() {
             let restid = $(this).data('id');
			 let resname = this.parentElement.querySelector('span').textContent.trim();
			 const a = document.createElement('a');
            a.href = 'foods.php?restid='+restid+'&restname='+resname;
			a.target='_blank';
            a.click();		
  });
		  
$(document).on('click', '.itembtn[data-id]', function() {
             let foodid = $(this).data('id');
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
});
		  
		$(document).on('click', '.btn[data-code]', function() {
             let orderCode = $(this).data('code');
			const a = document.createElement('a');
            a.href = 'myorder.php?ordercode='+orderCode;
			a.target='_blank';
            a.click();
              
          });

		function checkUsername(name) {
            var usernameRegex = /^[A-Za-z][A-Za-z0-9_-]{3,14}$/;
            if (!usernameRegex.test(name)) {
				  showMsg(0,"Invalid username. Username must start with a letter, be 4-15 characters long, and may contain letters, numbers, underscores, or hyphens.");
                return false;
            }
            return true;
        }
		
		function showMsg(type,msg)
		{
			if(type==0)
			{
			$('#errorMessage').text(msg);
				$('#errorMessage').removeClass('d-none').fadeIn();
                 setTimeout(function () {
                    $('#errorMessage').fadeOut().addClass('d-none');
                 }, 5000);
			}
			else
			{
				$('#successMessage').text(msg);
				$('#successMessage').removeClass('d-none').fadeIn();
                 setTimeout(function () {
                    $('#successMessage').fadeOut().addClass('d-none');
                 }, 5000);
			}
		}
		
		$(document).ready(function() {
			
		 $('.btn-shopping-cart').on('click', function(e) {
            e.preventDefault(); // Prevent the default anchor behavior
            const a = document.createElement('a');
            a.href = 'cards.php';
			a.target='_blank';
            a.click();
			
        });
		
		 $('#editUserInfo').on('click', function () {
			 
			 $('#errorMessage').addClass('d-none');
			 $('#successMessage').addClass('d-none');
			 
			 var UsrId=<?php echo $UserId;?>;
			 var name =$('#userName').val();
			 var email =$('#userEmail').val();
			 var oldPassword =$('#oldPassword').val();
			 var newPassword =$('#newPassword').val();
			 
			if (name.trim() === "") {
				 showMsg(0,"Please Enter the Name");
				return;
			}
			else
			{
				if (!checkUsername(name))
                return false;
            
			}
		   if (oldPassword.trim() === "") {
				showMsg(0,"Please Enter PassWord Old");
				return;
			}
			if (newPassword.trim() === "") {
				
				showMsg(0,"Please Enter PassWord New");
				return;
			}
			 
			 $.ajax({
        type: 'post',
        url: 'userdb.php',
        data: {
		  type: 3,
		  UsrId:UsrId,
          name: name,
		  email: email,
		  oldPassword: oldPassword,
          newPassword: newPassword
        },
        success: function(response) {
          if (response == "success") {
			  showMsg(1,"Data has been modified and saved successfully");
			  setTimeout(function () {
                   window.location.href = "myaccount.php";
                 }, 4000);
				 
          } else {
		   showMsg(0,response);
          }
        }
      });
			
			
        });
		
	 });
		</script>
	
	
    </body>
</html>