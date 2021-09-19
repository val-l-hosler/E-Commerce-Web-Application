<?php

include 'header.php';
include 'db_connection.php';

// This is the order id that was passed in from checkout.php
$id = (int)$_GET['order_id'];

// This gets the order id info needed for the UI
$query_get_order = "SELECT cupcake_order_id, pickup_date FROM cupcake_order WHERE cupcake_order_id = " . $id . ";";
$result_get_order = mysqli_query($connect, $query_get_order) or die("Error: cannot show table");
$order_id = '';
$pickup_date = '';
$count = 0;

foreach ($result_get_order as $val) {
    foreach ($val as $v) {
        if ($count === 0) {
            $order_id = $v;
        } else {
            $pickup_date = $v;
        }
        $count += 1;
    }
}

// This updates the date format for the UI so it's more user-friendly
$ui_date_format = date('m-d-Y', strtotime($pickup_date));

// This gets the total for all the items in the order which will be used in the UI
$query_get_total = "SELECT sum(quantity_purchased) FROM cupcake_order INNER JOIN cupcake_order_item ON cupcake_order_id = fk_cupcake_order_id WHERE cupcake_order_id = " . $id . ";";
$result_get_total = mysqli_query($connect, $query_get_total) or die("Error: cannot show table");
$total = number_format((mysqli_fetch_row($result_get_total)[0] * 3.50), 2);

mysqli_close($connect);
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