@foreach($users as $user)
    <li class="mdui-list-item mdui-ripple user-list-item">
        <a href="{{route('showPersonalCenter',$user->id)}}">
            <div class="mdui-list-item-avatar"><img src="{{$user->info->avatar_url}}"/></div>
        </a>
        <div class="mdui-list-item-content">
            <div class="mdui-list-item-title">{{$user->name}}
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
                @endforeach</div>
            <div class="mdui-list-item-text mdui-list-item-one-line"> -
                @if($user->info->motto)
                    {{$user->info->motto}}
                @else
                    {{__('user.noMotto')}}
                @endif
            </div>
            @if($user->id != Auth::id())
                @if($user->isFollowedBy(Auth::user()))
                    <a onclick="ajaxHandleFollowUser('{{route('userFollowOther')}}','{{route('userUnfollowOther')}}','{{$user->id}}',this)" class="mdui-btn mdui-btn-dense mdui-color-pink-accent">
                        <i class="mdui-icon material-icons mdui-icon-left">&#xe87d;</i>
                        <span>{{__('user.followed')}}</span>
                    </a>
                @else
                    <a onclick="ajaxHandleFollowUser('{{route('userFollowOther')}}','{{route('userUnfollowOther')}}','{{$user->id}}',this)" class="mdui-btn mdui-btn-dense mdui-text-color-pink-accent">
                        <i class="mdui-icon material-icons mdui-icon-left">&#xe87e;</i>
                        <span>{{__('user.follow')}}</span>
                    </a>
                @endif
            @endif

        </div>
    </li>
    <li class="mdui-divider-inset mdui-m-y-0"></li>
@endforeach