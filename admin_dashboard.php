<?php

include 'admin_header.php';
include 'db_connection.php';

// If a user is not logged in, redirect them to admin_login.php
if (!isset($_SESSION['username']) && !isset($_SESSION['password'])) {
    header('Location: admin_login.php');
}

// This gets the order ids for the completed orders
$query_get_complete_order_ids = "SELECT cupcake_order_id FROM cupcake_order WHERE status='true' ORDER BY pickup_date ASC;";
$result_get_complete_order_ids = mysqli_query($connect, $query_get_complete_order_ids) or die("Error: cannot show table");
$complete_order_ids = [];

foreach ($result_get_complete_order_ids as $val) {
    foreach ($val as $v) {
        $complete_order_ids[] = $v;
    }
}

// This gets the order ids for the orders in progress
$query_get_incomplete_order_ids = "SELECT cupcake_order_id FROM cupcake_order WHERE status='false' ORDER BY pickup_date ASC;";
$result_get_incomplete_order_ids = mysqli_query($connect, $query_get_incomplete_order_ids) or die("Error: cannot show table");
$incomplete_order_ids = [];

foreach ($result_get_incomplete_order_ids as $val) {
    foreach ($val as $v) {
        $incomplete_order_ids[] = $v;
    }
}

mysqli_close($connect);

function create_completed_order($order_id)
{
    get_order_info($order_id);

    echo '</div>';
}

function create_order_in_progress($order_id)
{
    // I needed to include the db connection inside functions that used it (just including it globally didn't work)
    include 'db_connection.php';

    get_order_info($order_id);

    // This ensures that none of the form inputs will have the same id/name
    $id = 'submit-' . $order_id . '';
    echo '
            </ul>
            <form action="admin_dashboard.php" method="post">
                <input id="' . $id . '" name="' . $id . '" type="submit" value="UPDATE ORDER STATUS" style="margin: 40px 0 0 0; width: 100%;">
            </form>
        </div>
        ';

    if (isset($_POST[$id])) {
        // This updates the row in the SQL table
        $query_update_order_item = "UPDATE cupcake_order SET status = 'true' WHERE cupcake_order_id = " . $order_id . ";";
        mysqli_query($connect, $query_update_order_item) or die('Error: cannot show table');

        // This refreshes the page
        echo '<meta http-equiv="refresh" content="0">';
    }

    mysqli_close($connect);
}

function get_order_info($order_id)
{
    // I needed to include the db connection inside functions that used it (just including it globally didn't work)
    include 'db_connection.php';

    // This gets the order info needed for the UI
    $query_get_order_info = "SELECT name, pickup_date FROM customer INNER JOIN cupcake_order ON customer_id = fk_customer_id WHERE cupcake_order_id = " . $order_id . ";";
    $result_get_order_info = mysqli_query($connect, $query_get_order_info) or die('Error: cannot show table');
    $name = '';
    $pickup_date = '';
    $count = 0;

    foreach ($result_get_order_info as $val) {
        foreach ($val as $v) {
            if ($count === 0) {
                $name = $v;
            } else {
                $pickup_date = $v;
            }
            $count += 1;
        }
    }

    // This updates the date format for the UI so it's more user-friendly
    $new_date_format = date('m-d-Y', strtotime($pickup_date));
    $pickup_date = $new_date_format;

    // This gets the order item info needed for the UI
    $query_get_order_items = "SELECT name, quantity_purchased FROM item INNER JOIN cupcake_order_item ON item_id = fk_item_id WHERE fk_cupcake_order_id = " . $order_id . ";";
    $result_get_order_items = mysqli_query($connect, $query_get_order_items) or die('Error: cannot show table');
    $items = [];

    foreach ($result_get_order_items as $val) {
        $count2 = 0;
        $item_name = '';
        $quantity_purchased = '';

        foreach ($val as $v) {
            if ($count2 === 0) {
                $item_name = $v;
            } else {
                $quantity_purchased = $v;
            }
            $count2 += 1;
        }

        $concat = '' . $quantity_purchased . ' ' . $item_name . '(s)';
        $items[] = $concat;
    }

    echo '
        <div class="order">
            <h3>Order ID: ' . $order_id . '</h3>
            <h3>Customer Name: ' . $name . '</h3>
            <h3>Pick Up Date: ' . $pickup_date . '</h3>
            <h3 style="margin: 0 0 20px 0;">Order Items:</h3>
            <ul>
            ';

    // This prints the order items into a list
    foreach ($items as $val) {
        echo '<li>' . $val . '</li>';
    }

    mysqli_close($connect);
}

?>

<header>
    <div class="logo-container">
        <h1>Cupcakery - Administrator</h1>
    </div>
    <div class="logout-container">
        <a href="admin_logout.php">
            <h2>LOGOUT</h2>
        </a>
    </div>
</header>

<main class="admin-content" style="padding: 40px 40px 0 40px;">
    <h2>Orders in Progress</h2>

    <?php
    if (!empty($incomplete_order_ids)) {
        for ($i = 0, $iMax = count($incomplete_order_ids); $i < $iMax; $i++) {
            create_order_in_progress($incomplete_order_ids[$i]);
        }
    } else {
        echo '
            <div class="order">No orders in progress.</div>
            ';
    }
    ?>

    <h2>Completed Orders</h2>

    <?php
    if (!empty($complete_order_ids)) {
        for ($i = 0, $iMax = count($complete_order_ids); $i < $iMax; $i++) {
            create_completed_order($complete_order_ids[$i]);
        }
    } else {
        echo '
            <div class="order">No completed orders.</div>
            ';
    }
    ?>
</main>

<?php
include 'admin_footer.php'
?>
