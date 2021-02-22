<?php
class VideoProcessor {

    private $con;
    private $sizeLimit = 500000000;
    private $allowedTypes = array("mp4", "flv", "webm", "mkv", "vob", "ogv", "ogg", "avi", "wmv", "mov", "mpeg", "mpg");
    private $ffmpegPath;
    private $ffprobePath;

    public function __construct($con) {
		$this->con = $con;
        $this->ffmpegPath = realpath("ffmpeg/bin/ffmpeg.exe");
        $this->ffprobePath = realpath("ffmpeg/bin/ffprobe.exe");
        $this->ipfsExePath = "E:/go-ipfs/ipfs.exe";
        $this->ipfsCtlExePath = "E:/go-ipfs/ipfs-cluster-ctl.exe";
        $this->ipfsRepoPath = "C:\Users\H3M3N N4!K\.ipfs";
    }

    public function upload($videoUploadData) {

        $targetDir = "uploads/videos/";
        $videoData = $videoUploadData->videoDataArray;
        
        $tempFilePath = $targetDir . uniqid() . basename($videoData["name"]);
        //uploads/videos/5aa3e9343c9ffdogs_playing.flv
		//echo $tempFilePath;
        $tempFilePath = str_replace(" ", "_", $tempFilePath);

        $isValidData = $this->processData($videoData, $tempFilePath);

        if(!$isValidData) {
            return false;
        }

        if(move_uploaded_file($videoData["tmp_name"], $tempFilePath)) {
            
            $finalFilePath = $targetDir . uniqid() . ".mp4";
			//echo '<br><br>'.$finalFilePath;
            if(!$this->insertVideoData($videoUploadData, $finalFilePath)) {
                echo "Insert query failed";
                return false;
            }
            //VIDEO ID SHOULD STAY HERE ONLY
            $videoId = $this->con->lastInsertId(); 
			
			if(!$this->convertVideoToMp4($tempFilePath, $finalFilePath)) {
				echo "Upload failed";
				return false; 
            }
            
            if(!$this->deleteFile($tempFilePath)) {
				echo "Upload failed";
				return false; 
            }
            
            if(!$this->generateThumbnails($finalFilePath)) {
				echo "Upload failed - Could not generate thumbnail";
				return false; 
            }
            
            $videoHashValue = $this->generateIPFSHashOnly($finalFilePath);
            if(!$videoHashValue) {
				echo "Upload failed - Could not generate hash value";
				return false; 
            }

            

            return array(true, $videoUploadData->title, $videoHashValue, $finalFilePath, $videoId);

        }
    }

    public function generateIPFSHashOnly($finalFilePath) {
        putenv("IPFS_PATH=$this->ipfsRepoPath");
        // $cmd = "$this->ipfsExePath add --only-hash --quieter $finalFilePath 2>&1 &";
        $cmd = "$this->ipfsExePath add --only-hash --quieter $finalFilePath 2>&1 &";
		//echo $cmd;
		$outputLog = array();
		exec($cmd, $outputLog, $returnCode);

		if($returnCode == 1) {
            echo "Error in hasding.";
			foreach($outputLog as $line) {
				echo $line."<br>";
            }
			return false;
        }
		return $outputLog[0];
    }

    public function uploadFileToIPFS($finalFilePath) {
        putenv("IPFS_PATH=$this->ipfsRepoPath");
        //$cmd = "$this->ipfsExePath add --quieter $finalFilePath 2>&1 &";
        $cmd = "$this->ipfsCtlExePath add --quieter $finalFilePath 2>&1 &";
		//echo "<BR>".$cmd;
		$outputLog = array();
		exec($cmd, $outputLog, $returnCode);

		if($returnCode == 1) {
            echo "<br>Error in uploading to IPFS.";
			foreach($outputLog as $line) {
				echo $line."<br>";
            }
			return false;
        }

        if(!$this->deleteFile($finalFilePath)) {
            echo "<br>Upload failed: Couldnt delete file after uploading to IPFS";
            return false; 
        }
		return true;
    }

    private function processData($videoData, $filePath) {
        $videoType = pathInfo($filePath, PATHINFO_EXTENSION);
        
        if(!$this->isValidSize($videoData)) {
            echo "File too large. Can't be more than " . $this->sizeLimit . " bytes";
            return false;
        }
        else if(!$this->isValidType($videoType)) {
            echo "Invalid file type";
            return false;
        }
        else if($this->hasError($videoData)) {
            echo "Error code: " . $videoData["error"];
            return false;
        }

        return true;
    }

    private function isValidSize($data) {
        return $data["size"] <= $this->sizeLimit;
    }

    private function isValidType($type) {
        $lowercased = strtolower($type);
        return in_array($lowercased, $this->allowedTypes);
    }
    
    private function hasError($data) {
        return $data["error"] != 0;
    }

    private function insertVideoData($uploadData, $filePath) {
        $query = $this->con->prepare("INSERT INTO videos(title, uploadedBy, description, privacy, category, filePath)
                                        VALUES(:title, :uploadedBy, :description, :privacy, :category, :filePath)");

        $query->bindParam(":title", $uploadData->title);
        $query->bindParam(":uploadedBy", $uploadData->uploadedBy);
        $query->bindParam(":description", $uploadData->description);
        $query->bindParam(":privacy", $uploadData->privacy);
        $query->bindParam(":category", $uploadData->category);
        $query->bindParam(":filePath", $filePath);

        return $query->execute();
	}

	public function convertVideoToMp4($tempFilePath, $finalFilePath) {
		//Change memory_limit in php.ini incase any more memory is required;
		// $cmd = "$this->ffmpegPath -i $tempFilePath $finalFilePath 2>&1";
        $cmd = "$this->ffmpegPath ^ -i $tempFilePath $finalFilePath ^ -vf scale=w=842:h=480:force_original_aspect_ratio=decrease ^ -vf 'scale=trunc(iw/2)*2:trunc(ih/2)*2' ^ -c:a aac -ar 48000 -c:v h264 -profile:v main -crf 20 -sc_threshold 0 -g 48 -keyint_min 48 ^ -b:v 1400k -maxrate 1498k -bufsize 2100k -b:a 128k ^ 2>&1";
		//echo $cmd;
		$outputLog = array();
		exec($cmd, $outputLog, $returnCode);

		if($returnCode != 0) {
			//Command Failed
			foreach($outputLog as $line) {
				echo $line."<br>";
			}
			return false;
		}

		return true;
	}
    
    private function deleteFile($filePath) {
        if(!unlink($filePath)) {
            echo "Could not delete file \n";
            return false;
        }
        return true;
    }
   
    public function generateThumbnails($filePath) {
        //IMPLEMENTING VIDEO PREVIEW ALSO
        $thumbnailSize ="210x118";
        $previewSize ="210x118";
        $numThumbnails = 3;
        $pathToThumbnail = "uploads/videos/thumbnails";
        $pathToPreview = "uploads/videos/previews";

        $duration = $this->getVideoDuration($filePath);


        $videoId = $this->con->lastInsertId();
        $this->updateDuration($duration, $videoId);

        $previewName = uniqid().".gif";
        $interval =($duration * 0.8) / $numThumbnails;
        $previewDuration = 5;
        $fullPreviewPath = "$pathToPreview/$videoId-$previewName";

        $cmd = "$this->ffmpegPath -i $filePath -ss $interval -s $previewSize -t $previewDuration $fullPreviewPath 2>&1";
        $outputLog = array();
        exec($cmd, $outputLog, $returnCode);

        if($returnCode != 0) {
            //Command Failed
            foreach($outputLog as $line) {
                echo $line."<br>";
            }
        }

            $query = $this->con->prepare("INSERT INTO previews(videoId, filePath)
            VALUES(:videoId, :filePath)");
            $query->bindParam(":videoId", $videoId);
            $query->bindParam(":filePath", $fullPreviewPath);

            $success = $query->execute();

            if(!$success) {
                echo "Error inserting Preview\n";
                return false;
            }

        for($num = 1; $num <= $numThumbnails; $num++) {
            $imageName = uniqid().".jpg";
            $interval =($duration * 0.8) / $numThumbnails * $num;
            $fullThumbnailPath = "$pathToThumbnail/$videoId-$imageName";

            $cmd = "$this->ffmpegPath -i $filePath -ss $interval -s $thumbnailSize -vframes 1 $fullThumbnailPath 2>&1";
		    $outputLog = array();
            exec($cmd, $outputLog, $returnCode);

            if($returnCode != 0) {
                //Command Failed
                foreach($outputLog as $line) {
                    echo $line."<br>";
                }
            }

            $query = $this->con->prepare("INSERT INTO thumbnails(videoId, filePath, selected)
            VALUES(:videoId, :filePath, :selected)");
            $query->bindParam(":videoId", $videoId);
            $query->bindParam(":filePath", $fullThumbnailPath);
            $query->bindParam(":selected", $selected);

            $selected = $num == 1 ? 1:0;

            $success = $query->execute();

            if(!$success) {
                echo "Error inserting thumbnail\n";
                return false;
            }
        }

        return true;

    }


    private function getVideoDuration($filePath) {
        return (int)shell_exec("$this->ffprobePath -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 $filePath");
    }

    private function updateDuration($duration, $videoId) {
        
        $hours = floor($duration / 3600);
        $mins = floor(($duration - ($hours*3600)) / 60);
        $secs = floor($duration % 60);
        
        $hours = ($hours < 1) ? "" : $hours . ":";
        $mins = ($mins < 10) ? "0" . $mins . ":" : $mins . ":";
        $secs = ($secs < 10) ? "0" . $secs : $secs;

        $duration = $hours.$mins.$secs;

        $query = $this->con->prepare("UPDATE videos SET duration=:duration WHERE id=:videoId");
        $query->bindParam(":duration", $duration);
        $query->bindParam(":videoId", $videoId);
        $query->execute();
    }




}
?>