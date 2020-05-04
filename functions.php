<?php

session_start();


function connect(){
    $dbhost = "localhost";
    $dbname = "prwb_1819_a01";
    $dbuser = "root";
    $dbpassword = "root";

    try
    {
        $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", "$dbuser", "$dbpassword");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
    catch (Exception $exc)
    {
        abort("Error while accessing database. Please contact your administrator.");
    }
}

function sanitize($var)
{
    $var = stripslashes($var);
    $var = strip_tags($var);
    $var = htmlspecialchars($var);
    return $var;
}

function redirect($url, $statusCode = 303)
{
    header('Location: ' . $url, true, $statusCode);
    die();
}

function check_login()
{
    global $user;
    if (!isset($_SESSION['user']))
        redirect('index.php');
    else
        $user = $_SESSION['user'];
}

function my_hash($password)
{
    $prefix_salt = "vJemLnU3";
    $suffix_salt = "QUaLtRs7";
    return md5($prefix_salt.$password.$suffix_salt);        
}

function check_password($password, $hash)
{
    return $hash === my_hash($password);  
}

function abort($err)
{
    global $error;
    $error = $err;
    include 'error.php';
    die;
}

function is_pseudo_available($username) {
    $pdo = connect();
    try{
        $query = $pdo->prepare("SELECT * FROM USERS WHERE USERNAME =: USERNAME");
        $query->execute(array("username"=>$username));
        $result = $query->fetchAll();
        return count($result) === 0;
    } catch (Exception $e){
        abort("Error while accessing database. Please contact your administrator.-Query for Username");
    }
}
function is_email_available($email) {
    $pdo = connect();
    try{
        $query = $pdo->prepare("SELECT * FROM USERS WHERE EMAIL =: EMAIL");
        $query->execute(array("email"=>$email));
        $result = $query->fetchAll();
        return count($result) === 0;
    } catch (Exception $e){
        abort("Error while accessing database. Please contact your administrator.-Query for email");
    }
}
function get_user($username){
    $pdo = connect();
    try
    {
        $query = $pdo->prepare("SELECT * FROM USERS WHERE USERNAME =: USERNAME");
        $query->execute(array("username" => $username));
        return $query->fetch(); 
    }
    catch (Exception $exc)
    {
        abort("Error while accessing database. Please contact your administrator.-Query for user");
    }
}

function get_all_users(){
    $pdo = connect();
    try
    {
        $query = $pdo->prepare("SELECT pseudo FROM USERS");
        $query->execute();
        return $query->fetchAll();
    }
    catch (Exception $exc)
    {
        abort("Erreur lors de l'accès à la base de données.Query for users");
    }
}

function add_user($pseudo, $password, $fullname, $birthdate, $email, $role){
    $pdo = connect();
    try{
        $query = $pdo->prepare("INSERT INTO Users(username,password, fullname, birthdate, email, role)
                                        VALUES(:pseudo,:password, :fullname, :birthdate, :email, :role)");
        $query->execute(array("username"=>$username, "password"=>my_hash($password), "fullname"=>$fullname,
                                "birthdate"=>$birthdate, "email"=>$email, "role"=>$role));
        return true;
    } catch (Exception $ex) {
        abort("Error while accessing database. Please contact your administrator.");
        return false;
    }
}

function update_user($username,$fullname,$email,$birthdate,$role){
    $actual = get_user($username);
    if($username == NULL)
        $profile = $actual['username'];
    if($fullname == NULL)
        $fullname = $actual['fullname'];
    if($email == NULL)
        $email = $actual['email'];
    if($birthdate == NULL)
        $birthdate = $actual['birthdate'];
    if($role == NULL)
        $role = $actual['role'];
    $pdo = connect();
    try{
        $query = $pdo->prepare("UPDATE Users SET username =:username, fullname=:fullname, email=:email, "
                . "birthdate=:birthdate, role=:role WHERE pseudo=:pseudo ");
        $query->execute(array("username"=>$username,"fullname"=>$fullname,
                                "birthdate"=>$birthdate, "email"=>$email, "role"=>$role));
        return true;
    } catch (Exception $ex) {
        abort("Error while accessing database. Please contact your administrator.");
        return false;
    }
    
}

function log_user($username){
    $_SESSION["role"] = get_role($username);
    $_SESSION["user"] = $username;
    redirect("home.php");
}

?>