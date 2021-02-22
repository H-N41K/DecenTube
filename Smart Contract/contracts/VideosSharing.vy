struct Video:
    path: bytes[50]
    title: bytes[200]

Transfer: event({_from: indexed(address), _to: indexed(address), _value: uint256})
Approval: event({_owner: indexed(address), _spender: indexed(address), _value: uint256})
UploadVideo: event({_user: indexed(address), _index: uint256})
LikeVideo: event({_video_liker: indexed(address), _video_uploader: indexed(address), _index: uint256})
UnlikeVideo: event({_video_liker: indexed(address), _video_uploader: indexed(address), _index: uint256})
DislikeVideo: event({_video_liker: indexed(address), _video_uploader: indexed(address), _index: uint256})
UndislikeVideo: event({_video_liker: indexed(address), _video_uploader: indexed(address), _index: uint256})
Subscribe: event({_user_from: indexed(address), _user_to: indexed(address)})
Unsubscribe: event({_user_from: indexed(address), _user_to: indexed(address)})
BuyTokens: event({_buyer: indexed(address), _amount: uint256})
SellTokens: event({_seller: indexed(address), _amount: uint256})

user_videos_index: map(address, uint256)

name: public(bytes[20])
symbol: public(bytes[3])
totalSupply: public(uint256)
decimals: public(uint256)
balances: map(address, uint256)
allowed: map(address, map(address, uint256))

all_videos: map(address, map(uint256, Video))

likes_videos: map(bytes[100], bool)
dislikes_videos: map(bytes[100], bool)
subscribes_users: map(bytes[100], bool)

aggregate_likes: map(bytes[100], uint256)
aggregate_dislikes: map(bytes[100], uint256)

aggregate_subscribers: map(bytes32, uint256)

admin: address
tokenBuyPrice: public(uint256)
tokenSellPrice: public(uint256)
tokensSold: public(uint256)
lastTokenBuyTime: map(address, timestamp)
lastTokenSellTime: map(address, timestamp)

@public
def __init__():
    _initialSupply: uint256 = 500
    _decimals: uint256 = 3
    self.totalSupply = _initialSupply * 10 ** _decimals
    self.balances[msg.sender] = self.totalSupply
    self.name = 'DecenTube Coin'
    self.symbol = 'DTC'
    self.decimals = _decimals


    self.admin = msg.sender
    self.tokenBuyPrice = 490000000000000
    #5 rupees for buying a token (15th Dec)
    self.tokenSellPrice = 470000000000000
    #4.75 rupees for selling a token (15th Dec)
    
    log.Transfer(ZERO_ADDRESS, msg.sender, self.totalSupply)

@public
@constant
def balanceOf(_owner: address) -> uint256:
    return self.balances[_owner]

@private
def _transfer(_source: address, _to: address, _amount: uint256) -> bool:
    assert self.balances[_source] >= _amount
    self.balances[_source] -= _amount
    self.balances[_to] += _amount
    log.Transfer(_source, _to, _amount)

    return True

@public
def transfer(_to: address, _amount: uint256) -> bool:
    return self._transfer(msg.sender, _to, _amount)

@public
def transferFrom(_from: address, _to: address, _value: uint256) -> bool:
    assert _value <= self.allowed[_from][msg.sender]
    assert _value <= self.balances[_from]

    self.balances[_from] -= _value
    self.allowed[_from][msg.sender] -= _value
    self.balances[_to] += _value
    log.Transfer(_from, _to, _value)

    return True

@public
def approve(_spender: address, _amount: uint256) -> bool:
    self.allowed[msg.sender][_spender] = _amount
    log.Approval(msg.sender, _spender, _amount)

    return True

@public
@constant
def allowance(_owner: address, _spender: address) -> uint256:
    return self.allowed[_owner][_spender]

@public
def upload_video(_video_path: bytes[50], _video_title: bytes[200]) -> bool:
    _index: uint256 = self.user_videos_index[msg.sender]

    self.all_videos[msg.sender][_index] = Video({ path: _video_path, title: _video_title })
    self.user_videos_index[msg.sender] += 1

    log.UploadVideo(msg.sender, _index)

    return True

@public
@constant
def latest_videos_index(_user: address) -> uint256:
    return self.user_videos_index[_user]

@public
@constant
def videos_path(_user: address, _index: uint256) -> bytes[50]:
    return self.all_videos[_user][_index].path

@public
@constant
def videos_title(_user: address, _index: uint256) -> bytes[200]:
    return self.all_videos[_user][_index].title

@public
def rename_videos_title(_user: address, _index: uint256, _new_video_title: bytes[200]) -> bool:
    assert (msg.sender == _user)
    self.all_videos[msg.sender][_index].title = _new_video_title

    return True

@public
def like_video(_user: address, _index: uint256) -> bool:
    _msg_sender_str: bytes32 = convert(msg.sender, bytes32)
    _user_str: bytes32 = convert(_user, bytes32)
    _index_str: bytes32 = convert(_index, bytes32)
    _key: bytes[100] = concat(_msg_sender_str, _user_str, _index_str)
    _likes_key: bytes[100] = concat(_user_str, _index_str)

    assert _index < self.user_videos_index[_user]
    if self.likes_videos[_key] == False:

        #Check if Disliked already
        if self.dislikes_videos[_key] == True:
            self.dislikes_videos[_key] = False
            self.aggregate_dislikes[_likes_key] -= 1

        self.likes_videos[_key] = True
        self.aggregate_likes[_likes_key] += 1
        self._transfer(msg.sender, _user, 4)
        self._transfer(msg.sender, self.admin, 1)
        #20% cut
        log.LikeVideo(msg.sender, _user, _index)

        return True
        
    elif self.likes_videos[_key] == True:
        self.likes_videos[_key] = False
        self.aggregate_likes[_likes_key] -= 1
        log.UnlikeVideo(msg.sender, _user, _index)

        return True

    return False



@public
def dislike_video(_user: address, _index: uint256) -> bool:
    _msg_sender_str: bytes32 = convert(msg.sender, bytes32)
    _user_str: bytes32 = convert(_user, bytes32)
    _index_str: bytes32 = convert(_index, bytes32)
    _key: bytes[100] = concat(_msg_sender_str, _user_str, _index_str)
    _dislikes_key: bytes[100] = concat(_user_str, _index_str)

    assert _index < self.user_videos_index[_user]
    if self.dislikes_videos[_key] == False:

        #Check if Liked already
        if self.likes_videos[_key] == True:
            self.likes_videos[_key] = False
            self.aggregate_likes[_dislikes_key] -= 1

        self.dislikes_videos[_key] = True
        self.aggregate_dislikes[_dislikes_key] += 1
        self._transfer(msg.sender, self.admin, 5)
        log.DislikeVideo(msg.sender, _user, _index)

        return True
        
    elif self.dislikes_videos[_key] == True:
        self.dislikes_videos[_key] = False
        self.aggregate_dislikes[_dislikes_key] -= 1
        log.UndislikeVideo(msg.sender, _user, _index)

        return True

    return False


@public
@constant
def video_has_been_liked(_user_like: address, _user_video: address, _index: uint256) -> bool:
    _user_like_str: bytes32 = convert(_user_like, bytes32)
    _user_video_str: bytes32 = convert(_user_video, bytes32)
    _index_str: bytes32 = convert(_index, bytes32)
    _key: bytes[100] = concat(_user_like_str, _user_video_str, _index_str)

    return self.likes_videos[_key]

@public
@constant
def video_has_been_disliked(_user_dislike: address, _user_video: address, _index: uint256) -> bool:
    _user_dislike_str: bytes32 = convert(_user_dislike, bytes32)
    _user_video_str: bytes32 = convert(_user_video, bytes32)
    _index_str: bytes32 = convert(_index, bytes32)
    _key: bytes[100] = concat(_user_dislike_str, _user_video_str, _index_str)

    return self.dislikes_videos[_key]

@public
@constant
def video_aggregate_likes(_user_video: address, _index: uint256) -> uint256:
    _user_video_str: bytes32 = convert(_user_video, bytes32)
    _index_str: bytes32 = convert(_index, bytes32)
    _key: bytes[100] = concat(_user_video_str, _index_str)

    return self.aggregate_likes[_key]

@public
@constant
def video_aggregate_dislikes(_user_video: address, _index: uint256) -> uint256:
    _user_video_str: bytes32 = convert(_user_video, bytes32)
    _index_str: bytes32 = convert(_index, bytes32)
    _key: bytes[100] = concat(_user_video_str, _index_str)

    return self.aggregate_dislikes[_key]


@public
def subscribe_user(_user_to: address) -> bool:
    assert _user_to != msg.sender

    _user_from_str: bytes32 = convert(msg.sender, bytes32)
    _user_to_str: bytes32 = convert(_user_to, bytes32)
    _key: bytes[100] = concat(_user_from_str, _user_to_str)
    _subscribes_key: bytes32 = _user_to_str

    if self.subscribes_users[_key] == False:

        self.subscribes_users[_key] = True
        self.aggregate_subscribers[_subscribes_key] += 1
        self._transfer(msg.sender, _user_to, 4)
        self._transfer(msg.sender, self.admin, 1)
        #20% CUT
        log.Subscribe(msg.sender, _user_to)

        return True
        
    elif self.subscribes_users[_key] == True:
        self.subscribes_users[_key] = False
        self.aggregate_subscribers[_subscribes_key] -= 1
        log.Unsubscribe(msg.sender, _user_to)

        return True
    
    return False

@public
@constant
def user_has_subscribed(_user_from: address, _user_to: address) -> bool:
    _user_from_str: bytes32 = convert(_user_from, bytes32)
    _user_to_str: bytes32 = convert(_user_to, bytes32)
    _key: bytes[100] = concat(_user_from_str, _user_to_str)

    return self.subscribes_users[_key]

@public
@constant
def user_aggregate_subscribers(_user: address) -> uint256:
    _user_str: bytes32 = convert(_user, bytes32)
    _key: bytes32 = _user_str

    return self.aggregate_subscribers[_key]

@private
@constant
def multiply(x: uint256, y:uint256) -> uint256:
    assert(y == 0 or (x * y) / y == x)
    z:uint256 = x * y

    return z

@public
@payable
def buyTokens (_numberOfTokens: uint256) -> bool:

    assert(block.timestamp > self.lastTokenBuyTime[msg.sender] + 604800)
    #ONE WEEK GAP
    assert(msg.value == self.multiply(_numberOfTokens, self.tokenBuyPrice))
    assert(_numberOfTokens <= 1000)
    assert(self.balances[self.admin] >= _numberOfTokens)

    self._transfer(self.admin, msg.sender, _numberOfTokens)

    self.tokensSold += _numberOfTokens

    self.lastTokenBuyTime[msg.sender] = block.timestamp

    log.BuyTokens(msg.sender, _numberOfTokens)
    return True

@public
def sellTokens (_numberOfTokens: uint256) -> bool:

    assert(block.timestamp > self.lastTokenSellTime[msg.sender] + 604800)
    #ONE WEEK GAP
    assert(_numberOfTokens <= 1000)
    assert(self.balances[msg.sender] >= _numberOfTokens)

    _amount_to_pay_user: uint256 = self.multiply(_numberOfTokens, self.tokenSellPrice)

    self._transfer(msg.sender, self.admin, _numberOfTokens)
    send(msg.sender, _amount_to_pay_user)
    self.tokensSold -= _numberOfTokens
    self.lastTokenSellTime[msg.sender] = block.timestamp
    log.SellTokens(msg.sender, _numberOfTokens)
    return True

@public
@constant
def getContractEthBalance() -> uint256(wei):
    assert (msg.sender == self.admin)
    return self.balance


@public
def withdrawContractEthBalance(_amount: uint256) -> bool:
    assert (msg.sender == self.admin)
    assert(_amount <= self.balance)
    send(msg.sender, _amount)
    return True

@public
@payable
def __default__() -> bool:
    assert (msg.sender == self.admin)
    return True

@public
@constant
def getBuyTimeStampValue(_user: address) -> timestamp:
    return self.lastTokenBuyTime[_user]

@public
@constant
def getSellTimeStampValue(_user: address) -> timestamp:
    return self.lastTokenSellTime[_user]

@public
@payable
def destroyEntireSmartContract() -> bool:
    assert (msg.sender == self.admin)
    selfdestruct(self.admin)

    


