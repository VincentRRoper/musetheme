var currentSlideClick = false,
    prodCoverImgClick = false,
    snapInterval = 300,
    snapTimeout = setTimeout(function() {}, snapInterval)
;

jQuery(document).ready(function($) {
    var owlHome = $('.home-sections');
    if (owlHome.length) {
        // stopOwlPropagation(owlHome);
        var obj = owlHome.owlCarousel({
            loop: false,
            nav: true,
            navContainer: '.sliderscroll-home .sliderscroll-arrows',
            navText: ['<span class="sliderscroll-arrow prev">&lt;</span>', '<span class="sliderscroll-arrow next">&gt;</span>'],
            dots: true,
            dotsContainer: '.sliderscroll-home .sliderscroll-points',
            items: 1,
            smartSpeed: 1000,
            autoHeight: false,
            autoHeightClass: 'owl-height'
        });
        owlHome.on('changed.owl.carousel', function (event) {
            var changedElement = $(event.target = event.target || event.srcElement);
            // Skip event for "Current" slider
            if (changedElement.hasClass('current-slides') || changedElement.closest('.current-slides').length) {
                return true;
            }
            event.preventDefault();
            // Provided by the core
            // var element   = event.target;         // DOM element, in this example .owl-carousel
            // var name      = event.type;           // Name of the event, in this example dragged
            // var namespace = event.namespace;      // Namespace of the event, in this example owl.carousel
            // var items     = event.item.count;     // Number of items
            var item = event.item.index;     // Position of the current item
            // Provided by the navigation plugin
            // var pages     = event.page.count;     // Number of pages
            // var page      = event.page.index;     // Position of the current page
            // var size      = event.page.size;      // Number of items per page

            var videoHomepage = document.getElementById('video-homepage');
            // Play video on the first slide and pause on others
            if (item === 0) {
                playVideo('video-homepage');
                $('.soundswitch').removeClass('hide');
                $('.video-container').removeClass('blur');
            } else {
                stopVideo('video-homepage');
                $('.soundswitch').addClass('hide');
                $('.video-container').addClass('blur');
            }
        });
        $(window).on('click', function(e) {
            var hoveredElement = $(e.target = e.target || e.srcElement);
            if ((hoveredElement.hasClass('video-section') || hoveredElement.closest('.video-section').length) &&
                !hoveredElement.hasClass('soundswitch') && !hoveredElement.closest('.soundswitch').length) {
                toggleVideo('video-homepage');
            }
        });
        $(window).on("resize", function() {
            if ($(this).width() <= 767 && window.innerHeight > window.innerWidth) {
                // Portrait mobile => stop video
                stopVideo('video-homepage');
            }
        });

    }
    // Lazy load video
    const videos = [].slice.call(document.querySelectorAll("video.lazy"));
    if ("IntersectionObserver" in window) {
        var videoObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(video) {
                if (video.isIntersecting) {
                    for (var source in video.target.children) {
                        var videoSource = video.target.children[source];
                        if (typeof videoSource.tagName === "string" && videoSource.tagName === "SOURCE") {
                            videoSource.src = videoSource.dataset.src;
                        }
                    }

                    video.target.load();
                    video.target.classList.remove("lazy");
                    videoObserver.unobserve(video.target);
                }
            });
        });

        videos.forEach(function(video) {
            videoObserver.observe(video);
        });
    }
    $(window).on("resize", function(e) {
        var owlCurrent = $('.current-slides-inner.owl-carousel');
        if (owlCurrent.length) {
            owlCurrent.data('owl.carousel').options.items = 1;
            var owlOptions = owlCurrent.data('owl.carousel').options;
            var windowWidth = $(window).width() ;
            // Portrait mobile
            if (windowWidth <= 767 && window.innerHeight > window.innerWidth) {
                var stagePadding = windowWidth <= 350 ? 40 : 50;
                owlOptions.stagePadding = stagePadding;
                owlOptions.items = 1;
            } else {
                var currentSlidesCount = $('.current-slide').length || 1;
                owlOptions.stagePadding = 0;
                if (windowWidth <= 900) {
                    owlOptions.items = Math.min(2, currentSlidesCount);
                } else {
                    owlOptions.items = Math.min(3, currentSlidesCount);
                }
            }
        }
        $('.owl-carousel').trigger('refresh.owl.carousel');
        toggleNewsItemOpener();
    });
    toggleNewsItemOpener();
    var owlHomeCurrent = $('.current-slides .current-slides-inner');
    if (owlHomeCurrent.length) {
        // Prevent scrolling the parent slider
        stopOwlPropagation(owlHomeCurrent);
        var windowWidth = $(window).width();
        var isMobilePortrait = windowWidth <= 767 && window.innerHeight > window.innerWidth;
        var currentSlidesCount = $('.current-slide').length || 1;
        // Portrait mobile => 50, else 0
        var mobileStagePadding = isMobilePortrait ? 50 : 0;
        if (isMobilePortrait) {
            itemsCount = 1;
        } else if (windowWidth <= 900) {
            itemsCount = Math.min(2,currentSlidesCount);
        } else {
            itemsCount = Math.min(3,currentSlidesCount);
        }
        owlHomeCurrent.owlCarousel({
            loop: false,
            nav: false,
            margin: 20,
            items: itemsCount,
            pullDrag: true,
            slideTransition: "linear",
            stagePadding: mobileStagePadding,
            smartSpeed: 300,
            autoHeight: false//,
            // dots: true,
            // dotsContainer: '.sliderscroll-current .sliderscroll-points'
        });
        brandSliderClasses(owlHomeCurrent);
        owlHomeCurrent.on('initialize.owl.carousel refreshe.owl.carousel translate.owl.carousel resize.owl.carousel change.owl.carousel', function(event) {
            $(this).find('.owl-item.active').removeClass('firstactiveitem').removeClass('lastactiveitem');
        }).on('initialized.owl.carousel refreshed.owl.carousel translated.owl.carousel resized.owl.carousel changed.owl.carousel', function(event) {
            brandSliderClasses($(this), event);
        });
    }
    $(window).scroll(function(e){
        var scrollTop = $(this).scrollTop();
        var isSrolled = scrollTop > 75 || $('body').hasClass('modal-open');
        $('body').toggleClass('scrolled', isSrolled);
        var pageBanner = jQuery('.page-banner');
        if (pageBanner.length > 0 && scrollTop < pageBanner.height()) {
            jQuery('.page-banner-img').css('top', -scrollTop);
        }

    }).trigger('scroll');
    $('.sliderscroll-point-circle').on('click', function () {
        var point = $(this).closest('.sliderscroll-point');
        var owlData = $('.'+$(this).closest('.sliderscroll').data('carousel-class')).data('owl.carousel');
        var currentIndex = owlData._current;
        var cntSlide = Math.abs(currentIndex - point.index()) || 1;
        var owlSpeed = owlData.options.smartSpeed ? owlData.options.smartSpeed : 500;
        owlData.to(point.index(), Math.round(owlSpeed/cntSlide));
        return false;
    });
    $('.soundswitch-home').on('click', function(e) {
        e.preventDefault();
        $(this).toggleClass('off');
        toggleVideoSound('video-homepage');
    });
    $('.main-menu-toggle').on('click', function() {
        if ($('.main-menu').hasClass('expanded')) {
            $('body').removeClass('modal-open');
        } else {
            $('body').addClass('modal-open');
        }
        $('.main-menu').toggleClass('expanded');
    });
    var owlProd = $('.prod-cover-items');
    if (owlProd.length) {
        owlProd.owlCarousel({
            loop: false,
            nav: true,
            navContainer: '.sliderscroll-prod .sliderscroll-arrows',
            navText: ['<span class="sliderscroll-arrow prev">&lt;</span>', '<span class="sliderscroll-arrow next">&gt;</span>'],
            dots: true,
            dotsContainer: '.sliderscroll-prod .sliderscroll-points',
            items: 1,
            smartSpeed: 1000
        });
        $('.sliderscroll-prod .sliderscroll-arrow').on('click', function() {
            var sliderScroll = $(this).closest('.sliderscroll');
            var sliderCount = sliderScroll.find('.sliderscroll-point').length;
            var currentItem = sliderScroll.find('.owl-dot.active').index();
            if ($(this).hasClass('next') && (currentItem+1) === sliderCount
                || $(this).hasClass('prev') && currentItem === 0
            ) {
                // Close popup
                $('body').removeClass('modal-open');
                $('.prod').animate(
                    {
                        bottom: 0
                    },
                    1000
                );
                $(window).trigger('scroll');
            }
        });
        owlProd.on('changed.owl.carousel', function (event) {
            var changedElement = $(event.target = event.target || event.srcElement);
            // Skip event for "Current" slider
            if (changedElement.hasClass('prod-cover-item-imgs-m') || changedElement.closest('.prod-cover-item-imgs-m').length) {
                return true;
            }
            setTimeout(animateCSS, 300, '.prod-cover-items .owl-item:nth-child('+(parseInt($(this).data('owl.carousel')._current)+1)+') .prod-cover-item-grid img');
        });
    }
    $('.prod-item').on('click', function() {
        var itemIndex = parseInt($(this).closest('.prod-item-box').index());
        $('body').addClass(['modal-open','scrolled']);
        var owlProdData = owlProd.data('owl.carousel');
        owlProdData.to(itemIndex, 0);
        $('.prod').animate(
            {
                bottom: $(document).height()
            },
            500
        );
        setTimeout(animateCSS, 200, '.prod-cover-items .owl-item:nth-child('+(itemIndex+1)+') .prod-cover-item-grid img');
    });
    $('.prod-cover-item-imgs-m').each(function() {
        var owlProdItem = $(this);
        stopOwlPropagation(owlProdItem);
        owlProdItem.owlCarousel({
            loop: false,
            nav: false,
            dots: false,
            items: 1,
            stagePadding: 50,
            smartSpeed: 300,
            // autoWidth:true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                }
            }
        });
    });
    $('.distrib-list').on('click', '.distrib-item', function() {
        var distribItem = $(this);
        $('.distrib-item.expanded').each(function() {
            if ($(this).index() !== distribItem.index()) {
                // Hide other expanded items
                toggleDistribItem($(this), 200);
            }
        });
        setTimeout(toggleDistribItem,200,distribItem);
    });
    $('.current-slides-inner').on('touchstart', function() {
        currentSlideClick = true;
    });
    $('.current-slides-inner').on('touchmove', function(e) {
        currentSlideClick = false;
    });
    $('.current-slides-inner').on('click', '.current-slide', function(e) {
        // console.log(e.type);
        // console.log(currentSlideClick);
        if (e.type == "click") currentSlideClick = true;
        var owlItem = $(this).closest('.owl-item');
        if (owlItem.hasClass('active')) {
            if (currentSlideClick && $(window).width() < 1200) {
                $(this).toggleClass('active');
            }
        } else {
            var owlEvent = owlItem.next().hasClass('active') ? 'prev.owl.carousel' : 'next.owl.carousel';
            $(this).closest('.owl-carousel').trigger(owlEvent);
        }
    });
    $('.current-slides-inner').on('click', '.current-slide-arrow--prev', function(e) {
        e.stopPropagation();
        $(this).closest('.owl-carousel').trigger('prev.owl.carousel');
    });
    $('.current-slides-inner').on('click', '.current-slide-arrow--next', function(e) {
        e.stopPropagation();
        $(this).closest('.owl-carousel').trigger('next.owl.carousel');
    });
    $('.distrib-list').on('click', '.distrib-items-details-close', function() {
        toggleDistribItem($(this).closest('.distrib-item-details').prev('.distrib-item'), 200);
    });
    $('.prod-cover-item-imgs-m').on('click touchend', '.prod-cover-item-img', function(e) {
        var owlItem = $(this).closest('.owl-item');
        if (!owlItem.hasClass('active')) {
            e.preventDefault();
            var owlEvent = owlItem.next().hasClass('active') ? 'prev.owl.carousel' : 'next.owl.carousel';
            $(this).closest('.owl-carousel').trigger(owlEvent);
        }
    });
    $('.owl-carousel').on('translated.owl.carousel', function (event) {
        $('body').removeClass('owl-changing');
    });
    $('.owl-carousel').on('translate.owl.carousel', function (event) {
        $('body').addClass('owl-changing');
    });
    $('.owl-carousel').on('changed.owl.carousel', function (event) {
        var owl = $(this);
        var evItem = event.item.index; // Position of the current item
        var evElement   = event.target;         // DOM element, in this example .owl-carousel
        $('.current-circle').each(function(index,element) {
            var sliderScroll = $(this).closest('.sliderscroll');
            var circleWidth = $(this).width();
            if (!$(evElement).hasClass(sliderScroll.data('carousel-class'))) {
                return true;
            }
            var circleOwl = $('.'+sliderScroll.data('carousel-class'));
            if (!circleOwl.is(owl)) return true;
            sliderScroll.find('.sliderscroll-point').removeClass('active').eq(evItem).addClass('active')
            var activePoint = sliderScroll.find('.sliderscroll-point.active');
            if (!activePoint.length) return true;
            var pointCircleWidth = activePoint.find('.sliderscroll-point-circle').width();
            // Check CSS fix for .sliderscroll-point-circle
            var leftPosition = (activePoint.position().left || 0) + (pointCircleWidth - circleWidth)/2;
            $(element).stop().animate({
                left: leftPosition
            })
        });
    });
    $('.main-menu-area').on('click', function() {
        rolloutElement($(this), '.main-menu-area-info-txt');
    });
    $('.main-menu-area').hover(function() {
        if (!$(this).hasClass('active') && $(window).width() > 1200) {
            rolloutElement($(this), '.main-menu-area-info-txt');
        }
    }, function() {
        if ($(this).hasClass('active') &&  $(window).width() > 1200) {
            rolloutElement($(this), '.main-menu-area-info-txt');
        }
    });

    // Initialize smooth scrolling
    initSmoothScroll();
    $('.news-item').on('click', function() {
        if ($(this).find('.news-item-opener:visible').length > 0) {
            rolloutElement($(this), '.news-item-body');
        }
    });
    $('.prod-cover-close').on('click', function() {
        // Close popup
        $('body').removeClass('modal-open');
        $('.prod').animate(
            {
                bottom: 0
            },
            1000
        );
        $(window).trigger('scroll');
    });

    lightbox.init();
    lightbox.option({
        'alwaysShowNavOnTouchDevices': true,
        // 'resizeDuration': 200,
        // 'wrapAround': true,
        'disableScrolling': true,
        'showImageNumberLabel': false,
        'wrapAround': false
    });
    // $('.prod-cover-item-imgs-m').on('touchstart', function() {
    //     prodCoverImgClick = true;
    // });
    // $('.prod-cover-item-imgs-m').on('touchmove', function(e) {
    //     prodCoverImgClick = false;
    // });
    // $('.prod-cover-item-imgs-m').on('touchend', '.owl-item.active .prod-cover-item-img', function() {
    //     if (prodCoverImgClick) {
    //         // Lightbox trigger
    //         $(this).trigger('click');
    //     }
    // });
    // $('.current-slide-content').scroll(function() {
        // console.log('Content is scrolling');
    // })

    $('.custom-select select').on('change', function() {
        $(this).siblings('.select-items').children('div').removeClass('same-as-selected');
        // Don't change the dropdown name
        // $(this).siblings('.select-selected').html($(this).find('option:selected').html());
    });
    $('.distrib-item-detail-dropdown-select').on('click', function() {
        $(this).siblings('.select-selected').toggleClass('select-arrow-active');
    });
    $('.btn-scroll-top').on('click', function() {
        $(this).closest('.prod-cover-item-content').animate({
            scrollTop: 0
        }, 700);
    });
    $('.prod-cover-item-content').on('scroll', function() {
        var $this = $(this);
        var scrollTopBtn = $this.find('.btn-scroll-top');
        if ($this.scrollTop() > 100) {
            scrollTopBtn.show();
        } else {
            scrollTopBtn.hide();
        }
        console.log($(this).scrollTop());
    });

    function rolloutElement(element, contentSelector) {
        var item = element.toggleClass('expanded').toggleClass('active');
        var itemContent = item.find(contentSelector);
        var contentHeight = itemContent.height();
        item.toggleClass('expanded');
        itemContent.stop(false,true).animate({height:contentHeight}, 300, function() {
            item.toggleClass('expanded');
            itemContent.height('');
        });
    }

    function toggleVideo(id) {
        var video = document.getElementById(id);
        if ( video.paused ) {
            playVideo(id);
        } else {
            stopVideo(id);
        }
    }

    function stopVideo(id) {
        var video = document.getElementById(id);
        if ( !video.paused ) {
            video.pause();
        }
        $(video).siblings('.video-cover').addClass('paused');
    }

    function playVideo(id) {
        // Portrait mobile
        if ($(window).width() <= 767 && window.innerHeight > window.innerWidth)
            return;
        var video = document.getElementById(id);
        if ( video.paused ) {
            video.play();
        }
        $(video).siblings('.video-cover').removeClass('paused');
    }

    function toggleVideoSound(id) {
        var video = document.getElementById(id);
        if ( video.muted ) {
            video.muted = false;
        } else {
            video.muted = true;
        }
    }

    function toggleDistribItem(item, speed) {
        var toggleSpeed = speed || 400,
            wH = $(window).height(),
            wW = $(window).width()
        ;
        item.toggleClass('expanded');
        var isExpanded = item.hasClass('expanded'),
            itemDetails = item.next('.distrib-item-details'),
            itemDetailsPosition = itemDetails.css('position')
        ;
        itemDetails.slideToggle(toggleSpeed, function() {
            var $element = $(this),
                isElementVisible = $element.is(':visible');
            if (isElementVisible) {
                $element.css('display', 'block');
                // var scrollVal = Math.floor($element.offset().top - (($(window).height() - $element.height()) / 2));
                var scrollVal = $element.offset().top - $('.logo-container').height() + 1;
                $('html, body').animate({
                    scrollTop: scrollVal
                }, 700);
            }
        });
        if (itemDetailsPosition == 'fixed') {
            if (isExpanded) {
                $('body').addClass('modal-open');
            } else {
                $('body').removeClass('modal-open');
            }
        } else {
            $('body').removeClass('modal-open');
        }
    }
    function stopOwlPropagation(element) {
        $(element).on('translate.owl.carousel to.owl.carousel next.owl.carousel prev.owl.carousel change.owl.carousel drag.owl.carousel touchstart.owl.core mousedown.owl.core', function(e) {
            // e.preventDefault();
            e.stopPropagation();
            // return false;
        });
    }

    function toggleNewsItemOpener() {
        $('.news-item-body').each(function (index, element) {
            var newsBody = $(this),
                newsItem = newsBody.closest('.news-item'),
                newsOpener = newsItem.find('.news-item-opener'),
                newsBodyH = newsBody.outerHeight(true),
                newsBodyInnerH = newsBody.find('p:first-child').outerHeight(true),
                hDiff = Math.abs(newsBodyH - newsBodyInnerH)
            ;
            if (newsItem.hasClass('expanded') || newsBodyInnerH > (newsBodyH + 1)) {
                newsOpener.removeClass('hide');
            } else {
                newsOpener.addClass('hide');
            }
        });
    }

    function brandSliderClasses(slider) {
        var items = slider.find('.owl-item');
        var activeItems = slider.find('.owl-item.active');
        var total = slider.data('owl.carousel').options.items;
        // alert(jQuery('.current-slides-inner .owl-item.active').length + ' - ' +jQuery('.current-slides-inner .owl-item').length)
        items.removeClass('firstactiveitem').removeClass('lastactiveitem');
        activeItems.each(function(index, element) {
            if (index === 0) {
                $(this).addClass('firstactiveitem')
            }
            if (index === total - 1) {
                $(this).addClass('lastactiveitem')
            }
        })

    }
});
// var newsItems = document.getElementsByClassName('news-item-content');
// for (var i = 0; i < newsItems.length; i++) {
//     newsItems[i].addEventListener('click', function(e) {
//         this.classList.toggle('expanded');
//     });
// }
const animateCSS = (element, animation, speed = '', prefix = 'animate__') =>
{
    // We create a Promise and return it
    new Promise((resolve, reject) => {
        const animationSpeed = speed ? `${prefix}${speed}` : null;
        const nodes = element.nodeType > 0 ? [element] : document.querySelectorAll(element);
        nodes.forEach((node) => {
            const animationName = animation || node.dataset.animation
            const animationClass = `${prefix}${animationName}`;
            node.classList.add(`${prefix}animated`, animationClass, animationSpeed);

            // When the animation ends, we clean the classes and resolve the Promise
            function handleAnimationEnd(event) {
                event.stopPropagation();
                node.classList.remove(`${prefix}animated`, animationClass, animationSpeed);
                resolve('Animation ended');
            }

            node.addEventListener('animationend', handleAnimationEnd, {once: true});
        });
    });
}

window.addEventListener('load', function () {
    initializeCustomSelect();
    /* If the user clicks anywhere outside the select box,
    then close all select boxes: */
    document.addEventListener("click", closeAllSelect);
});

function initializeCustomSelect() {
    /* Custom select functionality */
    var x, i, j, l, ll, selElmnt, a, b, c;
    /* Look for any elements with the class "custom-select": */
    x = document.getElementsByClassName("custom-select");
    l = x.length;
    for (i = 0; i < l; i++) {
        // Check if initialized already, skip initialized ones
        if (x[i].getElementsByClassName("select-items").length > 0)
            continue;
        selElmnt = x[i].getElementsByTagName("select")[0];
        ll = selElmnt.length;
        /* For each element, create a new DIV that will act as the selected item: */
        a = document.createElement("DIV");
        a.setAttribute("class", "select-selected");
        a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
        x[i].appendChild(a);
        /* For each element, create a new DIV that will contain the option list: */
        b = document.createElement("DIV");
        b.setAttribute("class", "select-items select-hide");
        for (j = 0; j < ll; j++) {
            /* For each option in the original select element,
            create a new DIV that will act as an option item: */
            c = document.createElement("DIV");
            c.innerHTML = selElmnt.options[j].innerHTML;
            c.addEventListener("click", function (e) {
                /* When an item is clicked, update the original select box,
                and the selected item: */
                var y, i, k, s, h, sl, yl;
                s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                sl = s.length;
                h = this.parentNode.previousSibling;
                for (i = 0; i < sl; i++) {
                    if (s.options[i].innerHTML == this.innerHTML) {
                        s.selectedIndex = i;
                        // Trigger change event
                        jQuery(s).trigger('change');
                        // Don't change the dropdown text
                        // h.innerHTML = this.innerHTML;
                        y = this.parentNode.getElementsByClassName("same-as-selected");
                        yl = y.length;
                        for (k = 0; k < yl; k++) {
                            y[k].removeAttribute("class");
                        }
                        this.setAttribute("class", "same-as-selected");
                        break;
                    }
                }
                h.click();
            });
            b.appendChild(c);
        }
        x[i].appendChild(b);
        a.addEventListener("click", function (e) {
            /* When the select box is clicked, close any other select boxes,
            and open/close the current select box: */
            e.stopPropagation();
            closeAllSelect(this);
            this.nextSibling.classList.toggle("select-hide");
            this.classList.toggle("select-arrow-active");
        });
    }
}
function closeAllSelect(elmnt) {
    /* A function that will close all select boxes in the document,
    except the current select box: */
    var x, y, i, xl, yl, arrNo = [];
    x = document.getElementsByClassName("select-items");
    y = document.getElementsByClassName("select-selected");
    xl = x.length;
    yl = y.length;
    for (i = 0; i < yl; i++) {
        if (elmnt == y[i]) {
            arrNo.push(i)
        } else {
            y[i].classList.remove("select-arrow-active");
        }
    }
    for (i = 0; i < xl; i++) {
        if (arrNo.indexOf(i)) {
            x[i].classList.add("select-hide");
        }
    }
}