<?php

session_start();

if (isset($_SESSION['admin'])) {
    // get userId is set in session
    $user = $_SESSION['admin'];
 
 } else {
    echo "<html><head><title>Unauthorized Request</title></head><body>";
    echo "<h1>Unauthorized Request</h1>";
    echo "<p>You are not authorized to access this page.</p>";
    echo "</body></html>";
    // Stop script execution
    exit();
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
    <title>Admin Dashboard</title>
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
        <a href="#" class="logo">Admin</a>

        <nav class="navbar">
            <a href="admin.php">Dashboard</a>
            <a href="admin_users.php">Users</a>
            <a href="admin_movies.php">Movies</a>
        </nav>

        <div id="menu-btn" class="fas fa-bars"></div>
    </section>

    <section class="dashboard">
        <h1 class="heading-title">Welcome to Admin Dashboard</h1>
        <form action="" method="post">
            <input type="submit" value="Logout" class="btn" name="send">
        </form>
    </section>


</body>

</html>