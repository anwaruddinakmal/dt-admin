<?php
require_once "../includes/config.php";

$premise_ip = "::1";

date_default_timezone_set("Asia/Kuala_Lumpur");
$current_time = date("h:i a");
$open = "10:00 am";
$close = "7:00 pm";
$date1 = DateTime::createFromFormat('h:i a', $current_time);
$date2 = DateTime::createFromFormat('h:i a', $open);
$date3 = DateTime::createFromFormat('h:i a', $close);

$id = $_GET['id'];
function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        // Check IP from internet.
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // Check IP is passed from proxy.
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        // Get IP address from remote address.
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
// echo getRealIpAddr();

if (getRealIpAddr() != $premise_ip) {
    echo "Please punch-in at counter pc!!";
} else {
    if ($date1 <= $date2 || $date1 >= $date3) {
        echo 'Punch-in is not valid due to out of operation hour!';
    } else {
        $sql = "INSERT INTO attendance (user_id, time_in) VALUES ('$id', '$current_time')";
        mysqli_query($link, $sql);
        echo '<script>window.alert("Punch-in Success!");</script>';
        header("location: ../index.php");
        exit;
    }
}
