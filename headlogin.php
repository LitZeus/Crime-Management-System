<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="bootstrap.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet">

    <title>Head Login</title>
    <?php
    if (isset($_POST['s'])) {
        session_start();
        $_SESSION['x'] = 1;

        // Create a connection
        $conn = new mysqli("localhost", "root", "", "crime_portal");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = $conn->real_escape_string($_POST['email']);
            $pass = $conn->real_escape_string($_POST['password']);

            // Use prepared statements to prevent SQL injection
            $stmt = $conn->prepare("SELECT h_id, h_pass FROM head WHERE h_id = ? AND h_pass = ?");
            $stmt->bind_param("ss", $name, $pass);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                echo "<script>alert('Id or Password not Matched.');</script>";
            } else {
                header("Location: headHome.php");
                exit();
            }
            $stmt->close();
        }
        $conn->close();
    }
    ?>
</head>
<body style="color: black; background-image: url(locker.jpeg); background-size: 100%; background-repeat: no-repeat;">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="home.php"><b>Crime Management System</b></a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="official_login.php">Official Login</a></li>
                    <li class="active"><a href="headlogin.php">HQ Login</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div align="center">
        <div class="form" style="margin-top: 15%">
            <form method="post">
                <div class="form-group" style="width: 30%">
                    <label for="exampleInputEmail1"><h1 style="color:white">HQ Id</h1></label>
                    <input type="text" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter user id" required>
                </div>
                <div class="form-group" style="width:30%">
                    <label for="exampleInputPassword1"><h1 style="color:white">Password</h1></label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-primary" name="s">Submit</button>
            </form>
        </div>
    </div>
    <div style="position: fixed; left: 0; bottom: 0; width: 100%; height: 30px; background-color: rgba(0,0,0,0.8); color: white; text-align: center;">
        <h4 style="color: white;">&copy; <b>Crime Management System 2024</b></h4>
    </div>
</body>
</html>
