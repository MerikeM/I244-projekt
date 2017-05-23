<?php
    
function connect_db(){
	global $connection;
	$host="localhost";
	$user="test";
	$pass="t3st3r123";
	$db="test";
	$connection = mysqli_connect($host, $user, $pass, $db) or die("ei saa ühendust mootoriga- ".mysqli_error());
	mysqli_query($connection, "SET CHARACTER SET UTF8") or die("Ei saanud baasi utf-8-sse - ".mysqli_error($connection));
}

function register(){
    global $connection;
    
    if ($_SERVER['REQUEST_METHOD']=='POST'){
        if (empty($_POST['user'])){
            $errors[] = "Palun sisestage kasutajanimi";
        } else {
            $user = mysqli_real_escape_string($connection, $_POST['user']);
            $sql = "SELECT * FROM mmeizner_kasutajad WHERE user = '$user'";
            $result = mysqli_query($connection, $sql) or die ($sql . " - " . mysqli_error($connection));
            if (mysqli_num_rows($result)>0){
                $errors[] = "Valitud kasutajanimi on juba kasutusel";
            }
        }
        if (empty($_POST['pass'])){
            $errors[] = "Palun sisestage parool";
        } else {
            $pass = SHA1(mysqli_real_escape_string($connection, $_POST['pass']));
        }
        if (empty($_POST['email'])){
            $errors[] = "Palun sisestage e-mail";
        } else {
            $email = mysqli_real_escape_string($connection, $_POST['email']);
        }   
        if (!empty($_POST['age'])){
            $age = mysqli_real_escape_string($connection, $_POST['age']);
        } else {
            $age = "";
        }
        if (!empty($_POST['gender'])){
            $gender = mysqli_real_escape_string($connection, $_POST['gender']);
        } else {
            $gender = "";
        }
        if (!isset($errors)){
            $sql = "INSERT INTO mmeizner_kasutajad (user, pass, email, age, gender) VALUES ('$user', '$pass', '$email', '$age', '$gender')";
            mysqli_query($connection, $sql) or die ($sql . " - " . mysqli_error($connection));
        }
    }
    include_once('views/register.html');
}

function login(){
    global $connection;
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if (empty($_POST['user'])){
            $errors[] = "Palun sisestage kasutajanimi";
        } else if (empty($_POST['pass'])){
            $errors[] = "Palun sisestage parool";
        } else {
            $user = mysqli_real_escape_string($connection, $_POST['user']);
            $pass = mysqli_real_escape_string($connection, $_POST['pass']);
            $sql = "SELECT * FROM mmeizner_kasutajad WHERE user = '$user' AND pass = SHA1('$pass')";
            $result = mysqli_query($connection, $sql) or die($sql ." - ".mysqli_error($connection));
            if (mysqli_num_rows($result)>0){
                $_SESSION['user'] = $user;
                $data = mysqli_fetch_assoc($result);
                $role = $data['role'];
                $_SESSION['role'] = $role;
                header("Location: ?");
            } else {
                $errors[] = "Vale kasutajanimi või parool";
            }
        }
    }
    include_once('views/login.html');
}

function logout(){
    session_destroy();
    header("Location: ?");
}




?>