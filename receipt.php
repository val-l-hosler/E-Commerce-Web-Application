<?php
include 'header.php';

// This is the order id that was passed in from checkout.php
$id = (int)$_GET['order_id'];

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$connection = mysqli_connect('localhost', 'valerjp1_cupcakery', 'Cupcakery123*', 'valerjp1_cupcakery');

// This gets the order id info needed for the UI
$stmt = mysqli_prepare($connection,
    "SELECT cupcake_order_id, pickup_date FROM cupcake_order WHERE cupcake_order_id = ?");

mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $order_id, $pickup_date);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// This updates the date format for the UI so it's more user-friendly
$ui_date_format = date('m-d-Y', strtotime($pickup_date));

// This gets the total for all the items in the order which will be used in the UI
$stmt2 = mysqli_prepare($connection,
    "SELECT sum(quantity_purchased) FROM cupcake_order INNER JOIN cupcake_order_item ON cupcake_order_id = fk_cupcake_order_id WHERE cupcake_order_id = ?");

mysqli_stmt_bind_param($stmt2, 'i', $id);
mysqli_stmt_execute($stmt2);
mysqli_stmt_bind_result($stmt2, $total);
mysqli_stmt_fetch($stmt2);
mysqli_stmt_close($stmt2);

$total = number_format(($total * 3.50), 2);

?>

    <main class="main-content">
        <div class="receipt-container">
            <h2>Thank you for your order!</h2>
            <div class="receipt-container-item">
                <h3>Total:</h3>
                <h3><?php echo $total; ?></h3>
            </div>
            <div class="receipt-container-item">
                <h3>Order #:</h3>
                <h3><?php echo $order_id; ?></h3>
            </div>
            <div class="receipt-container-item">
                <h3>Pick Up Date:</h3>
                <h3><?php echo $ui_date_format; ?></h3>
            </div>
            <!-- This code/feature is from https://addtocalendar.com/ -->
            <div class="reminder-button-container">
                <div title="Add Reminder to Calendar" class="addeventatc">
                    Add Reminder to Calendar
                    <span class="start"><?php echo $pickup_date; ?> 07:00 AM</span>
                    <span class="end"><?php echo $pickup_date; ?> 07:00 PM</span>
                    <span class="timezone">America/New_York</span>
                    <span class="title">Cupcakes from Cupcakery</span>
                    <span class="description">Pick up your cupcake order.</span>
                    <span class="location">123 Main St. Pittsburgh, PA 15215</span>
                </div>
            </div>
        </div>
    </main>

<?php
include 'footer.php'
?>