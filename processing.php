<?php 
require_once("includes/header.php");
require_once("includes/classes/VideoUploadData.php");
require_once("includes/classes/VideoProcessor.php");

if(!isset($_POST['uploadButton'])) {
		echo "No file Sent To Page !!";
		exit();
}


$videoUploadData = new VideoUploadData(
								$_FILES['fileInput'], 
								$_POST['titleInput'], 
								$_POST['descriptionInput'],
								$_POST['privacyInput'],
								$_POST['categoryInput'],
								$userLoggedInObj->getUsername()
	);

$videoProcessor = new VideoProcessor($con);
$wasSuccessful = $videoProcessor->upload($videoUploadData);

if($wasSuccessful[0]) {
	$videoTitle = $wasSuccessful[1];
	$videoHash = $wasSuccessful[2];
	$videofilePath = $wasSuccessful[3];
	$videoId = $wasSuccessful[4];
	$uploaderEthAddress = $userLoggedInObj->getEthAddress();
	echo "<br><h3>Upload successful... Please verify your details</h3><br>Uploaded video title: ".$videoTitle;
	//echo "<br>Uploaded video hash :".$videoHash;
	//echo "<br>Uploaded video path :".$videofilePath;
	//echo "<br>Uploaded video ID :".$videoId;
	echo "<br>Uploader's ETH Address: ".$uploaderEthAddress;
	echo "<br>
	<form method='POST' action='processing2.php' id='MetaMaskConfirmationForm'>
	<button class='btn btn-primary' name='uploadButton2' onclick='uploadToBlockchain();return false;'>Finalize Upload!</button>
	<input type='text' name='finalFilePath' value='$videofilePath' hidden='true'>
	<input type='text' name='videoId' value='$videoId' hidden='true'>
	<input type='text' name='postCheck' hidden='true'>
	</form>";
	echo "
	<script>
	async function uploadToBlockchain() {
		if(window.currentAccount != '$uploaderEthAddress'){
			alert('There Is an inconsistency between MetaMask wallet and User Session. Please set both to the same and try again.');
			return false;
		}
		window.videossharing.methods.upload_video(
			window.web3.utils.fromAscii('$videoHash'), 
			window.web3.utils.fromAscii('$videoTitle')
			).send({ from: window.currentAccount }, function(error, result)
			{
				if(error) 
				{
				console.log('Error is '+error);
				// alert('Send an AJAX Call to delete details so far uploaded OR remove videos with transactionalStatus=0');
				alert('Error');
				return;
				}
				console.log('Hash value is : $videoHash');
				console.log('Result is '+ result);
				$('#postCheck').val('GenuineFormFill');
				$('#loadingModal').modal('show');
				$('#MetaMaskConfirmationForm').submit();
				
          		
			});
	}
	</script>";
 }


?>

<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background-color:black;">
      
      <div class="modal-body">
        Please wait. This might take a while.
        <img src="assets/images/icons/loading-spinner.gif" style="width: 45%;">
      </div>

    </div>
  </div>
</div>

<?php require_once("includes/footer.php"); ?>