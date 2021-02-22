<?php
 
require_once("includes/header.php");
 
if(!User::isLoggedIn()) {
    header("Location: signIn.php");
  }
 
$query = $con->prepare("SELECT history FROM users WHERE username=:username");
 
$query->bindParam(":username", $usernameLoggedIn);
 
$query->execute();
 
$historyList = array();
 
while($row = $query->fetch(PDO::FETCH_ASSOC)) {
 
	array_push($historyList, $row["history"]);
}
 
$list_string = implode(",", $historyList);
 
$list_array = explode(",", $list_string);
 
$list_array = array_reverse($list_array);
 
$list_array = array_unique($list_array);
 
 
$video_list = array();
$videoString = "";
 
foreach($list_array as $list_item) {
 
	$video = new Video($con, $list_item, $userLoggedInObj);
	$videoId = $video->getId();
	if($videoId == '') continue; 
	$videoString = ",". $videoId . $videoString;
	array_push($video_list, $video);
}
$videoString = substr($videoString, 1);
//echo $videoString;
//$video_list = array_slice($video_list, 0, -1);

$query = $con->prepare("UPDATE users SET history=:videoString WHERE username=:username"); 
$query->bindParam(":username", $usernameLoggedIn);
$query->bindParam(":videoString", $videoString);
$query->execute();

?>
<div class='largeVideoGridContainer'>
<?php
if(!empty($video_list)){
 
	$videoGrid = new VideoGrid($con, $userLoggedInObj, null, true);
 
	echo $videoGrid->createLarge($video_list, "Watch History", false);
}
 
else {
 
	echo "You have no items in your history";
}?>
</div>
<?php
require_once("includes/footer.php"); ?>