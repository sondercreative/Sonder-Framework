// INVIEW PLUGIN

!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof exports?module.exports=a(require("jquery")):a(jQuery)}(function(a){function i(){var b,c,d={height:f.innerHeight,width:f.innerWidth};return d.height||(b=e.compatMode,(b||!a.support.boxModel)&&(c="CSS1Compat"===b?g:e.body,d={height:c.clientHeight,width:c.clientWidth})),d}function j(){return{top:f.pageYOffset||g.scrollTop||e.body.scrollTop,left:f.pageXOffset||g.scrollLeft||e.body.scrollLeft}}function k(){if(b.length){var e=0,f=a.map(b,function(a){var b=a.data.selector,c=a.$element;return b?c.find(b):c});for(c=c||i(),d=d||j();e<b.length;e++)if(a.contains(g,f[e][0])){var h=a(f[e]),k={height:h[0].offsetHeight,width:h[0].offsetWidth},l=h.offset(),m=h.data("inview");if(!d||!c)return;l.top+k.height>d.top&&l.top<d.top+c.height&&l.left+k.width>d.left&&l.left<d.left+c.width?m||h.data("inview",!0).trigger("inview",[!0]):m&&h.data("inview",!1).trigger("inview",[!1])}}}var c,d,h,b=[],e=document,f=window,g=e.documentElement;a.event.special.inview={add:function(c){b.push({data:c,$element:a(this),element:this}),!h&&b.length&&(h=setInterval(k,250))},remove:function(a){for(var c=0;c<b.length;c++){var d=b[c];if(d.element===this&&d.data.guid===a.guid){b.splice(c,1);break}}b.length||(clearInterval(h),h=null)}},a(f).on("scroll resize scrollstop",function(){c=d=null}),!g.addEventListener&&g.attachEvent&&g.attachEvent("onfocusin",function(){d=null})});


(function ($, root, undefined) {
	$(function () {
		'use strict';


    $(document).ready(function(){
      $('.slider').slider();
    });

    (function($){
      $(function(){
          $('.button-collapse').sideNav({
		      menuWidth: 300, // Default is 240
		      edge: 'right', // Choose the horizontal origin
		      closeOnClick: true // Closes side-nav on <a> clicks, useful for Angular/Meteor
		    }
		  );

      }); // end of document ready
    })(jQuery); // end of jQuery name space



    // SCROLL-TO Links
	$('a[href^="#"]').live('click',function(event){
	    event.preventDefault();
	    var target_offset = $(this.hash).offset() ? $(this.hash).offset().top : 0;
	    //change this number to create the additional off set        
	    var customoffset = 85;
	    $('html, body').animate({scrollTop:target_offset - customoffset}, 500);
	});
 

   
    // $( "#searchToggle" ).click(function() {
     




    //  	$(this).toggleClass('open');
    // 	$( "#searchWrap" ).slideToggle( "fast", function() {
    // 	});

    // 	  if($('#searchToggle').hasClass('open')){
    // 	  	$( "#searchform #s" ).focus();
    // 	  } else {
    // 	  	$('#searchform #s').val('');
    // 	  }

    // });



	  $(document).ready(function() {
	    // $('select').material_select();
	  });


    // ISOTOPE

	if($('.news-grid').is(':visible')){

	    function isoGo(){
	      var $grid = $('.news-grid').isotope({
	        itemSelector: '.newsItem',
	        layoutMode: 'masonry',
	        stagger: 60
	      });
	    }

	    $(window).load(function() {
	      isoGo();
	    });

	    $(window).resize(function(){
	      isoGo();
	    });

	    // filter items on button click
	    $('.filter-button-group button').on( 'click', function() {
	    	console.log('test');
	      $('.filter-button-group').find('.active').removeClass('active');
	      $(this).addClass('active');
	      var filterValue = $(this).attr('data-filter');
	      $('.isoFeed').isotope({ filter: filterValue });
	    });

	    $('.filter').on( 'click', function() {
	      var filterValue = $(this).attr('data-filter');
	      $('.isoFeed').isotope({ filter: filterValue });

	      return false;
	    });

	    // END ISOTOPE


		// bind filter on select change
		$('.filters-select').on( 'change', function() {
		  // get filter value from option value
		  var filterValue = this.value;
		  // use filterFn if matches value
		  $('.news-grid').isotope({ filter: filterValue });
		});
	}


	if($('.resource-grid').is(':visible')){

			// quick search regex
			var qsRegex;

			// init Isotope
			var $grid = $('.resource-grid').isotope({
			  itemSelector: '.resource-item',
			  layoutMode: 'masonry',
			  filter: function() {
			    var $this = $(this);
			    var searchResult = qsRegex ? $(this).find('.projTit').text().match( qsRegex ) : true;
			    return searchResult;
			  }

			});

			// use value of search field to filter
			var $quicksearch = $('.name-input.autocomplete').bind("keyup change", debounce( function(e) {
			  qsRegex = new RegExp( $quicksearch.val(), 'gi' );
			  $grid.isotope();
			}) );
			 
			// debounce so filtering doesn't happen every millisecond
			function debounce( fn, threshold ) {
			  var timeout;
			  return function debounced() {
			    if ( timeout ) {
			      clearTimeout( timeout );
			    }
			    function delayed() {
			      fn();
			      timeout = null;
			    }
			    setTimeout( delayed, threshold || 100 );
			  };
			}
			$(window).on('load' , function(){
				$grid.isotope();
			});

	}




    //---------- ON DOCUMENT READY  --------------

    $( document ).ready(function() {


        // CONTACT FORM 7 FIX

		var cf7input = $( ".wpcf7-form-control" );
	      if ( cf7input.parent().is( "span" ) ) {
	        cf7input.unwrap();
	      } else {
	        cf7input.wrap( "<div></div>" );
	      }
	    jQuery('.form-group br').remove();




	    // CHILD NAVIGATION

        $(".childnav_toggle").click(function (e) {
            e.stopPropagation();
            $(this).toggleClass('opened');
            $(".childNav").slideToggle('fast');
        });


        $( ".childNav li.page_item_has_children" ).each(function(){
          $(this).append( "<div class='toggle'></div>" );
        });

       	// $( ".childNav li.page_item_has_children.current_page_ancestor" ).find( ".toggle" ).addClass("opened");
 		$( ".childNav li.menu-item-has-children.current_page_ancestor > .toggle" ).each(function() {
      	    $( this ).addClass( "opened" );
      	});


        $( ".page_item_has_children .toggle" ).click(function (e) {
            e.stopPropagation();
            $(this).toggleClass('opened');
            $(this).siblings('.children').stop().slideToggle( 'fast', function() {
          });

        });


		$('li.page_item_has_children').each(function(){
			console.log('test');
			if($(this).children('ul').is(":visible")){
				console.log('more test');
				$(this).children('.toggle').addClass('opened');
			}
		});

		$(".receiveUpdates > a").click(function (e) {
            e.stopPropagation();
            $(this).toggleClass('opened');
            $("#signUpDrop").slideToggle('fast');
            return false;
        });


        $( ".side-nav .menu-item-has-children .toggle" ).click(function (e) {
              e.stopPropagation();
              $(this).toggleClass('opened');
              $(this).siblings('.sub-menu').stop().slideToggle( 'fast');
        });


    });



    // Hide Header on on scroll down

    (function($){
    	$(function(){  

	    	var didScroll = false;
	        var scroll = $(document).scrollTop();
	        var headerHeight = $('#navHead').outerHeight(true);
	        var topOffset = 10;

	        console.log(headerHeight);
	        console.log(topOffset);


	    	function scrolldeely(){

				if($('.loginSlide').is(':visible')){
					headerHeight = $('.loginSlide').outerHeight(true) + 10;
					topOffset = $('.loginSlide').outerHeight(true) + 10;
					console.log(headerHeight);
					console.log(topOffset);

				} else{
					headerHeight = 10;
				}

				// console.log(headerHeight);

				var scrolled = $(document).scrollTop();
				var heightPlus = headerHeight + 100;

				if ((scrolled > 500) && $('#navHead').hasClass('off-canvas')){
					$('#navHead').addClass('fixed');
				} else if (scrolled <= topOffset){
					$('#navHead').removeClass('fixed');
				}

	            if ((scrolled > heightPlus) && (scrolled > scroll)){
	            	$('#navHead').removeClass('on-canvas');
	            	$('#navHead').addClass('off-canvas');
	            	
	            } else {

	            	$('#navHead').addClass('on-canvas');
	            	$('#navHead').removeClass('off-canvas');
	            }             

	          scroll = $(document).scrollTop();


	    	}

	    	window.onscroll = doThisStuffOnScroll;

	    	function doThisStuffOnScroll() {
	    	    didScroll = true;
	    	}

	    	setInterval(function() {
	    	    if(didScroll) {
	    	        didScroll = false;
	    	        scrolldeely();
	    	     
	    	    }
	    	}, 100);
	       });
    })(jQuery); 
    // END Hide Header on on scroll down

});// END USE STRICT?


	
})(jQuery, this);

jQuery(function($) { 





	if($('.navigation').is(':visible')){
	

		// $(window).ready(dropDownMaker());

		// 	function dropDownMaker() {
		// 	  $('.desktopMenu').find('.menu-item-has-children').hover(function(){
		// 	    if ($(window).width() > 990) {
		// 	      var subHeight = ($(this).find('.sub-menu').outerHeight(true));
		// 	      $(this).children('.sub-menu-wrap').stop().animate({
		// 	        height:subHeight
		// 	      },150,function(){
		// 	        $(this).css({'overflow':'visible','height':'auto'});  
		// 	      });

		// 	    }
		// 	  },function(){
		// 	    if ($(window).width() > 990) {
		// 	      $(this).children('.sub-menu-wrap').stop().animate({
		// 	        height:0
		// 	      },150,function(){
		// 	      $(this).removeAttr('style'); 
		// 	    });
		// 	    }
		// 	});

		// }

		$('.desktopMenu li').hover(function() {
			console.log('test');
			$(this).children('.sub-menu-wrap').stop(true, false, true).slideToggle(300);
		});
				
		
		
		$('.nav-actiavator').click(function(){
			if(!$(this).hasClass("open")){

				var navHeight = $('.mobileWrap').find('ul').outerHeight(true);
				if($('.search-close').is(":visible")){
					$('.search-open').toggle();
					$('.search-close').toggle();
					$('.searchWrap').slideToggle(150);
				}
				$('.mobileWrap').stop().animate({
					height:navHeight
				},150,function(){
					$(this).css({'height':'auto'});	
				});
				$(this).addClass('open');
				// $('body').css('overflow','hidden');
			}else{
				// $('.sub-menu-wrap').stop().animate({
				// 	height:0
				// },150,function(){
				// 	$('.sub-toggle').removeClass('toggled');
				// 	$(this).removeAttr('style');	
				// });
				
				// //resetting the toggle function, will reset the toggle so it can be opened again when the main menu is closed
				// $('.sub-toggle').unbind('click').toggle(function(){
				// 	$(this).addClass('toggled');
				// 	var $sub = $(this).siblings('.sub-menu-wrap');
				// 	var subHeight = $sub.children('ul').outerHeight(true);
				// 		$sub.stop().animate({
				// 			height:subHeight
				// 		},150,function(){
				// 			$(this).css('height','auto');	
				// 		});
				
				// },function(){
				// 	var $sub = $(this).siblings('.sub-menu-wrap');
				// 		$sub.stop().animate({
				// 			height:0
				// 		},150);

				// 		$(this).removeClass('toggled');
					
				// });

				$('.mobileWrap').stop().animate({
					height:0
				},150,function(){
					$(this).removeAttr('style');	
				});
				$(this).removeClass("open");
				// $('body').css('overflow','auto');
				
				}
		});



		//initial toggle function, will run when the menu is first opened
		$('.sub-toggle').toggle(function(){
			$(this).addClass('toggled');
			var $sub = $(this).siblings('.sub-menu-wrap');
			var subHeight = $sub.children('ul').outerHeight(true);

			$sub.stop().animate({
				height:subHeight
			},150,function(){
				$(this).css('height','auto');	
			});
			
		},function(){
				$(this).removeClass('toggled');
				var $sub = $(this).siblings('.sub-menu-wrap');
				$sub.stop().animate({
					height:0
				},150);
		});



		$('.search-act').click(function(){
			$('.search-open').toggle();
			$('.search-close').toggle();
			$('.searchWrap').slideToggle(150);
			if($('.searchWrap').is(":visible")){
				$('.searchWrap').find('input').focus();
				
			}
			if($('.nav-actiavator').hasClass('open')){

				$('.mobileWrap').stop().animate({
					height:0
				},150,function(){
					$(this).removeAttr('style');	
				});
				$('.nav-actiavator').removeClass("open");
				$('.nav-actiavator .hamburger').removeClass("is-active")
    	  	}
			return false;


		});

	}



 	var forEach=function(t,o,r){if("[object Object]"===Object.prototype.toString.call(t))for(var c in t)Object.prototype.hasOwnProperty.call(t,c)&&o.call(r,t[c],c,t);else for(var e=0,l=t.length;l>e;e++)o.call(r,t[e],e,t)};

    var hamburgers = document.querySelectorAll(".hamburger");
    if (hamburgers.length > 0) {
      forEach(hamburgers, function(hamburger) {
        hamburger.addEventListener("click", function() {
          this.classList.toggle("is-active");
        }, false);
      });
    }

});






