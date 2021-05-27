<?php
include('includes/header.php');
?>
<div class="container">
    <div class="card">
        <div class="card-body">
            Welcome <?php echo $_SESSION['name']; ?>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>