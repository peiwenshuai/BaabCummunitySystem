var $$ = mdui.JQ;


/************************
 * 顶部appbar right menu
 */

var appbarRightMenu = new mdui.Menu('#appbar-right-menu-btn','#appbar-right-menu',{covered:false});

/************************
 * 首页轮播图
 */
layui.use('carousel', function(){
    var carousel = layui.carousel;
    //建造实例
    carousel.render({
        elem: '#index-carousel',
        width: '100%', //设置容器宽度
        height: '100%', //设置容器宽度
        arrow: 'hover' //始终显示箭头
        //anim: 'updown' //切换动画方式
    });
});