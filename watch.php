<?php 

require_once("includes/header.php");
require_once("includes/classes/VideoPlayer.php");
require_once("includes/classes/VideoInfoSection.php");   
require_once("includes/classes/CommentSection.php");
require_once("includes/classes/Comment.php");  

if(!isset($_GET["id"])) {
    echo "No URL PASSED INTO PAGE!";
    exit();
} else {
	$id = $_GET['id'];
}


$server = isset($_GET["server"]) ? $_GET["server"] : 1;
$serverUrl = $ipfsNodeArray[$server];
// if ($_SERVER['SERVER_NAME'] == 'localhost' && $server == 1) {
//   $serverUrl = 'http://localhost:8080/ipfs/';
// }
$currentlyPlayingVideoId = $_GET["id"];
$video = new Video($con, $_GET["id"], $userLoggedInObj);

if($video->getTransactionStatus() == 0) {
echo "<script>
        var redir = confirm('This video does not exist or has been taken down!');
        if (redir == true || redir == false) {
        window.location.href = 'index.php'
        }
        </script>";
exit();
}

if($video->getPrivacy() == 0 && $usernameLoggedIn != $video->getUploadedBy()) {
  echo "<script>
          var redir = confirm('This video has been made private by the owner!');
          if (redir == true || redir == false) {
          window.location.href = 'index.php'
          }
          </script>";
  exit();
  }

$video->incrementViews();

if(User::isloggedIn()) {
 
  $query = $con->prepare("UPDATE users SET history=CONCAT(history, ',', :id) WHERE username=:username");

  $query->bindParam(":id", $id);

  $query->bindParam(":username", $usernameLoggedIn);

  $query->execute();

}

$uploaderEthAddress = $video->getUploaderEthAddress();
$videoIndex =  $video->getVideoIndex();
?>

<script src="assets/js/videoPlayerActions.js"></script>
<script src="assets/js/commentActions.js"></script>

<div class="watchLeftColumn">

<?php 
    $videoPlayer = new VideoPlayer($video);
    echo $videoPlayer->create(true);

    $videoPlayer = new VideoInfoSection($con, $video, $userLoggedInObj);
    echo $videoPlayer->create();

    $commentSection = new CommentSection($con, $video, $userLoggedInObj);
    echo $commentSection->create();
    
?>

</div>

<div class='suggestions'>
  <?php
  $showCategory = false;
  $videoGrid = new VideoGrid($con, $userLoggedInObj, $currentlyPlayingVideoId, $showCategory);
  echo $videoGrid->create(null, null, false);
  ?>
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
          await loadVideoPopularity();
          await loadVideoTitle();
          if (window.currentAccount != null){
            await loadSubscriberCount();
          }
          
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
                    videojs('videoPlayer', {
                    controls: true,
                    autoplay: true,
                    preload:true,
                    playbackRates: [0.25, 0.5, 0.75, 1, 1.5, 2, 4]
                    });
                    loadEmojiOneArea();
                    initVideo("<?php echo $id ?>", "<?php echo $usernameLoggedIn; ?>");
      }

      //Loading from the blockchain
      async function loadVideoPopularity() {
        video_user = getVideoUser();
        video_index = getVideoIndex();
        video_likes = await window.videossharing.methods.video_aggregate_likes(video_user, video_index).call()
        video_dislikes = await window.videossharing.methods.video_aggregate_dislikes(video_user, video_index).call()
        var likesSpanText = $( "div.videoInfo > div.bottomSection > div.controls > button.likeButton > span.text" );
        var dislikesSpanText = $( "div.videoInfo > div.bottomSection > div.controls > button.dislikeButton > span.text" );
        
        likesSpanText.text(video_likes);
        dislikesSpanText.text(video_dislikes);
      }

      async function loadVideoTitle() {
        video_user = getVideoUser();
        video_index = getVideoIndex();
        video_title_hex = await window.videossharing.methods.videos_title(video_user, video_index).call();
        video_title = web3.utils.toAscii(video_title_hex);
        var videoTitleH1 = $( "div.videoInfo > h1" );
        videoTitleH1.text(video_title);
      }

      async function loadSubscriberCount() {
        video_user = getVideoUser();
        num_subscribers = await window.videossharing.methods.user_aggregate_subscribers(video_user).call()
        
        subscription_status = await window.videossharing.methods.user_has_subscribed(window.currentAccount, video_user).call()
        if  (subscription_status == true) {
          subStatus = "SUBSCRIBED 🔔"
        } else {
          subStatus = "SUBSCRIBE";
        }
        var subButtonCount = $( "div.secondaryInfo > div.topRow > div.subscribeButtonContainer > button > span.text" );
        subButtonCount.text(subStatus + " " +num_subscribers);
      }

      function initVideo(videoId, username) {
        if (username == null || username == ''){
          return;
        }
        setStartTime(videoId, username);
        updateProgressTimer(videoId, username);
      }

      function setStartTime(videoId, username) {
          $.post("ajax/getProgress.php", { videoId: videoId, username: username }, function(data) {
              if(isNaN(data)) {
                alert(data);
                return;
              }

              $("video").on("canplay", function () {
                  this.currentTime = data;
                  $("video").off("canplay");
              })
          })
      }

function updateProgressTimer(videoId, username) {
      addDuration(videoId, username);

      var timer;

      $("video").on("playing", function(event) {
          window.clearInterval(timer);
          timer = window.setInterval(function() {
              updateProgress(videoId, username, event.target.currentTime)
          }, 3000);
      })
      .on("ended", function() {
          setFinished(videoId, username);
          window.clearInterval(timer);
      })
}

function addDuration(videoId, username) {
    $.post("ajax/addDuration.php", { videoId: videoId, username: username }, function(data) {
        if(data !== null && data !== "") {
            alert(data);
        }
    })
}

function updateProgress(videoId, username, progress) {
    $.post("ajax/updateDuration.php", { videoId: videoId, username: username, progress: progress }, function(data) {
        if(data !== null && data !== "") {
            alert(data);
        }
    })
}

function setFinished(videoId, username) {
    $.post("ajax/setFinished.php", { videoId: videoId, username: username }, function(data) {
        if(data !== null && data !== "") {
            alert(data);
        }
    })
}

    </script>
    <script>
    <?php echo file_get_contents("assets/js/video.js");?>
    </script>
<?php require_once("includes/footer.php"); ?>
                