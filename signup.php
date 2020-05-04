<?php
require_once ("functions.php");
$username = '';
$password = '';
$password_confirm = '';
$fullname = '';
$email = '';
$birthdate = '';
if(isset($_POST['username']) &&isset($_POST['fullname'])&& isset($_POST['password']) && isset($_POST['password_confirm'])&&isset($_POST['e-mail'])){
    $username = sanitize($_POST['username']);
    $fullname = sanitize($_POST['fullname']);
    $password = sanitize($_POST['password']);
    $password_confirm = sanitize($_POST['password_confirm']);
    $email = sanitize($_POST['e-mail']);
    if (!is_pseudo_available($username))
        $errors[] = "Username already exists";
    if(trim($username) == '')
        $errors[] = "Username is required";
    if(strlen(trim($username)) < 3)
        $errors[] = "Username must be longer than 3 caracters";
    if(is_email_available($email))
        $errors[] = "Email already in our database. Please contact your administrator";
    if($password != $password_confirm)
        $errors[] = "Passwords must be identical";
    if(!isset($error)){
        add_user($username, $password, $fullname, $email, $birthdate);
        redirect("login.php");
    }

}


?>
<html>
    <head>
        <title>Sign up</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
         <div class="title">Sign up</div>
        <div class="main">
            <form action="signup.php" method="post">
                <table>
                    <tr>
                        <td>User Name (*):</td>
                        <td><input id="username" name="username" type="text" value="<?php echo $username; ?>"></td>
                    </tr>
                    <tr>
                        <td>Password (*):</td>
                        <td><input id="password" name="password" type="password" value="<?php echo $password; ?>"></td>
                    </tr>
                    <tr>
                        <td>Confirm Password (*):</td>
                        <td><input id="password_confirm" name="password_confirm" type="password" value="<?php echo $password_confirm; ?>"></td>
                    </tr>
                    <tr>
                        <td>Full Name (*):</td>
                        <td><input id="username" name="fullname" type="fullname" value="<?php echo $fullname; ?>"></td>
                    </tr>
                    <tr>
                        <td>Birth Date:</td>
                        <td><input id="birthdate" name="birthdate" type="date" value="<?php echo $birthdate; ?>"></td>
                    </tr>
                    <tr>
                        <td>Email (*):</td>
                        <td><input id="email" name="email" type="email" value="<?php echo $email; ?>"></td>
                    </tr>
                    <tr>
                        <td>Role :</td>
                        <td><input name='role' readonly value='member'></td>"
                    </tr>
                    <tr>
                    <td>
                        <button type="submit">Sign up</button>
                        <a href="index.php"><button type="button">Cancel</button></a>
                    </td>
                </tr>
                </table>
            </form>
            <?php 
                if(isset($errors)){
                    echo "<div class='errors'>
                          <br><br><p>Veuillez corriger les erreurs suivantes :</p>
                          <ul>";
                    foreach($errors as $error){
                        echo "<li>".$error."</li>";
                    }
                    echo '</ul></div>';
                } 
            ?>
        </div>
    </body>
</html>
