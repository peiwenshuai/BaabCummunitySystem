@extends('frame.indexframe')
@section('title',__('index.news'))
@section('content')
    {{--新闻主页--}}
    <div class="mdui-row">
        <div class="mdui-col-md-8 mdui-col-xs-12 index-carousel">
            {{--大图新闻栏--}}
            @include('news.newspage')
        </div>
        <div class="mdui-col-md-4 mdui-col-xs-12">
            {{--新闻列表--}}
            @include('news.newspage-top-right')
        </div>
    </div>
    {{--新闻卡片--}}
    @include('news.newspage-bottom')
@endsection