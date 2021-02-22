const VideosSharing = artifacts.require("VideosSharing");

require('chai')
    .use(require('chai-as-promised'))
    .should()

contract('VideosSharing', ([deployer, user_acc1, user_acc2, user_acc3]) => {
    let videossharing 

    before (async () => {
        videossharing = await VideosSharing.deployed()
    })

//     describe('Deployment and Initialization of contract:', async () => {
//         it('Deploys successfully', async () => {
//             const address = await videossharing.address
//             assert.notEqual(address, 0x0)
//             assert.notEqual(address, '')
//             assert.notEqual(address, null)
//             assert.notEqual(address, undefined)
//         })

//         it('Has correct amount of totalSupply: 500000', async () => {
//             const totalSupply = await videossharing.totalSupply()
//             assert.equal(totalSupply.toNumber(), 500000)
//         })

//         it('Deployer has entire supply of tokens', async () => {
//             const deployer_balance = await videossharing.balanceOf(deployer)
//             assert.equal(deployer_balance.toNumber(), 500000)
//         })

//         it('has correct name: Video Sharing Coin', async () => {
//             const name = await videossharing.name()
//             assert.equal(web3.utils.toAscii(name), 'Video Sharing Coin')
//         })

//         it('Has correct symbol: VID', async () => {
//             const symbol = await videossharing.symbol()
//             assert.equal(web3.utils.toAscii(symbol), 'VID')
//         })

//         it('has correct number of decimals: 3', async () => {
//             const decimals = await videossharing.decimals()
//             assert.equal(decimals.toNumber(), 3)
//         })
   
//     })
//     //Todo: Add Check length of path and title before uploading in smart contract.
//     describe('Video Uploading Status:', async () => {
//         let result1, result2, uploader_video_index_before, uploader_video_index_after, video_uploader
//         before (async () => {
//             video_uploader = user_acc1;
//             uploader_video_index_before = await videossharing.latest_videos_index(video_uploader)
//             assert.equal(uploader_video_index_before.toNumber(), 0) 
//         })

//         it('Uploads Videos', async () => {
//             //SUCCCESS

//             result1 = await videossharing.upload_video(web3.utils.fromAscii("video-ipfs-path"),web3.utils.fromAscii("video-title"), {from: video_uploader})

//             uploader_video_index_after = await videossharing.latest_videos_index(video_uploader)
//             assert.equal(uploader_video_index_after.toNumber(), 1)

//             video_index = await videossharing.latest_videos_index(video_uploader)
//             video_path = await videossharing.videos_path(video_uploader, 0)
//             video_title = await videossharing.videos_title(video_uploader, 0)

//             assert.equal(video_index.toNumber(), 1 ,'Uploader Video Index should match after upload!')
//             assert.equal(web3.utils.toAscii(video_path), "video-ipfs-path" ,'Uploaded Video Path should match after upload!')
//             assert.equal(web3.utils.toAscii(video_title), "video-title" ,'Uploaded Video Title should match after upload!')
            


//             result2 = await videossharing.upload_video(web3.utils.fromAscii("video-ipfs-path2"),web3.utils.fromAscii("video-title2"), {from: video_uploader})

//             uploader_video_index_after = await videossharing.latest_videos_index(video_uploader)
//             assert.equal(uploader_video_index_after.toNumber(), 2)

//             video_index = await videossharing.latest_videos_index(video_uploader)
//             video_path = await videossharing.videos_path(video_uploader, 1)
//             video_title = await videossharing.videos_title(video_uploader, 1)

//             assert.equal(video_index.toNumber(), 2 ,'Uploader Video Index should match after upload!')
//             assert.equal(web3.utils.toAscii(video_path), "video-ipfs-path2" ,'Uploaded Video Path should match after upload!')
//             assert.equal(web3.utils.toAscii(video_title), "video-title2" ,'Uploaded Video Title should match after upload!')

//             const event1 = result1.logs[0].args
//             assert.equal(event1._user, video_uploader, 'Event emitted: Uploader should be correct!')
//             assert.equal(event1._index.toNumber(), 0 ,'Uploader Video Index should match after upload!')
            
//             const event2 = result2.logs[0].args
//             assert.equal(event2._user, video_uploader, 'Event emitted: Uploader should be correct!')
//             assert.equal(event2._index.toNumber(), 1 ,'Uploader Video Index should match after upload!')

//         //     //Failure: Product must have a name
//         //     await marketplace.createProduct('', web3.utils.toWei('1', 'Ether'), {from: seller}).should.be.rejected;

//         //     //Failure: Product must have a price
//         //    await marketplace.createProduct('iPhone X',0, {from: seller}).should.be.rejected;

//         })
       
//    })

   describe('Video Liking & User Subscription Status:', async () => {
    let transfer_result1, transfer_result2, transfer_result3, upload_result; 
    let video_uploader, video_liker, video_liker2, uploader_video_index_before;
    let user_from, user_from2, user_to;
    before (async () => {
        video_uploader = user_acc2;
        video_liker = user_acc1;
        video_liker2 = user_acc3;
        user_from = user_acc2;
        user_from2 = user_acc1;
        user_to = user_acc3;
        uploader_video_index_before = await videossharing.latest_videos_index(video_uploader)
        assert.equal(uploader_video_index_before.toNumber(), 0) 
    })

    // it('Likes Videos', async () => {
    //     //SUCCCESS
    //     transfer_result1 = await videossharing.transfer(video_liker, 100, {from: deployer})
    //     transfer_result2 = await videossharing.transfer(video_liker2, 100, {from: deployer})
    //     transfer_result3 = await videossharing.transfer(video_uploader, 50, {from: deployer})
        
    //     upload_result = await videossharing.upload_video(web3.utils.fromAscii("video-ipfs-path"),web3.utils.fromAscii("video-title"), {from: video_uploader})

    //     likedbyl1 = await videossharing.video_has_been_liked(video_liker, video_uploader, 0)
    //     assert.equal(likedbyl1, false)
    //     likedbyl2 = await videossharing.video_has_been_liked(video_liker2, video_uploader, 0)
    //     assert.equal(likedbyl2, false)

    //     video_uploader_balance = await videossharing.balanceOf(video_uploader)
    //     assert.equal(video_uploader_balance.toNumber(), 50)
    //     video_liker_balance = await videossharing.balanceOf(video_liker)
    //     assert.equal(video_liker_balance.toNumber(), 100)
    //     video_liker2_balance = await videossharing.balanceOf(video_liker2)
    //     assert.equal(video_liker2_balance.toNumber(), 100)

    //     aggregate_likes = await videossharing.video_aggregate_likes(video_uploader, 0)
    //     assert.equal(aggregate_likes.toNumber(), 0)

    //     likevideo_result1 = await videossharing.like_video(video_uploader, 0, {'from': video_liker})
    //     liked = await videossharing.video_has_been_liked(video_liker, video_uploader, 0)
    //     assert.equal(liked, true)
    //     liked2 = await videossharing.video_has_been_liked(video_liker2, video_uploader, 0)
    //     assert.equal(liked2, false)

        
    //     video_uploader_balance = await videossharing.balanceOf(video_uploader)
    //     assert.equal(video_uploader_balance.toNumber(), 51)

    //     video_liker_balance = await videossharing.balanceOf(video_liker)
    //     assert.equal(video_liker_balance.toNumber(), 99)

    //     video_liker2_balance = await videossharing.balanceOf(video_liker2)
    //     assert.equal(video_liker2_balance.toNumber(), 100)

    //     aggregate_likes = await videossharing.video_aggregate_likes(video_uploader, 0)
    //     assert.equal(aggregate_likes.toNumber(), 1)

        

    //     unlikevideo_result1 = await videossharing.like_video(video_uploader, 0, {'from': video_liker})
    //     liked = await videossharing.video_has_been_liked(video_liker, video_uploader, 0)
    //     assert.equal(liked, false)
    //     liked2 = await videossharing.video_has_been_liked(video_liker2, video_uploader, 0)
    //     assert.equal(liked2, false)

    //     video_uploader_balance = await videossharing.balanceOf(video_uploader)
    //     assert.equal(video_uploader_balance.toNumber(), 51)

    //     video_liker_balance = await videossharing.balanceOf(video_liker)
    //     assert.equal(video_liker_balance.toNumber(), 99)

    //     video_liker2_balance = await videossharing.balanceOf(video_liker2)
    //     assert.equal(video_liker2_balance.toNumber(), 100)

    //     aggregate_likes = await videossharing.video_aggregate_likes(video_uploader, 0)
    //     assert.equal(aggregate_likes.toNumber(), 0)
        
    //     const likevideo_event1 = likevideo_result1.logs[1].args
    //     const unlikevideo_event1 = unlikevideo_result1.logs[0].args


    //     assert.equal(likevideo_event1._video_liker, video_liker, 'Event emitted: Liker should be correct!')
    //     assert.equal(likevideo_event1._video_uploader, video_uploader, 'Event emitted: Uploader should be correct!')
    //     assert.equal(likevideo_event1._index.toNumber(), 0, 'Event emitted: Video Index should be correct!')

    //     assert.equal(unlikevideo_event1._video_liker, video_liker, 'Event emitted: Liker should be correct!')
    //     assert.equal(unlikevideo_event1._video_uploader, video_uploader, 'Event emitted: Uploader should be correct!')
    //     assert.equal(unlikevideo_event1._index.toNumber(), 0, 'Event emitted: Video Index should be correct!')

        
        

    // //     //Failure: Product must have a name
    // //     await marketplace.createProduct('', web3.utils.toWei('1', 'Ether'), {from: seller}).should.be.rejected;

    // //     //Failure: Product must have a price
    // //    await marketplace.createProduct('iPhone X',0, {from: seller}).should.be.rejected;

    // })

    it('Subscribes Videos', async () => {
        //SUCCCESS
        transfer_result1 = await videossharing.transfer(user_to, 100, {from: deployer})
        transfer_result2 = await videossharing.transfer(user_from, 50, {from: deployer})
        transfer_result3 = await videossharing.transfer(user_from2, 50, {from: deployer})
        
        subbedbyfrom1 = await videossharing.user_has_subscribed(user_from, user_to);
        assert.equal(subbedbyfrom1, false)
        subbedbyfrom2 = await videossharing.user_has_subscribed(user_from2, user_to);
        assert.equal(subbedbyfrom2, false)

        user_to_balance = await videossharing.balanceOf(user_to)
        assert.equal(user_to_balance.toNumber(), 100)
        user_from_balance = await videossharing.balanceOf(user_from)
        assert.equal(user_from_balance.toNumber(), 50)
        user_from2_balance = await videossharing.balanceOf(user_from2)
        assert.equal(user_from2_balance.toNumber(), 50)

        aggregate_subscribers = await videossharing.user_aggregate_subscribers(user_to)
        assert.equal(aggregate_subscribers.toNumber(), 0)

        subscribe_result1 = await videossharing.subscribe_user(user_to, {'from': user_from})
        subscribed = await videossharing.user_has_subscribed(user_from, user_to)
        assert.equal(subscribed, true)
        subscribed2 = await videossharing.user_has_subscribed(user_from2, user_to)
        assert.equal(subscribed2, false)

        
        user_to_balance = await videossharing.balanceOf(user_to)
        assert.equal(user_to_balance.toNumber(), 101)

        user_from_balance = await videossharing.balanceOf(user_from)
        assert.equal(user_from_balance.toNumber(), 49)

        user_from2_balance = await videossharing.balanceOf(user_from2)
        assert.equal(user_from2_balance.toNumber(), 50)

        aggregate_subscribers = await videossharing.user_aggregate_subscribers(user_to)
        assert.equal(aggregate_subscribers.toNumber(), 1)

        //PARTITION

        subscribe_result2 = await videossharing.subscribe_user(user_to, {'from': user_from2})
        subscribed = await videossharing.user_has_subscribed(user_from, user_to)
        assert.equal(subscribed, true)
        subscribed2 = await videossharing.user_has_subscribed(user_from2, user_to)
        assert.equal(subscribed2, true)

        
        user_to_balance = await videossharing.balanceOf(user_to)
        assert.equal(user_to_balance.toNumber(), 102)

        user_from_balance = await videossharing.balanceOf(video_liker)
        assert.equal(user_from_balance.toNumber(), 49)

        user_from2_balance = await videossharing.balanceOf(user_from2)
        assert.equal(user_from2_balance.toNumber(), 49)

        aggregate_subscribers = await videossharing.user_aggregate_subscribers(user_to)
        assert.equal(aggregate_subscribers.toNumber(), 2)

        //PARTITION

        subscribe_result3 = await videossharing.subscribe_user(user_to, {'from': user_from})
        subscribed = await videossharing.user_has_subscribed(user_from, user_to)
        assert.equal(subscribed, false)
        subscribed2 = await videossharing.user_has_subscribed(user_from2, user_to)
        assert.equal(subscribed2, true)

        
        user_to_balance = await videossharing.balanceOf(user_to)
        assert.equal(user_to_balance.toNumber(), 102)

        user_from_balance = await videossharing.balanceOf(video_liker)
        assert.equal(user_from_balance.toNumber(), 49)

        user_from2_balance = await videossharing.balanceOf(user_from2)
        assert.equal(user_from2_balance.toNumber(), 49)

        aggregate_subscribers = await videossharing.user_aggregate_subscribers(user_to)
        assert.equal(aggregate_subscribers.toNumber(), 1)

        
        
        const subscribe_event1 = subscribe_result1.logs[1].args
        const subscribe_event2 = subscribe_result2.logs[1].args
        const subscribe_event3 = subscribe_result3.logs[0].args
        // console.log("______GAP__________")
        // console.log(subscribe_result2);
        

        assert.equal(subscribe_event1._user_to, user_to, 'Event emitted: Channel Owner must be correct')
        assert.equal(subscribe_event1._user_from, user_from, 'Event emitted: Subscriber address should match')

        assert.equal(subscribe_event2._user_to, user_to, 'Event emitted: Channel Owner must be correct')
        assert.equal(subscribe_event2._user_from, user_from2, 'Event emitted: Subscriber address should match')

        assert.equal(subscribe_event3._user_to, user_to, 'Event emitted: Channel Owner must be correct')
        assert.equal(subscribe_event3._user_from, user_from, 'Event emitted: Subscriber address should match')


    

        
        

    //     //Failure: Product must have a name
    //     await marketplace.createProduct('', web3.utils.toWei('1', 'Ether'), {from: seller}).should.be.rejected;

    //     //Failure: Product must have a price
    //    await marketplace.createProduct('iPhone X',0, {from: seller}).should.be.rejected;

    })
    
})


})