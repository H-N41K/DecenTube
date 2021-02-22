<?php 
require_once("includes/header.php");
require_once("includes/classes/VideoUploadData.php");
require_once("includes/classes/VideoProcessor.php");


if(!isset($_POST['postCheck'])) {
		echo "No file Sent To Page !!";
		exit();
}
else{
	$videoProcessor = new VideoProcessor($con);
	$wasSuccessful = $videoProcessor->uploadFileToIPFS($_POST['finalFilePath']);
	if($wasSuccessful){
		echo "Video uploaded successfully to IPFS";
		$query = $con->prepare("UPDATE videos SET transactionStatus=1 WHERE id=:videoId");
		$query->bindParam(":videoId", $_POST['videoId']);
		$success = $query->execute();
		
		$query2 = $con->prepare("UPDATE videos SET 
		uploaderEthAddress=:uploaderEthAddress, videoIndex=:videoIndexCount
		 WHERE id=:videoId");
		$query2->bindParam(":uploaderEthAddress", $uploaderEthAddress);
		$query2->bindParam(":videoIndexCount", $videoIndexCount);
		$query2->bindParam(":videoId", $_POST['videoId']);

		$videoId =$_POST['videoId'];
		$uploaderEthAddress = $userLoggedInObj->getEthAddress();
		$videoIndexCount = $userLoggedInObj->getVideoIndexCount();
		//echo "<BR> UPDATE videos SET uploaderEthAddress=$uploaderEthAddress AND videoIndex=$videoIndexCount WHERE id=$videoId";
		
		$success2 = $query2->execute();

		$userLoggedInObj->incrementVideoIndexCount();
		

		if(!$success || !$success2) {
			echo "FAILED TO SET TRANSACTION STATUS=1 OR FAILED TO UPDATE VIDEO_INDEX\n";
		} else {
			//header("Location: watch.php?id=$videoId");
		}
		
	}
	else{
		echo "<br>IPFS UPLOAD FAILED";
	}
	
}

?>


<?php require_once("includes/footer.php"); ?>