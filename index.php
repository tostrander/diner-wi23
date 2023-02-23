<?php

// order1 route -> views/order-form1.html
// summary route -> views/order-summary.html

//This is my controller

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require files
require_once('vendor/autoload.php');

//Start a session AFTER requiring autoload.php
session_start();
//var_dump($_SESSION);

/*
$myOrder = new Order();
$myOrder->setFood("tacos");
echo $myOrder->getFood();
var_dump($myOrder);
*/

/*
$food1 = "tacos";
$food2 = "        ";
$food3 = "x";
echo validFood($food1) ? "valid" : "not valid";
echo validFood($food2) ? "valid" : "not valid";
echo validFood($food3) ? "valid" : "not valid";
*/
//var_dump(getMeals());
//var_dump(getCondiments());

//Instantiate F3 Base class
$f3 = Base::instance();

//Instantiate a Controller object
$con = new Controller($f3);

//Define a default route (328/diner)
$f3->route('GET /', function() {

    $GLOBALS['con']->home();
});

//Define a breakfast route (328/diner/breakfast)
$f3->route('GET /breakfast', function() {

    //Instantiate a view
    $view = new Template();
    echo $view->render("views/breakfast.html");

});

//Define an order1 route (328/diner/order1)
$f3->route('GET|POST /order1', function($f3) {

    $GLOBALS['con']->order1();
});

//Define an order2 route (328/diner/order2)
$f3->route('GET|POST /order2', function($f3) {

    $GLOBALS['con']->order2();
});

//Define a summary route (328/diner/summary)
$f3->route('GET /summary', function() {

    $GLOBALS['con']->summary();
});

//Run Fat Free
$f3->run();
