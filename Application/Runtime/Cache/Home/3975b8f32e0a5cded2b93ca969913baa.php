<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="viewport" content="width=640, minimum-scale=0.5, maximum-scale=2.0, user-scalable=no"/>
<title>臻美铂金馆</title>
<link rel="stylesheet" href="/baogeli/Public/css/style.css">
<link rel="stylesheet" href="/baogeli/Public/css/index.css">
<script type="text/javascript" src="/baogeli/Public/scripts/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="/baogeli/Public/scripts/TouchSlide.1.1.js"></script>
<script type="text/javascript" src="/baogeli/Public/scripts/slider.js"></script>
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
		<li><img src="/baogeli/Public/images/menu.png" class="btnMenu"></li>
		<li style="width:490px;text-align:center;"><img src="/baogeli/Public/images/menu_title.png"></li>
		<li><a href="/baogeli/"><img src="/baogeli/Public/images/logo@58.png"></a></li>
	</ul>
</div>
<div class="menu">
	<ul>
		<li class="h1"><a href="/baogeli/">首页</a></li>
		<li class="h1">选择你喜欢的品牌</li>
        <!--<li class="h2"><a href="">首页</a></li>-->
        <?php if(is_array($brand)): $i = 0; $__LIST__ = $brand;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$b): $mod = ($i % 2 );++$i;?><li class="h2"><a href="/baogeli/Home/Index/brand/id/<?php echo ($b["brand_id"]); ?>"><?php echo ($b["brand_name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
		<!--<li class="h2">六福珠宝</li>-->
		<!--<li class="h2">周大福</li>-->
		<!--<li class="h2">周生生</li>-->
		<!--<li class="h2">钻石小鸟</li>-->
		<li class="h1"><a href="/">国际铂金协会官方网站</a></li>
	</ul>
</div>
<div class="menuMask">
</div>
<script type="text/javascript">
    $(function () {
        $('.category > ul > li').each(function () {
            $(this).on('click', function () {
                $('.active').removeClass('active');
                $(this).toggleClass('active');
                var c_id = $(this).attr('data-id');
                getProductList(c_id);
            });
        });

        var fragementId = window.location.hash[1];
        var activeObj = $('.category > ul > li[data-id='+fragementId+']');
        if(fragementId != '' && activeObj.length != 0){
            $('.active').removeClass('active');
            activeObj.toggleClass('active');
            getProductList(fragementId);
        }
        
    });

    function getProductList(c_id){
        $.get("/baogeli/Home/Index/getProductList", {id:c_id}, function (data, textStatus) {
            $('#p_results').html(data);
        });
    }
</script>
<div class="clear"></div>
<div class="dc1 brand"><a href="<?php echo ($brand_shop_url); ?>"><img class="bimage" src="/baogeli/<?php echo ($logo_img); ?>"><span>在线购买</span></a></div>
<!--<div class="dc1 brand"><img src="/baogeli/Public/images/logo-zss.gif"><span>在线购买</span></div>-->
<!--<div class="dc1 brand"><img src="<?php echo ($logo_img); ?>"><span>在线购买</span></div>-->
<div class="dc1 category">
    <ul>
            <?php if($c_id != null): if(is_array($category)): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?><li
                        <?php if($c["category_id"] == $c_id): ?>class="active"<?php endif; ?>
                    data-id="<?php echo ($c["category_id"]); ?>"><?php echo ($c["category_name"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php else: ?>
                <?php if(is_array($category)): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?><li
                        <?php if($i == 1): ?>class="active"<?php endif; ?>
                    data-id="<?php echo ($c["category_id"]); ?>"><?php echo ($c["category_name"]); ?></li><?php endforeach; endif; else: echo "" ;endif; endif; ?>
    </ul>
</div>
<div id="p_results" class="dc1 plist">
    <?php if(is_array($product)): $i = 0; $__LIST__ = $product;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$p): $mod = ($i % 2 );++$i;?><a href="/baogeli/Home/Index/productDetail/p_id/<?php echo ($p["product_id"]); ?>">
            <div class="p <?php if($i % 2 == 0): ?>right<?php endif; ?>">
                <div>
                        <img class="pimage" src="/baogeli/<?php echo ($p["product_logo_img"]); ?>">
                </div>
                <p><?php echo ($p["product_name"]); ?></p>
                <p>￥<?php echo ($p["price"]); ?></p>
            </div>
        </a><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
<div class="clear h20"></div>
</body>
</html>