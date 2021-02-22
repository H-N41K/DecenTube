<?php
require_once("includes/header.php");
require_once("includes/classes/VideoPlayer.php");
require_once("includes/classes/VideoDetailsFormProvider.php");
require_once("includes/classes/VideoUploadData.php");
require_once("includes/classes/SelectThumbnail.php");

if(!User::isLoggedIn()) {
    header("Location: signIn.php");
}

if(!isset($_GET["videoId"])) {
    echo "No video selected";
    exit();
}

$server = isset($_GET["server"]) ? $_GET["server"] : 1;
$serverUrl = $ipfsNodeArray[$server];
if ($_SERVER['SERVER_NAME'] == 'localhost' && $server == 1) {
    $serverUrl = 'http://localhost:8080/ipfs/';
  }

$video = new Video($con, $_GET["videoId"], $userLoggedInObj);


if($video->getUploadedBy() != $userLoggedInObj->getUsername()){
    echo "Error! Access Denied!. You do not own this video.";
    exit();
}

if($video->getTransactionStatus() == 0) {
    echo "ERROR! Video doesn't exist!";
    exit();
}

$uploaderEthAddress = $video->getUploaderEthAddress();
$videoIndex =  $video->getVideoIndex();

$detailsMessage = "";
if(isset($_POST["saveButton"])) {
    $videoData = new VideoUploadData(
        null,
        $_POST["titleInput"],
        $_POST["descriptionInput"],
        $_POST["privacyInput"],
        $_POST["categoryInput"],
        $userLoggedInObj->getUsername()
    );

    if($videoData->updateDetails($con, $video->getId())) {
        $detailsMessage = "<div class='alert alert-success' style='color: #ffffff;background-color: #116524;border-color: #c3e6cb;'>
                                <strong>SUCCESS!</strong> Details updated successfully!
                            </div>";
        $video = new Video($con, $_GET["videoId"], $userLoggedInObj);
    }
    else {
        $detailsMessage = "<div class='alert alert-danger' style='color: #ffffff;background-color: #d60c0c;border-color: #c3e6cb;'>
                                <strong>ERROR!</strong> Something went wrong!
                            </div>";
    }
}
?>
<script src="assets/js/editVideoActions.js"></script>
<div class='editVideoContainer column'>
    <div class='message'>
    <?php echo $detailsMessage; ?>
    </div>
    <div class='topSection'>
        <?php
        $videoPlayer = new VideoPlayer($video);
        echo $videoPlayer->create(false);


        $selectThumbnail = new SelectThumbnail($con, $video);
        echo $selectThumbnail->create();
         
        ?>
    </div>
    <div class='bottomSection'>
        Server:
    <select id='serverSelectOptions'>
            <option value='1'>Hemendra's IPFS Gateway &nbsp;🌎</option>
            <option value='2'>Shubham's IPFS Gateway &nbsp;🌎</option>
            <option value='3'>IPFS.io Public Gateway &nbsp;🌎</option>
        </select>
        <script type='text/javascript'>
            $(function () {
                $('#serverSelectOptions').change(function () {
                    getParams = getUrlVars();
                    var id = getParams['videoId'];
                    var server = $(this).val();
                    window.location.href = window.location.origin + window.location.pathname + '?videoId=' + id + '&server=' + server;
                });
            });
        </script>
        <br><br>
        Update Video Details
        <br><br>
    <?php
        $formProvider = new VideoDetailsFormProvider($con);
        echo $formProvider->createEditDetailsForm($video);
    ?>
    </div>
</div>

<script>
    function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}     
      
      window.addEventListener('load', async () => {
          loadWeb3();
          loadBlockchainData();   
      });
    
      async function loadWeb3() {
        // Modern dapp browsers...
        if (window.ethereum) {
            window.web3 = new Web3(ethereum);
            try {
                // Request account access if needed
                console.log("window.ethereum");
                ethereum.enable();
                ethereum.autoRefreshOnNetworkChange = false;
    
                ethereum.on('accountsChanged', function () {
                //location.reload();
                });
    
                ethereum.on('networkChanged', function () {
                //location.reload();
                });
            } catch (error) {
                console.log(error); // User denied account access...
            }
        }
        // Legacy dapp browsers...
        else if (window.web3) {
            window.web3 = new Web3(web3.currentProvider);
            console.log("window.currentProvider");
            // Acccounts always exposed
        }
        // Non-dapp browsers...
        else {
            var provider = new Web3.providers.HttpProvider('https://ropsten.infura.io/v3/ee7f14f8e4ef43dab2769edfcda8445f')
          window.web3 = new Web3(provider)
            alert('Non-Ethereum browser detected. You should consider trying MetaMask!');
            console.log('Non-Ethereum browser detected. You should consider trying MetaMask!');
        }
        console.log("version");
        var version = web3.version;
        console.log(version);
        // var currentAccount = await web3.eth.getAccounts();
        // console.log(currentAccount);
      }
    
      async function loadBlockchainData() {
      //Load account
      window.currentAccount = await web3.eth.getAccounts();
      window.currentAccount = window.currentAccount[0];
      
    //   $.getJSON( "assets/contracts/VideosSharing.json", function( json ) {
    //     console.log( "JSON Data received, name is " + json.contractName);
    //     window.VideosSharingContract = json;
    // });
    window.VideosSharingContract = <?php require_once("includes/VideosSharingJSON.php");?>;
    console.log( "JSON Contract Data received");
      window.networkId = await web3.eth.net.getId()
        window.networkData = window.VideosSharingContract.networks[networkId];
        if (window.networkData) {
          window.videossharing = new web3.eth.Contract(window.VideosSharingContract.abi, window.networkData.address);
          await loadVideo();
          //await loadVideoPopularity();
          //await loadVideoTitle();
          //await loadSubscriberCount();
          if(window.currentAccount == getUserEthAddress()){
            await displayERC20Balance();
          }
          
          
        } else {
          window.alert('Please switch to Ropsten Test Network in your MetaMask Wallet');
        }
        
      }

      function getVideoUser() {
        return '<?php echo $uploaderEthAddress; ?>';
      }

      function getVideoIndex() {
        return '<?php echo $videoIndex; ?>';
      }

      function getUserEthAddress() {
        return '<?php echo $userLoggedInObj->getEthAddress(); ?>';
      }

      async function displayERC20Balance() {
        var currBal = await window.videossharing.methods.balanceOf(window.currentAccount).call();
          //currBal = parseInt(currBal) / 1000;
          document.getElementsByClassName("balanceDisplay")[0].innerHTML = currBal + ' DTC';
      }

      async function loadVideo() {
                    $("#serverSelectOptions").val('<?php echo $server?>'); 
                    video_user = getVideoUser();
                    video_index = getVideoIndex();
                    video_path_hex = await window.videossharing.methods.videos_path(video_user, video_index).call();
                    video_path = web3.utils.toAscii(video_path_hex);
                    video_url = '<?php echo $serverUrl; ?>' + video_path; 
                    $('#videoSourceURL').attr('src', video_url);
                    document.getElementById("videoPlayer").load();                 
      }

    </script>

<?php require_once("includes/footer.php");?>