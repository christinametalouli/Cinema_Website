<?php

if (isset($_POST['send'])) {
   $username = $_POST['name'];
   $password = $_POST['password'];

   // Make API call to authenticate user
   $url = 'http://localhost:8080/CinemaServices/api/auth/login';
   $data = array('username' => $username, 'password' => $password);
   $options = array(
       'http' => array(
           'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
           'method'  => 'POST',
           'content' => http_build_query($data)
       )
   );
   $context  = stream_context_create($options);
   $result = file_get_contents($url, false, $context);
   
   // Handle the response from the API
   if ($result === false) {
       echo 'Error making API call';
   } else {
       $response = json_decode($result, true);
       if (isset($response["roleId"])) {
           session_start();
           

           $role = $response["roleId"];
           if ($role == 1) {
            $_SESSION['admin'] = $response;
           header('Location: admin.php');
           } else {
            $_SESSION['user'] = $response;
            header('Location: reservations.php');
           }
           exit();
       } else {
           echo 'Invalid username or password.';
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
         <a href="register.php">register</a>
      </nav>

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
               <input type="text" placeholder="enter your username" name="name">
            </div>
            <div class="inputBox">
               <span>password :</span>
               <input type="password" placeholder="enter your password" name="password">
            </div>
         </div>

         <input type="submit" value="login" class="btn" name="send">

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