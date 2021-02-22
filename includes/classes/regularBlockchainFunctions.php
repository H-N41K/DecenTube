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
                    console.log('window.ethereum');
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
                console.log('window.currentProvider');
                // Acccounts always exposed
            }
            // Non-dapp browsers...
            else {
                var provider = new Web3.providers.HttpProvider('https://ropsten.infura.io/v3/ee7f14f8e4ef43dab2769edfcda8445f')
                window.web3 = new Web3(provider)
                alert('Non-Ethereum browser detected. You should consider trying MetaMask!');
                console.log('Non-Ethereum browser detected. You should consider trying MetaMask!');
            }
            console.log('version');
            var version = web3.version;
            console.log(version);
            // var currentAccount = await web3.eth.getAccounts();
            // console.log(currentAccount);
          }
        
          async function loadBlockchainData() {
          //Load account
          window.currentAccount = await web3.eth.getAccounts();
          window.currentAccount = window.currentAccount[0];
          
        //   $.getJSON( 'assets/contracts/VideosSharing.json', function( json ) {
        //     console.log( 'JSON Data received, name is ' + json.contractName);
        //     window.VideosSharingContract = json;
        // });
        window.VideosSharingContract = <?php require_once('includes/VideosSharingJSON.php');?>;
        console.log( 'JSON Contract Data received');
          window.networkId = await web3.eth.net.getId();
            window.networkData = window.VideosSharingContract.networks[networkId];
            if (window.networkData) {
              window.videossharing = new web3.eth.Contract(window.VideosSharingContract.abi, window.networkData.address);
              if(window.currentAccount == getUserEthAddress()){
                await displayERC20Balance();
              }
              
            } else {
              window.alert('Please switch to Ropsten Test Network in your MetaMask Wallet');
            }
            
          }
    
          async function displayERC20Balance() {
            var currBal = await window.videossharing.methods.balanceOf(window.currentAccount).call();
              //currBal = parseInt(currBal) / 1000;
              document.getElementsByClassName('balanceDisplay')[0].innerHTML = currBal + ' DTC';
          }
    
          function getUserEthAddress() {
            return '<?php echo $userEthAddress?>';
          }
        </script>