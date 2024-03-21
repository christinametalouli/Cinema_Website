<?php

$showForm = true;

if (isset($_POST['send'])) {
   $url = 'http://localhost:8080/CinemaServices/api/auth/register';
   $data = array(
      'username' => $_POST['username'],
      'password' => $_POST['password'],
      'first_name' => $_POST['firstName'],
      'last_name' => $_POST['lastName'],
      'city' => $_POST['city'],
      'country' => $_POST['country'],
      'email' => $_POST['email'],
      'address' => $_POST['address']
   );

   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_POST, true);
   curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   $response = curl_exec($ch);
   curl_close($ch);

   if ($response === false) {
      echo 'Error sending cURL request';
   } else {
      $response = json_decode($response, true);
      $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      if ($httpCode == 201) {
         $showForm = false;
      } else {
         echo 'Error registering user';
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <!-- swiper css link  -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

   <!-- CSS only -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

</head>


<body>
   <!-- header section starts  -->

   <section class="header">

      <a href="home.php" class="logo">Neo Movie</a>

      <nav class="navbar">
         <a href="home.php">home</a>
         <a href="login.php">login</a>
      </nav>

      <div id="menu-btn" class="fas fa-bars"></div>

   </section>

   <!-- header section ends -->

   <!-- booking section starts  -->

   <section class="booking" <?php if ($showForm == false) echo "hidden"; ?>>

      <h1 class="heading-title">register yourself</h1>

      <form action="" method="post" class="book-form">

         <div class="flex">
            <div class="inputBox">
               <span>username :</span>
               <input type="text" placeholder="enter your username" name="username">
            </div>
            <div class="inputBox">
               <span>password :</span>
               <input type="password" placeholder="enter your password" name="password">
            </div>
            <div class="inputBox">
               <span>First Name :</span>
               <input type="text" placeholder="enter your name" name="firstName">
            </div>
            <div class="inputBox">
               <span>Last Name :</span>
               <input type="text" placeholder="enter your name" name="lastName">
            </div>
            <div class="inputBox">
               <span>city :</span>
               <input type="text" placeholder="enter your city" name="city">
            </div>
            <div class="inputBox">
               <span>country :</span>
               <input type="text" placeholder="enter your country" name="country">
            </div>
            <div class="inputBox">
               <span>email :</span>
               <input type="email" placeholder="enter your email" name="email">
            </div>
            <div class="inputBox">
               <span>adress :</span>
               <input type="text" placeholder="enter your adress" name="address">
            </div>

         </div>

         <input type="submit" value="submit" class="btn" name="send">

      </form>

   </section>

   <!-- booking section ends -->



   <section <?php if ($showForm == true) echo "hidden"; ?>>
      <h1>Registration request submitted successfully!</h1>
      <p>Thank you for submitting your registration request. We will review your application and notify you once your account has been activated.</p>
   </section>












   <!--footer section starts -->

   <section class="footer">

      <div class="box-container">

         <div class="box">
            <h3>quick links</h3>
            <a href="home.html"> <i class="fas fa-angle-right"></i> home</a>
            <a href="reservations.php"> <i class="fas fa-angle-right"></i> reservations</a>
            <a href="book.php"> <i class="fas fa-angle-right"></i> book</a>
            <a href="login.php"> <i class="fas fa-angle-right"></i> login</a>
            <a href="register.php"> <i class="fas fa-angle-right"></i> register</a>
         </div>

         <div class="box">
            <h3>extra links</h3>
            <a href="#"> <i class="fas fa-angle-right"></i> ask questions</a>
            <a href="#"> <i class="fas fa-angle-right"></i> about us</a>
            <a href="#"> <i class="fas fa-angle-right"></i> privacy policy</a>
            <a href="#"> <i class="fas fa-angle-right"></i> terms of use</a>
         </div>

         <div class="box">
            <h3>contact info</h3>
            <a href="#"> <i class="fas fa-phone"></i> +30 2101234567 </a>
            <a href="#"> <i class="fas fa-phone"></i> +30 2101234567 </a>
            <a href="#"> <i class="fas fa-envelope"></i> uni@gmail.com </a>
            <a href="#"> <i class="fas fa-map"></i> Piraeus, Greece </a>
         </div>

         <div class="box">
            <h3>follow us</h3>
            <a href="#"> <i class="fab fa-facebook-f"></i> facebook </a>
            <a href="#"> <i class="fab fa-twitter"></i> twitter </a>
            <a href="#"> <i class="fab fa-instagram"></i> instagram </a>
            <a href="#"> <i class="fab fa-linkedin"></i> linkedin </a>
         </div>

      </div>

      <div class="credit"> created by <span>unipi</span> | all rights reserved </div>

   </section>


   <!--footer section ends -->





   <!-- swiper js link  -->
   <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

   <!-- custom js file link  -->
   <script src="script.js"></script>

</body>


</html>