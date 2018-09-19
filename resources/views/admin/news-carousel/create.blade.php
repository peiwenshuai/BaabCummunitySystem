@extends('frame.adminframe')
@section('title',__('admin.newsCenterCarousel'))
@section('subtitleUrl',route('adminNewsCarouselsList'))
@section('adminDrawerActiveVal','drawer-newsOtherItem')

@section('content')
        <form id="createNewsCarouselForm" method="post" action="{{route('adminNewsCarouselStore')}}">
            {{csrf_field()}}
            <h3 class="admin-title mdui-text-color-indigo">{{__('admin/news.createNewsCarousel')}}</h3>

            @include('admin.layout.msg')
            <div class="mdui-row">
                <div class="mdui-textfield mdui-textfield-floating-label mdui-col-xs-12 mdui-col-sm-10 mdui-col-md-6">
                    <h3 class="admin-index-title mdui-text-color-indigo">1.{{__('admin.carouselTitle')}}</h3>
                    <input class="mdui-textfield-input" name="title" required/>
                </div>
            </div>

            <div class="mdui-textfield mdui-textfield-floating-label ">
                <h3 class="admin-index-title mdui-text-color-indigo">2.{{__('admin.carouselSubtitle')}}</h3>
                <input class="mdui-textfield-input" name="subtitle" required>
            </div>

            <div class="mdui-textfield mdui-textfield-floating-label ">
                <h3 class="admin-index-title mdui-text-color-indigo">3.{{__('admin.jumpLink')}}
                    <br><small class="show-file-title-sub">{{__('admin.jumpLinkTip')}}</small>
                </h3>
                <input class="mdui-textfield-input" name="url" placeholder="http(s)://" required>
            </div>

            <h3 class="admin-index-title mdui-text-color-indigo">4.{{__('admin.imgUpload')}}
                <br><small class="show-file-title-sub">{{__('admin/news.newsCarouselImgUploadTip')}}</small></h3>
            <label for="newsCoverUploadInput">
                <img src="/imgs/default_news_cover.png" class="avatar mdui-hoverable newsCover" style="width: 400px; height: 200px">
            </label>
            <input class="mdui-hidden" id="newsCoverUploadInput" type="file" onchange="handleNewsCarouselUpdate(this,'newsCover')" accept="image/jpeg,image/png">
            <input class="mdui-hidden" type="text" name="cover_img" required>

            <h3 class="admin-index-title mdui-text-color-indigo">5.{{__('admin.priority')}}
                <br><small class="show-file-title-sub">{{__('admin.carouselPriorityTip1')}}</small>
                <br><small class="show-file-title-sub">{{__('admin.carouselPriorityTip2')}}</small></h3>
            <label class="mdui-slider mdui-slider-discrete">
                <input type="range" step="1" min="0" max="20" value="0" name="order"/>
            </label>

            <div class="mdui-divider" style="margin-top: 50px"></div>
            <button onclick="formPublicSubmit('#createNewsCarouselForm')" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-pink-accent admin-btn"><i class="mdui-icon material-icons mdui-icon-left">add</i>{{__('admin.publish')}}</button>
            <button onclick="formHiddenSubmit('#createNewsCarouselForm')" class="mdui-btn mdui-btn-raised mdui-ripple admin-btn"><i class="mdui-icon material-icons mdui-icon-left">local_cafe</i>{{__('community.save')}}</button>
            <a href="{{route('adminNewsCarouselsList')}}" class="mdui-btn mdui-btn-raised mdui-ripple admin-btn"><i class="mdui-icon material-icons mdui-icon-left">arrow_back</i>{{__('index.back')}}</a>
            <div class="mdui-divider" style="margin-bottom: 200px"></div>



        </form>
        <!--/内容-->
@endsection
