<?php
$cmd = "E:/xampp/htdocs/ffmpeg/bin/ffmpeg.exe ^ -i uploads/videos/faf.mp4 uploads/videos/output.mp4 ^ -vf scale=w=842:h=480:force_original_aspect_ratio=decrease ^ -vf 'scale=trunc(iw/2)*2:trunc(ih/2)*2' ^ -c:a aac -ar 48000 -c:v h264 -profile:v main -crf 20 -sc_threshold 0 -g 48 -keyint_min 48 ^ -b:v 1400k -maxrate 1498k -bufsize 2100k -b:a 128k ^ 2>&1";

echo $cmd."<br>----<br>";
$outputLog = array();
exec($cmd, $outputLog, $returnCode);
echo $returnCode."<br>----<br>";
echo "<br>--OUTPUT LOG--<br>";
//if($returnCode != 0) {
	//Command Failed
	foreach($outputLog as $line) {
		echo $line."<br>";
	}
	//return false;
//}
?>