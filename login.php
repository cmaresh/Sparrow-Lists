<?php session_start(); ?>
<?php
$emailErr = "";
$passwordErr = "";

if (isset($_POST['submit'])) {
    include './templates/config.tpl.php';

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);


    if (empty($email)) {
        $emailErr = "Please enter an email address.";
    }
    
    if (empty($password)) {
        $passwordErr = "Please enter a password";
    }

    $exists = false;

    if (empty($emailErr)) {

        $stmt = $conn->prepare("SELECT email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $stmt->bind_result($emailResult, $passwordResult);

            while ($stmt->fetch()) {
                $exists = true;

                if (password_verify($password, $passwordResult)) {
                    $_SESSION['user'] = $email;
                    header("Location: /sparrow/");
                } else {
                    $passwordErr = "Password is incorrect";
                }
            }

        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    if (!$exists) {
        $emailErr = "An account with this email does not exist.";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<?php include './templates/head.tpl.php'; ?>

<body>
<?php include './templates/header.tpl.php'; ?>
<div class="backdrop birds"></div>
<section id="login">
    <div class="container padded"><div class="row"><div class="col-12">
        <h2>Login</h2>
        <form method="post">
            <input name="email" type="text" placeholder="email">
            <div id="email-err"><?php echo $emailErr; ?></div>
            <input name="password" type="password" placeholder="password">
            <div id="email-err"><?php echo $passwordErr; ?></div>
            <input type="submit" name="submit" value=">">
        </form>
        <a class="to-create" href="create.php">don't have an account?</a>
    </div></div></div>
</section>

</body>

</html>