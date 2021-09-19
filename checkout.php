<?php
include 'header.php';
include 'get_counters.php';
include 'db_connection.php';

if (isset($_POST['name'])) {
    $name = $_POST['name'];
}
if (isset($_POST['phone'])) {
    $phone = $_POST['phone'];
}
if (isset($_POST['date'])) {
    $date = $_POST['date'];
}
if (isset($_POST['card-name'])) {
    $card_name = $_POST['card-name'];
}
if (isset($_POST['card-number'])) {
    $card_number = $_POST['card-number'];
}
if (isset($_POST['card-cvv'])) {
    $card_cvv = $_POST['card-cvv'];
}
if (isset($_POST['expiration'])) {
    $expiration = $_POST['expiration'];
}

// These flags keep track of if the input is empty because of a new page load or if a user doesn't add a value to a field
$flag_name = false;
$flag_phone = false;
$flag_first_name = false;
$flag_date = false;
$flag_card_name = false;
$flag_card_number = false;
$flag_card_cvv = false;
$flag_expiration = false;
?>

<main class="main-content">
    <h2 id="success" style="margin: 0 0 40px 0;">Your order was successfully submitted. Redirecting to the receipt in 3
        seconds...</h2>

    <div class="payment-order-container">
        <h2>Schedule Pickup</h2>

        <form action="checkout.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" pattern="^[a-zA-Z' .]{1,150}$" max="150"
                   placeholder="John Doe" <?php if (isset($_POST['name'])) {
                $flag_name = true;
                echo "value='$name'";
            } ?>
                   oninvalid="this.setCustomValidity('Error: the name field is in the wrong format. Valid characters are letters, spaces, apostrophes, and periods and is up to 150 chars in length.')"
                   oninput="this.setCustomValidity('')" required>

            <?php
            if (preg_match("/^[a-zA-Z' .]{1,150}$/", $name)) {
                $final_name = $name;
            } elseif (empty($_POST['name'])) {
                if ($flag_name) {
                    echo "<span>Error: the name field is empty.</span>";
                }
            } else {
                echo "<span>Error: the name field is in the wrong format. Valid characters are letters, spaces, apostrophes, and periods and is up to 150 chars in length.</span>";
            }
            ?>

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" minlength="10"
                   placeholder="555-555-5555" <?php if (isset($_POST['phone'])) {
                $flag_phone = true;
                echo "value='$phone'";
            } ?>
                   oninvalid="this.setCustomValidity('Error: the phone number field is in the wrong format. It must be in the following format... 555-555-5555')"
                   oninput="this.setCustomValidity('')" required>

            <?php
            if (preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phone)) {
                $final_phone = $phone;
            } elseif (empty($_POST['phone'])) {
                if ($flag_phone) {
                    echo "<span>Error: the phone number field is empty.</span>";
                }
            } else {
                echo "<span>Error: the phone number field is in the wrong format. It must be in the following format... 555-555-5555</span>";
            }
            ?>

            <label for="date">Pickup Date: (no same-day pickup)</label>
            <input type="date" id="date" name="date"
                <?php if (isset($_POST['date'])) {
                    $flag_date = true;
                    echo "value='$date'";
                } ?> required>

            <?php
            if (empty($_POST['date'])) {
                if ($flag_date) {
                    echo "<span>Error: the pickup date field is empty.</span>";
                }
            } elseif (check_date($date) === 'no error') {
                $final_date = $date;
            } else if (check_date($date) === 'Sunday error') {
                echo '<span>Error: the pickup date is invalid. The store is closed on Sundays.</span>';
            } else if (check_date($date) === 'past error') {
                echo '<span>Error: the pickup date is invalid. It cannot be in the past.</span>';
            } else if (check_date($date) === 'today error') {
                echo '<span>Error: the pickup date is invalid. We do not accommodate same-day pickups.</span>';
            }

            function check_date($date)
            {
                date_default_timezone_set('America/New_York');

                // This gets a numeric representation of the day in the date
                $day = date('w', strtotime($date));

                $today = date('Y-m-d');

                // If the day is Sunday
                if ($day == 0) {
                    return 'Sunday error';
                }

                // If the day is in the past
                if ($date < $today) {
                    return 'past error';
                }

                // If the date is today
                if ($date === $today) {
                    return 'today error';
                }

                return 'no error';
            }
            ?>

            <h2>Payment Information</h2>

            <label for="card-name">Name on Card:</label>
            <input type="text" id="card-name" name="card-name" pattern="^[a-zA-Z' .]{1,150}$" max="150"
                   placeholder="John Doe" <?php if (isset($_POST['card-name'])) {
                $flag_card_name = true;
                echo "value='$card_name'";
            } ?>
                   oninvalid="this.setCustomValidity('Error: the card name field is in the wrong format. Valid characters are letters, spaces, apostrophes, and periods and is up to 150 chars in length.')"
                   oninput="this.setCustomValidity('')" required>

            <?php
            if (preg_match("/^[a-zA-Z' .]{1,150}$/", $card_name)) {
                $final_card_name = $card_name;
            } elseif (empty($_POST['card-name'])) {
                if ($flag_card_name) {
                    echo "<span>Error: the card name field is empty.</span>";
                }
            } else {
                echo "<span>Error: the card name field is in the wrong format. Valid characters are letters, spaces, apostrophes, and periods and is up to 150 chars in length.</span>";
            }
            ?>

            <label for="card-number">Card Number:</label>
            <input type="text" name="card-number" id="card-number" min="19"
                   pattern="^[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}$"
                   placeholder="5555-5555-5555-5555" <?php if (isset($_POST['card-number'])) {
                $flag_card_number = true;
                echo "value='$card_number'";
            } ?>
                   oninvalid="this.setCustomValidity('Error: the card number field is not in the following format... 5555-5555-5555-5555')"
                   oninput="this.setCustomValidity('')" required>

            <?php
            if (preg_match("/^[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}$/", $card_number)) {
                $final_card_number = $card_number;
            } elseif (empty($_POST['card-number'])) {
                if ($flag_card_name) {
                    echo "<span>Error: the card number field is empty.</span>";
                }
            } else {
                echo "<span>the card number field is not in the following format... 5555-5555-5555-5555</span>";
            }
            ?>

            <label for="card-cvv">CVV:</label>
            <input type="text" name="card-cvv" id="card-cvv" min="3" pattern="^[0-9]{3}$" placeholder="555"
                <?php if (isset($_POST['card-cvv'])) {
                    $flag_card_cvv = true;
                    echo "value='$card_cvv'";
                } ?>
                   oninvalid="this.setCustomValidity('Error: the card cvv field is not in the following format... 555')"
                   oninput="this.setCustomValidity('')" required>

            <?php
            if (preg_match("/^[0-9]{3}$/", $card_cvv)) {
                $final_cvv = $card_cvv;
            } elseif (empty($_POST['card-cvv'])) {
                if ($flag_card_cvv) {
                    echo "<span>Error: the card cvv field is empty.</span>";
                }
            } else {
                echo "<span>Error: the card cvv field is not in the following format... 555</span>";
            }
            ?>

            <label>Expiration Date:</label>
            <div class="expiration">
                <select id="month" name="month">
                    <option value="01" <?php if (isset($_POST['month']) && $_POST['month'] === '01') {
                        $flag_expiration = true;
                        echo "selected='selected'";
                        $month = '01';
                    } ?>>
                        January
                    </option>
                    <option value="02" <?php if (isset($_POST['month']) && $_POST['month'] === '02') {
                        $flag_expiration = true;
                        echo "selected='selected'";
                        $month = '02';
                    } ?>>
                        February
                    </option>
                    <option value="03" <?php if (isset($_POST['month']) && $_POST['month'] === '03') {
                        $flag_expiration = true;
                        echo "selected='selected'";
                        $month = '03';
                    } ?>>
                        March
                    </option>
                    <option value="04" <?php if (isset($_POST['month']) && $_POST['month'] === '04') {
                        $flag_expiration = true;
                        echo "selected='selected'";
                        $month = '04';
                    } ?>>
                        April
                    </option>
                    <option value="05" <?php if (isset($_POST['month']) && $_POST['month'] === '05') {
                        $flag_expiration = true;
                        echo "selected='selected'";
                        $month = '05';
                    } ?>>
                        May
                    </option>
                    <option value="06" <?php if (isset($_POST['month']) && $_POST['month'] === '06') {
                        $flag_expiration = true;
                        echo "selected='selected'";
                        $month = '06';
                    } ?>>
                        June
                    </option>
                    <option value="07" <?php if (isset($_POST['month']) && $_POST['month'] === '07') {
                        $flag_expiration = true;
                        echo "selected='selected'";
                        $month = '07';
                    } ?>>
                        July
                    </option>
                    <option value="08" <?php if (isset($_POST['month']) && $_POST['month'] === '08') {
                        $flag_expiration = true;
                        echo "selected='selected'";
                        $month = '08';
                    } ?>>
                        August
                    </option>
                    <option value="09" <?php if (isset($_POST['month']) && $_POST['month'] === '09') {
                        $flag_expiration = true;
                        echo "selected='selected'";
                        $month = '09';
                    } ?>>
                        September
                    </option>
                    <option value="10" <?php if (isset($_POST['month']) && $_POST['month'] === '10') {
                        $flag_expiration = true;
                        echo "selected='selected'";
                        $month = '10';
                    } ?>>
                        October
                    </option>
                    <option value="11" <?php if (isset($_POST['month']) && $_POST['month'] === '11') {
                        $flag_expiration = true;
                        echo "selected='selected'";
                        $month = '11';
                    } ?>>
                        November
                    </option>
                    <option value="12" <?php if (isset($_POST['month']) && $_POST['month'] === '12') {
                        $flag_expiration = true;
                        echo "selected='selected'";
                        $month = '12';
                    } ?>>
                        December
                    </option>
                </select>
                <select id="year" name="year">
                    <option value="2021" <?php if (isset($_POST['year']) && $_POST['year'] === '2021') {
                        $flag_expiration = true;
                        echo "selected='selected'";
                        $year = '2021';
                    } ?>>
                        2021
                    </option>
                    <option value="2022" <?php if (isset($_POST['year']) && $_POST['year'] === '2022') {
                        $flag_expiration = true;
                        echo "selected='selected'";
                        $year = '2022';
                    } ?>>
                        2022
                    </option>
                    <option value="2023" <?php if (isset($_POST['year']) && $_POST['year'] === '2023') {
                        $flag_expiration = true;
                        echo "selected='selected'";
                        $year = '2023';
                    } ?>>
                        2023
                    </option>
                    <option value="2024" <?php if (isset($_POST['year']) && $_POST['year'] === '2024') {
                        $flag_expiration = true;
                        echo "selected='selected'";
                        $year = '2024';
                    } ?>>
                        2024
                    </option>
                    <option value="2025" <?php if (isset($_POST['year']) && $_POST['year'] === '2025') {
                        $flag_expiration = true;
                        echo "selected='selected'";
                        $year = '2025';
                    } ?>>
                        2025
                    </option>
                    <option value="2026" <?php if (isset($_POST['year']) && $_POST['year'] === '2026') {
                        $flag_expiration = true;
                        echo "selected='selected'";
                        $year = '2026';
                    } ?>>
                        2026
                    </option>
                </select>
            </div>

            <?php
            if (check_expiration($month, $year)) {
                $final_expiration_month = $month;
                $final_expiration_year = $year;
            } else if ($flag_expiration) {
                echo "<span>Error: the expiration date is invalid. It cannot be in the past.</span>";
            }

            function check_expiration($m, $y)
            {
                date_default_timezone_set('America/New_York');
                $valid_expiration = false;
                // Creates a date using the month and year in the args
                $date = $y . '-' . $m;
                $today = date('Y-m');

                // If the date is greater or equal to today
                if ($date >= $today) {
                    $valid_expiration = true;
                }

                return $valid_expiration;
            }

            ?>

            <div class="checkout-button-container">
                <input type="submit" value="COMPLETE ORDER">
            </div>
        </form>
    </div>
</main>

<?php
if (isset($final_name, $final_phone, $final_date, $final_card_name, $final_card_number, $final_cvv, $final_expiration_month, $final_expiration_year)) {

    $final_name = addslashes($final_name);
    $final_phone = addslashes($final_phone);
    $final_date = addslashes($final_date);
    $final_card_name = addslashes($final_card_name);
    $final_cvv = addslashes($final_cvv);
    $final_expiration_month = addslashes($final_expiration_month);
    $final_expiration_year = addslashes($final_expiration_year);

    // Inserts the appropriate input values into the customer table
    $insert_customer = "
    INSERT INTO customer
    (name, phone_number)
    VALUES
    ('" . $final_name . "', '" . $final_phone . "')
    ;
    ";

    $result_insert_customer = mysqli_query($connect, $insert_customer);

    // Gets the appropriate customer_id
    // Note: instead of just getting the most recent customer_id, I chose to add more filtering parameters to make sure it's the correct row
    $query_get_customer_id = "SELECT customer_id FROM customer WHERE name = '" . $final_name . "' AND phone_number = '" . $final_phone . "' ORDER BY customer_id DESC LIMIT 1;";
    $result_get_customer_id = mysqli_query($connect, $query_get_customer_id) or die("Error: cannot show table");
    $customer_id = mysqli_fetch_row($result_get_customer_id)[0];

    // Inserts the appropriate input values into the cupcake_order table
    $insert_order = "
    INSERT INTO cupcake_order
    (card_name, card_number, card_cvv, card_expiration_month, card_expiration_year, pickup_date, status, fk_customer_id)
    VALUES
    ('" . $final_card_name . "', '" . $final_card_number . "', '" . $final_cvv . "', '" . $final_expiration_month . "', '" . $final_expiration_year . "', '" . $final_date . "', 'false', " . $customer_id . ")
    ;
    ";

    $result_insert_order = mysqli_query($connect, $insert_order);

    // Gets the appropriate order_id
    // Note: instead of just getting the most recent order_id, I chose to add more filtering parameters to make sure it's the correct row
    $query_get_order_id = "SELECT cupcake_order_id FROM cupcake_order WHERE card_name = '" . $final_card_name . "' AND card_number = '" . $final_card_number . "' AND pickup_date = '" . $final_date . "' ORDER BY cupcake_order_id DESC LIMIT 1;";
    $result_get_order_id = mysqli_query($connect, $query_get_order_id) or die("Error: cannot show table");
    $order_id = mysqli_fetch_row($result_get_order_id)[0];
    $_SESSION['order_id'] = $order_id;

    if ($berry_counter > 0) {
        query_order_item($berry_counter, $order_id, 1);
    }

    if ($carrot_counter > 0) {
        query_order_item($carrot_counter, $order_id, 2);
    }

    if ($cinnamon_counter > 0) {
        query_order_item($cinnamon_counter, $order_id, 3);
    }

    if ($mint_counter > 0) {
        query_order_item($mint_counter, $order_id, 4);
    }

    if ($rainbow_counter > 0) {
        query_order_item($rainbow_counter, $order_id, 5);
    }

    if ($red_velvet_counter > 0) {
        query_order_item($red_velvet_counter, $order_id, 6);
    }

    mysqli_close($connect);

    echo '
    <script>
    // This displays the success h2 and redirects to clear_session.php after 3 seconds
    document.getElementById("success").style.display = "block";
    let timeout_id = setTimeout(() => {
            window.location.href = "https://valeriehosler.com/Cupcakery/clear_session.php";
            window.clearTimeout(timeout_id);
    }, 3000);
    </script>
    ';
}

function query_order_item($counter, $id, $fk_id)
{
    include 'db_connection.php';

    // This inserts the appropriate values into the cupcake_order_item table
    $insert_cupcake = "
        INSERT INTO cupcake_order_item
        (quantity_purchased, fk_cupcake_order_id, fk_item_id)
        VALUES
        (" . $counter . ", " . $id . ", $fk_id)
        ; 
        ";

    mysqli_query($connect, $insert_cupcake);
    mysqli_close($connect);
}

?>

<?php
include 'footer.php'
?>
