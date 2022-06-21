<?php

// This file is your starting point (= since it's the index)
// It will contain most of the logic, to prevent making a messy mix in the html

// This line makes PHP behave in a more strict way
declare(strict_types=1);



// We are going to use session variables so we need to enable sessions
session_start();

$products = [
    ['name' => 'item 1', 'price' => 2.5],
    ['name' => 'item 2', 'price' => 4.5],
    ['name' => 'item 3', 'price' => 4],
    ['name' => 'item 4', 'price' => 6.25],
    ['name' => 'item 5', 'price' => 8],
    ['name' => 'item 6', 'price' => 10],
];

if(isset($_POST['submit'])){

$email = $_POST["email"];
$street = $_POST["street"];
$streetNumber = $_POST["streetnumber"];
$city = $_POST["city"];
$zipCode = $_POST["zipcode"];
$checkedProducts = [];
$checkedProductsNames = [];

 foreach($_POST['products'] as $value){
     array_push($checkedProductsNames, $products[$value]["name"]); 
     array_push($checkedProducts, $products[$value]); 
     }

displayConfirmationWindow($street, $streetNumber, $city, $zipCode, $checkedProductsNames);  

}

// Use this function when you need to need an overview of these variables
function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}

// TODO: provide some products (you may overwrite the example)




$totalValue = 0;

function validate()
{
    // TODO: This function will send a list of invalid fields back
    return [];
}

function displayConfirmationWindow($street, $streetNumber, $city, $zipCode, $checkedProducts ){
    $productString = implode(", ", $checkedProducts);
    echo "<h3>Thank you for your purchase! We will be sending: $productString to: $street, $streetNumber in $city with zipCode $zipCode</h3>";
}

function handleForm()
{
    // TODO: form related tasks (step 1)

    // Validation (step 2)
    $invalidFields = validate();
    if (!empty($invalidFields)) {
        // TODO: handle errors
    } else {
        // TODO: handle successful submission
    }
}

// TODO: replace this if by an actual check
$formSubmitted = false;
if ($formSubmitted) {
    handleForm();
}

require 'form-view.php';