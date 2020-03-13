<?php
    //this code helps siam to automatically include classes
    //containing php files while we are instantiating the class
    spl_autoload_register('autoLoaderFunc');

    function autoLoaderFunc($className)
    {
        $dir = 'classes/';
        $extension = '.php';
        $path = $dir.$className.$extension;

        //$url=  $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];  //this method checks the current page url
        //if(strpos($url, 'index')) //to check if we are in index page or not
        //{
        //    echo "true";
        //} //this will be handy for including sibling directories.

        include_once $path;
    }
?>