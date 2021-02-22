<?php
require_once("includes/header.php");
require_once("includes/classes/SearchResultsProvider.php");

$term = $_GET["term"];
$term = trim($term);

if(!isset($term) || $term == "" ) {
    echo "You must enter a search term";
    exit();
}



if(!isset($_GET["orderBy"]) || $_GET["orderBy"] == "views") {
    $orderBy = "views"; 
} else {
    $orderBy = "uploadDate";
}

$searchResultsProvider = new SearchResultsProvider($con, $userLoggedInObj);

$videos = $searchResultsProvider->getVideos($term, $orderBy);
$showCategory = true;
$videoGrid = new VideoGrid($con, $userLoggedInObj, null, $showCategory);
?>

<div class='largeVideoGridContainer'>
    <?php

    if(sizeof($videos) > 0) {
    echo $videoGrid->createLarge($videos, sizeof($videos) . " results found", true);    

    } else {
        echo "No results found";
    }

    ?>
</div>







<?php
require_once("includes/footer.php");
?>