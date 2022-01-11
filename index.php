<?php
session_start();





require 'Routing.php';

    $path = trim($_SERVER['REQUEST_URI'], '/');
    $path = PARSE_URL($path, PHP_URL_PATH);

    Routing::get('', 'DefaultController');
    Routing::get('register', 'DefaultController');
    Routing::get('stronaGlowna', 'DefaultController');
    Routing::get('scrape', 'DefaultController');
    Routing::get('curl', 'DefaultController');


    Routing::post('login', 'SecurityController');
    Routing::post('logout', 'SecurityController');



    Routing::run($path);




