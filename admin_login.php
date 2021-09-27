<?php
include 'admin_header.php';

// If the user is logged in, redirect them to admin_dashboard.php
if (isset($_SESSION['username'], $_SESSION['password'])) {
    header('Location: admin_dashboard.php');
}

if (isset($_POST['username'])) {
    $username = $_POST['username'];
}
if (isset($_POST['password'])) {
    $password = $_POST['password'];
}

// These flags keep track of if the input is empty because of a new page load or if a user doesn't add a value to a field
$sticky_flag_username = false;
$sticky_flag_password = false;
?>

    <main class="login">
        <form action="admin_login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username"
                   name="username" <?php if (isset($_POST['username'])) {
                $sticky_flag_username = true;
            }
            echo "value='$username'"; ?> min="4" max="20" pattern="^[a-zA-Z0-9]{4,20}$"
                   oninvalid="this.setCustomValidity('Error: the username field is in the wrong format. Valid characters are letters and numbers and it must be 4-20 characters in length.')"
                   oninput="this.setCustomValidity('')"
                   required>

            <?php
            if (preg_match('/^[a-zA-Z0-9]{4,20}$/', $username)) {
                $final_username = $username;
            } elseif (empty($_POST['username'])) {
                if ($sticky_flag_username) {
                    echo '<span>Error: the username field is empty. Valid characters are letters and numbers, and it must be 4-20 characters in length.</span>';
                }
            } else {
                echo '<span>Error: the username field is in the wrong format. Valid characters are letters and numbers, and it must be 4-20 characters in length.</span>';
            }
            ?>

            <label for="password">Password:</label>
            <input type="text" id="password"
                   name="password" <?php if (isset($_POST['password'])) {
                $sticky_flag_password = true;
            }
            echo "value='$password'"; ?> min="4" max="20" pattern="^[a-zA-Z0-9]{4,20}$"
                   oninvalid="this.setCustomValidity('Error: the password field is in the wrong format. Valid characters are letters and numbers and it must be 4-20 characters in length.')"
                   oninput="this.setCustomValidity('')" required>

            <?php
            if (preg_match('/^[a-zA-Z0-9]{4,20}$/', $password)) {
                $final_password = $password;
            } elseif (empty($_POST['password'])) {
                if ($sticky_flag_password) {
                    echo '<span>Error: the password field is empty. Valid characters are letters and numbers, and it must be 4-20 characters in length.</span>';
                }
            } else {
                echo '<span>Error: the password field is in the wrong format. Valid characters are letters and numbers, and it must be 4-20 characters in length.</span>';
            }
            ?>

            <input type="submit" id="login" class="login-button" name="login" value="LOGIN"/>

            <?php
            if (isset($final_username, $final_password)) {
                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                $connection = mysqli_connect('localhost', 'valerjp1_cupcakery', 'Cupcakery123*', 'valerjp1_cupcakery');

                $stmt = mysqli_prepare($connection, "SELECT password FROM admin WHERE username = ? AND password = ? LIMIT 1");
                mysqli_stmt_bind_param($stmt, 'ss', $final_username, $final_password);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $password_result);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_close($stmt);

                if ($final_password === $password_result) {

                    $_SESSION['username'] = $final_username;
                    $_SESSION['password'] = $final_password;

                    echo '
                <script>
                    window.location.href = "https://valeriehosler.com/Cupcakery/logging_in.php";
                </script>
                ';

                } else {
                    echo '<span style="text-align: center;">Error: username and/or password are incorrect</span>';
                }
            }
            ?>
        </form>
    </main>

<?php
include 'admin_footer.php'
?>