<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="viewport" content="width=640, minimum-scale=0.5, maximum-scale=2.0, user-scalable=no"/>
<title>臻美铂金馆</title>
<link rel="stylesheet" href="/Public/css/style.css">
<link rel="stylesheet" href="/Public/css/index.css">
<script type="text/javascript" src="/Public/scripts/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="/Public/scripts/TouchSlide.1.1.js"></script>
<script type="text/javascript" src="/Public/scripts/slider.js"></script>
<script>

	var menuSelected = false;
	$(function(){
		var menu_item_height = ($(window).height() - $('.header').height() - 120) / $('.menu').find('li').length;
		if(menu_item_height < 90){
			$('.menu > ul > li').css('line-height', menu_item_height + 'px');
			$('.menu > ul > li').css('height',menu_item_height + 'px');
		}
		$('.menu').css('height',$(window).height() - $('.header').height() + 'px');
		$('.menuMask').css('height',$('.menu').css('height'));

		$('.btnMenu').click(function(){
			if(menuSelected){
				$('.menu').removeClass('a-menu-l').addClass('a-menu-r');
				$('.menuMask').hide();
				$('body').css('overflow','auto');
				menuSelected = false;
			} else {
				$('.menu').removeClass('a-menu-r').addClass('a-menu-l');
				$('.menuMask').show();
				$('body').css('overflow','hidden');
				menuSelected = true;
			}
		})

		$('.menuMask').click(function(){
			$('.menu').removeClass('a-menu-l').addClass('a-menu-r');
			$('.menuMask').hide();
			$('body').css('overflow','auto');
			menuSelected = false;
		})
	});
</script>
</head>
<body>
<div class="header">
	<ul>
		<li><img src="/Public/images/menu.png" class="btnMenu"></li>
		<li style="width:490px;text-align:center;"><img src="/Public/images/menu_title.png"></li>
		<li><a href="/"><img src="/Public/images/logo@58.png"></a></li>
	</ul>
</div>
<div class="menu">
	<ul>
		<li class="h1"><a href="/">首页</a></li>
		<li class="h1">选择你喜欢的品牌</li>
        <!--<li class="h2"><a href="">首页</a></li>-->
        <?php if(is_array($brand)): $i = 0; $__LIST__ = $brand;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$b): $mod = ($i % 2 );++$i;?><li class="h2"><a href="/Home/Index/brand/id/<?php echo ($b["brand_id"]); ?>"><?php echo ($b["brand_name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
		<!--<li class="h2">六福珠宝</li>-->
		<!--<li class="h2">周大福</li>-->
		<!--<li class="h2">周生生</li>-->
		<!--<li class="h2">钻石小鸟</li>-->
		<li class="h1"><a href="/">国际铂金协会官方网站</a></li>
	</ul>
</div>
<div class="menuMask">
</div>
<div class="clear"></div>
<div class="dc1 brand">
	<img class="bimage" src="/<?php echo ($product["logo_img"]); ?>">
    <!--<img src="/Public/images/logo-zss.gif">-->
	<a href="<?php echo ($product["shop_url"]); ?>"><span>在线购买</span></a>
	<div class="back"><img src="/Public/images/back.gif"></div>
</div>
<div class="clear w600"><span class="linkDD">查看详情</span></div>

<div id="slideBox" class="slideBox">
	<div class="bd">
		<ul>
            <?php if(is_array($product['imageurl'])): $i = 0; $__LIST__ = $product['imageurl'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$image): $mod = ($i % 2 );++$i;?><li>
                    <a class="pic" href="#"><img  src="/<?php echo ($image); ?>" /></a>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>

			<!--<li>-->
				<!--<a class="pic" href="#"><img src="/Public/images/p_2.jpg"/></a>-->
			<!--</li>-->
			<!--<li>-->
				<!--<a class="pic" href="#"><img src="/Public/images/p_3.jpg"/></a>-->
			<!--</li>-->
		</ul>
	</div>
	<div class="hd">
		<ul></ul>
	</div>
</div>
<!--
<div id="demo02" class="flexslider">
	<ul class="slides">
		<li><div class="img"><img src="/Public/images/p_1.jpg" /></div></li>
		<li><div class="img"><img src="/Public/images/p_2.jpg" /></div></li>
		<li><div class="img"><img src="/Public/images/p_3.jpg" /></div></li>
	</ul>
</div>
-->
<div class="dc1 hr"></div>
<div class="dc1 pintro">
	<p><?php echo ($product["product_name"]); ?></p>
		<p>￥<?php echo ($product["price"]); ?></p>
</div>
<div class="pdetail">
	<p class="dc1 brand"><?php echo ($product["brand_name"]); ?></p>
	<div class="dc1 hr"></div>
	<div class="dc1 details">
		<p>款号：<?php echo ($product["style"]); ?></p>
		<p>参考零售价　￥<?php echo ($product["price"]); ?></p>
		<p>材质：<?php echo ($product["material"]); ?></p>
		<p>重量：<?php echo ($product["weight"]); ?></p>
		<p>尺寸：<?php echo ($product["size"]); ?></p>
		<p>戒面宽度：<?php echo ($product["width"]); ?></p>
		<p>备注：<?php echo ($product["remark"]); ?></p>
	</div>
	<div class="close"><img src="/Public/images/close.jpg"></div>
</div>
<div class="clear h20"></div>
<script type="text/javascript">
	
	TouchSlide({ 
		slideCell:"#slideBox",
		titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
		mainCell:".bd ul", 
		effect:"leftLoop", 
		autoPage:true,//自动分页
		//autoPlay:true,
	});
	
	/*
	
	$('#demo02').flexslider({
		animation: "slide",
		direction:"vertical",
		easing:"swing"
	});
	*/
	//jQuery(".slideBox").slide({titCell:".hd ul",mainCell:".bd ul",effect:"topLoop",autoPage:true,autoPlay:true});
	var detailDisplay = false;
	$(function(){
		$('.pdetail').height($(window).height());
		//$('.pdetail').css('top',$(window).height() * .24 + 'px');
		$('.close').on('click',function(){
			if(detailDisplay){
				detailDisplay = false;
				$('.pdetail').removeClass('a-detail-up').addClass('a-detail-down');
			}
		});
		$('.linkDD').on('click',function(){
			if(!detailDisplay){
				detailDisplay = true;
				$('.pdetail').removeClass('a-detail-down').addClass('a-detail-up');
			}
		});
		$('.back').on('click',function(){
			history.back();
		})
	});
</script>
</body>
</html>