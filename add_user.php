<?php
    require_once("functions.php");
    check_login();
    if($role == "member"){
        redirect("home.php");
    }
    $usernameOld = $username;
    $fullname = '';
    $email = '';
    $birthdate = '';
    $roleNewUser = 'member';
    if(isset($_POST['username'])&&isset($_POST['fullname'])&&isset($_POST['email'])&&isset($_POST['role'])){
      $username = sanitize($_POST['username']);
      $fullname = sanitize($_POST['fullname']);
      $email = sanitize($_POST['email']);
      $roleNewUser = sanitize($_POST['role']);
        
        if (!is_pseudo_available($username))
            $errors[] = "Username already exists";
        if(trim($username) == '')
            $errors[] = "Username is required";
        if(strlen(trim($username)) < 3)
            $errors[] = "Username must be longer than 3 caracters";
        if(is_email_available($email))
            $errors[] = "Email already in our database. Please contact your administrator";
        
        if(!isset($errors)){
            add_user($username_old,$fullname,$email,$birthdate,$roleNewUser,$username);
        }
    }
?>

<html>
    <head>
        <title>Create a new user</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div classe="menu"><?php include('menu.html'); ?></<div>
         <div class="title">Create a user</div>
        <div class="main">
            <form action="add_user.php" method="post">
                <table>
                    <tr>
                        <td>User Name (*):</td>
                        <td><input id="username" name="username" type="text" value="<?php echo $username; ?>"></td>
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
                        <?php 
                        if($role == "admin"){
                            echo '
                                <td>
                                <select name="role">
                                    <option selected value="'.$roleNewUser.'"></option>
                                    <option value="admin">admin</option>
                                    <option value="member">member</option>
                                    <option value ="manager">manager</option>
                                </select>
                                </td>';
                        }
                            else {
                                echo "<td>
                                 <input name='role' readonly value='member'>".$roleNewUser."</td>";
                            }
                        ?>
                    </tr>
                    <tr>
                    <td>
                        <button type="submit">add User</button>
                        <a href="userlist.php"><button type="button">Cancel</button></a>
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