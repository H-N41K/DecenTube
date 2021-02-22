<?php 
require_once("includes/config.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/FormSanitizer.php");

$account = new Account($con);

if(isset($_POST['submitButton'])) {
    
    $username = FormSanitizer::sanitizeFormUsername($_POST['username']);
    $password = FormSanitizer::sanitizeFormPassword($_POST['password']);

    $wasSuccessful = $account->login($username, $password);

    
    if($wasSuccessful == true) {
      $_SESSION["userLoggedIn"] = $username;
      header("Location: index.php");
    } 
    
  }

function getInputValue($name) {
    if(isset($_POST[$name])) {
      echo $_POST[$name];
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
    <title>DecenTube</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link href="assets/css/Font-Titillium-Web.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/icons/favicon.ico">
    <!-- <link href="assets/css/Font-Product-Sans.css" rel="stylesheet"> -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    
</head>
<body oncontextmenu='return false;'>
    <div class="signInContainer">
        <div class="column" >
                <!-- style="background-color:rgb(18, 18, 18);" -->
            <div class="header">
                <img src="assets/images/icons/DecenTubeLogo.png" title="logo" alt="Site logo">
                <h3>Sign In</h3>
                <span>to continue to DecenTube</span>
            </div>

            <div class="loginForm">
                <form action="signIn.php" method="POST">
                <?php echo $account->getError(Constants::$loginFailed);?>
                    <input type="text" class='form-control' name="username" placeholder="Username"  value="<?php getInputValue('username');?>" autocomplete="off" required="true">
                    <input type="password" class='form-control' name="password" placeholder="Password" autocomplete="off" required="true">
                    <input type="submit" name="submitButton" value="SIGN IN">
                  </form>
            </div>

            <a class="signUpMessage" href="signUp.php">Need an account? Sign up here!</a>
        </div>
    </div>
</body>

</html>