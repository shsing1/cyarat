/*global $*/
$(function () {
    'use strict';

    var menu_li = $('#navigation>div>ul>li>a');

    // 左方選單點擊事件
    menu_li.click(function (evt) {
        evt.preventDefault();
        var $this = $(this),
            parent = $this.parent(),
            ul = parent.children('ul');


        if (!parent.hasClass('open')) {
            parent.parent().children('.open').not(parent).children('ul').slideUp(400, function () {
                parent.parent().children('.open').not(parent).removeClass('open');
            });
            parent.addClass('open');
            ul.slideDown();
        }
    });
    $('.open ul').show();
});