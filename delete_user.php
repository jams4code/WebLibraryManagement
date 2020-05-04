<?php
    require_once 'functions.php';
    check_login();
    $username = $_GET['username'];
    if($role == "member")
        redirect("home.php");
    if($role == "manager")
        redirect("userlist.php");
    $validate ='';
    if(isset($_POST['validate'])){
        deleteUser($username);
        redirect("userlist.php");
    }
?>
<html>
    <head>
        <title>Delete</title>
        <link rel="stylesheet" media="screen" type="text/css" title="Exemple" href="styles.css">
    </head>
    <body>
        <?php include 'menu.html';?>
        <h1>Delete confirmation</h1>'
        <div class="confirm">
        <p>You're about to delete user <?php echo $username; ?></p><br>
        <p>if this is correct, please confirm</p></div>
        <form  action="" method = "post">
            <input type ="hidden" name="validate" id="validate" value="confirm">
            <button type="submit">Confirm</button>
            <a href="userlist.php"><button type="button">Cancel</button></a>      
        </form>
        
    </body>
</html>