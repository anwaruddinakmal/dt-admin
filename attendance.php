<?php
include('includes/header.php');
date_default_timezone_set("Asia/Kuala_Lumpur");
header("Refresh: 10;url='attendance.php'");
$today = date("Y-m-d");
$id = $_SESSION['id'];
?>
<div class="container">
    <div class="card border-0 shadow-sm" style="background-color: #000000; background-image: linear-gradient(315deg, #000000 0%, #414141 74%);">
        <div class="card-body">
            <h3 style="color:white">Thank you for coming today</h3>
            <p style="color:orange">Click button below to record your today attendance</p>
            <hr style="background-color:gray">
            <div class="card border-0">
                <div class="card-body">
                    <?php
                    echo "Date Today : <b>" . date("d-m-Y") . " ( " . date("l") . " )</b><br>";
                    echo "Time Now : <b>" . date("h:i a") . "</b>";
                    ?>
                </div>
            </div>
            <br>
            <?php
            $sql = "SELECT time_in,time_out FROM attendance where user_id='$id' and timestampnow='$today'";
            $result = $link->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $punchin = $row["time_in"];
                    $punchout = $row["time_out"];

                    if ($punchin != "" && $punchout != "") {
            ?>
                        <p style="color: red;"><b>You already punch-in and punch-out for today. Thanks!</b></p>
                <?php
                    }elseif ($punchin != "" || $punchin != null && $punchout == "" || $punchout == null){
                        ?>
                        <a href="function/punch-in.php?id=<?php echo $_SESSION['id']; ?>" class="btn btn-primary btn-lg disabled">Punch In</a>
                        <a href="function/punch-out.php?id=<?php echo $_SESSION['id']; ?>" class="btn btn-danger btn-lg">Punch Out</a>
                        <?php
                    }else{
                        ?>
                        <a href="function/punch-in.php?id=<?php echo $_SESSION['id']; ?>" class="btn btn-primary btn-lg">Punch In</a>
                        <a href="function/punch-out.php?id=<?php echo $_SESSION['id']; ?>" class="btn btn-danger btn-lg disabled">Punch Out</a>
                        <?php
                    }
                    break;
                }
            } else {
                ?>
                <a href="function/punch-in.php?id=<?php echo $_SESSION['id']; ?>" class="btn btn-primary btn-lg">Punch In</a>
                <a href="function/punch-out.php?id=<?php echo $_SESSION['id']; ?>" class="btn btn-danger btn-lg disabled">Punch Out</a>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>