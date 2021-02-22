<?php
class VideoPlayer {

    private $video;

    public function __construct($video) {
        $this->video = $video;
    }

    public function create($autoPlay) {
        if($autoPlay) {
           $autoPlay = "autoplay='true'"; 
        }
        else {
            $autoPlay = "";
        }
        $filePath = $this->video->getFilePath();
        $thumbnail = $this->video->getThumbnail();
        return "<video class='videoPlayer video-js' id='videoPlayer'  poster='$thumbnail' controls  controlsList='nodownload' oncontextmenu='return false;'>
                    <source src='' type='video/mp4' id='videoSourceURL'>
                    Your Browser doesnot support the video tag
                </video>";
    }
}
?>