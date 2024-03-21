<?php

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    echo "<html><head><title>Invalid Request</title></head><body>";
    echo "<h1>Invalid Request</h1>";
    echo "<p>You have reached this page because the request you made was invalid. Please check the URL and try again.</p>";
    echo "</body></html>";
    exit();
}


// Set API endpoint URL
$url = 'http://localhost:8080/CinemaServices/api/movies/' . $id;

// Initialize cURL session
$curl = curl_init();

// Set cURL options
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $url
));

// Execute cURL request and get response
$response = curl_exec($curl);

// Check for errors
if (curl_errno($curl)) {
    echo 'Error: ' . curl_error($curl);
} else {
    // Decode JSON response into a PHP array
    $movie = json_decode($response, true);
}

// Close cURL session
curl_close($curl);


if (isset($_POST['send'])) {

    $data = array(
        'name' => $_POST['name'],
        'image_url' => $_POST['image_url']
    );

    $url = 'http://localhost:8080/CinemaServices/api/admin/movies/' . $id;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

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
    <title>Edit Movie</title>
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

    <div class="container mt-3">
        <h1 class="mb-3">Add Movie</h1>

        <form method="post" action="">

            <div class="form-group">
                <label for="movieId">ID:</label>
                <input type="text" class="form-control" id="movieId" value="<?php echo $movie["id"]; ?>" name="movieId" disabled>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" value="<?php echo $movie["name"]; ?>" name="name" required>
            </div>
            <div class="form-group">
                <label for="image_url">Image URL:</label>
                <input type="text" class="form-control" id="image_url" value="<?php echo $movie["image_url"]; ?>" name="image_url" required>
            </div>
            <button type="submit" class="btn btn-primary" name="send">Submit</button>
        </form>
    </div>


</body>


</html>