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
    $(document).ready(function(){
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
            var channel_id = $(this).attr('data-id') ;
            console.log(channel_id);
            //TODO AJAX查询详情

            //TODO 增加DIV
            var html = "<p>baogeli</p>";
            $(this).after(html);

            //TODO DIV高度从0到AUTO动画
//            $(this).css('height','auto');
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
    <div class="content" data-id="1">
        <div class="content_img">
            <div class="content_img_font">
                00
            </div>
        </div>
        <div class="content_title">OCN导视1</div>
        <div class="content_detail">
            <img  src="/Public/images/detail.jpg">
        </div>
        <div style="clear:both;width:100%;" id="expand1">
        </div>
    </div>

    <div class="lineB"></div>

    <div class="content" data-id="2">
        <div class="content_img">
            <div class="content_img_font">
                00
            </div>
        </div>
        <div class="content_title">OCN导视2</div>
        <div class="content_detail">
            <div class="content_detail_img">
                <img onclick="detail(this)" src="/Public/images/detail.jpg">
            </div>
            <!--<div class="content_detail_title"></div>-->
        </div>
    </div>
    <div class="lineB"></div>
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