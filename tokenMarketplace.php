<?php 
require_once("includes/header.php");

if(!User::isLoggedIn()) {
    header("Location: signIn.php");
  }

?>


<div class="column">
    <h2>Buy / Sell DTC &nbsp;&nbsp;<img src="assets/images/icons/coin.svg" width="50px"></h2>
    
    <form method="POST">
					<p>
                    <h6>
                        Introducing&nbsp;"DecenTube Coin"&nbsp;&nbsp;&nbsp;&nbsp;(DTC)&nbsp;!<br><br> 
                        Coin Buy Price:&nbsp;&nbsp; <span class="buy-token-price"></span> ETH per coin&nbsp;&nbsp; (₹ 5 per coin)<br>
                        Coin Sell Price:&nbsp;&nbsp;&nbsp; <span class="sell-token-price"></span> ETH per coin&nbsp;&nbsp; (₹ 4.75 per coin)<br><br>
                        Your last buy transaction was made on: <span class="last-buy-timestamp"></span><br>
                        Your last sell transaction was made on: <span class="last-sell-timestamp"></span><br><br>
                        Terms of Use:<br>
                        - A maximum of 1000 coins can be bought or sold in a single transaction.<br>
                        - Every buy/sell transaction can be made after a duration of 7 days since the previous transaction.
                        <br><br>
                        Add the following token address to your MetaMask wallet:&nbsp;&nbsp; <span class="token-address"></span><br>
                        Token Symbol: &nbsp;&nbsp;DTC<br>
                        Decimals: &nbsp;&nbsp;3 <br>
                        <br><br>
                        You currently have : &nbsp;&nbsp;<span class="dtc-balance">0</span> DTC <br><br>
                        Total amount of coins: &nbsp;&nbsp;<span class="tokens-available"></span><br>
                        Amount of coins sold:  &nbsp;&nbsp;<span class="tokens-sold"></span><br>
                    </h6>
                    </p>
                    <br>
                    <div class="form-group">
                    <span class="ico-sale-percent"></span> % of coins sold. Hurry!&nbsp;&nbsp;Invest in DTC before it gets too late 
                    <div class="progress">
                        <div id="progress" class="progress-bar progress-bar-striped active progress-bar-animated" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>	
                    </div>
                    <div class="form-group">
                <div class="input-group">
                  <input id="numberOfTokens" class="form-control input-lg" type="number" name="number" value="1" min="1" pattern="[0-9]" max="1000">
                  </input>
                  <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary btn-lg" onclick="buyTokens(); return false;">Buy Tokens</button>
                  </span>
                  <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary btn-lg" onclick="sellTokens(); return false;">Sell Tokens</button>
                  </span>
                </div>
              </div>

				</form>


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
          
          if(window.currentAccount == getUserEthAddress()){
            await displayERC20Balance();
          }
          loadTokenPrices();
          loadUserBalance();
          updateProgressBar();
          loadLastTxnTimes();
          
          
        } else {
          window.alert('Please switch to Ropsten Test Network in your MetaMask Wallet');
        }
        
      }

      function getUserEthAddress() {
        return '<?php echo $userLoggedInObj->getEthAddress(); ?>';
      }

      async function displayERC20Balance() {
        var currBal = await window.videossharing.methods.balanceOf(window.currentAccount).call();
          //currBal = parseInt(currBal) / 1000;
          document.getElementsByClassName("balanceDisplay")[0].innerHTML = currBal + ' DTC';
      }

      async function loadTokenPrices() {
            buyPrice = await window.videossharing.methods.tokenBuyPrice().call();
            buyPrice = window.web3.utils.fromWei(buyPrice, 'ether');
    

            sellPrice = await window.videossharing.methods.tokenSellPrice().call();
            sellPrice = window.web3.utils.fromWei(sellPrice, 'ether');
    
            $(".buy-token-price").text(buyPrice);
            $(".sell-token-price").text(sellPrice);
        }

    async function loadUserBalance() {
        userBalance = await window.videossharing.methods.balanceOf(window.currentAccount).call();
        $(".dtc-balance").text(userBalance);
  }
  
  async function loadLastTxnTimes() {
    lastBuyTime = await window.videossharing.methods.getBuyTimeStampValue(window.currentAccount).call();
    lastSellTime = await window.videossharing.methods.getSellTimeStampValue(window.currentAccount).call();

    if (lastBuyTime == '0') {
        $(".last-buy-timestamp").text("NIL");
    } else {
        lastBuyTimeText = convertTimestampToDateTime(lastBuyTime);
        $(".last-buy-timestamp").text(lastBuyTimeText);
    }

    if (lastSellTime == '0') {
        $(".last-sell-timestamp").text("NIL");
    } else {
        lastSellTimeText = convertTimestampToDateTime(lastSellTime);
        $(".last-sell-timestamp").text(lastSellTimeText);
    }
    
  }

  function convertTimestampToDateTime(timestamp) {
var months_arr = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
var date = new Date(timestamp*1000);
var year = date.getFullYear();
var month = months_arr[date.getMonth()];
var day = date.getDate();
var hours = date.getHours();
var minutes = "0" + date.getMinutes();
var seconds = "0" + date.getSeconds();
var convdataTime = month+'-'+day+'-'+year+' '+hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
return convdataTime;
}
var rCatch;
async function buyTokens() {
    var numberOfTokens = $('#numberOfTokens').val();
    console.log("Buying " + numberOfTokens + " tokens");
    buyPrice = await window.videossharing.methods.tokenBuyPrice().call();
    await window.videossharing.methods.buyTokens(numberOfTokens).send(
      { from: window.currentAccount,
        value: numberOfTokens * buyPrice
      },function(error, result) {
        if(error) {
            alert("ERROR: Buy transaction failed :"+error.message);
        }
        else {
            alert("Buy Transaction successful "+ result);
            rCatch = result;
        }
      });
  }

  async function sellTokens() {
    var numberOfTokens = $('#numberOfTokens').val();
    console.log("Selling " + numberOfTokens + " tokens");
    await window.videossharing.methods.sellTokens(numberOfTokens).send(
      { from: window.currentAccount},function(error, result) {
        if(error) {
            alert("ERROR: Sell transaction failed :"+error.message);
        }
        else {
            alert("Sell Transaction successful "+result);
        }
      });
  }

  async function updateProgressBar() {
    tokensSold = await window.videossharing.methods.tokensSold().call();
    tokensSold = parseInt(tokensSold);
    $('.token-address').html(window.networkData.address);
    $('.tokens-sold').html(tokensSold);
    $('.tokens-available').html(500000);
    var progressPercent = 100 * (tokensSold / 500000);
      $('#progress').css('width', progressPercent + '%');
      $('.ico-sale-percent').html(progressPercent);
  }

</script>

<?php
require_once("includes/footer.php");
?>