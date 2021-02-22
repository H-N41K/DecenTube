<?php 

require_once("includes/config.php");
require_once("includes/classes/ButtonProvider.php");
require_once("includes/classes/User.php");
require_once("includes/classes/Video.php");
require_once("includes/classes/VideoGrid.php");
require_once("includes/classes/VideoGridItem.php");  
require_once("includes/classes/SubscriptionsProvider.php");
require_once("includes/classes/NavigationMenuProvider.php");    

$usernameLoggedIn = User::isLoggedIn() ? $_SESSION["userLoggedIn"] : "";
$userLoggedInObj = new User($con, $usernameLoggedIn);

$userEthAddress = $userLoggedInObj->getEthAddress();
?>
<!DOCTYPE html>
<html>
<head>
    <title>DecenTube</title>
    <meta name="viewport" content="width=device-width, initial-scale=0.1">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/emojionearea.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/video-js.css">
    <link href="assets/css/Font-Titillium-Web.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/icons/favicon.ico">
    <!-- <link href="assets/css/Font-Product-Sans.css" rel="stylesheet"> -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script> 
    <script src="assets/js/commonActions.js"></script>
    <script src="assets/js/userActions.js"></script>
    <script src="assets/js/regenerator-runtime@0.13.3/runtime.js"></script>
    <script src="assets/js/web3.js@1.2.1/web3.min.js"></script>
    <script src="assets/js/blockies.js"></script>
    <?php 
    $currentFileName = basename($_SERVER['PHP_SELF']);
    if($currentFileName != 'watch.php' && $currentFileName != 'editVideo.php' && $currentFileName != 'tokenMarketplace.php') {
        require_once("includes/classes/regularBlockchainFunctions.php"); 
    }
    ?>
</head>
<body oncontextmenu='return false;'>
    
    <div id="pageContainer">

        <div id="mastHeadContainer">
            <button class="navShowHide">
                <img src="assets/images/icons/menu.png" style="height: 70%;" id="stackNavButton" class="">
                <img src="assets/images/icons/menuClose.png" style="height: 80%;" class="hideNavButton" id="closeNavButton">
            </button>

            <a class="logoContainer" href="index.php">
                <img src="assets/images/icons/DecenTubeLogo.png" title="logo" alt="Site logo">
            </a>

            <div class="searchBarContainer">
                <form action="search.php" method="GET">
                    <input type="text" class="searchBar" name="term" placeholder="Search...">
                    <button class="searchButton">
                        <img src="assets/images/icons/search.png">
                    </button>
                </form>
            </div>

            <div class="rightIcons">
                <a href="upload.php">
                    <img class="upload" src="assets/images/icons/upload.png">
                </a>
                <?php
                echo ButtonProvider::createUserProfileNavigationButton($con, $userLoggedInObj->getUsername());
                ?>
                <!-- <a href="" class="balanceDisplay"> 
                </a> -->
            </div>

        </div>

        <div id="sideNavContainer" style="display:none;">
            <?php
            $navigationProvider = new NavigationMenuProvider($con, $userLoggedInObj);
            echo $navigationProvider->create();
            ?>
        </div>

        <div id="mainSectionContainer">
        
            <div id="mainContentContainer">