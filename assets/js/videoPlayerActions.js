function likeVideo(button, videoId) {
    video_user = getVideoUser();
    video_index = getVideoIndex();
    if(window.currentAccount != getUserEthAddress()){
        alert('There is an inconsistency between MetaMask wallet and User Session. Please set both to the same account and try again.');
        return false;
    }
    window.videossharing.methods.like_video(video_user, video_index).send({ from: window.currentAccount }, function(error, result){
        if(error) 
        {
        console.log('Error is '+error);
        return;
        }
            
            $.post("ajax/likeVideo.php", {videoId: videoId})
            .done(function(data){

            var likeButton = $(button);
            var dislikeButton = $(button).siblings(".dislikeButton");

            likeButton.addClass("active");
            dislikeButton.removeClass("active");

            var result = JSON.parse(data);
            updateLikesValue(likeButton.find(".text"), result.likes);
            updateLikesValue(dislikeButton.find(".text"), result.dislikes);

            if(result.likes < 0) {
            likeButton.removeClass("active");
            likeButton.find("img:first").attr("src", "assets/images/icons/thumb-up.png");  
            }
            else {
            likeButton.find("img:first").attr("src", "assets/images/icons/thumb-up-active.png"); 
            }

            dislikeButton.find("img:first").attr("src", "assets/images/icons/thumb-down.png");
            });
            
        });
    
   
}

function dislikeVideo(button, videoId) {
    video_user = getVideoUser();
    video_index = getVideoIndex();
    if(window.currentAccount != getUserEthAddress()){
        alert('There is an inconsistency between MetaMask wallet and User Session. Please set both to the same account and try again.');
        return false;
    }
    window.videossharing.methods.dislike_video(video_user, video_index).send({ from: window.currentAccount }, function(error, result){
        if(error) 
        {
        console.log('Error is '+error);
        return;
        }
      
    $.post("ajax/dislikeVideo.php", {videoId: videoId})
    .done(function(data){
        
    var dislikeButton = $(button);
    var likeButton = $(button).siblings(".likeButton");

    dislikeButton.addClass("active");
    likeButton.removeClass("active");

    var result = JSON.parse(data);
    updateLikesValue(likeButton.find(".text"), result.likes);
    updateLikesValue(dislikeButton.find(".text"), result.dislikes);

    if(result.dislikes < 0) {
        dislikeButton.removeClass("active");
        dislikeButton.find("img:first").attr("src", "assets/images/icons/thumb-down.png");  
    }
    else {
        dislikeButton.find("img:first").attr("src", "assets/images/icons/thumb-down-active.png"); 
    }

    likeButton.find("img:first").attr("src", "assets/images/icons/thumb-up.png");
    });

    });
    
}

function updateLikesValue(element, num) {
    var likesCountVal = element.text() || 0;
    element.text(parseInt(likesCountVal) + parseInt(num));
}