<!DOCTYPE html>
<html>
<head>
    <?php
    session_start();
    
    // Establish the database connection
    $conn = mysqli_connect("localhost", "root", "", "crime_portal"); // Include the database name here
    if (!$conn) {
        die("Could not connect: " . mysqli_connect_error());
    }

    // Check if the user is logged in
    if (!isset($_SESSION['x'])) {
        header("location:userlogin.php");
        exit();
    }

    $u_id = $_SESSION['u_id'];
    $result1 = mysqli_query($conn, "SELECT a_no FROM user WHERE u_id='$u_id'");
    
    $q2 = mysqli_fetch_assoc($result1);
    $a_no = $q2['a_no'];

    if (isset($_POST['s2'])) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $cid = $_POST['cid'];
            $_SESSION['cid'] = $cid;

            $resu = mysqli_query($conn, "SELECT a_no FROM complaint WHERE c_id='$cid'");
            $qn = mysqli_fetch_assoc($resu);

            if ($qn['a_no'] == $q2['a_no']) {
                header("location:complainer_complain_details.php"); 
                exit();
            } else {
                $message = "Not Your Case";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
        }
    }

    $query = "SELECT c_id, type_crime, d_o_c, location FROM complaint WHERE a_no='$a_no' ORDER BY c_id DESC";
    $result = mysqli_query($conn, $query);
    ?>
    
    <title>Complaint History</title>
    
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <script>
    function f1() {
        var sta2 = document.getElementById("ciid").value;
        var x2 = sta2.indexOf(' ');

        if (sta2 != "" && x2 >= 0) {
            document.getElementById("ciid").value = "";
            alert("Space Not Allowed");
        }
    }
    </script>
</head>

<body style="background-color: #dfdfdf">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home.php"><b>Crime Management System</b></a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="complainer_page.php">User Login</a></li>
                    <li class="active"><a href="complainer_page.php">User Home</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="complainer_page.php">Log New Complain</a></li>
                    <li class="active"><a href="complainer_complain_history.php">Complaint History</a></li>
                    <li><a href="logout.php">Logout &nbsp <i class="fa fa-sign-out" aria-hidden="true"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div>
        <form style="float: right; margin-right: 100px; margin-top: 65px;" method="post">
            <input type="text" name="cid" style="width: 250px; height: 30px; color: black;" placeholder="&nbsp Complain Id" id="ciid" onfocusout="f1()" required>
            <input class="btn btn-primary btn-sm" type="submit" value="Search" style="margin-top:2px; margin-left:20px;" name="s2">
        </form>
    </div>

    <div style="padding:50px;">
        <table class="table table-bordered">
            <thead class="thead-dark" style="background-color: black; color: white;">
                <tr>
                    <th scope="col">Complaint Id</th>
                    <th scope="col">Type of Crime</th>
                    <th scope="col">Date of Crime</th>
                    <th scope="col">Location of Crime</th>
                </tr>
            </thead>
            <tbody style="background-color: white; color: black;">
                <?php
                while ($rows = mysqli_fetch_assoc($result)) {
                ?> 
                    <tr>
                        <td><?php echo htmlspecialchars($rows['c_id']); ?></td>
                        <td><?php echo htmlspecialchars($rows['type_crime']); ?></td>     
                        <td><?php echo htmlspecialchars($rows['d_o_c']); ?></td>          
                        <td><?php echo htmlspecialchars($rows['location']); ?></td>          
                    </tr>
                <?php
                } 
                ?>
            </tbody>
        </table>
    </div>

    <div style="position: fixed; left: 0; bottom: 0; width: 100%; height: 30px; background-color: rgba(0,0,0,0.8); color: white; text-align: center;">
        <h4 style="color: white;">&copy <b>Crime Management System 2024</b></h4>
    </div> 

    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
