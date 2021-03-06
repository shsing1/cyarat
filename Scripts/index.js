/*global $*/
/*jslint browser : true*/
$(function () {
    'use strict';

    var news_open_btn = $('#news_open_btn'),
        news_close_btn = $('#news_close_btn'),
        news_panel = $('#news_panel'),
        slider,
        win = $(window);

    slider = $('#slider').anythingSlider({
        buildNavigation : false,
        buildStartStop : false,
        appendForwardTo : $('#slider_forward'),
        appendBackTo : $('#slider_back'),
        forwardText : '',
        backText : '',
        autoPlay : false,
        hashTags : false,
        resizeContents : false
    }).anythingSliderFx({
        /*inFx : {
            '.main_title' : {top : 295, duration: 400, easing : 'easeOutBounce'},
            '.sub_title' : {top : 350, duration: 400, easing : 'easeOutBounce'}
        },
        outFx : {
            '.main_title' : {top : -2000, duration: 400, easing : 'easeOutBounce'},
            '.sub_title' : {top : -2000, duration: 400, easing : 'easeOutBounce'}
        }*/
        '.main_title' : ['fade'],
        '.sub_title' : ['fade']
    });

    win.resize(function() {
        slider.find('.rsContent').css({'max-width' : '100%'});
        slider.data('AnythingSlider').updateSlider();
    });

    news_open_btn.click(function (evt) {
        evt.preventDefault();
        news_open_btn.hide();
        news_panel.slideDown();
    });
    news_close_btn.click(function (evt) {
        evt.preventDefault();
        news_panel.slideUp(400, function () {
            news_open_btn.show();
        });
    });

    $('.news_title').each(function () {
        var $this = $(this);
        if ($this.text().length > 15) {
            $this.trunk8({width : 15});
        }
    });
    $('.news_brief').each(function () {
        var $this = $(this);
        if ($this.text().length > 0) {
            $this.trunk8({width : 30});
        }
    });
});