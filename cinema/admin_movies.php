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


function fetchMovies()
{

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://localhost:8080/CinemaServices/api/movies");
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    if (curl_error($ch)) {
        echo 'Error: ' . curl_error($ch);
    }

    curl_close($ch);

    return json_decode($response, true);
}

$data = fetchMovies();

if (isset($_POST['delete'])) {
    $movieId = $_POST['movie_id'];
    // Initialize cURL
    $ch = curl_init();

    // Set the URL and options
    curl_setopt($ch, CURLOPT_URL, "http://localhost:8080/CinemaServices/api/admin/movies/" . $movieId);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    $response = curl_exec($ch);
    curl_close($ch);

    $data = fetchMovies();
}

if (isset($_POST['edit'])) {
    $movieId = $_POST['movie_id'];

    header("Location: admin_movies_edit.php?id=" . $movieId);
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies</title>
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
        <h1 class="mb-3">Movies</h1>

        <a href="admin_movies_add.php" class="btn btn-primary mb-3">Add Movie</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image URL</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['image_url']; ?></td>
                        <td>
                            <form action="" method="post">

                                <input type="hidden" value="<?php echo $row["id"]; ?>" name="movie_id">
                                <button type="submit" class="btn btn-success" name="edit">Edit</button>
                                <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>


</html>