<!DOCTYPE html>
<html>
<head>
    
    <?php
    session_start();
    if(!isset($_SESSION['x']))
        header("location:inchargelogin.php");
    
    $conn=mysqli_connect("localhost","root","");
    if(!$conn) {
        die("could not connect".mysqli_error($conn)); // Added $conn for error context
    }
    mysqli_select_db($conn, "crime_portal"); // Fixed argument order
    
    $i_id=$_SESSION['email'];

    $result1=mysqli_query($conn, "SELECT location FROM police_station where i_id='$i_id'"); // Added $conn here
    $q2=mysqli_fetch_assoc($result1);
    $location=$q2['location'];
    
    if(isset($_POST['s2'])) {
        if($_SERVER["REQUEST_METHOD"]=="POST") {
            $pid=$_POST['pid'];
            
            $q1=mysqli_query($conn, "delete from police where p_id='$pid'"); // Added $conn here
            $q3=mysqli_query($conn, "update complaint set pol_status='null',inc_status='Unassigned',p_id='Null' where p_id='$pid'"); // Added $conn here
        }
    }
    
    $result=mysqli_query($conn, "select p_id,p_name,spec,location from police where location='$location'"); // Added $conn here
    ?>
    
    <title>Incharge Homepage</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    
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
                    <li><a href="official_login.php">Official Login</a></li>
                    <li><a href="inchargelogin.php">Incharge Login</a></li>
                    <li class="active"><a href="incharge_view_police.php">Incharge View Police</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="Incharge_complain_page.php">View Complaints</a></li>
                    <li class="active"><a href="incharge_view_police.php">Police Officers</a></li>
                    <li><a href="inc_logout.php">Logout &nbsp <i class="fa fa-sign-out" aria-hidden="true"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div style="padding:50px;">
        <table class="table table-bordered">
            <thead class="thead-dark" style="background-color: black; color: white;">
                <tr>
                    <th scope="col">Police Id</th>
                    <th scope="col">Police Name</th>
                    <th scope="col">Specialization</th>
                    <th scope="col">Location</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <?php
            while($rows=mysqli_fetch_assoc($result)) {
            ?> 
            <tbody style="background-color: white; color: black;">
                <tr>
                    <td><?php echo $rows['p_id'];?></td>
                    <td><?php echo $rows['p_name'];?></td>
                    <td><?php echo $rows['spec'];?></td>
                    <td><?php echo $rows['location'];?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="pid" value="<?php echo $rows['p_id'];?>">
                            <input type="submit" name="s2" class="btn btn-danger" value="Delete">
                        </form>
                    </td>
                </tr>
            </tbody>
            <?php
            } 
            ?>
        </table>
    </div>
    
    <div style="position: fixed; left: 0; bottom: 0; width: 100%; height: 30px; background-color: rgba(0,0,0,0.8); color: white; text-align: center;">
        <h4 style="color: white;">&copy <b>2024 Crime Management System | All Right Reserved</b></h4>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
