<?php // This file is mostly containing things for your view / html ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <title>Your fancy store</title>
</head>
<body>
<?php if($show_consent == True){ ?>
	<input type="checkbox" id="close_cookie"></input>
	<div id="cookie_consent_popup">
		<h1>Cookies</h1>
		<label for="close_cookie" id="close_cookie_box">X</label>
		<p>This websites uses cookies. By clicking 'OK', 'X' or continuing using our site, you consent to the use of cookies unless you disabled them.<p>
		<label for="close_cookie" id="ok_cookie_box">OK</label>
	</div>
<?php }?>
<div class="container">
    <h1>Place your order</h1>
    <?php // Navigation for when you need it ?>
    <?php /*
    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="?food=1">Order food</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?food=0">Order drinks</a>
            </li>
        </ul>
    </nav>
    */ ?>
    
    <form action="index.php" method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES); ?>"/>
                <?php
                if (isset($_POST["submit"])){
                    echo (in_array("Email is Empty",$errorMessages)) ? '<div class="alert alert-danger" role="alert">Email field can not be empty</div>' : '';
                    if(!in_array("Email is Empty", $errorMessages)){
                        echo (in_array("Email is not valid",$errorMessages)) ? '<div class="alert alert-danger" role="alert">Email entered is not valid</div>' : '<div class="alert alert-success" role="alert">Email field OK</div>';
                    }
                    
                 }
                //  echo (in_array("Email is Empty",$errorMessages)) ? "<div class=alert alert-danger role=alert>Email is Empty</div>" : "" 
                 ?>
            </div>
            <div></div>
        </div>

        <fieldset>
            <legend>Address</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street:</label>
                    <input type="text" name="street" id="street" class="form-control" value="<?php echo htmlspecialchars($_POST['street'] ?? '', ENT_QUOTES); ?>">
                    <?php if(isset($_POST["street"])){
                        echo (in_array("Street is empty",$errorMessages)) ? '<div class="alert alert-danger" role="alert">Street field can not be empty</div>' : '<div class="alert alert-success" role="alert">Street field OK</div>';
                    } ?>
                </div>
                <div class="form-group col-md-6">
                    <label for="streetnumber">Street number:</label>
                    <input type="text" id="streetnumber" name="streetnumber" class="form-control" value="<?php echo htmlspecialchars($_POST['streetnumber'] ?? '', ENT_QUOTES); ?>">
                    <?php if(isset($_POST["submit"])){
                        echo (in_array("Streetnumber is empty",$errorMessages)) ? '<div class="alert alert-danger" role="alert">Street No. field can not be empty</div>' : '<div class="alert alert-success" role="alert">Street No. field OK</div>';
                    } ?>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" class="form-control" value="<?php echo htmlspecialchars($_POST['city'] ?? '', ENT_QUOTES); ?>">
                    <?php if(isset($_POST["submit"])){
                        echo (in_array("City is empty",$errorMessages)) ? '<div class="alert alert-danger" role="alert">City field can not be empty</div>' : '<div class="alert alert-success" role="alert">City field OK</div>';
                    } ?>
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode</label>
                    <input type="text" id="zipcode" name="zipcode" class="form-control" value="<?php echo htmlspecialchars($_POST['zipcode'] ?? '', ENT_QUOTES); ?>">
                    <?php
                if (isset($_POST["submit"])){
                    echo (in_array("Zipcode is empty",$errorMessages)) ? '<div class="alert alert-danger" role="alert">Zipcode field can not be empty</div>' : "";
                    if(!in_array("Zipcode is empty", $errorMessages)){
                        echo (in_array("Zipcode has to be a number",$errorMessages)) ? '<div class="alert alert-danger" role="alert">Zipcode has to be a number</div>' : '<div class="alert alert-success" role="alert">Zipcode field OK</div>';
                    }
                    
                 }
                //  echo (in_array("Email is Empty",$errorMessages)) ? "<div class=alert alert-danger role=alert>Email is Empty</div>" : "" 
                 ?>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>
            <?php foreach ($products as $i => $product): ?>
                <label>
					<?php // <?= is equal to <?php echo ?>
                    <input type="checkbox" value=<?php echo $i ?> name="products[<?php echo $i ?>]" <?php if(isset($_POST["submit"])){ if(isset($_POST["products"])) {if(in_array($i, $_POST["products"])) { echo "checked='checked'"; } } } ?> /> <?php echo $product['name'] ?> - 
                    &euro; <?= number_format($product['price'], 2) ?></label><br />
            <?php endforeach; ?>
            <?php if(isset($_POST["submit"])){
                        echo (in_array("Please select at least 1 item",$errorMessages)) ? '<div class="alert alert-danger" role="alert">Please select at least 1 item</div>' : '<div class="alert alert-success" role="alert">successfully selected products</div>';
                    } ?>
        </fieldset>

        <button type="submit" name="submit" class="btn btn-primary">Order!</button>
    </form>

    <footer>You already ordered <strong>&euro; <?php echo $totalValue ?></strong> in our products.</footer>
</div>

<style>
    footer {
        text-align: center;
    }
    #close_cookie{display:none;}
	#close_cookie:checked + #cookie_consent_popup{display:none;}	
#cookie_consent_popup{
	position:fixed;
	bottom:30px;left:30px;
	width:400px;
	height:180px;
	background-color:#fbb63e;
	padding:20px;
	 z-index:2;
}
	#cookie_consent_popup h1{
		font-size:1.2em;
	}
		#cookie_consent_popup h1:before{
			content:"";
			padding:0;
		}
	#cookie_consent_popup p{
		font-size:0.7em;
	}
	#cookie_consent_popup #close_cookie_box{
		position:absolute;
		top:20px;right:20px;
		cursor:pointer;
		font-size:1.3em;
	}
	#cookie_consent_popup #ok_cookie_box{
		position:absolute;
		bottom:20px;right:20px;
		cursor:pointer;
		font-size:1.6em;
		padding:10px 20px;
		font-weight:700;
		color:white;
	}
</style>
</body>
</html>
