<?php
class VideoGridItem {

    private $video, $largeMode;

    public function __construct($video, $largeMode, $showCategory) {
        $this->video = $video;
        $this->largeMode = $largeMode;
        $this->showCategory = $showCategory;
    }

    public function create() {
        $thumbnail = $this->createThumbnail();
        $details = $this->createDetails();
        $url = "watch.php?id=". $this->video->getId();

        return "<a href='$url'>
                    <div class='videoGridItem'>
                    $thumbnail
                    $details
                    </div>
                </a>";
    }

    private function createThumbnail() {

        $thumbnail = $this->video->getThumbnail();
        $preview = $this->video->getPreview();
        $duration = $this->video->getDuration();

        return "<div class='thumbnail'>
                  <img src='$thumbnail' class='previewEnabled'>
                  <img src='$preview' class='previewContent'>
                  <div class='duration'>
                     <span>$duration</span>
                  </div>
                </div>";
        
    }

    private function createDetails() {

        $title = $this->video->getTitle();
        $username = $this->video->getUploadedBy();
        $views = $this->video->getViews();
        $description = $this->createDescription();
        $timestamp = $this->video->getUploadDate();
        $category = ($this->showCategory) ? $this->video->getCategoryName() : "";
        return "<div class='details'>
                <h3 class='title'>$title</h3>
                <span class='username'>$username</span>
                <div class='stats'>
                    <span class='viewCount'>$views views - </span>
                    <span class='timeStamp'>$timestamp</span>
                </div>
                $description
                <span class='category'>$category</span>
                </div>";

    }

    private function createDescription() {
        if(!$this->largeMode) {
            return "";
        }
        else {
            $description = $this->video->getDescription();
            $description = strip_tags($description);
            $description = (strlen($description) > 100) ? substr($description, 0 ,97). "..." : $description;
            return "<span class='description'>$description</span>";
        }
    }
}

?>