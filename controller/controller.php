<?php

// 328/diner/controller/controller.php

class Controller
{
    private $_f3; //Fat-Free object

    function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    function home()
    {
        //Instantiate a view
        $view = new Template();
        echo $view->render("views/diner-home.html");
    }

    function order1()
    {
        //var_dump($_POST);
        //["food"]=> string(5) "pizza" ["meal"]=> string(9) "breakfast" }


        //If the form has been submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $newOrder = new Order();

            //Move food from POST array to SESSION array
            $food = trim($_POST['food']);
            if (Validate::validFood($food)) {
                $newOrder->setFood($food);
            }
            else {
                $this->_f3->set('errors["food"]',
                    'Food must have at least 2 chars');
            }

            //Validate the meal
            $meal = $_POST['meal'];
            if (Validate::validMeal($meal)) {
                $newOrder->setMeal($meal);
            }
            else {
                $this->_f3->set('errors["meal"]',
                    'Meal is invalid');
            }

            //Redirect to summary page
            //if there are no errors
            if (empty($this->_f3->get('errors'))) {
                $_SESSION['newOrder'] = $newOrder;
                $this->_f3->reroute('order2');
            }
        }

        //Add meals to F3 hive
        $this->_f3->set('meals', DataLayer::getMeals());

        //Instantiate a view
        $view = new Template();
        echo $view->render('views/order-form1.html');

    }

    function order2()
    {
        //If the form has been submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Move data from POST array to SESSION array
            /*
            $newOrder = $_SESSION['newOrder'];
            $condString = implode(", ",$_POST['conds']);
            $newOrder->setCondiments($condString);
            $_SESSION['newOrder'] = $newOrder;
            */

            $condString = isset($_POST['conds']) ?
                implode(", ",$_POST['conds']) : "";
            $_SESSION['newOrder']->setCondiments($condString);

            //$_SESSION['conds'] = implode(", ",$_POST['conds']);

            //Redirect to summary page
            $this->_f3->reroute('summary');
        }

        //Add condiments to the hive
        $this->_f3->set('condiments', DataLayer::getCondiments());

        //Instantiate a view
        $view = new Template();
        echo $view->render("views/order-form2.html");
    }

    function summary()
    {
        //Write to Database

        //Instantiate a view
        $view = new Template();
        echo $view->render("views/order-summary.html");

        //Destroy session array
        session_destroy();
    }
}