<?php

class Validate
{
    //Return true if the food has at least
    //two characters
    static function validFood($food)
    {
        /*
        if (strlen($food) <= 2) {
            return false;
        }
        else {
            return true;
        }
        */

        return strlen($food) > 2;
    }

    //Make sure user's meal is valid
    static function validMeal($meal)
    {
        /*
        if (in_array($meal, getMeals())) {
            return true;
        }
        else {
            return false;
        }
        */

        return in_array($meal, DataLayer::getMeals());
    }
}