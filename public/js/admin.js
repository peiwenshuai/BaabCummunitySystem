//表单提交按钮
function formPublicSubmit(formid) {
    var tmpStatusInput = $$("<input class='mdui-hidden' type='text' name='status' value='publish'/>");
    tmpStatusInput.appendTo(formid);
    $$(formid).submit();
}
function formHiddenSubmit(formid) {
    var tmpStatusInput = $$("<input class='mdui-hidden' type='text' name='status' value='hidden'/>");
    tmpStatusInput.appendTo(formid);
    $$(formid).submit();
}

$$(function () {
    //后台侧边栏展开激活
    var adminDrawerMenuCollapse = new mdui.Collapse('#adminDrawerMenu',{accordion:true});
    var adminDrawerActiveVal = $$('#adminDrawerActiveVal').text();

    adminDrawerMenuCollapse.open('#'+adminDrawerActiveVal);
    $$('#'+adminDrawerActiveVal).addClass('mdui-list-item-active');
});



//新闻分类部分

/**
 * 删除新闻分类
 * @param catId
 * @param catName
 */
function deleteNewsCategory(catId,catName) {
    mdui.dialog({
        title: '删除新闻分类',
        content: '您确定要删除此新闻分类吗<br/>'+catName,
        buttons: [
            {
                text: '取消'
            },
            {
                text: '确认',
                onClick: function(inst){
                    $$.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $$('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: '/admin/news-category/delete',
                        data: {
                            id:catId
                        },
                        statusCode: {
                            500: function (xhr, textStatus) {
                                mdui.alert('Server internal error<br/>服务器内部错误');
                            }
                        },
                        success: function (data) {
                            data = JSON.parse(data)
                            if (data.status ===1) {
                                mdui.snackbar({
                                    message:data.msg,
                                    position:'top'
                                });
                                setTimeout(function(){
                                    //使用  setTimeout（）方法设定定时5000毫秒
                                    window.location.reload();//页面刷新
                                },2000);
                            } else {
                                mdui.snackbar(data.msg,{
                                    position:'top',
                                    timeout:0,
                                    buttonText:'ok'
                                });
                            }

                        }
                    });
                }
            }
        ]
    });
}

/**
 * 获取表格中选择的项的id
 * @returns {Array}
 */
function getSelectedIds() {
    var ids=[];
    var result = $$('.mdui-table-row').map(function () {
        //判断如果选择则push进数组
        if ($$(this).hasClass('mdui-table-row-selected')) {
            ids.push($$(this).attr('id'));
        }
    });
    return ids;
}

/**
 * 获取表格中选择的项的name
 * @returns {Array}
 */
function getSelectedNames() {
    var names=[];
    var result = $$('.mdui-table-row').map(function () {
        //判断如果选择则push进数组
        if ($$(this).hasClass('mdui-table-row-selected')) {
            names.push($$(this).attr('name'));
        }
    });
    return names;
}

/**
 * 批量删除新闻分类
 */
function deleteNewsCategories() {
    //获取选中对象数组
    var ids=getSelectedIds();
    var names=getSelectedNames();
    //弹出确认对话框
    mdui.dialog({
        title: '批量删除新闻分类',
        content: '您确定要删除我们吗<br/>'+names,
        buttons: [
            {
                text: '取消'
            },
            {
                text: '确认',
                onClick: function(inst){
                    $$.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $$('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: '/admin/news-category/deletes',
                        data: {
                            ids:ids
                        },
                        statusCode: {
                            500: function (xhr, textStatus) {
                                mdui.alert('服务器内部错误');
                            }
                        },
                        success: function (data) {
                            data=JSON.parse(data);
                            if (data.status ===1) {
                                mdui.snackbar({
                                    message:data.msg,
                                    position:'top'
                                });
                                setTimeout(function(){
                                    //使用  setTimeout（）方法设定定时5000毫秒
                                    window.location.reload();//页面刷新
                                },2000);
                            } else {
                                mdui.snackbar({
                                    message:data.msg,
                                    position:'top',
                                    timeout:0,
                                    buttonText:'OK',
                                    buttonColor:'pink',
                                    onButtonClick: function(){
                                        window.location.reload();//页面刷新
                                    }
                                });
                            }

                        }
                    });
                }
            }
        ]
    });
}

/**
 * 删除新闻轮播图
 * @param id
 * @param name
 */
function deleteNewsCarousel(id,name) {
    mdui.dialog({
        title: '删除新闻轮播图',
        content: '您确定要删除此新闻轮播图吗<br/>'+name,
        buttons: [
            {
                text: '取消'
            },
            {
                text: '确认',
                onClick: function(inst){
                    $$.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $$('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: '/admin/news-carousel/delete',
                        data: {
                            id:id
                        },
                        statusCode: {
                            500: function (xhr, textStatus) {
                                mdui.alert('Server internal error<br/>服务器内部错误');
                            }
                        },
                        success: function (data) {
                            data = JSON.parse(data);
                            if (data.status ===1) {
                                mdui.snackbar({
                                    message:data.msg,
                                    position:'top'
                                });
                                setTimeout(function(){
                                    //使用  setTimeout（）方法设定定时5000毫秒
                                    window.location.reload();//页面刷新
                                },2000);
                            } else {
                                mdui.snackbar(data.msg,{
                                    position:'top',
                                    timeout:0,
                                    buttonText:'ok'
                                });
                            }

                        }
                    });
                }
            }
        ]
    });
}


//新闻编辑器
var E = window.wangEditor;
if ($$('#editorToolbar').length>0){
    var editor = new E('#editorToolbar','#editorText');
    var textArea = $$('#editorTextArea');
    editor.customConfig.onchange = function (html) {
        // 监控变化，同步更新到 textarea
        textArea.val(html);
    };
    editor.customConfig.zIndex = 0;
    editor.customConfig.lang = {
        '设置标题': 'title',
        '正文': 'p',
        '链接文字': 'link text',
        '链接': 'link',
        '上传图片': 'upload image',
        '上传': 'upload',
        '创建': 'init'
        // 还可自定添加更多
    };
    switch ($$('#editorToolbar').attr('type')){
        case 'community-topic':
            editor.customConfig.uploadImgServer = '/community/topic/upload/img';
            break;
        case 'news':
            editor.customConfig.uploadImgServer = '/admin/news/upload/img';
            break;
        case 'news-reply':
            editor.customConfig.uploadImgServer = '/news/reply/upload/img';
            editor.customConfig.menus = [
                'emoticon',  // 表情
                'image', // 插入图片
                'bold',  // 粗体
                'italic',  // 斜体
                'underline',  // 下划线
                'quote'  // 引用
            ];
            break;
    }
    editor.customConfig.uploadImgHeaders = {
        'X-CSRF-TOKEN': $$('meta[name="csrf-token"]').attr('content'),
        'X-Requested-With': 'XMLHttpRequest'
    };
    editor.customConfig.uploadFileName = 'img[]';
    editor.create();
    // 初始化 textarea 的值
    textArea.val(editor.txt.html());
}

/**
 * 处理新闻封面上传
 * @param obj
 * @param className
 */
function handleNewsCoverUpdate(obj,className) {
    var coverImg = $$('.'+className);
    var coverInput = $$('input[name="cover_img"]');
    var cover = obj.files[0];
    var id = $$('input[name="userId"]').val();

    var form = new FormData();
    form.append('cover',cover);
    $$.ajax({
        method: 'POST',
        url: '/admin/news/upload/cover',
        headers: {
            'X-CSRF-TOKEN': $$('meta[name="csrf-token"]').attr('content')
        },
        data: form,
        contentType: false, //禁止设置请求类型
        processData: false, //禁止jquery对DAta数据的处理,默认会处理
        //禁止的原因是,FormData已经帮我们做了处理
        success: function (data) {
            data=JSON.parse(data);
            if (data.status===1){
                coverImg.attr('src',data.src);
                coverInput.val(data.src);
                mdui.snackbar({
                    message:'The Cover has been uploaded successfully<br/>封面已成功上传',
                    position:'top'
                });
            }
        }
    });

}

/**
 * 处理新闻轮播图上传
 * @param obj
 * @param className
 */
function handleNewsCarouselUpdate(obj,className) {
    var coverImg = $$('.'+className);
    var coverInput = $$('input[name="cover_img"]');
    var cover = obj.files[0];
    var id = $$('input[name="userId"]').val();

    var form = new FormData();
    form.append('cover',cover);
    $$.ajax({
        method: 'POST',
        url: '/admin/news-carousel/upload',
        headers: {
            'X-CSRF-TOKEN': $$('meta[name="csrf-token"]').attr('content')
        },
        data: form,
        contentType: false, //禁止设置请求类型
        processData: false, //禁止jquery对DAta数据的处理,默认会处理
        //禁止的原因是,FormData已经帮我们做了处理
        success: function (data) {
            data=JSON.parse(data);
            if (data.status===1){
                coverImg.attr('src',data.src);
                coverInput.val(data.src);
                mdui.snackbar({
                    message:'The Cover has been uploaded successfully<br/>封面已成功上传',
                    position:'top'
                });
            }
        }
    });

}
//新闻失效日期选择
if ($$('#selInvalidedAt').length>0){
    layui.use('laydate', function(){
        var laydate = layui.laydate;
        //执行一个laydate实例
        laydate.render({
            elem: '#selInvalidedAt', //指定元素
            type:'datetime',
            lang: 'en'
        });
    });
}

/**
 * 删除新闻
 * @param newsId
 * @param newsTitle
 */
function deleteNews(newsId,newsTitle) {
    mdui.dialog({
        title: '删除新闻',
        content: '您确定要删除此新闻吗<br/>'+newsTitle,
        buttons: [
            {
                text: '取消'
            },
            {
                text: '确认',
                onClick: function(inst){
                    $$.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $$('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: '/admin/news/delete',
                        data: {
                            id:newsId
                        },
                        statusCode: {
                            500: function (xhr, textStatus) {
                                mdui.alert('Server internal error<br/>服务器内部错误');
                            }
                        },
                        success: function (data) {
                            data = JSON.parse(data)
                            if (data.status ===1) {
                                mdui.snackbar({
                                    message:data.msg,
                                    position:'top'
                                });
                                setTimeout(function(){
                                    //使用  setTimeout（）方法设定定时5000毫秒
                                    window.location.reload();//页面刷新
                                },2000);
                            } else {
                                mdui.snackbar(data.msg,{
                                    position:'top',
                                    timeout:0,
                                    buttonText:'ok'
                                });
                            }

                        }
                    });
                }
            }
        ]
    });
}
/**
 * 批量删除新闻
 */
function deleteNewses() {
    //获取选中对象数组
    var ids=getSelectedIds();
    var titles=getSelectedNames();
    //弹出确认对话框
    mdui.dialog({
        title: '批量删除新闻',
        content: '您确定要删除我们吗<br/>'+titles,
        buttons: [
            {
                text: '取消'
            },
            {
                text: '确认',
                onClick: function(inst){
                    $$.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $$('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: '/admin/news/deletes',
                        data: {
                            ids:ids
                        },
                        statusCode: {
                            500: function (xhr, textStatus) {
                                mdui.alert('服务器内部错误');
                            }
                        },
                        success: function (data) {
                            data=JSON.parse(data);
                            if (data.status ===1) {
                                mdui.snackbar({
                                    message:data.msg,
                                    position:'top'
                                });
                                setTimeout(function(){
                                    //使用  setTimeout（）方法设定定时5000毫秒
                                    window.location.reload();//页面刷新
                                },2000);
                            } else {
                                mdui.snackbar(data.msg,{
                                    position:'top',
                                    timeout:0,
                                    buttonText:'ok'
                                });
                            }

                        }
                    });
                }
            }
        ]
    });
}

/**
 * 删除新闻回复
 * @param newsReplyId
 * @param newsReplyContent
 */
function deleteNewsReply(newsReplyId,newsReplyContent) {
    mdui.dialog({
        title: '删除新闻回复',
        content: '您确定要删除此新闻回复吗<br/>'+newsReplyContent,
        buttons: [
            {
                text: '取消'
            },
            {
                text: '确认',
                onClick: function(inst){
                    $$.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $$('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: '/admin/news/reply/delete',
                        data: {
                            id:newsReplyId
                        },
                        statusCode: {
                            500: function (xhr, textStatus) {
                                mdui.alert('Server internal error<br/>服务器内部错误');
                            }
                        },
                        success: function (data) {
                            data = JSON.parse(data);
                            if (data.status ===1) {
                                mdui.snackbar({
                                    message:data.msg,
                                    position:'top'
                                });
                                setTimeout(function(){
                                    //使用  setTimeout（）方法设定定时5000毫秒
                                    window.location.reload();//页面刷新
                                },2000);
                            } else {
                                mdui.snackbar(data.msg,{
                                    position:'top',
                                    timeout:0,
                                    buttonText:'ok'
                                });
                            }

                        }
                    });
                }
            }
        ]
    });
}
/**
 * 批量删除新闻回复
 */
function deleteNewsReplies() {
    //获取选中对象数组
    var ids=getSelectedIds();
    var titles=getSelectedNames();
    //弹出确认对话框
    mdui.dialog({
        title: '批量删除新闻回复',
        content: '您确定要删除我们吗<br/>'+titles,
        buttons: [
            {
                text: '取消'
            },
            {
                text: '确认',
                onClick: function(inst){
                    $$.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $$('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: '/admin/news/reply/deletes',
                        data: {
                            ids:ids
                        },
                        statusCode: {
                            500: function (xhr, textStatus) {
                                mdui.alert('服务器内部错误');
                            }
                        },
                        success: function (data) {
                            data=JSON.parse(data);
                            if (data.status ===1) {
                                mdui.snackbar({
                                    message:data.msg,
                                    position:'top'
                                });
                                setTimeout(function(){
                                    //使用  setTimeout（）方法设定定时5000毫秒
                                    window.location.reload();//页面刷新
                                },2000);
                            } else {
                                mdui.snackbar({
                                    message:data.msg,
                                    position:'top',
                                    timeout:0,
                                    buttonText:'OK',
                                    buttonColor:'pink',
                                    onButtonClick: function(){
                                        window.location.reload();//页面刷新
                                    }
                                });
                            }

                        }
                    });
                }
            }
        ]
    });
}

/**
 * 处理zone封面图上传
 * @param obj
 * @param className
 */
function handleZoneImgUpdate(obj,className) {
    var Img = $$('.'+className);
    var Input = $$('input[name="img_url"]');
    var file = obj.files[0];

    var form = new FormData();
    form.append('img',file);
    $$.ajax({
        method: 'POST',
        url: '/admin/community/category/zones/upload/img',
        headers: {
            'X-CSRF-TOKEN': $$('meta[name="csrf-token"]').attr('content')
        },
        data: form,
        contentType: false, //禁止设置请求类型
        processData: false, //禁止jquery对DAta数据的处理,默认会处理
        //禁止的原因是,FormData已经帮我们做了处理
        success: function (data) {
            data=JSON.parse(data);
            if (data.status===1){
                Img.attr('src',data.src);
                Input.val(data.src);
                mdui.snackbar({
                    message:'The Cover has been uploaded successfully<br/>封面已成功上传',
                    position:'top'
                });
            }
        }
    });

}

//社区分类管理页collapse
var adminCommunityCategoryCollapse = new mdui.Collapse('#adminCommunityCategoryCollapse');

function adminCommunityCatOpenAll(){
    adminCommunityCategoryCollapse.openAll()
}
function adminCommunityCatCloseAll(){
    adminCommunityCategoryCollapse.closeAll()
}

/**
 * 删除社区zone
 * @param zoneId
 * @param zoneContent
 */
function deleteCommunityZone(zoneId,zoneContent) {
    mdui.dialog({
        title: '删除新闻回复',
        content: '您确定要删除此社区分区吗<br/>'+zoneContent,
        buttons: [
            {
                text: '取消'
            },
            {
                text: '确认',
                onClick: function(inst){
                    $$.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $$('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: '/admin/community/category/zone/delete',
                        data: {
                            id:zoneId
                        },
                        statusCode: {
                            500: function (xhr, textStatus) {
                                mdui.alert('Server internal error<br/>服务器内部错误');
                            }
                        },
                        success: function (data) {
                            data = JSON.parse(data);
                            if (data.status ===1) {
                                mdui.snackbar({
                                    message:data.msg,
                                    position:'top'
                                });
                                setTimeout(function(){
                                    //使用  setTimeout（）方法设定定时5000毫秒
                                    window.location.reload();//页面刷新
                                },2000);
                            } else {
                                mdui.snackbar({
                                    message:data.msg,
                                    position:'top'
                                });
                            }

                        }
                    });
                }
            }
        ]
    });
}


/**
 * 删除社区section
 * @param sectionId
 * @param sectionContent
 */
function deleteCommunitySection(sectionId,sectionContent) {
    mdui.dialog({
        title: '删除新闻回复',
        content: '您确定要删除此社区板块吗<br/>'+sectionContent,
        buttons: [
            {
                text: '取消'
            },
            {
                text: '确认',
                onClick: function(inst){
                    $$.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $$('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: '/admin/community/category/section/delete',
                        data: {
                            id:sectionId
                        },
                        statusCode: {
                            500: function (xhr, textStatus) {
                                mdui.alert('Server internal error<br/>服务器内部错误');
                            }
                        },
                        success: function (data) {
                            data = JSON.parse(data);
                            if (data.status ===1) {
                                mdui.snackbar({
                                    message:data.msg,
                                    position:'top'
                                });
                                setTimeout(function(){
                                    //使用  setTimeout（）方法设定定时5000毫秒
                                    window.location.reload();//页面刷新
                                },2000);
                            } else {
                                mdui.snackbar({
                                    message:data.msg,
                                    position:'top'
                                });
                            }

                        }
                    });
                }
            }
        ]
    });
}

//初始化新建话题页面选择section
var adminSelectSection = new mdui.Select('#adminSelectSection',{position: 'bottom'});

function handleSelGetSections(zoneId,classToAppend){
    $$.ajax({
        method: 'POST',
        url: '/admin/community/category/getSectionsByZoneId',
        headers: {
            'X-CSRF-TOKEN': $$('meta[name="csrf-token"]').attr('content')
        },
        data:{
            id:zoneId
        },
        success: function (data) {
            data=JSON.parse(data);
            var sectionsHtmlToAppend='<option value="null">请选择分区</option>';
            $$.each(data.sections,function (i,value) {
                sectionsHtmlToAppend+='<option value="'+value.id+'">'+value.name+'</option>'
            });
            $$('.'+classToAppend).empty();
            $$('.'+classToAppend).append(sectionsHtmlToAppend);
            adminSelectSection.handleUpdate();
        }
    });

}

/**
 * 删除社区话题
 * @param topicId
 * @param topicContent
 */
function deleteCommunityTopic(topicId,topicContent) {
    mdui.dialog({
        title: '删除社区话题',
        content: '您确定要删除此社区话题吗<br/>'+topicContent,
        buttons: [
            {
                text: '取消'
            },
            {
                text: '确认',
                onClick: function(inst){
                    $$.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $$('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: '/admin/community/topic/delete',
                        data: {
                            id:topicId
                        },
                        statusCode: {
                            500: function (xhr, textStatus) {
                                mdui.alert('Server internal error<br/>服务器内部错误');
                            }
                        },
                        success: function (data) {
                            data = JSON.parse(data);
                            if (data.status ===1) {
                                mdui.snackbar({
                                    message:data.msg,
                                    position:'top'
                                });
                                setTimeout(function(){
                                    //使用  setTimeout（）方法设定定时5000毫秒
                                    window.location.reload();//页面刷新
                                },2000);
                            } else {
                                mdui.snackbar({
                                    message:data.msg,
                                    position:'top'
                                });
                            }

                        }
                    });
                }
            }
        ]
    });
}
/**
 * 批量删除社区话题
 */
function deleteCommunityTopics() {
    //获取选中对象数组
    var ids=getSelectedIds();
    var titles=getSelectedNames();
    //弹出确认对话框
    mdui.dialog({
        title: '批量删除社区话题',
        content: '您确定要删除我们吗<br/>'+titles,
        buttons: [
            {
                text: '取消'
            },
            {
                text: '确认',
                onClick: function(inst){
                    $$.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $$('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: '/admin/community/topic/deletes',
                        data: {
                            ids:ids
                        },
                        statusCode: {
                            500: function (xhr, textStatus) {
                                mdui.alert('服务器内部错误');
                            }
                        },
                        success: function (data) {
                            data=JSON.parse(data);
                            if (data.status ===1) {
                                mdui.snackbar({
                                    message:data.msg,
                                    position:'top'
                                });
                                setTimeout(function(){
                                    //使用  setTimeout（）方法设定定时5000毫秒
                                    window.location.reload();//页面刷新
                                },2000);
                            } else {
                                mdui.snackbar({
                                    message:data.msg,
                                    position:'top',
                                    timeout:0,
                                    buttonText:'OK',
                                    buttonColor:'pink',
                                    onButtonClick: function(){
                                        window.location.reload();//页面刷新
                                    }
                                });
                            }

                        }
                    });
                }
            }
        ]
    });
}

function deleteCommunityTopicReply(Id,Content) {
    mdui.dialog({
        title: '删除话题回复',
        content: '您确定要删除此话题回复吗<br/>'+Content,
        buttons: [
            {
                text: '取消'
            },
            {
                text: '确认',
                onClick: function(inst){
                    $$.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $$('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: '/admin/community/topic/reply/delete',
                        data: {
                            id:Id
                        },
                        statusCode: {
                            500: function (xhr, textStatus) {
                                mdui.alert('Server internal error<br/>服务器内部错误');
                            }
                        },
                        success: function (data) {
                            data = JSON.parse(data);
                            if (data.status ===1) {
                                mdui.snackbar({
                                    message:data.msg,
                                    position:'top'
                                });
                                setTimeout(function(){
                                    //使用  setTimeout（）方法设定定时5000毫秒
                                    window.location.reload();//页面刷新
                                },2000);
                            } else {
                                mdui.snackbar({
                                    message:data.msg,
                                    position:'top'
                                });
                            }

                        }
                    });
                }
            }
        ]
    });
}
/**
 * 批量删除新闻回复
 */
function deleteCommunityTopicReplies() {
    //获取选中对象数组
    var ids=getSelectedIds();
    var titles=getSelectedNames();
    //弹出确认对话框
    mdui.dialog({
        title: '批量删除话题回复',
        content: '您确定要删除我们吗<br/>'+titles,
        buttons: [
            {
                text: '取消'
            },
            {
                text: '确认',
                onClick: function(inst){
                    $$.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $$('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: '/admin/community/topic/reply/deletes',
                        data: {
                            ids:ids
                        },
                        statusCode: {
                            500: function (xhr, textStatus) {
                                mdui.alert('服务器内部错误');
                            }
                        },
                        success: function (data) {
                            data=JSON.parse(data);
                            if (data.status ===1) {
                                mdui.snackbar({
                                    message:data.msg,
                                    position:'top'
                                });
                                setTimeout(function(){
                                    //使用  setTimeout（）方法设定定时5000毫秒
                                    window.location.reload();//页面刷新
                                },2000);
                            } else {
                                mdui.snackbar({
                                    message:data.msg,
                                    position:'top',
                                    timeout:0,
                                    buttonText:'OK',
                                    buttonColor:'pink',
                                    onButtonClick: function(){
                                        window.location.reload();//页面刷新
                                    }
                                });
                            }

                        }
                    });
                }
            }
        ]
    });
}


