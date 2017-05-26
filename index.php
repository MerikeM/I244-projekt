<?php
require_once('functions.php');
session_start();
connect_db();

$page="home";
if (isset($_GET['page']) && $_GET['page']!=""){
    $page=htmlspecialchars($_GET['page']);
}
include_once('views/head.html');

switch($page){
    case('reg'):
        register();
        break;
    case('login'):
        login();
        break;
    case('logout'):
        logout();
        break;
    case('add'):
        add_poem();
        break;
    case('poems'):
        show_poems();
        break;
    default:
        home();
    break;
}

include_once('views/foot.html');
?>