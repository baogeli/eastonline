<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="viewport" content="width=750, minimum-scale=0.43, maximum-scale=2.0, user-scalable=no"/>
<title>东主有线</title>
<link rel="stylesheet" href="/Public/css/index.css">
<script type="text/javascript" src="/Public/scripts/jquery-2.1.1.min.js"></script>
</head>
<body>


<script>
    var selectedIndex = 0;
    var c_id;
    $(document).ready(function(){
        var baogeli;
        var height = $(window).height();
        var new_height = height - 78;
        $('.left_bar').css('height',new_height);
        var bar = false;
        moveToTriangle(0,0);
        var div = $('.logo > div');
        div.click(function () {
            var index,length = div.length;
            for(var i = 0;i<length;i++){
                if(div[i] == $(this)[0]){
                    index = i;
                    break;
                }
            }
            moveToTriangle(index,0);
        });

        //  点击出现侧边栏
        $('#l_bar').click(function () {
            if (bar == false) {
                $('.left_bar').animate({'left':0},200);
                $('.content_img').animate({'marginLeft':'19px'},200);
                $('.content_title').animate({'marginLeft':'31px'},200);
                $('.container').animate({'margin-left':'200px'},200);
                $('.baogeli').animate({'margin-left':'200px'},200);
                bar = true;
                moveToTriangle(selectedIndex,200);
            } else {
                $('.left_bar').animate({'left':-203},200);
                $('.baogeli').animate({'margin-left':0},200);
                $('.content_img').animate({'marginLeft':'0px'},200);
                $('.content_title').animate({'marginLeft':'111px'},200);
                $('.container').animate({'margin-left':0},200);
                bar = false;
                moveToTriangle(selectedIndex,-200);
            }
        });

        //  回到顶部
        $("#to_top").click(function () {
            $('body,html').animate({scrollTop:0},1000);
            return false;
        });

        $("#detail").click(function () {
            alert(1);
        });

        $('.content').click(function(){
            if (bar == true) {
                $('.left_bar').animate({'left':-203},200);
                $('.baogeli').animate({'margin-left':0},200);
                $('.content_img').animate({'marginLeft':'0px'},200);
                $('.content_title').animate({'marginLeft':'111px'},200);
                $('.container').animate({'margin-left':0},200);
                moveToTriangle(selectedIndex,-200);
                bar == false;
            }
            var channel_id = $(this).attr('data-id') ;
            var content = $(this);
            //TODO AJAX查询详情
            if (c_id != channel_id) {
                $('.ajax_content').detach();
                $.post("/Home/Index/ajaxDetail",
                        {
                            id: channel_id
                        },
                        function(data){
                            c_id = channel_id;
                            content.parent().append("<div class='ajax_content'> </div>");
                            $('.ajax_content').animate({'height':300});
                        }
                );
            } else {
                c_id = null;
                $('.ajax_content').animate({'height':0},function(){
                    $('.ajax_content').detach();
                });
            }
        });
    });

    function moveToTriangle(index,offsetWidth) {
        selectedIndex = index;
        var dom = $('.logo > div')[index];
        var left = $(dom).offset().left;
        var width = $(dom).width();
        var margin_left = left + (width/2 - 18.5);
        $('.triangle').animate({'marginLeft':margin_left+offsetWidth},200);
    }

</script>

<div class="left_bar">
    <div class="left_bar_notice"></div>
    <div class="left_bar_line"></div>
    <div class="left_bar_hot"></div>
    <div class="left_bar_img"></div>
</div>

<div class="baogeli">
    <div class="logo">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>

<div class="triangle">
    <img src="/Public/images/triangle.jpg">
</div>
<div class="line"></div>

<div class="container">
    <?php if(is_array($l)): $i = 0; $__LIST__ = $l;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><div>
            <div class="content" data-id="<?php echo ($list["list_channel_id"]); ?>">
                <div class="content_img">
                    <div class="content_img_font">
                        <?php echo ($list["list_channel_no"]); ?>
                    </div>
                </div>
                <div class="content_title"><?php echo ($list["list_name"]); ?></div>
                <div class="content_detail">
                    <img  src="/Public/images/detail.jpg">
                </div>
                <div style="clear:both;width:100%;" id="expand1">
                </div>

            </div>
             <!--<div class='ajax_content'> </div>-->
         </div><?php endforeach; endif; else: echo "" ;endif; ?>
</div>

<div style="height:78px"></div>

<div class="end_bar">
    <div class="end_bar_left">
        <img id="l_bar" src="/Public/images/bar.jpg">
    </div>

    <div class="end_bar_right">
        <img id="to_top" src="/Public/images/up.jpg">
    </div>
</div>


</body>
</html>