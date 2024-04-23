<?php
/* Put all the JS scripts for the <head> section below this comment.
The scripts will work on the entire site */
?>
<script>
    const SMOOTHSCROLL_SPEED = 200;
    const SMOOTHSCROLL_INERTIA = 12;
    function initDocumentSmoothScroll(){
        new SmoothScroll(document,SMOOTHSCROLL_SPEED,SMOOTHSCROLL_INERTIA)
    }
    function initSmoothScroll() {
        let scrollElements = document.querySelectorAll('[data-scrollbar]');
        for (let i = 0; i < scrollElements.length; i++) {
            let scrollElement = scrollElements[i];
            if (scrollElement.getAttribute('smooth-scroll-loaded') !== 'true') {
                new SmoothScroll(scrollElements[i], SMOOTHSCROLL_SPEED, SMOOTHSCROLL_INERTIA);
            }
        }
    }
    function initSmoothScrollH(){
        new SmoothHorizontalScroll(150,10)
    }
    function initSmoothScrollHCurrent(){
        new SmoothHorizontalScrollCurrent(150,10)
    }
    function SmoothScroll(target, speed, smooth) {
        var isDocument;
        if (target === document) {
            isDocument = true;
            target = (document.scrollingElement
                || document.documentElement
                || document.body.parentNode
                || document.body) // cross browser support for document scrolling

        }
        var moving = false
        var pos = target.scrollTop
        var frame = target === document.body
        && document.documentElement
            ? document.documentElement
            : target // safari is the new IE

        target.addEventListener('mousewheel', scrolled, { passive: false })
        target.addEventListener('DOMMouseScroll', scrolled, { passive: false })
        target.setAttribute('smooth-scroll-loaded', 'true');

        function scrolled(e) {
            var hoveredElement = jQuery(e.target = e.target || e.srcElement);
            if (isDocument && (hoveredElement.is('[data-scrollbar]') || hoveredElement.closest('[data-scrollbar]').length)) {
                return true;
            }
            e.preventDefault(); // disable default scrolling
            var delta = normalizeWheelDelta(e)
            pos = target.scrollTop
            pos += -delta * speed
            pos = Math.max(0, Math.min(pos, target.scrollHeight - frame.clientHeight)) // limit scrolling
            if (!moving) update()
        }

        function normalizeWheelDelta(e){
            if(e.detail){
                if(e.wheelDelta)
                    return e.wheelDelta/e.detail/40 * (e.detail>0 ? 1 : -1) // Opera
                else
                    return -e.detail/3 // Firefox
            }else
                return e.wheelDelta/120 // IE,Safari,Chrome
        }

        function update() {
            moving = true
            var $body = jQuery('body');
            if ($body.is(':animated')) {
                moving = false;
                return;
            }

            var delta = (pos - target.scrollTop) / smooth
            var prevScrollTop = target.scrollTop;
            target.scrollTop += delta

            if (Math.abs(delta) > 0 && prevScrollTop != target.scrollTop)
                requestFrame(update)
            else
                moving = false
        }

        var requestFrame = function() { // requestAnimationFrame cross browser
            return (
                window.requestAnimationFrame ||
                window.webkitRequestAnimationFrame ||
                window.mozRequestAnimationFrame ||
                window.oRequestAnimationFrame ||
                window.msRequestAnimationFrame ||
                function(func) {
                    window.setTimeout(func, 1000 / 50);
                }
            );
        }()
    }

    // Smooth scrolling between the home sections
    function SmoothHorizontalScroll(speed, smooth) {
        var moving = false

        var owlStage = jQuery('.owl-stage').first();
        var owlStageNode = owlStage.get(0);
        var itemsCount = owlStage.children('.owl-item').length;
        var currentItem = owlStage.children('.owl-item.active').first();
        var currentItemWidth = owlStage.children('.owl-item.active').first().width();
        var currentItemIndex = currentItem.index();
        var transformStyle = owlStageNode.style.transform;
        var rx = /translate3d\((\-?[0-9]+\.?[0-9]*)(px)?,\s*[\-0-9]+(px)?,\s*[\-0-9]+(px)?\)/;
        var translateVal = parseInt(rx.exec(transformStyle)[1]) || 0;
        var maxTranslateVal = (owlStage.width()-currentItemWidth);
        var owlHome = jQuery('.home-sections');

        var pos = -translateVal;

        owlStageNode.addEventListener('mousewheel', scrolled, { passive: false })
        owlStageNode.addEventListener('DOMMouseScroll', scrolled, { passive: false })

        function scrolled(e) {
            var hoveredElement = jQuery(e.target = e.target || e.srcElement);
            // Skip event for "News" section - scroll the news separately
            if (hoveredElement.hasClass('news-items') || hoveredElement.closest('.news-items').length
                || hoveredElement.hasClass('current-slides') || hoveredElement.closest('.current-slides').length
            ) {
                return true;
            }

            e.preventDefault(); // disable default scrolling

            var delta = normalizeWheelDelta(e)

            // Update position
            transformStyle = jQuery('.owl-stage').first().get(0).style.transform;
            translateVal = parseInt(rx.exec(transformStyle)[1]) || 0;
            pos = -translateVal;
            pos += -delta * speed
            pos = Math.max(0, Math.min(pos, maxTranslateVal)) // limit scrolling

            if (!moving) update()
        }

        function normalizeWheelDelta(e){
            if(e.detail){
                if(e.wheelDelta)
                    return e.wheelDelta/e.detail/40 * (e.detail>0 ? 1 : -1) // Opera
                else
                    return -e.detail/3 // Firefox
            }else
                return e.wheelDelta/120 // IE,Safari,Chrome
        }

        function update() {
            moving = true
            if (jQuery('body').hasClass('owl-changing')) {
                moving = false;
                return;
            }

            var delta = (pos + translateVal) / smooth
            translateVal -= delta;
            owlStageNode.style.transition = 'none';
            owlStageNode.style.transform = 'translate3d('+translateVal+'px,0,0)';

            if (Math.abs(delta) > 2)
                requestFrame(update)
            else {
                moving = false
                if (delta > 0) {
                    owlHome.trigger('next.owl.carousel');
                } else if (delta < 0) {
                    owlHome.trigger('prev.owl.carousel');
                }
            }
        }

        var requestFrame = function() { // requestAnimationFrame cross browser
            return (
                window.requestAnimationFrame ||
                window.webkitRequestAnimationFrame ||
                window.mozRequestAnimationFrame ||
                window.oRequestAnimationFrame ||
                window.msRequestAnimationFrame ||
                function(func) {
                    window.setTimeout(func, 1000 / 50);
                }
            );
        }()
    }

    // Smooth scrolling for the current section
    function SmoothHorizontalScrollCurrent(speed, smooth) {
        var moving = false

        var owlStage = jQuery('.current-slides-inner .owl-stage').first();
        var owlStageNode = owlStage.get(0);
        var itemsCount = owlStage.children('.owl-item').length;
        if (itemsCount == owlStage.children('.owl-item.active').length)
            return;
        var currentItem = owlStage.children('.owl-item.active').first();
        var currentItemWidth = 0;
        owlStage.children('.owl-item.active').each(function(index,element){
            currentItemWidth += parseInt(jQuery(element).outerWidth(true), 10);
        })
        var currentItemIndex = currentItem.index();
        var transformStyle = owlStageNode.style.transform;
        var rx = /translate3d\((\-?[0-9]+\.?[0-9]*)(px)?,\s*[\-0-9]+(px)?,\s*[\-0-9]+(px)?\)/;
        var translateVal = parseInt(rx.exec(transformStyle)[1]) || 0;
        var maxTranslateVal = (owlStage.width()-currentItemWidth);
        var owl = jQuery('.current-slides-inner');

        var pos = -translateVal;

        owlStageNode.addEventListener('mousewheel', scrolled, { passive: false })
        owlStageNode.addEventListener('DOMMouseScroll', scrolled, { passive: false })

        function scrolled(e) {
            var hoveredElement = jQuery(e.target = e.target || e.srcElement);
            // Skip event for "News" section - scroll the news separately
//            if (hoveredElement.hasClass('news-item-content') || hoveredElement.closest('.news-item-content').length
//                || hoveredElement.hasClass('current-slides') || hoveredElement.closest('.current-slides').length
//            ) {
//                return true;
//            }

            e.preventDefault(); // disable default scrolling

            var delta = normalizeWheelDelta(e)

            // Update position
            transformStyle = jQuery('.current-slides-inner .owl-stage').first().get(0).style.transform;
            translateVal = parseInt(rx.exec(transformStyle)[1]) || 0;
            pos = -translateVal;
            pos += -delta * speed
            pos = Math.max(0, Math.min(pos, maxTranslateVal)) // limit scrolling

            if (!moving) update()
        }

        function normalizeWheelDelta(e){
            if(e.detail){
                if(e.wheelDelta)
                    return e.wheelDelta/e.detail/40 * (e.detail>0 ? 1 : -1) // Opera
                else
                    return -e.detail/3 // Firefox
            }else
                return e.wheelDelta/120 // IE,Safari,Chrome
        }

        function update() {
            moving = true
            if (jQuery('body').hasClass('owl-changing')) {
                moving = false;
                return;
            }

            var delta = (pos + translateVal) / smooth
            translateVal -= delta;
            owlStageNode.style.transition = 'none';
            owlStageNode.style.transform = 'translate3d('+translateVal+'px,0,0)';

            if (Math.abs(delta) > 2)
                requestFrame(update)
            else {
                moving = false
                if (delta > 0) {
                    owl.trigger('next.owl.carousel');
                } else if (delta < 0) {
                    owl.trigger('prev.owl.carousel');
                }
            }
        }

        var requestFrame = function() { // requestAnimationFrame cross browser
            return (
                window.requestAnimationFrame ||
                window.webkitRequestAnimationFrame ||
                window.mozRequestAnimationFrame ||
                window.oRequestAnimationFrame ||
                window.msRequestAnimationFrame ||
                function(func) {
                    window.setTimeout(func, 1000 / 50);
                }
            );
        }()
    }

</script>
