   // nav toggle
   $(window).scroll(function () {
    var scrollh = $(this).scrollTop();
    if (scrollh >= 10) {
        $('nav').addClass('add_nav');
        $('ul.nav.navbar-nav').addClass('navNew')

    }else {
        $('nav').removeClass('add_nav');
        $('ul.nav.navbar-nav').removeClass('navNew')
    }

});
 // create store page input focus

$('.form-control').focus(function(){

  $(this).prev('div').children('span').css({background: '#F38120'});
  $(this).parent().prev('label').css({color: '#F38120'});
})



// Animation header home page   >>    animation 1

$(function (){

  var animation = bodymovin.loadAnimation({
    container: document.getElementById('anim'),
    renderer: 'svg',
    loop: true,
    autoplay: true,
    path: 'js/lf30_INM39Q.json'
  });
});

// Animation header home page    >>   animation 2

$(function (){

  var animation = bodymovin.loadAnimation({
    container: document.getElementById('track-img'),
    renderer: 'svg',
    loop: true,
    autoplay: true,
    path: 'js/2.json'
  });
});

// Animation contact us page    >>   animation 3

$(function (){

  var animation = bodymovin.loadAnimation({
    container: document.getElementById('welcome'),
    renderer: 'svg',
    loop: true,
    autoplay: true,
    path: 'js/3.json'
  });
});

// Animation Blog page    >>   animation 4

$(function (){

  var animation = bodymovin.loadAnimation({
    container: document.getElementById('welcome-img'),
    renderer: 'svg',
    loop: true,
    autoplay: true,
    path: 'js/5.json'
  });
});
// Animation login & create-store page    >>   animation 5

$(function (){

  var animation = bodymovin.loadAnimation({
    container: document.getElementById('store-img'),
    renderer: 'svg',
    loop: true,
    autoplay: true,
    path: 'js/4.json'
  });
});

// form animation blog page

// why sahla icons hover change

$(function(){     //  icon 1

  $('.why-sahlah .card').eq(0).hover(function() {

    $(this).children('img').attr('src','img/Group 168-2.svg');

  },function(){

    $(this).children('img').attr('src','img/Group 168.svg');

  });

 });
 $(function(){     // icon 2

  $('.why-sahlah .card').eq(1).hover(function() {

    $(this).children('img').attr('src','img/Group 167-2.svg');

  },function(){

    $(this).children('img').attr('src','img/Group 167.svg');

  });

 });
 $(function(){     //  icon 3

  $('.why-sahlah .card').eq(2).hover(function() {

    $(this).children('img').attr('src','img/Group 173-2.svg');

  },function(){

    $(this).children('img').attr('src','img/Group 173.svg');

  });

 });
 $(function(){     //  icon 4

  $('.why-sahlah .card').eq(3).hover(function() {

    $(this).children('img').attr('src','img/Group 178-2.svg');

  },function(){

    $(this).children('img').attr('src','img/Group 178.svg');

  });

 });
 $(function(){     //  icon 5

  $('.why-sahlah .card').eq(4).hover(function() {

    $(this).children('img').attr('src','img/Group 177-2.svg');

  },function(){

    $(this).children('img').attr('src','img/Group 177.svg');

  });

 });
 $(function(){     //  icon 6

  $('.why-sahlah .card').eq(5).hover(function() {

    $(this).children('img').attr('src','img/Group 174-2.svg');

  },function(){

    $(this).children('img').attr('src','img/Group 174.svg');

  });

 });

/* end Animation one */

   // owl slider

   $('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        600:{
            items:2,
            nav:false
        },
        1000:{
            items:3,
            nav:true,
            loop:false
        }
    }
})

// counter 1

$(document).ready(function() {

  var counters = $(".count");
  var countersQuantity = counters.length;
  var counter = [];

  for (i = 0; i < countersQuantity; i++) {
    counter[i] = parseInt(counters[i].innerHTML);
  }

  var count = function(start, value, id) {
    var localStart = start;
    setInterval(function() {
      if (localStart < value) {
        localStart++;
        counters[id].innerHTML = localStart;
      }
    }, 50);
  }

  for (j = 0; j < countersQuantity; j++) {
    count(1, counter[j], j);
  }
});

// counter 2

$(document).ready(function() {

    var counters = $(".count-two");
    var countersQuantity = counters.length;
    var counter = [];

    for (i = 0; i < countersQuantity; i++) {
      counter[i] = parseInt(counters[i].innerHTML);
    }

    var count = function(start, value, id) {
      var localStart = start;
      setInterval(function() {
        if (localStart < value) {
          localStart++;
          counters[id].innerHTML = localStart;
        }
      }, 50);
    }

    for (j = 0; j < countersQuantity; j++) {
      count(1, counter[j], j);
    }
  });

  // counter 3

$(document).ready(function() {

    var counters = $(".count-three");
    var countersQuantity = counters.length;
    var counter = [];

    for (i = 0; i < countersQuantity; i++) {
      counter[i] = parseInt(counters[i].innerHTML);
    }

    var count = function(start, value, id) {
      var localStart = start;
      setInterval(function() {
        if (localStart < value) {
          localStart++;
          counters[id].innerHTML = localStart;
        }
      }, 50);
    }

    for (j = 0; j < countersQuantity; j++) {
      count(1, counter[j], j);
    }
  });

/* end counter */

/* track business google play hover */

$(function(){

  $('.track-business .g-play').hover(function(){

    $(this).children('.old-g').attr('src','img/google-play (1)-1.svg').css({

      transform: 'translateX(70px) rotate(360deg)'
    });

  }, function() {

    $(this).children('.old-g').attr('src','img/google-play (1).svg').css({

      transform: 'translateX(0px) rotate(0deg)'
    });

  });

});

/* track business app store hover */

$(function(){

  $('.track-business .app-store').hover(function(){

    $(this).children('.old-app').attr('src','img/app.svg').css({

      transform: 'translateX(70px) rotate(360deg)'
    });

  }, function() {

    $(this).children('.old-app').attr('src','img/app-1.svg').css({

      transform: 'translateX(0px) rotate(0deg)'
    });

  });

});


/* switch button packages */

$('.packages .switch input') .click(function () {

  $('.packages span.monthly').toggleClass('white-blue');
  $('.packages span.yearly').toggleClass('white-blue');

  if( $('.packages span.yearly').hasClass('white-blue')) {

    $('.packages .card .list-group-item.price').eq(0).html('579<span>SAR</span>');
    $('.packages .card .list-group-item.price').eq(1).html('250<span>SAR</span>');

  }else {

    $('.packages .card .list-group-item.price').eq(0).html('299<span>SAR</span>');
    $('.packages .card .list-group-item.price').eq(1).html('99<span>SAR</span>');
  }
})

// change icons on hover 'home page'

$(function(){ // facebook

  $('.face-icon img').hover(function() {

    $(this).attr('src','img/Icon1-1.svg');

  },function(){

    $(this).attr('src','img/Icon-1.svg');
  });

 });

 $(function(){ // twitter

  $('.twitter-icon img').hover(function() {

    $(this).attr('src','img/Icon-2.svg');

  },function(){

    $(this).attr('src','img/twitter-w.svg');
  });

 });
 $(function(){ // youtube

  $('.youtube-icon img').hover(function() {

    $(this).attr('src','img/Icon-3-1.svg');

  },function(){

    $(this).attr('src','img/Icon-3.svg');
  });

 });

// change icons on hover 'contact us'

$(function(){ // facebook

  $('.old-icon-1 img').hover(function() {

    $(this).attr('src','img/Icon1-1.svg');

  },function(){

    $(this).attr('src','img/facebook.svg');
  });

 });

 $(function(){ // twitter

  $('.old-icon-2 img').hover(function() {

    $(this).attr('src','img/Icon-2.svg');

  },function(){

    $(this).attr('src','img/twitter.svg');
  });

 });

 $(function(){ // youtube

  $('.old-icon-3 img').hover(function() {

    $(this).attr('src','img/Icon-3-1.svg');

  },function(){

    $(this).attr('src','img/youtube.svg');
  });


 });

	$(function(){
		$('.maps .toggle-address').click(function(){
		$(this).prev().slideToggle(800);
	})
 })
