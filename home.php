<?php
require_once "functions.php";
check_login();
?>
<!DOCTYPE html>
<html>
    <head>
        <title> Home [<?php echo $username; ?>]</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div classe="menu"><?php include('menu.html'); ?></<div>
        <div class="title">Welcome <?php echo $username; ?> !</div>
    </body>
</html>
