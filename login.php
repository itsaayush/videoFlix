<?php
require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/Account.php");
    
    $account = new Account($conn); 
    
    if(isset($_POST["submitButton"])){
      
        $userName = FormSanitizer::sanitizeFormUserName($_POST["userName"]);
        $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);

        $success = $account->login($userName,$password);
     
         if($success) {
   
             $_SESSION["userLoggedIn"] = $userName;
             header("Location: index.php");
         }
    } 
    function getInputValues($name) {
        if(isset($_POST[$name])){
            echo $_POST[$name];
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Welcome to VideoFlix</title>
        <link rel="stylesheet" type="text/css" href="assets/style/style.css">
    </head>
    <body>
        <div class="signInContainer">
            <div class="column">
                <div class="header">
                    <img src="assets/images/logo.png" title="logo" alt="Site Logo">
                    <h3>Sign In</h3>
                    <span>to continue to videoflix</span>
                </div>
                    <form method="POST">

                    <?php echo $account->getError(Constants::$loginFailed); ?>
                        <input type="text" placeholder="UserName" name="userName" value="<?php getInputValues("username");?>" required>
                        <input type="password" placeholder="Password" name="password" required>
                        <input type="submit" value="SUBMIT" name="submitButton">
                    </form>

                    <a href="register.php" class="signInMessage">Need an account ? Sign up here!</a>
            </div>
        </div>
    </body>
</html>