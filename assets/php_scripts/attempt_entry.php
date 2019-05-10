<?php
    $con=mysqli_connect("localhost","root","","wecan");
    if (mysqli_connect_errno()) {
        header("Location: ../home.php");
        exit;
        exit();
    }
    
    $idcard = $_GET['idcard'];
    $date = $_GET['date'];
    $venue = $_GET['venue'];

	$formatted_date = $date;
	$formatted_date = str_replace('/', '-', $formatted_date);
    $formatted_date = date('Y-m-d', strtotime($formatted_date));
    
    $query = "SELECT * FROM `entry` WHERE card_idcard = '".$idcard."' and date = '".$formatted_date."' and venue = '".$venue."'";
    $result = mysqli_query($con,$query);
    if($result->num_rows>0)
    {
        $row = mysqli_fetch_array($result);
        //echo $row['entryno'] ." has been ".$row['access']." access!";
        echo "Access ".strtolower($row['access'])."!";
    }
?> 