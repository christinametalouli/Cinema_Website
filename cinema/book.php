<?php
session_start();

if (isset($_SESSION['user'])) {
   // get userId is set in session
   $user = $_SESSION['user'];
   
   if (isset($_GET['id']) && isset($_GET['movie'])) {
      $id = $_GET['id'];
      $movie = $_GET['movie'];
   } else {
      echo "<html><head><title>Invalid Request</title></head><body>";
      echo "<h1>Invalid Request</h1>";
      echo "<p>You have reached this page because the request you made was invalid. Please check the URL and try again.</p>";
      echo "</body></html>";
      exit();
   }
} else {
   echo "<html><head><title>Unauthorized Request</title></head><body>";
   echo "<h1>Unauthorized Request</h1>";
   echo "<p>You are not authorized to access this page.</p>";
   echo "</body></html>";
   // Stop script execution
   exit();
}

// api
if(isset($_POST['send'])) {

   // Retrieve form data
   $userId = $_SESSION['user']['userId'];
   $movieId = $_GET['id'];
   $bookingDate = $_POST['date'];
   $email = $_SESSION['user']['email'];

   $formattedDate = date('Y-m-d H:i:s', strtotime($bookingDate));

   // Create JSON data
   $postData = array(
      'user_id' => $userId,
      'movie_id' => $movieId,
      'booking_date' => $formattedDate,
      'email' => $email
   );
   $jsonData = json_encode($postData);

   // Call the API using cURL
   $ch = curl_init('http://localhost:8080/CinemaServices/api/bookings/new');
   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
   curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Content-Length: ' . strlen($jsonData))
   );

   // Get the response
   $response = curl_exec($ch);
   $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
   curl_close($ch);

   // Check the response code
   if($httpCode == 200) {
      header('Location: admin_movies.php');
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
         <a href="reservations.php">reservations</a>

      </nav>
      <h3><?php echo $user["username"]; ?></h3>
      <div id="menu-btn" class="fas fa-bars"></div>

   </section>

   <!-- header section ends -->

   <!-- booking section starts  -->

   <section class="booking">

      <h1 class="heading-title">book your movie!</h1>

      <form action="" method="post" class="book-form">

         <div class="flex">
            <div class="inputBox">
               <span>username :</span>
               <input type="text" placeholder="enter your username" name="username" , value="<?php echo $user["username"]; ?>" disabled>
            </div>
            <div class="inputBox">
               <span>email :</span>
               <input type="email" placeholder="enter your email" name="email" , value="<?php echo $user["email"]; ?>" disabled>
            </div>

            <div class="inputBox">
               <span>date :</span>
               <input type="date" name="date">
            </div>
            <div class="inputBox">
               <span>movie :</span>
               <input type="email" placeholder="enter your movie" name="movie" , value="<?php echo $movie; ?>" disabled>
            </div>
         </div>

         <input type="submit" value="submit" class="btn" name="send">

      </form>

   </section>

   <!-- booking section ends -->















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