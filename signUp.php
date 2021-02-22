<?php 

require_once("includes/config.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/FormSanitizer.php");

$account = new Account($con);


if(isset($_POST['submitButton'])) {
  $firstName = FormSanitizer::sanitizeFormString($_POST['firstName']);
  $lastName = FormSanitizer::sanitizeFormString($_POST['lastName']);

  $username = FormSanitizer::sanitizeFormUsername($_POST['username']);

  $email = FormSanitizer::sanitizeFormEmail($_POST['email']);
  $email2 = FormSanitizer::sanitizeFormEmail($_POST['email2']);

  $password = FormSanitizer::sanitizeFormPassword($_POST['password']);
  $password2 = FormSanitizer::sanitizeFormPassword($_POST['password2']);

  $ethAddr = FormSanitizer::sanitizeEthAddress($_POST['ethAddr']);
  
  $profilePic = FormSanitizer::sanitizeBlockiesIcon($_POST['blockiesIcon']);
  

  $wasSuccessful = $account->register($firstName, $lastName, $username, $email, $email2, $password, $password2, $ethAddr, $profilePic);
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
    <script src="assets/js/regenerator-runtime@0.13.3/runtime.js"></script>
    <script src="assets/js/web3.js@1.2.1/web3.min.js"></script>
    <script src="assets/js/blockies.js"></script>
    
    <script>
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
        console.log('Non-Ethereum browser detected. You should consider trying MetaMask!');
        alert('Non-Ethereum browser detected. You must have MetaMask installed in order to proceed.');
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
  await loadBlockiesIcon();
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
    } else {
      window.alert('VideosSharing contract doesnt exist on the detected network. Please switch to Ganache Network');
    }
    
  }
  async function loadBlockiesIcon() {
            var address = window.currentAccount;
            var seed = address.toLowerCase();
            var source = blockies.create({ seed:seed ,size: 8,scale: 1});
            var profilePicture = $(".profilePicture");
            profilePicture.attr('src', blockies.create({ seed:seed ,size: 8,scale: 16}).toDataURL());
            profilePicture.attr('style', 'width: 45px;height: 45px;border-radius: 30px;');
            $(".ethAddress").val(address);
            $('input[name ="blockiesIcon"]').val(profilePicture.attr('src'));
  }
</script>
</head>
<body oncontextmenu='return false;' style='background-color:rgb(18, 18, 18);'>
    <div class="signInContainer">
        <div class="column" >
                <!-- style="background-color:rgb(18, 18, 18);" -->
            <div class="header">
                <img src="assets/images/icons/DecenTubeLogo.png" title="logo" alt="Site logo">
                <h3>Sign Up</h3>
                <span>to continue to DecenTube</span>
            </div>

            <div class="loginForm">
                <form action="signUp.php" method="POST">
                    <!-- class='form-control' -->
                  
                  <?php echo $account->getError(Constants::$firstNameCharacters);?>
                  <input type="text" class='form-control' name="firstName" placeholder="First Name" value="<?php getInputValue('firstName');?>" autocomplete="off" required="true">
                  
                  <?php echo $account->getError(Constants::$lastNameCharacters);?>
                  <input type="text" class='form-control' name="lastName" placeholder="Last Name" value="<?php getInputValue('lastName');?>" autocomplete="off" required="true">
                  
                  <?php echo $account->getError(Constants::$usernameCharacters);?>
                  <?php echo $account->getError(Constants::$usernameTaken);?>
                  <input type="text" class='form-control' name="username" placeholder="Username" value="<?php getInputValue('username');?>" autocomplete="off" required="true">

                  <?php echo $account->getError(Constants::$emailsDoNotMatch);?>
                  <?php echo $account->getError(Constants::$emailInvalid);?>
                  <?php echo $account->getError(Constants::$emailTaken);?>
                  <input type="email" class='form-control'  name="email" placeholder="E-Mail Address" value="<?php getInputValue('email');?>" autocomplete="off" required="true">
                  <input type="email" class='form-control' name="email2" placeholder="Confirm E-Mail Address" value="<?php getInputValue('email2');?>" autocomplete="off" required="true">

                  <?php echo $account->getError(Constants::$passwordsDoNotMatch);?>
                  <?php echo $account->getError(Constants::$passwordNotAlphanumeric);?>
                  <?php echo $account->getError(Constants::$passwordLength);?>
                  <input type="password" class='form-control'  name="password" placeholder="Password"  autocomplete="off" required="true">
                  <input type="password" class='form-control'  name="password2" placeholder="Confirm Password"  autocomplete="off" required="true">
                  
                  
                  <br>Detected Ethereum Address:<br>
                  <?php echo $account->getError(Constants::$ethAddressTaken);?>
                  <?php echo $account->getError(Constants::$ethAddressInvalid);?>
                  
                  <img class="profilePicture" src="assets/images/profilePictures/default.png" width="45px" height="45px"></img>
                  <input type="text" name="blockiesIcon" hidden="true">
                  <input type="text" name="ethAddr" class="ethAddress" readonly="true">
                  <br>
                  <span><input type="checkbox" id="terms_conditions_checkbox" required onclick="signTerms_Conditions();">&nbsp;&nbsp;By signing up with DecenTube, I agree to the <a href='#' onclick="$('#tandcModal').modal('show');">Terms & Conditions.</a></span>
                  <input type="submit" name="submitButton" value="SUBMIT">
                </form>
            </div>

            <a class="signInMessage" href="signIn.php">Already have an account? Sign in here.</a>
        </div>
    </div>

    <div class="modal fade" id="tandcModal" tabindex="-1" role="dialog" aria-labelledby="tandcModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content" style="background-color:black;">
                  <div class="modal-header">
                    <h5 class="modal-title">Terms & Conditions | DecenTube</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                  <p>1. DecenTube enforces the usage of DTC(DecenTube Coins) for all transactions and actions performed by the user.</p>
                  <p>2. DecenTubers will spend 5 DTC coins each time they like, dislike a video  or subscribe a channel. 
                  <br>In case of subscribing or liking action, of these 5 DTC coins , 4 will be rewarded to the content creator(uploader) and 1 coin will be deposited with DecenTube as DecenTube Community Fund. 
                  <br>In case of disliking, all the 5 DTC coins will be deposited with DecenTube as DecenTube Community Fund.
                  </p>

                  <p>3. DecenTube reserves the right to decide in its sole discretion whether Your Content, Your DecenTube Account and/or Your use of the DecenTube Service violates these Terms for any reasons other than copyright infringement, such as, but not limited to, pornography, obscenity, or excessive length. 
                  Failure to comply with these Terms may result in <br>
                  (i) Your Content being blocked without prior notice and/or <br>
                  (ii) Your DecenTube Account being deactivated without prior notice and/or <br>
                  (iii) In addition, DecenTube reserves the right to report any violation of these provisions to applicable legal authorities and You may be personally liable to criminal sanctions applicable to the content in question (fines and imprisonment), in addition to any applicable civil damages.</p>

                  <p>4. Due to its tokenized business model, DecenTube is 100% ad-free and does not collect any personal data from its users. DecenTube respects the privacy of its users.</p>
                  <p>5. DecenTube reserves the right to accept/deny users from purchasing and selling DTC tokens. DecenTube also reserves the right to destroy the smart contract without providing prior notice.</p>
                  </div>

              </div>
        </div>
    </div>
</body>
<script>
function signTerms_Conditions() {
  $("#terms_conditions_checkbox")[0].checked = false;
  var text = `# TERMS & CONDITIONS #

              _Our Terms & Conditions have been updated as of December 21st , 2019_

              1. DecenTube enforces the usage of DTC(DecenTube Coins) for all transactions and actions performed by the user.
              
              2. DecenTubers will spend 5 DTC coins each time they like, dislike a video  or subscribe a channel. 
                  
                  In case of subscribing or liking action, of these 5 DTC coins , 4 will be rewarded to the content creator(uploader) and 1 coin will be deposited with DecenTube as DecenTube Community Fund. 
                  In case of disliking, all the 5 DTC coins will be deposited with DecenTube as DecenTube Community Fund.
                  
              3. DecenTube reserves the right to decide in its sole discretion whether Your Content, Your DecenTube Account and/or Your use of the DecenTube Service violates these Terms for any reasons other than copyright infringement, such as, but not limited to, pornography, obscenity, or excessive length. 
                  Failure to comply with these Terms may result in 

                  (i) Your Content being blocked without prior notice and/or 

                  (ii) Your DecenTube Account being deactivated without prior notice and/or 

                  (iii) In addition, DecenTube reserves the right to report any violation of these provisions to applicable legal authorities and You may be personally liable to criminal sanctions applicable to the content in question (fines and imprisonment), in addition to any applicable civil damages.

              4. Due to its tokenized business model, DecenTube is 100% ad-free and does not collect any personal data from its users. DecenTube respects the privacy of its users.
              
              5. DecenTube reserves the right to accept/deny users from purchasing and selling DTC tokens. DecenTube also reserves the right to destroy the smart contract without providing prior notice.`;


  var msg = window.web3.utils.asciiToHex(text)
  console.log(text)
  console.log(msg)
  var from = window.currentAccount

  console.log('CLICKED, SENDING PERSONAL SIGN REQ')
  var params = [msg, from]
  var method = 'personal_sign'

  web3.currentProvider.sendAsync({
    method,
    params,
    from,
  }, function (err, result) {
    if (err) return console.error(err)
    if (result.error) return console.error(result.error)
    console.log('PERSONAL SIGNED:' + JSON.stringify(result.result))

    console.log('recovering...')
    const msgParams = { data: msg }
    msgParams.sig = result.result
    // console.dir({ msgParams })
    const recovered = from;
    // console.dir({ recovered })

    if (recovered === from ) {
      $("#terms_conditions_checkbox")[0].checked = true;
      console.log('Web3 Successfully verified signer as ' + from)
      window.alert('Web3 Successfully verified signer as ' + from)
      
    } else {
      console.dir(recovered)
      console.log('Web3 Failed to verify signer when comparing ' + recovered.result + ' to ' + from)
      console.log('Failed, comparing %s to %s', recovered, from)
    }
  })

}
</script>
</html>