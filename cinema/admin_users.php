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
function fetchRequests()
{

    $url = 'http://localhost:8080/CinemaServices/api/admin/registration_requests';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    }
    curl_close($ch);

    return json_decode($result, true);
}

function fetchUsers()
{
    // Set API endpoint URL
    $url = 'http://localhost:8080/CinemaServices/api/admin/users';

    // Initialize cURL session
    $curl = curl_init();

    // Set cURL options
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url
    ));

    // Execute cURL request and get response
    $response = curl_exec($curl);
    curl_close($curl);


    return json_decode($response, true);
}

$users = fetchUsers();
$data = fetchRequests();

// approve

if (isset($_POST['approve'])) {
    $requestId = $_POST['requestId'];
    $role = $_POST['role'];

    $data = array('role' => $role);

    $url = 'http://localhost:8080/CinemaServices/api/admin/registration_requests/approve/' . $requestId;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $response = curl_exec($ch);
    curl_close($ch);

    $users = fetchUsers();
    $data = fetchRequests();
}



if (isset($_POST['deny'])) {
    $requestId = $_POST['requestId'];
    // Initialize cURL
    $ch = curl_init();

    // Set the URL and options
    curl_setopt($ch, CURLOPT_URL, "http://localhost:8080/CinemaServices/api/admin/registration_requests/deny/" . $requestId);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    $response = curl_exec($ch);
    curl_close($ch);

    $users = fetchUsers();
    $data = fetchRequests();
}

if (isset($_POST['delete'])) {
    $userId = $_POST['userId'];
    // Initialize cURL
    $ch = curl_init();

    // Set the URL and options
    curl_setopt($ch, CURLOPT_URL, "http://localhost:8080/CinemaServices/api/admin/users/" . $userId);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    $response = curl_exec($ch);
    curl_close($ch);

    $users = fetchUsers();
    $data = fetchRequests();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Requests</title>
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
        <h1 class="mb-3">Registration Requests</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Country</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Request ID</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row) { ?>
                    <tr>
                        <td><?php echo $row['firstName']; ?></td>
                        <td><?php echo $row['lastName']; ?></td>
                        <td><?php echo $row['country']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td><?php echo $row['city']; ?></td>
                        <td><?php echo $row['requestId']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <form action="" method="post">
                            <td><select name="role">
                                    <option value="user" selected>User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </td>
                            <td>
                                <div class="btn-group" role="group">

                                    <input type="hidden" name="requestId" value="<?php echo $row["requestId"]; ?>">
                                    <button type="submit" class="btn btn-success" name="approve">Approve</button>
                                    <button type="submit" class="btn btn-danger" name="deny">Deny</button>

                                </div>

                            </td>
                        </form>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="container mt-3">
        <h1 class="mb-3">Users</h1>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Country</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Request ID</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $row) { ?>
                    <tr>
                        <td><?php echo $row['firstName']; ?></td>
                        <td><?php echo $row['lastName']; ?></td>
                        <td><?php echo $row['country']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td><?php echo $row['city']; ?></td>
                        <td><?php echo $row['requestId']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td>
                        <form action="" method="post">
                                <div class="btn-group" role="group">

                                    <input type="hidden" name="userId" value="<?php echo $row["userId"]; ?>">
                                    <!-- <button type="submit" class="btn btn-success" name="edit">Edit</button> -->
                                    <button type="submit" class="btn btn-danger" name="delete">Delete</button>

                                </div>
                            </form>
                        </td>

                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>

</html>