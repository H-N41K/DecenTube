<?php
putenv("IPFS_PATH=C:\Users\H3M3N N4!K\.ipfs");
$cmd = 'E:/go-ipfs/ipfs-cluster-ctl.exe add --quieter uploads/videos/5e44036b4927f.mp4 2>&1 &';
echo $cmd."<br>----<br>";
$outputLog = array();
exec($cmd, $outputLog, $returnCode);
echo $returnCode."<br>----<br>";
echo "<br>--OUTPUT LOG--<br>";

//echo $outputLog[0];
if($returnCode != 1) {
	//Command Failed
	foreach($outputLog as $line) {
		echo $line."<br>";
	}
	return false;
}
?>