@php($isAllEmpty = true)
@if($user_collection->isNotEmpty())
    @php($isAllEmpty = false)
    <div class="mdui-card mdui-m-t-1" style="border-radius: 10px">
        <div class="search-card-header">
            <i class="mdui-icon material-icons">account_circle</i> {{__('discover.users')}}
        </div>
        <div class="search-card-content">
            @include('discover-search-res.left-list-user-data')
            <div id="UsersLoadingBtn" class="mdui-m-y-1" style="">
                <button onclick="ajaxLoadSearchUsers()" class="mdui-btn mdui-color-pink-a200 mdui-ripple mdui-center">
                    <i class="mdui-icon material-icons mdui-icon-left">&#xe627;</i>
                    {{__('layout.loadMore')}}
                </button>
            </div>
            <div id="UsersLoadingTip" class="mdui-m-y-1" style="display:none">
                <div class="mdui-spinner mdui-spinner-colorful mdui-center"></div>
                <span class="loading-tip-text">{{__('layout.loadingMore')}}</span>
            </div>
            <div id="UsersLoadingFailed" class="animated fadeIn faster" style="display:none">
                <i class="mdui-icon material-icons mdui-center mdui-text-color-grey-600">mood_bad</i>
                <span class="loading-tip-text">{{__('layout.noAnyMore')}}</span>
            </div>
        </div>
    </div>
@endif

@if($isAllEmpty)
    @include('discover-search-res.all-empty-res')
@endif
