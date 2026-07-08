<?php
include_once 'session.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>WE CARE | SignUp</title>
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
						<li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
						<li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
						<li class="nav-item"><a class="nav-link active" href="signup.php">SignUp</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        
<div class="container login-container">
    <div class="login-card  bg-light">
        <h2>SignUp to Fight Food Waste</h2>
        <p class="tagline">Enjoy fresh meals while saving the planet!</p>
        <form action="userdb.php" method="post" onsubmit="return checkSignUp();">
		    <div class="form-group">
                <label for="name"><i class="fas fa-user login-icons"></i>User Name</label>
                <input type="text" class="form-control" id="uname" placeholder="Enter your Name" required>
            </div>
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope login-icons"></i>Email Address</label>
                <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password"><i class="fas fa-lock login-icons"></i>Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
            </div>
			<div class="form-group">
                <label for="password"><i class="fas fa-lock login-icons"></i>Re-Password</label>
                <input type="password" class="form-control" id="repassword" placeholder="Enter your password" required>
            </div>
			
			 <div id="messageContainer">
                 <div id="errorMessage" class="alert alert-danger d-none" role="alert">
                   Error message!.
                 </div>
             </div>
	   
			<div class="py-4 pt-4 border-top-0 bg-transparent">
            <div class="text-center"><button type="submit" class="btn btn-outline-dark mt-auto">Sign up</button></div>
			</div>
			
        </form>
        <div class="text-center mt-2">
            <span>I have an account? <a href="login.php">Login</a></span>
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
		 
		 <script>
          
        
        function checkUsername(name) {
            var usernameRegex = /^[A-Za-z][A-Za-z0-9_-]{3,14}$/;
            if (!usernameRegex.test(name)) {
				 $('#errorMessage').removeClass('d-none').text("Invalid username. Username must start with a letter, be 4-15 characters long, and may contain letters, numbers, underscores, or hyphens.");
                return false;
            }
            return true;
        }

        function checkSignUp() {
			$('#errorMessage').addClass('d-none');
			var name = document.getElementById("uname").value;
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            var repassword = document.getElementById("repassword").value;
            
            if (!checkUsername(name)) {
                return false;
            }
            
            if (password !== repassword) {
				 $('#errorMessage').removeClass('d-none').text("Passwords do not match.");
                return false;
            }

            $.ajax({
                type: 'POST',
                url: 'userdb.php',
                data: {
                    type: 2,
                    email: email,
                    name: name,
                    password: password
                },
                success: function(response) {
                    if (response.trim() === "success") {
                        window.location.href = "index.php";
                    } else {
						 $('#errorMessage').removeClass('d-none').text(response);
                    }
                }
            });
            return false;
        }
    </script>
		 
    </body>
</html>
