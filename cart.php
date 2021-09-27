<?php
include 'header.php';
include 'get_counters.php';

if (!isset($cupcake_item_counter)) {
    // This variable helps give the forms individual ids
    $cupcake_form_counter = 0;
}

function display_cart_item($cupcake_name, $cupcake_counter, $img)
{
    // This sets the price of the cart item
    $price = number_format(($cupcake_counter * 3.50), 2);

    global $cupcake_form_counter;
    // This ensures that none of the forms have the same id/name
    $id = 'cupcake-item-' . $cupcake_form_counter;

    echo '
        <div class="cart-item">
            <img src="' . $img . '" alt="' . $cupcake_name . '" />
            <div class="cart-item-right-col">
                <div class="cart-item-name-price">
                    <h3>' . $cupcake_name . '(s)</h3>
                    <h3>$' . $price . '</h3>
                </div>

                <form action="cart.php" method="post">
                    <label>Quantity:</label>
                    <input type="number" value="' . $cupcake_counter . '" id="' . $id . '" name=' . $id . ' min="0">
                    <input type="submit" value="UPDATE"> 
                </form> 
    ';

    // This increments the global variable so none of the ids are the same
    $cupcake_form_counter += 1;

    if (isset($_POST[$id]) && ($_POST[$id] < 0)) {
        echo '<span>The cart cannot have negative quantities of items.</span>';
    } else if (isset($_POST[$id]) && ($_POST[$id] >= 0)) {
        global $berry_counter, $carrot_counter, $cinnamon_counter, $mint_counter, $rainbow_counter, $red_velvet_counter;

        // These if statements check to see which item is being passed in to the function, then updates the appropriate session counter variable
        if ($img === 'images/berry_cupcake.png') {
            update_session_variables('berry', $berry_counter, $id);
        } else if ($img === 'images/carrot_cupcake.png') {
            update_session_variables('carrot', $carrot_counter, $id);
        } else if ($img === 'images/cinnamon_cupcake.png') {
            update_session_variables('cinnamon', $cinnamon_counter, $id);
        } else if ($img === 'images/mint_cupcake.png') {
            update_session_variables('mint', $mint_counter, $id);
        } else if ($img === 'images/rainbow_cupcake.png') {
            update_session_variables('rainbow', $rainbow_counter, $id);
        } else if ($img === 'images/red_cupcake.png') {
            update_session_variables('red_velvet', $red_velvet_counter, $id);
        }
    }

    echo '
            </div>
        </div>
    ';
}

function display_summary_item($cupcake_name, $cupcake_counter)
{
    // This sets the price of the summary item
    $price = number_format(($cupcake_counter * 3.50), 2);

    echo '
        <div class="summary-container-item">
            <h3>' . $cupcake_counter . ' ' . $cupcake_name . '(s)</h3>
            <h3>' . $price . '</h3>
        </div>
        ';
}

function update_session_variables($cupcake_name, $counter, $form_id)
{
    // This replaces the value of the appropriate key to be an array that contains the new quantity
    $_SESSION["cart_items"][$cupcake_name] = [$_POST[$form_id]];

    // This updates the cart button UI
    $_SESSION['cart_item_num'] -= ($counter - $_POST[$form_id]);

    // This refreshes the page
    echo '<meta http-equiv="refresh" content="0">';
}

?>

<main class="main-content">
    <div class="cart-container">
        <?php

        // If there are no items in the cart
        if (($berry_counter === 0) && ($carrot_counter === 0) &&
            ($cinnamon_counter === 0) && ($mint_counter === 0) && ($rainbow_counter === 0) && ($red_velvet_counter === 0)) {
            echo '
            <h2 style="text-align: center;">The cart is empty</h2>
            ';
        } else {
            if ($berry_counter > 0) {
                display_cart_item('Berry Cupcake', $berry_counter, 'images/berry_cupcake.png');
            }

            if ($carrot_counter > 0) {
                display_cart_item('Carrot Cupcake', $carrot_counter, 'images/carrot_cupcake.png');
            }

            if ($cinnamon_counter > 0) {
                display_cart_item('Cinnamon Cupcake', $cinnamon_counter, 'images/cinnamon_cupcake.png');
            }

            if ($mint_counter > 0) {
                display_cart_item('Mint Chocolate Cupcake', $mint_counter, 'images/mint_cupcake.png');
            }

            if ($rainbow_counter > 0) {
                display_cart_item('Rainbow Cupcake', $rainbow_counter, 'images/rainbow_cupcake.png');
            }

            if ($red_velvet_counter > 0) {
                display_cart_item('Red Velvet Cupcake', $red_velvet_counter, 'images/red_cupcake.png');
            }

            echo '</div>'; // Closes the cart-container

            echo '
            <div class="summary-container">
                <h2>Summary</h2>';

            if ($berry_counter > 0) {
                display_summary_item('Berry Cupcake', $berry_counter);
            }

            if ($carrot_counter > 0) {
                display_summary_item('Carrot Cupcake', $carrot_counter);
            }

            if ($cinnamon_counter > 0) {
                display_summary_item('Cinnamon Cupcake', $cinnamon_counter);
            }

            if ($mint_counter > 0) {
                display_summary_item('Mint Chocolate Cupcake', $mint_counter);
            }

            if ($rainbow_counter > 0) {
                display_summary_item('Rainbow Cupcake', $rainbow_counter);
            }

            if ($red_velvet_counter > 0) {
                display_summary_item('Red Velvet Cupcake', $red_velvet_counter);
            }

            $total = number_format((($berry_counter + $carrot_counter + $cinnamon_counter + $mint_counter + $rainbow_counter + $red_velvet_counter) * 3.50), 2);

            echo '
            <div class="total-container-item">
                <h2>Total</h2>
                <h2>' . $total . '</h2>
            </div>
            ';

            echo '      
            <div class="checkout-button-container">
                <a href="checkout.php">
                  GO TO CHECKOUT
                </a>
            </div>
            ';

            echo '
            </div>
            '; // Closes the summary-container
        }
        ?>
</main>

<?php
include 'footer.php'
?>
