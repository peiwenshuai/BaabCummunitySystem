<div class="mdui-card mdui-hoverable">
    <div class="right-focus-info">
        <a onclick="handleShowFollowingsDialog('{{route('userGetFollowings')}}','{{$user->id}}')" class="mdui-btn right-focus-info-item">
            <div class="right-focus-info-item-inner">
                <div class="right-focus-info-item-name">正在关注</div>
                <strong class="right-focus-info-item-value">{{$followingsCount}}</strong>
            </div>
        </a>
        <a onclick="handleShowFollowersDialog('{{route('userGetFollowers')}}','{{$user->id}}')" class="mdui-btn right-focus-info-item">
            <div class="right-focus-info-item-inner">
                <div class="right-focus-info-item-name">关注者</div>
                <strong class="right-focus-info-item-value pc-followerCount">{{$followersCount}}</strong>
            </div>
        </a>
    </div>
</div>