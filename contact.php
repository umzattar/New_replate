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
        <title>WE CARE | Home</title>
		 <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css" />
         <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
         
        <!-- Bootstrap icons-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <!-- Theme CSS Bootstrap-->
        <link href="css/bootstrap.min.css" rel="stylesheet" />
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
						<li class="nav-item"><a class="nav-link active" href="#">Contact</a></li>
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
        <!-- Contact Section -->
<section class="contact-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Get In Touch With Us</h2>
            <p>If you have any questions or want to learn more about WE CARE, feel free to contact us.</p>
        </div>

        <div class="row g-5">
		<!-- Contact Info -->
            <div class="col-lg-6">
                <div class="contact-info">
                    <h4>Our Contact Information</h4>
                    <p>Feel free to reach out to us through any of the following methods:</p>
                    <ul class="list-unstyled">
                        <li class="mb-3"><i class="fas fa-map-marker-alt icon-contact"></i> 123 Main St, New York, NY 10001</li>
                        <li class="mb-3"><i class="fas fa-phone-alt icon-contact"></i> +1 800-123-4567</li>
                        <li class="mb-3"><i class="fas fa-envelope icon-contact"></i> support@wecare.com</li>
                        <li class="mb-3"><i class="fas fa-globe icon-contact"></i> www.wecare.com</li>
                    </ul>
                </div>
            </div>
			
            <!-- Contact Form -->
            <div class="col-lg-6">
                <form action="contactdb.php" method="POST" id="contactForm" onsubmit="return SendData();">
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Your Name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Your Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Your Email">
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subject" placeholder="Subject">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" rows="4" placeholder="Your Message"></textarea>
                    </div>
					 
					 <div id="messageContainer">
                         <div id="successMessage" class="alert alert-success d-none" role="alert">
                             The message was sent successfully
                         </div>
                         <div id="errorMessage" class="alert alert-danger d-none" role="alert">
                             Error submitting  try again.
                         </div>
                     </div>
	   
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
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
    function SendData() {

	  var form = document.getElementById('contactForm');
      $('#errorMessage').addClass('d-none');
      $('#successMessage').addClass('d-none');
	  
      var email = document.getElementById("email").value;
      var name = document.getElementById("name").value;
      var subject = document.getElementById("subject").value;
	  var msgs = document.getElementById("message").value;
	  
      if (name == "") {
		  $('#errorMessage').removeClass('d-none').text("enter the name");
        return false;
      }
      
      if (email == "") {
		    $('#errorMessage').removeClass('d-none').text("enter the Email");
        return false;
      } else {
        if (!ValidateEmail(email)) {
			  $('#errorMessage').removeClass('d-none').text("You have entered an invalid email address!");
          return false;
        }
      }
      if (msgs == "") {
		 $('#errorMessage').removeClass('d-none').text("enter the Message");
        return false;
      }

      $.ajax({
        type: 'post',
        url: 'contactdb.php',
        data: {
          name: name,
          email: email,
		  subject:subject,
          message: msgs
        },
        success: function(response) {
          if (response == "success") {
			   form.reset();
			   $('#successMessage').removeClass('d-none');
            setTimeout(function() {
			   $('#successMessage').addClass('d-none');
            }, 2000);
          } else {
		    $('#errorMessage').removeClass('d-none').text(response);
          }
        }
      });
      return false;
    }

    function ValidateEmail(inputText) {
      var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
      if (inputText.match(mailformat)) {
        return true;
      } else {
		 
        return false;
      }
    }
  </script>
    </body>
</html>
