/*
$(document).ajaxStart(function() {
	$("#loader").css('display', 'flex');
}).ajaxStop(function() {
	$("#loader").hide();
});
*/

(function ($) {
	$(window).on('resize load', function () {
		$('body').css({
			"margin-top": $(".menu-logo").height() + "px"
		});
		$('.offcanvas .wrapper .inner-items').css({
			"padding-bottom": $(".fixed-footer-buttons").outerHeight() + "px"
		});
	});
	// Nice scroll
	$(".offcanvas .nice_scroll").niceScroll();
	//nice select
	$('.nice-select select').niceSelect();

// Navbar Megamenu
	$('.droopmenu-navbar').droopmenu({
		dmArrow: true,
		dmToggleSpeed: 100,
		dmAnimDelay: 0,
		dmShowDelay: 0,
		dmHideDelay: 0,
		dmAnimationEffect: 'dmslideright',
		dmOffCanvas: true,
		dmOffCanvasPos: 'dmoffleft',
		dmArrowDirection: 'dmarrowup',
	});

	new WOW().init();
	// Sections slider
	$('.six_items_carousel').slick({
		slidesToShow: 6,
		slidesToScroll: 6,
		nextArrow: '<button type="button" class="slick-next"><i class="fas fa-long-arrow-alt-left"></i></button>',
		prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-long-arrow-alt-right"></i></button>',
		dots: false,
		rtl: true,
		arrows: true,
		centerMode: false,
		focusOnSelect: true,
		responsive: [
			{
				breakpoint: 1025,
				settings: {
					slidesToShow: 5,
					slidesToScroll: 4,
				}
			},
			{
				breakpoint: 769,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 3,
					dots: false,
					arrows: false
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2,
					dots: false,
					arrows: false
				}
			}
		]
	});

	$('.five_items_carousel').slick({
		slidesToShow: 5,
		slidesToScroll: 5,
		nextArrow: '<button type="button" class="slick-next"><i class="fas fa-long-arrow-alt-left"></i></button>',
		prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-long-arrow-alt-right"></i></button>',
		dots: true,
		rtl: true,
		arrows: false,
		centerMode: false,
		focusOnSelect: false,
		responsive: [
			{
				breakpoint: 1025,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 3,
				}
			},
			{
				breakpoint: 600,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2,
					dots: false,
					arrows: false
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2,
					dots: false,
					arrows: false
				}
			}
		]
	});

	$('.slider-for').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		dots: false,
		fade: true,
		rtl:true,
		asNavFor: '.slider-nav',
	});

	$('.slider-nav').slick({
		slidesToShow: 4,
		slidesToScroll: 1,
		asNavFor: '.slider-for',
		dots: false,
		arrows: false,
		rtl: true,
		centerMode: false,
		focusOnSelect: true,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
				}
			},
			{
				breakpoint: 600,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
				}
			}
		]
	});

	// Aside navs on click
	$("#reviewPanelTrigger").on("click", function (e) {
		e.preventDefault();
		e.stopPropagation();
		$("#reviewPanel").toggleClass("show");
	});

	$(document).click(function(event){
		if($('#reviewPanel').hasClass('show') && $(event.target).closest("#reviewPanel").length == 0) {
			$('#reviewPanel').toggleClass('show');
		}
	});

	// Close menu when pressing ESC
	$(document).on('keydown', function (event) {
		if (event.keyCode === 27) {
			$(".offcanvas").removeClass("show");
			$("body").removeClass("overlay-active");
			$(".screen-overlay").removeClass("show");
			$("#reviewPanel").removeClass("show");
		}
	});

	$(document).on("click", function(e) {
		var _parent = $(e.target).parents('aside').length;
		if (_parent == false) {
			$(".offcanvas").removeClass("show");
			$("body").removeClass("offcanvas-active");
		}
	});

	$("#closeCanvas, .screen-overlay").click(function (e) {
		$(".screen-overlay").removeClass("show");
		$(".offcanvas").removeClass("show");
		$("body").removeClass("offcanvas-active");
		$("#reviewPanel").removeClass("show");
	});

	$("[data-trigger]").on("click", function (e) {
		e.preventDefault();
		e.stopPropagation();
		var offcanvas_id = $(this).attr('data-trigger');
		$(offcanvas_id).addClass("show");
		$('body').addClass("offcanvas-active");
		$(".screen-overlay").addClass("show");
		cart_total_price();
		if( offcanvas_id == '#notification-aside' )
		{
			//notification_seen();
		}
	});
	 

// ===== Scroll to Top ====
$(window).scroll(function() {
	if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
		$('#return-to-top').fadeIn(200);    // Fade in the arrow
	} else {
		$('#return-to-top').fadeOut(200);   // Else fade out the arrow
	}
});
$('#return-to-top').click(function() {      // When arrow is clicked
	$('body,html').animate({
		scrollTop : 0                       // Scroll to top of body
	}, 500);
});

// Radio Buttons on click show content
$('.radio_selection input[type="radio"]').click(function(){
	var inputValue = $(this).attr("id");
	var targetBox = $("." + inputValue);
	$(".radio-content").not(targetBox).hide();
	$(targetBox).show();
});

$(window).on('load',function () {
	$('#loader').fadeOut('slow');
});

})(jQuery);
