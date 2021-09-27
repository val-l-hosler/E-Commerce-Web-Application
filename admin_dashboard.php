<?php
include 'admin_header.php';

// If a user is not logged in, redirect them to admin_login.php
if (isset($_SESSION['username'], $_SESSION['password'])) {
    echo '
    <script>
        window.location.href = "https://valeriehosler.com/Cupcakery-Test/admin_login.php";
    </script>
    ';
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$connection = mysqli_connect('localhost', 'valerjp1_cupcakery', 'Cupcakery123*', 'valerjp1_cupcakery');

// This gets the order ids for the completed orders
$stmt = mysqli_prepare($connection,
    "SELECT cupcake_order_id FROM cupcake_order WHERE status='true' ORDER BY pickup_date");

mysqli_stmt_execute($stmt);
$result1 = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_array($result1, MYSQLI_NUM)) {
    foreach ($row as $r) {
        $complete_order_ids[] = $r;
    }
}

mysqli_stmt_close($stmt);

// This gets the order ids for the orders in progress
$stmt2 = mysqli_prepare($connection,
    "SELECT cupcake_order_id FROM cupcake_order WHERE status='false' ORDER BY pickup_date");

mysqli_stmt_execute($stmt2);
$result2 = mysqli_stmt_get_result($stmt2);

while ($row = mysqli_fetch_array($result2, MYSQLI_NUM)) {
    foreach ($row as $r) {
        $incomplete_order_ids[] = $r;
    }
}

mysqli_stmt_close($stmt2);

function create_completed_order($order_id)
{
    get_order_info($order_id);

    echo '</div>';
}

function create_order_in_progress($order_id)
{
    // I needed to include the db connection inside functions that used it (just including it globally didn't work)
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $connection = mysqli_connect('localhost', 'valerjp1_cupcakery', 'Cupcakery123*', 'valerjp1_cupcakery');

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
        $stmt = mysqli_prepare($connection,
            "UPDATE cupcake_order SET status = 'true' WHERE cupcake_order_id = ?");

        mysqli_stmt_bind_param($stmt, 'i', $order_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // This refreshes the page
        echo '<meta http-equiv="refresh" content="0">';
    }
}

function get_order_info($order_id)
{
    // I needed to include the db connection inside functions that used it (just including it globally didn't work)
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $connection = mysqli_connect('localhost', 'valerjp1_cupcakery', 'Cupcakery123*', 'valerjp1_cupcakery');

    // This gets the order info needed for the UI
    $stmt = mysqli_prepare($connection,
        "SELECT name, pickup_date FROM customer INNER JOIN cupcake_order ON customer_id = fk_customer_id WHERE cupcake_order_id = ?");

    mysqli_stmt_bind_param($stmt, 'i', $order_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name, $pickup_date);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // This updates the date format for the UI so it's more user-friendly
    $new_date_format = date('m-d-Y', strtotime($pickup_date));
    $pickup_date = $new_date_format;

    // This gets the order item info needed for the UI
    $stmt2 = mysqli_prepare($connection,
        "SELECT name, quantity_purchased FROM item INNER JOIN cupcake_order_item ON item_id = fk_item_id WHERE fk_cupcake_order_id = ?");

    mysqli_stmt_bind_param($stmt2, 'i', $order_id);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);

    $items = [];
    while ($row = mysqli_fetch_array($result2, MYSQLI_NUM)) {
        $count = 0;
        $item_name = '';
        $quantity_purchased = '';

        foreach ($row as $r) {
            if ($count === 0) {
                $item_name = $r;
            } else {
                $quantity_purchased = $r;
            }
            $count += 1;
        }

        $concat = '' . $quantity_purchased . ' ' . $item_name . '(s)';
        $items[] = $concat;
    }

    mysqli_stmt_close($stmt2);

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
