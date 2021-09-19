<?php

include 'header.php';

if (!isset($_SESSION["cart_items"])) {
    $_SESSION["cart_items"] = array(
        'berry' => [0],
        'carrot' => [0],
        'cinnamon' => [0],
        'mint' => [0],
        'rainbow' => [0],
        'red_velvet' => [0]
    );
}

function add_to_cart($quantity, $cupcake_name)
{
    if (isset($_POST[$quantity]) && $_POST[$quantity] <= 0) {
        echo '<span>Add at least 1 item to the cart</span>';
    } else if (isset($_POST[$quantity]) && ($_POST[$quantity] >= 1)) {
        // This variable is used to update the UI on the cart button
        $_SESSION['cart_item_num'] += $_POST[$quantity];
        $_SESSION["cart_items"][$cupcake_name][] = $_POST[$quantity];

        echo '<meta http-equiv="refresh" content="0">';
    }
}

?>

<main class="main-content-home">
    <div class="cupcake-row">
        <div class="cupcake-order">
            <h3>Berry Cupcake</h3>
            <img src="images/berry_cupcake.png" alt="berry cupcake"/>

            <?php
            add_to_cart('quantity-1', 'berry');
            ?>

            <form action="index.php" method="post">
                <label for="quantity-1">Quantity:</label>
                <input type="number" id="quantity-1" name="quantity-1" value="0" min="0">
                <input type="submit" value="ADD TO CART">
            </form>
        </div>

        <div class="cupcake-order">
            <h3>Carrot Cupcake</h3>
            <img src="images/carrot_cupcake.png" alt="carrot cupcake"/>

            <?php
            add_to_cart('quantity-2', 'carrot');
            ?>

            <form action="index.php" method="post">
                <label for="quantity-2">Quantity:</label>
                <input type="number" id="quantity-2" name="quantity-2" value="0" min="0">
                <input type="submit" value="ADD TO CART">
            </form>
        </div>

        <div class="cupcake-order">
            <h3>Cinnamon Cupcake</h3>
            <img src="images/cinnamon_cupcake.png" alt="cinnamon cupcake"/>

            <?php
            add_to_cart('quantity-3', 'cinnamon');
            ?>

            <form action="index.php" method="post">
                <label for="quantity-3">Quantity:</label>
                <input type="number" id="quantity-3" name="quantity-3" value="0" min="0">
                <input type="submit" value="ADD TO CART">
            </form>
        </div>

        <div class="cupcake-order">
            <h3>Mint Chocolate Cupcake</h3>
            <img src="images/mint_cupcake.png" alt="mint chocolate cupcake"/>

            <?php
            add_to_cart('quantity-4', 'mint');
            ?>

            <form action="index.php" method="post">
                <label for="quantity-4">Quantity:</label>
                <input type="number" id="quantity-4" name="quantity-4" value="0" min="0">
                <input type="submit" value="ADD TO CART">
            </form>
        </div>

        <div class="cupcake-order">
            <h3>Rainbow Cupcake</h3>
            <img src="images/rainbow_cupcake.png" alt="rainbow cupcake"/>

            <?php
            add_to_cart('quantity-5', 'rainbow');
            ?>

            <form action="index.php" method="post">
                <label for="quantity-5">Quantity:</label>
                <input type="number" id="quantity-5" name="quantity-5" value="0" min="0">
                <input type="submit" value="ADD TO CART">
            </form>
        </div>

        <div class="cupcake-order">
            <h3>Red Velvet Cupcake</h3>
            <img src="images/red_cupcake.png" alt="red velvet cupcake"/>

            <?php
            add_to_cart('quantity-6', 'red_velvet');
            ?>

            <form action="index.php" method="post">
                <label for="quantity-6">Quantity:</label>
                <input type="number" id="quantity-6" name="quantity-6" value="0" min="0">
                <input type="submit" value="ADD TO CART">
            </form>
        </div>
    </div>
</main>

<?php
include 'footer.php'
?>

