<?php
$ipfsRepoPath = "C:\Users\H3M3N N4!K\.ipfs";
//putenv("IPFS_PATH=$ipfsRepoPath");
$ipfsCTLExePath = "E:/go-ipfs/ipfs-cluster-ctl.exe";
$cmd = "$ipfsCTLExePath add --quieter .htaccess 2>&1 &";

		$outputLog = array();
		exec($cmd, $outputLog, $returnCode);

		if($returnCode == 1) {
            echo "<br>Error in uploading to IPFS.";
			foreach($outputLog as $line) {
				echo $line."<br>";
            }
			return false;
        }
		return true;
?>