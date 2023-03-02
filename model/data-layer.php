<?php

require_once ($_SERVER['DOCUMENT_ROOT'].'/../pdo-config.php');

class DataLayer
{
    // Database connection object
    private $_dbh;

    function __construct()
    {
        try {
            //Instantiate a PDO object
            $this->_dbh = new PDO(DB_DRIVER, USERNAME, PASSWORD);
            //echo 'Successful!';
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function saveOrder($orderObj)
    {
        //1. Define the query
        $sql = "INSERT INTO orders (food, meal, conds) VALUES
        (:food, :meal, :conds)";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters
        $food = $orderObj->getFood();
        $meal = $orderObj->getMeal();
        $conds = $orderObj->getCondiments();
        $statement->bindParam(':food', $food);
        $statement->bindParam(':meal', $meal);
        $statement->bindParam(':conds', $conds);

        //4. Execute the query
        $statement->execute();

        //5. Process the results
        $id = $this->_dbh->lastInsertId();
        return $id;
    }

    function getOrders()
    {
        //1. Define the query
        $sql = "SELECT * FROM orders";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters

        //4. Execute the query
        $statement->execute();

        //5. Process the results
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    static function getMeals()
    {
        return array("breakfast", "lunch",
            "dinner", "dessert");
    }

    static function getCondiments()
    {
        return array("ketchup", "mustard", "sriracha", "mayonnaise");
    }
}