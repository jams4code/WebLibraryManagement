<?php
require_once 'functions.php';
$pdo = connect();
$username = '';
$password = '';

if (isset($_POST['username']) && isset($_POST['password'])) 
{
    $pseudo = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);

    $user = get_user($username);
    if($user){
        if(check_password($password, $member['password'])){
            log_user($username);
        } else {
            $error = "Wrong password. Please try again.";
        }
    } else {
        $error = "Can't find a member with the username '$username'. Please sign up.";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Log In</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="title"><h1>Log In</h1></div>
        <div class="menu">
            <a href="index.php">index</a>
            <a href="signup.php">Sign Up</a>
        </div>
        <div class="main">
            <form action="login.php" method="post">
                <table>
                    <tr>
                        <td>Username:</td>
                        <td><input id="username" name="username" type="text" value="<?php echo $username; ?>"></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><input id="password" name="password" type="password" value="<?php echo $password; ?>"></td>
                    </tr>
                </table>
                <input type="submit" value="Log In">
            </form>
            <?php
            if (isset($error))
                echo "<div class='errors'><br><br>$error</div>";
            ?>
        </div>
    </body>
</html>
