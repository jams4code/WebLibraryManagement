<?php
    require 'functions.php';
    check_login();
    if($role == "member"){
        redirect("home.php");
    }
    $user = $_GET['username'];
    $userU = getUser($user);
    $username = $userU['username'];
    $fullname = $userU['fullname'];
    $email = $userU['email'];
    $birthdate=$userU['birthdate'];
    $roleUserU = $userU['role'];
    if(isset($_POST['username'])&&isset($_POST['fullname'])&&isset($_POST['email'])&&isset($_POST['role'])){
        $username = sanitize($_POST['username']);
        $fullname = sanitize($_POST['fullname']);
        $email = sanitize($_POST['email']);
        $roleUser = sanitize($_POST['role']);
        if(pseudo_already_exists($username) && ($username != $u))
            $errors[] = "Ce pseudo existe déja";    
        if(!is_email_available($email))
            $errors[] = "Email already used please contact your administrator to have a new password";
        if(trim($username) == '')
                $errors[] = "Username is required";
        if(!isset($error)){
            updateUser($username,$fullname,$email,$_POST['date'],$roleUser,$u);
            redirect("userlist.php");
        }
    }
?>
<html>
    <head>
        <title>Edit user</title>
        <link rel="stylesheet" media="screen" type="text/css"href="styles.css"/>
    </head>
    <body>
        <?php include 'menu.html'?>
        <h1>Update User [<?php echo $username; ?>]</h1>
        <form action="<?php echo"edit.php?username=".$user?>" method="post">
            <table>
                <tr>
                    <td>Pseudo :</td>
                    <td>
                        <input name ="username"type="text" value ="<?php echo $username;?>" required>
                    </td>
                </tr>
                <tr>
                    <td>Nom :</td>
                    <td>
                        <input name="fullname"type="text" value ="<?php echo $fullname ?>" required>
                    </td>
                </tr>
                <tr><td>Email :</td>
                    <td>
                        <input name ="email" type="email" value ="<?php echo $email?>" required>
                    </td>
                </tr>
                <tr>
                    <td>Date de naissance:</td>
                    <td>
                        <input name ="date"type="date" value ="<?php echo $birthdate;?>">
                    </td>
                </tr>
                <tr>
                    
                    <td>Role :</td>
                    <?php 
                    if($role == "admin"){
                        echo '
                            <td>
                            <select name="role">
                                <option selected value="'.$roleUser.'"></option>
                                <option value="admin">admin</option>
                                <option value="member">member</option>
                                <option value ="manager">manager</option>
                            </select>
                            </td>';
                    }
                        else {
                            echo "<td>".$roleUser."</td>";
                        }
                    ?>
                    
                </tr>
                <tr>
                    <td>
                        <button type="submit">Save modification</button>
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
    </body>
</html>

