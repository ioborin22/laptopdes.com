$(function(){

    $("ul.dropdown li").hover(function(){
    
        $(this).addClass("selected");
        $('ul:first',this).css('visibility', 'visible');
    
    }, function(){
    
        $(this).removeClass("selected");
        $('ul:first',this).css('visibility', 'hidden');
    
    });    
	$("ul.dropdown li.c-main-menu:not(:has(ul))").addClass("without-submenu");
	
    //$("ul.dropdown li ul li:has(ul)").find("a:first").append(" &raquo; ");
	//$("ul.dropdown li ul li:has(ul)").find("a:first").addClass("c-right-tick");
	
	//add tick image to level2 menu items <a>
	//var current_location = window.location.pathname;
	$("ul.dropdown li.c-level2:has(ul)").find("a:first").append(" <img class=\"c-menu-tick\" src=\"http://fileshero.net/wp-content/themes/fileshero/images/header-menu-tick.png\" alt=\"menu-tick\"/> ");

});