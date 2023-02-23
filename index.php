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

    //If the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Move data from POST array to SESSION array
        /*
        $newOrder = $_SESSION['newOrder'];
        $condString = implode(", ",$_POST['conds']);
        $newOrder->setCondiments($condString);
        $_SESSION['newOrder'] = $newOrder;
        */

        $condString = implode(", ",$_POST['conds']);
        $_SESSION['newOrder']->setCondiments($condString);

        //$_SESSION['conds'] = implode(", ",$_POST['conds']);

        //Redirect to summary page
        $f3->reroute('summary');
    }

    //Add condiments to the hive
    $f3->set('condiments', DataLayer::getCondiments());

    //Instantiate a view
    $view = new Template();
    echo $view->render("views/order-form2.html");

});

//Define a summary route (328/diner/summary)
$f3->route('GET /summary', function() {

    //Write to Database

    //Instantiate a view
    $view = new Template();
    echo $view->render("views/order-summary.html");

    //Destroy session array
    session_destroy();

});

//1. Help each other get caught up
//2. Define a lunch route + page
//3. Add an image to breakfast and/or lunch


//Run Fat Free
$f3->run();
