/*global $*/
$(function () {
    'use strict';

    var news_open_btn = $('#news_open_btn'),
        news_close_btn = $('#news_close_btn'),
        news_panel = $('#news_panel');

    $('#slider').anythingSlider({
        buildNavigation : false,
        buildStartStop : false,
        appendForwardTo : $('#slider_forward'),
        appendBackTo : $('#slider_back'),
        forwardText : '',
        backText : '',
        autoPlay : true,
        hashTags : false
    }).anythingSliderFx({
        inFx : {
            '.main_title' : {top : 295, duration: 400, easing : 'easeOutBounce'},
            '.sub_title' : {top : 350, duration: 400, easing : 'easeOutBounce'}
        },
        outFx : {
            '.main_title' : {top : -2000, duration: 400, easing : 'easeOutBounce'},
            '.sub_title' : {top : -2000, duration: 400, easing : 'easeOutBounce'}
        }
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

    $('.news_title').trunk8();
    $('.news_brief').trunk8({width : 35});
});