<?php
include_once 'session.php';
include_once 'mypoints.php';
$mypoint = new MyPoints();
$UserName = '';
$UserId=(int)0;
$IsUnLogin=(!isset($_SESSION['Id']) || ($_SESSION['Id'] == ''));
//start session 
if ($IsUnLogin) {
header('location:index.php');
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
        <title>WE CARE | Cart</title>
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
    font-size: 1.8rem;
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
    <h2 class="cart-title">Your Food Cart</h2>
    <!-- Header Section -->
    <div class="cart-header">
        <div>
            <h4>Order Menu :WE CARE <i class="fas fa-leaf me-1"></i></h4>
            <p class="mb-1"><strong>Address Delivery:</strong> 46411 Raghad Street, Yanbu</p>
            <p><strong>Customer Name:</strong> <?php echo $UserName ;?></p>
        </div>
        <i class="fa fa-print header-icon print-btn"></i>
    </div>
    <!-- Cart Items -->
	
	<?php
      $query = "select *,(select name from resturants where id=f.rest_id)RestName from foods f where state=1"
	         ." and id in (select foodid from mycart where usrid=$UserId and type=1)";
      $result = $db->getData($query);
	  $count=(int)0;
	  $Total=(float)0;
	  $netTotal=(float)0;
	  $PrcntTax=(float)10;
	  $ProfitDiscount=(float)0;
	  $valueDiscount=(float)0;
	  $Tax=(float)0;
	  $Fee=(float)3;
      while ($rows = mysqli_fetch_array($result)) {
        $id = (int)$rows['id'];
		$drestid = (int)$rows['rest_id'];
		$RestName = $rows['RestName'];
        $name = $rows['title'];
		$Price = (float)$rows['Price'];
		$imagePath = $rows['imagePath'];
        $Total=$Total+$Price;
      ?>
	  
    <div class="cart-item"  data-productid="<?php echo $id; ?>">
        <img src="<?php echo $imagePath;?>" alt="<?php echo $name;?>">
        <div class="cart-item-info">
            <h5 class="foodName"><?php echo $name;?></h5>
            <p class="mb-1 text-muted">Restaurant: <?php echo $RestName;?></p>
            <p>Unit Price: <span class="price">$<?php echo $Price;?></span></p>
        </div>
        <div class="cart-item-actions">
		    
            <input type="number" class="form-control w-50 quantity-input" min="1" value="1">
			
            <button class="btn btn-link btn-remove-item text-danger"><i class="fa fa-times"></i> Remove</button>
            <p class="mt-2"><strong>Total: <span class="amount">$<?php echo $Price;?></span></strong></p>
        </div>
    </div>
     
	 <?php 
		    $count=$count+1;
		   }
		   if($count>0)
			{
              $ProfitDiscount = $mypoint->chckPoints($db, $UserId);  
		      $Tax=($Total/$PrcntTax);
		      $netTotal=$Total+$Tax+$Fee;
			  if($ProfitDiscount>0)
			  {
				$valueDiscount=($netTotal*$ProfitDiscount)/100;
               	$netTotal=($netTotal-$valueDiscount);	
			  }				
			}
			else
			{
				$Tax=(float)0;
				$Fee=(float)0;
				$netTotal=(float)0;
			}
		   ?>
	 
    <!-- Total Section -->	
    <div class="total-section">
        <ul class="list-unstyled">
            <li>Subtotal: <span class="float-end total">$<?php echo $Total; ?></span></li>
            <li>Tax (10%): <span class="float-end tax">$<?php echo $Tax; ?></span></li>
            <li>Delivery Fee: <span class="float-end fee">$<?php echo $Fee; ?></span></li>
			 <?php if($valueDiscount>0){?>
            <li>ProfitDiscount: <span class="float-end discount">$<?php echo $valueDiscount; ?></span></li>
			 <?php } ?>
            <li><strong>Total:</strong> <span class="float-end netTotal"><strong>$<?php echo $netTotal; ?></strong></span></li>
        </ul>
    </div>

<?php 
$hideItm='';
if($count<=0)
	$hideItm=' d-none';
?>
    <!-- form Order -->
<div class="container order-info-container <?php echo $hideItm;?>">
    <h3 class="section-title mb-4">Order <span id="ordercode"></span> Information</h3>
    <form id="orderForm">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" placeholder="Enter your name">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Enter your email">
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" placeholder="Enter your address">
        </div>
        <div id="messageContainer" class="ms-3">
            <div id="successMessage" class="alert alert-success d-none" role="alert"></div>
            <div id="errorMessage" class="alert alert-danger d-none" role="alert"></div>
        </div>
        <div class="text-center">
            <a href="#" class="btn btn-dark w-50 checkout-btn">Order</a>
        </div>
    </form>
</div>
	
</div>
        
    
	<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Do you want to delete this product?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete</button>
            </div>
        </div>
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
		<!-- Core Notification JS-->
		<script src="js/notify.min.js"></script>
		
<script>

const orderbtn = document.querySelector('.checkout-btn');
$(document).ready(function() {
	
	 $('#errorMessage').addClass('d-none');
     $('#successMessage').addClass('d-none');
	 
	
	let productItem; // Store the row element for deletion
    let productId;  // Store the product ID for deletion
	

	function showMsg(type,msg)
		{
			if(type==0)
			{
			$('#errorMessage').text(msg);
				$('#errorMessage').removeClass('d-none').fadeIn();
                 
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
		


   $('.print-btn').on('click', function(e) {
        e.preventDefault();
		
	});
	
	
	 // Event listener for delete button click
    $('.btn-remove-item').on('click', function(e) {
        e.preventDefault();
        
        // Get the product row and product ID
		productItem=$(this).closest('.cart-item'); 
        productId = productItem.data('productid'); // Add `data-productid` to the row or button in PHP

        // Show the confirmation modal
        $('#deleteConfirmationModal').modal('show');
    });
	 // Confirm delete button click in the modal
    $('#confirmDeleteBtn').on('click', function() {
		
		let cartNumber =0;
		if($(".cart-number").text()!="")
		  cartNumber=parseInt($(".cart-number").text());
        // AJAX request to delete the product
        $.ajax({
            type: 'POST',
            url: 'opreationsdb.php', // Adjust URL as needed
            data: {
				foodid: productId ,
				IsAdd:0,
	            type:1
				},
            success: function(response) {
                if (response === 'success') {
                    // Remove the product row from the table
                    productItem.remove();
                    
                    // Recalculate cart totals
                    recalculateCart();
					if(cartNumber<=1)
                        $(".cart-number").text("");
				    else
					   $(".cart-number").text(cartNumber - 1);
                    // Show success notification
                    notify('success','WE-CARE Message', 'Product removed from cart successfully.');
                } else {
                    notify('error','WE-CARE Message', 'Failed to remove product.');
                }
            }
        });
        
        // Hide the confirmation modal
        $('#deleteConfirmationModal').modal('hide');
    });
	
	
	 $('.btn-shopping-cart').on('click', function(e) {
            e.preventDefault(); // Prevent the default anchor behavior
            const a = document.createElement('a');
            a.href = 'cards.php';
			a.target='_blank';
            a.click();
			
        });
		
    // Function to recalculate totals
   function recalculateCart() {
    let newTotal = 0;
    let Total = 0;
    let Tax = 0;
    const PrcntTax = <?php echo $PrcntTax; ?>;
    const Fee = <?php echo $Fee; ?>;
    const ProfitDiscount = <?php echo $ProfitDiscount; ?>;
    let valueDiscount = 0;

    // Iterate over each product row
    $('.cart-item').each(function() {
        // Get the unit price and quantity
        let unitPrice = parseFloat($(this).find('.price').text().replace('$', ''));
        let quantity = parseInt($(this).find('.quantity-input').val());

        // Calculate the total for this product
        let total = unitPrice * quantity;

        // Set the total for this row
        $(this).find('.amount').text('$' + total.toFixed(2));

        // Add to subtotal
        Total += total;
    });

    // Calculate Tax and New Total
    Tax = Total / PrcntTax;
    newTotal = Total + Tax + Fee;

    if (ProfitDiscount > 0) {
        valueDiscount = (newTotal * ProfitDiscount) / 100;
        newTotal -= valueDiscount;
    }

    // Update the cart totals in the UI
    $('.total-section .total').text('$' + Total.toFixed(2));             // Subtotal
    $('.total-section .tax').text('$' + Tax.toFixed(2));                 // Tax
    $('.total-section .fee').text('$' + Fee.toFixed(2));                 // Delivery Fee
    $('.total-section .discount').text('$' + valueDiscount.toFixed(2));  // Discount
    $('.total-section .netTotal').text('$' + newTotal.toFixed(2));       // Total
}

    // Bind change event to quantity input fields
    $('.quantity-input').on('change', function() {
        // Call recalculateCart whenever quantity changes
        recalculateCart();
    });

    // Initial calculation
    recalculateCart();
	
	function ValidateEmail(inputText) {
      var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
      if (inputText.match(mailformat)) {
        return true;
      } else {
		 
        return false;
      }
    }
	
	function SendOrder() {
    var netTotal = 0;
	var Total=0;
	var sumTotal=0;
	var Tax=0;
	var PrcntTax=<?php echo $PrcntTax; ?>;
	var Fee=<?php echo $Fee; ?>;
	var ProfitDiscount=<?php echo $ProfitDiscount; ?>;
	var valueDiscount=0;
	var statPoints=1;
	var email = document.getElementById("email").value;
    var name = document.getElementById("name").value;
    var address = document.getElementById("address").value;	 	
	  
	$('#errorMessage').addClass('d-none');
    $('#successMessage').addClass('d-none');
	
	if (name == "") {
		showMsg(0,'Error: Please Enter your Name!');
        return false;
      }
      
      if (email == "") {
		  showMsg(0,'Error: Please Enter your Email!');
        return false;
      } else {
        if (!ValidateEmail(email)) {
			showMsg(0,'Error: You have entered an invalid email address!');
          return false;
        }
      }
	  if (address == "") {
		  showMsg(0,'Error: Please Enter your Address!');
        return false;
      }
	  
	 
 // Create an array to store the card data
    var cardData =[] ;
     $('.cart-item').each(function() {
		let foodid = parseInt($(this).data('productid'));
		let foodName=$(this).find('.foodName').text();
		let price = parseFloat($(this).find('.price').text().replace('$', ''));
        let quantity = parseInt($(this).find('.quantity-input').val());
		
		  if(quantity>0 && price>0)
		  {
          sumTotal = quantity * price;
		  Total+=sumTotal;
		  // Create an object to store the card data
        var data = {
			foodid:foodid,
			foodName:foodName,
            quantity: quantity,
            price: price,
		    sumTotal: sumTotal,
        };
        // Add the card data to the array
        cardData.push(data);
		  }
		});
		if(sumTotal<=0)
		{
			showMsg(0,'Error: The Total must be greater than 0!');
			return;
		}
		
	//const subtotal = parseFloat(document.querySelector('.total').textContent.replace('$', ''));
    Tax = parseFloat(document.querySelector('.tax').textContent.replace('$', ''));
    Fee = parseFloat(document.querySelector('.fee').textContent.replace('$', ''));
    valueDiscount = document.querySelector('.discount')
        ? parseFloat(document.querySelector('.discount').textContent.replace('$', ''))
        : 0; // Set to 0 if discount doesn't exist
    netTotal = parseFloat(document.querySelector('.netTotal').textContent.replace('$', ''));
    if(ProfitDiscount>0)
	{
		statPoints=0;
	}
	var form = new FormData();
            form.append('cardsData', JSON.stringify(cardData));
            form.append('Total', Total);
            form.append('Tax', Tax);
            form.append('Fee', Fee);
			form.append('Discount', valueDiscount);
			form.append('StatPoints', statPoints);
            form.append('netTotal', netTotal);
			form.append('name', name);
			form.append('email', email);
			form.append('address', address);
			$.ajax({
        type: 'post',
        url: 'orderdb.php',
        cache: false,
        contentType: false,
        processData: false,
        data: form,
        success: function(response) {
          if (response.startsWith("success:")) {
			  let code = response.substring("success:".length);
            var qtyInputs = document.querySelectorAll('.quantity-input');
                qtyInputs.forEach(function(input) {
                input.disabled = true;  // Disable the input
              });
			  var btnsremove = document.querySelectorAll('.btn-remove-item');
                btnsremove.forEach(function(input) {
                input.disabled = true;  // Disable the input
              });
			  $('#orderForm').find('input, button').prop('disabled', true);
              orderbtn.disabled = true;
			  orderbtn.style.cursor = 'not-allowed';
			  notify('success','WE-CARE Message', 'The Order has been sent successfully,Check your email to ensure student success.');
			   setTimeout(function () {
                    window.location.href = "myorder.php?ordercode="+code;
                 }, 4000);
				 
		  } else {
			  showMsg(0,response);
          }
        }
      });
    }


$('.checkout-btn').on('click', function(e) {
            e.preventDefault(); // Prevent the default anchor behavior
            SendOrder();
			
        });
		
});


</script>

    </body>
</html>