(function(){
	"use strict";
	var target;

	var $ = window.jQuery;

	var hash = window.location.hash;
	var startslide = 0;

	//get the hash, if it's a story update inital slide
	if(hash) {
		var story = $('.akMedia').find(hash);

		if(story.length > 0 ) {
			startslide = parseInt($(hash)[0].dataset['index']);
		}		
	}

	//disable links
	$('.ak-media-archive__item').on('click', function(evt) {
	  evt.preventDefault();
	}); 


	$('.akMedia').slick({
	  	slidesToShow: 1,
	  	initialSlide: startslide,
	  	slidesToScroll: 1,
	  	arrows: true,
	  	asNavFor: '.ak-media-archive__list',
  		adaptiveHeight: true,
  		appendArrows: '.akMedia__bottom',
  		prevArrow: '.akMedia__button--prev',
  		nextArrow: '.akMedia__button--next'
	});

	$('.ak-media-archive__list').slick({
	  	slidesToShow: $('.akMedia-archive__item').length,
	  	slidesToScroll: 0,
	  	initialSlide: startslide,
	  	asNavFor: '.akMedia',
	  	vertical: true,
	  	arrows: false
	});

	//update url on change (both links & arrows)
	$('.akMedia').on('afterChange', function(event, slick, currentSlide){   
		var target = $('[data-slick-index=' + currentSlide + ']')[1].id;
		  if(history.replaceState) {
		    history.replaceState(null, null, '#' + target);
		}
		else {
		    location.hash = target;
		}
	});

	function shareOnLinkedIn(href, title) {
      var url = 'https://www.linkedin.com/shareArticle?mini=true&url=' + href + '&title=' + title;
      window.open(url,'Share on LinkedIn','status = 1, height = 380, width = 500, resizable = 0');
      return false;
    }

    function shareOnTwitter(href, title) {
      var url = 'https://twitter.com/intent/tweet?text=' + title + ' ' + href;
      window.open(url,'Twitter','status = 1, height = 380, width = 500, resizable = 0');
      return false;
    }

    function shareOnFacebook(href) {
      var url = 'https://www.facebook.com/sharer/sharer.php?u=' + href;

      window.open(url,'facebook','status = 1, height = 380, width = 500, resizable = 0');
      return false;
    }

	function socialShare() {
      	var linkedInBtn = $('.akMedia__button--linkedin');
      	var twitterBtn = $('.akMedia__button--twitter');
      	var facebookBtn = $('.akMedia__button--facebook');

      	if (linkedInBtn ) {
	        linkedInBtn.on('click', function(e) {
	        	e.preventDefault();
				var currentTitle = $('.akMedia .slick-active').find('.akMedia-post__headline').text();
	          	
	          	var url = window.location.href;
	          	shareOnLinkedIn(url, currentTitle);
	        });
      	}

      	
      	if (twitterBtn ) {
	        twitterBtn.on('click', function(e) {
	        	e.preventDefault();
				var currentTitle = $('.akMedia .slick-active').find('.akMedia-post__headline').text();
	          	
	          	var url = window.location.href;
	          	shareOnTwitter(url, currentTitle);
	        });
      	}

      	if (facebookBtn ) {
	        facebookBtn.on('click', function(e) {
	        	e.preventDefault();
				var currentTitle = $('.akMedia .slick-active').find('.akMedia-post__headline').text();
	          	
	          	var url = window.location.href;
	          	shareOnFacebook(url, currentTitle);
	        });
      	}
	}

	socialShare()

})();