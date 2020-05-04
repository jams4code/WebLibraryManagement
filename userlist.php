<?php

    require_once "functions.php";
    $pdo = connect();
    check_login();
    $users = get_all_users();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Users</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="title">Users</div>
        <?php include('menu.html'); ?>
        <div class="main">
            <h1>List of users registered in the system</h1>
            <table>
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Full Name</th>
                        <th>E-mail</th>
                        <th>Birth Date</td>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach($users as $user){
                            $username = $user['username'];
                            $fullname = $user['fullname'];
                            $email = $user['email'];
                            $birth = $user['birthdate'];
                            $role = $user['role'];
                            echo "<tr>
                                <td>$username</td>
                                <td>$fullName</td>
                                <td>$email</td>
                                <td>$birth</td>
                                <td>$role</td>
                                <td><a href=update_user.php?username=$username><button id='update'>Edit</button></a></td>
                                <td><a href=delete.php?username=$username><button id='delete'>delete</button></a></td>
                            </tr>";
                        }
                    ?>
                    </tr>
                </tbody>
            </table>
            <a href="useradd.php"><button type='button'>Add a new User</button></a>
        </div>
    </body>
</html>