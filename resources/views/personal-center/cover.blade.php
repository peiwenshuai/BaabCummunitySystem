<div class="mdui-card user-center-cover userCover" style="background-image: url('{{$user->info->cover_bg_url}}');">
    @if($userIsMe)
        <div class="cover-upload">
            <label for="coverUploadInput">
                <a class="mdui-btn mdui-btn-icon mdui-ripple upload-btn" mdui-tooltip="{content: '{{__('user.uploadCoverTip')}}', position: 'top'}">
                    <i class="mdui-icon material-icons">photo_camera</i>
                </a>
            </label>
            <input class="mdui-hidden" id="coverUploadInput" type="file" onchange="handleCoverUpdate(this,'userCover')" accept="image/jpeg,image/png">
        </div>
    @endif
    <div class="gradient mdui-card-media-covered mdui-card-media-covered-gradient"></div>
    <div class="user-center-cover-info">
        <div class="avatar-box">
            @if($userIsMe)
                <div class="avatar-upload">
                    <label for="personalCenterAvatarUploadInput">
                        <a class="mdui-btn mdui-btn-icon mdui-ripple upload-btn" mdui-tooltip="{content: '{{__('user.uploadAvatarTip')}}', position: 'top'}">
                            <i class="mdui-icon material-icons">photo_camera</i>
                        </a>
                    </label>
                    <input class="mdui-hidden" id="personalCenterAvatarUploadInput" type="file" onchange="handleAvatarUpdate(this,'userAvatar')" accept="image/jpeg,image/png">
                </div>
            @endif
            <img src="{{$user->info->avatar_url}}" class="avatar mdui-hoverable userAvatar">
        </div>
        <div class="username-cover">{{$user->name}}</div>
        <div class="meta">
            @if($user->info->motto)
                <a class="headline">
                    @foreach($user->roles as $role)
                        @switch($role->name)
                            @case('Founder')
                            <span class="layui-badge">{{$role->name}}</span>
                            @break
                            @case('Maintainer')
                            <span class="layui-badge layui-bg-blue">{{$role->name}}</span>
                            @break
                            @case('BanedUser')
                            <span class="layui-badge layui-bg-black">Banned</span>
                            @break
                        @endswitch
                    @endforeach{{$user->info->motto}}</a>
            @else
                <a class="headline">
                    @foreach($user->roles as $role)
                        @switch($role->name)
                            @case('Founder')
                            <span class="layui-badge">{{$role->name}}</span>
                            @break
                            @case('Maintainer')
                            <span class="layui-badge layui-bg-blue">{{$role->name}}</span>
                            @break
                            @case('BanedUser')
                            <span class="layui-badge layui-bg-black">Banned</span>
                            @break
                        @endswitch
                    @endforeach
                    {{__('user.noMotto')}}</a>
            @endif

        </div>
        @if($userIsMe)
            <a onclick="openEditUserInfoDialog()" class="right-btn mdui-btn mdui-btn-raised">{{__('user.editProfile')}}</a>
        @else
            @if(Auth::check() && $user->isFollowedBy(Auth::user()))
                <a onclick="ajaxHandleFollowUser('{{route('userFollowOther')}}','{{route('userUnfollowOther')}}','{{$user->id}}',this,'pc-followerCount')" class="right-btn mdui-btn mdui-color-pink-accent mdui-btn-raised">
                    <i class="mdui-icon material-icons" style="margin-top: -2px;font-size: 20px;">&#xe87d;</i>
                    <span>{{__('user.followed')}}</span>
                </a>
            @else
                <a onclick="ajaxHandleFollowUser('{{route('userFollowOther')}}','{{route('userUnfollowOther')}}','{{$user->id}}',this,'pc-followerCount')" class="right-btn mdui-btn mdui-text-color-pink-accent mdui-btn-raised">
                    <i class="mdui-icon material-icons" style="margin-top: -2px;font-size: 20px;">&#xe87e;</i>
                    <span>{{__('user.follow')}}</span>
                </a>
            @endif

        @endif
    </div>
</div>