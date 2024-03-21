<?php

session_start();

if (isset($_SESSION['user'])) {
   // get userId is set in session
   $user = $_SESSION['user'];

} else {
   echo "<html><head><title>Unauthorized Request</title></head><body>";
   echo "<h1>Unauthorized Request</h1>";
   echo "<p>You are not authorized to access this page.</p>";
   echo "</body></html>";
   // Stop script execution
   exit();
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
         
      </nav>
      <h3><?php echo $user["username"]; ?></h3>
      <div id="menu-btn" class="fas fa-bars"></div>

   </section>

   <!-- header section ends -->



   <section class="booking">

      <h1 class="heading-title">your reservations</h1>

      <form class="book-form">
         <div class="inputBox">
            <h1>Username :</h1>
            <h3><?php echo $user["username"]; ?></h3>
         </div>
         <hr>

         <?php
         // Set the API endpoint URL
         $url = 'http://localhost:8080/CinemaServices/api/bookings/1';

         // Create a new curl resource
         $curl = curl_init();

         // Set the curl options
         curl_setopt($curl, CURLOPT_URL, $url);
         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

         // Execute the curl request
         $response = curl_exec($curl);

         // Check for errors
         if (curl_error($curl)) {
            echo 'Error: ' . curl_error($curl);
         } else {
            // Decode the JSON response into a PHP array
            $data = json_decode($response, true);

            foreach ($data as $booking) {
               echo '<div class="flex">';
               echo '<div class="inputBox">';
               echo '<h1>Movie :</h1>';
               echo '<h3>' . $booking['movie_name'] . '</h3>';
               echo '</div>';
               echo '<div class="inputBox">';
               echo '<h1>Date :</h1>';
               echo '<h3>' . date('d/m/Y', strtotime($booking['booking_date'])) . '</h3>';
               echo '</div>';
               echo '</div>';
               echo '<br>';
            }
         }

         // Close the curl resource
         curl_close($curl);
         ?>
      </form>

      <form class="book-form">

      </form>

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