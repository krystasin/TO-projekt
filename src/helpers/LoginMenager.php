<?php

Class LoginMenager
{


    public static function isLoggedIn() : bool   {
        return isset($_SESSION['user']);
    }


    public static function redirectIfNotLoggedIn(){
        if(!isset($_SESSION['user']))
        {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/login");
            exit();
        }
    }
    public static function redirectIfLoggedIn(){
        if(isset($_SESSION['user']))
        {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/stronaGlowna");
            exit();
        }
    }

}