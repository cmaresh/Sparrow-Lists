<?php session_start(); ?>
<?php
$emailErr = "";
$passwordErr = "";
$confirmErr = "";

if (isset($_POST['submit'])) {
    
    include './config.tpl.php';

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm = trim($_POST['confirm']);
    

    if (!empty($email)) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
    
        if(mysqli_stmt_execute($stmt)){
            /* store result */
            mysqli_stmt_store_result($stmt);
            
            if(mysqli_stmt_num_rows($stmt) == 1){
                $emailErr = "This username is already taken.";
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    
        mysqli_stmt_close($stmt);
    } else {
        $emailErr = "Please enter an email address.";
    }
    
    if (!empty($password)) {
        if (strlen($password) < 8) {
            $passwordErr = "Passwords must be at least 8 characters long.";
        }
    } else {
        $passwordErr = "Please enter a password";
    }

    if (!empty($confirm)) {
        if (strcmp($password, $confirm) !== 0) {
            $confirmErr = "Please make sure that passwords match";
        }
    } else {
        $confirmErr = "Please confirm password.";
    }

    if (empty($usernameErr) && empty($passwordErr) && empty($confirmErr)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "ss", $email, $hash);

        if(mysqli_stmt_execute($stmt)){
            /* store result */
            mysqli_stmt_store_result($stmt);
            $conn->close();
            $_SESSION['user'] = $email;
            header("Location: /sparrow/");
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<?php include './templates/head.tpl.php'; ?>

<body>
<?php include './templates/header.tpl.php'; ?>

<section id="login">
    <div class="container"><div class="row"><div class="col-12">
        <h2>Create</h2>
        <form method="post">
            <input name="email" type="text">
            <div id="email-err"><?php echo $emailErr; ?></div>
            <input name="password" type="password">
            <div id="email-err"><?php echo $passwordErr; ?></div>
            <input name="confirm" type="password">
            <div id="email-err"><?php echo $confirmErr; ?></div>
            <input type="submit" name="submit" value=">">
        </form>
    </div></div></div>
</section>

</body>

</html>