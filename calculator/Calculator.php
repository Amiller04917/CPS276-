<?php
    class Calculator {
        function calc(string $op = null, int $numOne = null, int $numTwo = null){
            if(is_null($op) || is_null($numOne) || is_null($numTwo)){ // Sanity check
                return "You must enter a string and two numbers <br>";
            }

            switch($op){
                case "+":
                    return "The sum of the numbers is " . ($numOne + $numTwo) . "<br>";
                case "-":
                    return "The difference of the numbers is " . ($numOne - $numTwo) . "<br>";
                case "*":
                    return "The product of the numbers is " . ($numOne * $numTwo) . "<br>";
                case "/":
                    if($numOne == 0 || $numTwo == 0){ // Sanity check
                        return "Cannot divide by zero" . "<br>";
                    }
                    return "The division of the numbers is " . $numOne > $numTwo ? ($numOne / $numTwo) : ($numTwo / $numOne) . "<br>";
                default: // Default to catch any other input
                    return "invalid operator <br>";
            }
        }
    }
?>