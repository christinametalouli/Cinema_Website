<?php

session_start();

if (isset($_SESSION['user'])) {
   // get userId is set in session
   $user = $_SESSION['user'];
}

if (isset($_POST['send'])) {
   $_SESSION = array();
   session_destroy();

   header("Location: login.php");
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
         <?php
         if (!isset($user)) {
            echo '<a href="login.php">login</a>';
            echo '<a href="register.php">register</a>';
         } else {
            echo '<a href="reservations.php">reservations</a>';
         }
         ?>
      </nav>

      <?php
      if (isset($user)) {
         echo '<form action="" method="post"><input type="submit" value="Logout" class="btn" name="send"></form>';
      }
      ?>


      <div id="menu-btn" class="fas fa-bars"></div>

   </section>

   <!-- header section ends -->



   <!-- home section starts  -->

   <section class="home">

      <div class="swiper home-slider">

         <div class="swiper-wrapper">

            <div class="swiper-slide slide" style="background:url(images/cin1.jpg) no-repeat">
               <div class="content">
                  <span>new movies every week</span>
                  <h3>book your movie</h3>
                  <!-- <a href="book.php" class="btn">book now</a> -->
               </div>
            </div>

         </div>
      </div>

   </section>

   <!-- home section ends -->





   <!-- packages section starts  -->

   <section class="home-movies">

      <h1 class="heading-title">Top movies</h1>

      <div class="box-container">

         <?php

         $ch = curl_init();
		 
         curl_setopt($ch, CURLOPT_URL, "http://localhost:8080/CinemaServices/api/movies");
         curl_setopt($ch, CURLOPT_HTTPGET, true);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         $response = curl_exec($ch);

         if (curl_error($ch)) {
            echo 'Error: ' . curl_error($ch);
         }

         curl_close($ch);

			
         $data = json_decode($response, true);

         foreach ($data as $movie) { 
            echo '<div class="box">';
            echo '<div class="image">';
            echo '<img src="' . $movie["image_url"] . '" alt="">';
            echo '</div>';
            echo '<div class="content">';
            echo '<h3>' . $movie["name"] . '</h3>';
            echo '<p>Only in Neo Movie</p>';
            echo '<a href="book.php?id=' . $movie["id"] . '&movie=' . $movie["name"] . '" class="btn">book now</a>';
            echo '</div>';
            echo '</div>';
         }

         ?>


         <!--	  <div class="load-more"><span class="btn">load more</span></div>  -->
   </section>

   <!-- packages section ends -->





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