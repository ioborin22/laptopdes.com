//Script for div underlay menu
$(function(){
		$.fn.functionName = function(value_in){
			var pos = $(value_in).position();
			var pos_left = pos.left;
			//alert(pos_left);
			var main_menu_height = $("ul.dropdown").height();
			var main_menu_pos = $("ul.dropdown").position();
			var main_menu_left = main_menu_pos.left;
			var sub_menu_height = $("ul.dropdown ul").height();
			var sub2_menu_height = $("ul.dropdown ul ul").height();
			//alert(sub2_menu_height);
			$("#i-underlay").css('height',sub_menu_height+1);
			$("#i-underlay").css('left',pos_left + main_menu_left + 30);
			$("#i-underlay").css('top',main_menu_height+5-1);
			$("#i-underlay").css('visibility', 'visible');
		};
			
		$("ul.dropdown li:not(.without-submenu)").hover(function(){
			$("ul.dropdown li").functionName($(this));
			//$("ul.dropdown li.c-main-menu:not(:has(ul))").
    	}, function(){
				$("ul.dropdown li ul li").hover(function(){
					$("#i-underlay").css('visibility', 'visible');
				});
				$("#i-underlay").css('visibility', 'hidden');
    
		});
});
//handling submenus height and top 
$(function(){
		$("ul.dropdown li.c-level2:has(ul)").hover(function(){
			var p = $("ul.dropdown ul").position();
			var t = p.top;
				
			var p1 = $(this).position();
			var t1 = p1.top;
			$("ul.dropdown ul ul").css('top', - t1);
				
			var h = $("ul.dropdown ul").height();
			$("ul.dropdown ul ul").css('height', h);
    
		}, function(){
    
				//nothing to do
    
		});
});