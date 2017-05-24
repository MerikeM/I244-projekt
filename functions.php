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
                $data = mysqli_fetch_assoc($result);
                $_SESSION['user'] = $data['id'];
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

function add_poem(){
    global $connection;
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if (empty($_POST['poem'])){
            $error = "Palun sisestage luuletus";
        } else {
            $title = mysqli_real_escape_string($connection, $_POST['title']);
            $poem = mysqli_real_escape_string($connection, $_POST['poem']);
            $user = mysqli_real_escape_string($connection, $_SESSION['user']);
            $sql = "INSERT INTO mmeizner_luuletused (title, poem, user) VALUES ('$title', '$poem', '$user')";
            mysqli_query($connection, $sql) or die ($sql . " - " . mysqli_error($connection));
            header("Location: ?page=poems");
        }
    }
    
    include_once('views/add.html');
}

function show_poems(){
    global $connection;
    $sql = "SELECT mmeizner_luuletused.title,
        mmeizner_luuletused.poem, 
        mmeizner_luuletused.time,
        mmeizner_kasutajad.user,
        mmeizner_kasutajad.age,
        mmeizner_kasutajad.gender
        FROM mmeizner_luuletused, mmeizner_kasutajad
        WHERE mmeizner_luuletused.user = mmeizner_kasutajad.id
        ORDER BY mmeizner_luuletused.time DESC";
    $poems = mysqli_query($connection, $sql) or die ($sql . " - " . mysqli_error($connection));
    
            
    include_once('views/poems.html');
}



?>