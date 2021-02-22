function setNewThumbnail(thumbnailId, videoId, itemElement) {
    $.post("ajax/updateThumbnail.php", { videoId: videoId, thumbnailId: thumbnailId })
    .done(function() {
        var item = $(itemElement);
        var itemClass = item.attr("class");

        $("." + itemClass).removeClass("selected");

        item.addClass("selected");
        alert("Thumbnail updated");
    });
}

async function updateVideoTitle() {
    video_user = getVideoUser();
    video_index = getVideoIndex();
    new_video_title = $('input[name ="titleInput"]').val();

    await window.videossharing.methods.rename_videos_title(video_user, video_index, window.web3.utils.fromAscii(new_video_title)).send({ from: window.currentAccount }, function(error, result){
        if(error) 
        {
        console.log('Error is '+error);
        return;
        }
        console.log('Result is '+ result);
        alert("Video title successfully updated on the blockchain");
        });
}