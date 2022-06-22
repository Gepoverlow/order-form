<?php

// This file is your starting point (= since it's the index)
// It will contain most of the logic, to prevent making a messy mix in the html

// This line makes PHP behave in a more strict way
declare(strict_types=1);

// We are going to use session variables so we need to enable sessions

// echo '<script>window.alert("hello")</script>';

$show_consent;

if(!isset($_COOKIE['cookies'])){
	// First time visitor
    $show_consent = true;
    $cookies = ['consent'=>0,'analytic' => 0, 'ads' => 0];
	$cookies_string = json_encode($cookies);
    setcookie("cookies", "cookies consent", time() + (86400 * 30), "/"); // 86400 = 1 day
}else{
    // Continue with the website with consent
    $show_consent = false;
    
}

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
$errorMessages = validate();
handleForm($products, $errorMessages);
whatIsHappening();
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

$totalValue = 0;

function validate() {
// TODO: This function will send a list of invalid fields back

$errorMessages = [];
$pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";

//Email validation check for empty field & valid email
checkIfEmpty("email", $errorMessages, "Email is Empty");
validateEmail($pattern, "email", $errorMessages, "Email is not valid");

//Zipcode validation for empty & valid number
checkIfEmpty("zipcode", $errorMessages, "Zipcode is empty");
checkIfNumber("zipcode", $errorMessages, "Zipcode has to be a number");

//Street validation for empty
checkIfEmpty("street", $errorMessages, "Street is empty");

//City validation for empty
checkIfEmpty("city", $errorMessages, "City is empty");

//Streetnumber validation for empty
checkIfEmpty("streetnumber", $errorMessages, "Streetnumber is empty");

//Check that at least an item has been checked
checkIfEmpty("products", $errorMessages, "Please select at least 1 item");

return $errorMessages;
}

function checkIfEmpty($sgName, &$errorsArray, $message){
    if(empty($_POST[$sgName])){
        array_push($errorsArray, $message);
    }
}

function validateEmail($pattern, $sgName, &$errorsArray, $message){
    if (!preg_match ($pattern, $_POST[$sgName])){
        array_push($errorsArray, $message);
    }
}

function checkIfNumber($sgName, &$errorsArray, $message){
    if (!preg_match ("/^[0-9]*$/", $_POST[$sgName]) ){
        array_push($errorsArray, $message);
    }
}

function displayConfirmationWindow($street, $streetNumber, $city, $zipCode, $checkedProducts ){
    $productString = implode(", ", $checkedProducts);
    echo '<div class="alert alert-success" role="alert">';
    echo "Thank you for your purchase! We will be sending: $productString to: $street, $streetNumber in $city with zipCode $zipCode";
    echo "</div>";
}

function handleForm($productsArray, $errorMessages) {
    // TODO: form related tasks (step 1) 

    // Validation (step 2)
    // $invalidFields = validate();
    if (!empty($errorMessages)) {
        // TODO: handle errors
        // var_dump($errorMessages);
    } else {
        // TODO: handle successful submission
        $email = $_POST["email"];
        $street = $_POST["street"];
        $streetNumber = $_POST["streetnumber"];
        $city = $_POST["city"];
        $zipCode = $_POST["zipcode"];
        $checkedProducts = [];
        $checkedProductsNames = [];

        foreach($_POST['products'] as $value){
            array_push($checkedProductsNames, $productsArray[$value]["name"]); 
            array_push($checkedProducts, $productsArray[$value]); 
            }

        displayConfirmationWindow($street, $streetNumber, $city, $zipCode, $checkedProductsNames); 
            }
}

// // TODO: replace this if by an actual check
// $formSubmitted = false;
// if ($formSubmitted) {
//     handleForm();
// }

require 'form-view.php';
