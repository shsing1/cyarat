/*global $*/
/*jslint browser: true */
$(function () {
    'use strict';

    var menu_li = $('#navigation>div>ul>li>a'),
        qa_li = $('#qa_list>ul>li>a'),
        qa_option = $('#qa_select option'),
        myalert,
        myajax,
        myprocessing;

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

    // Q&A點擊事件
    qa_li.click(function (evt) {
        evt.preventDefault();
        var $this = $(this),
            parent = $this.parent(),
            ul = parent.children('ul'),
            other_li,
            index = qa_li.index($this);


        if (!parent.hasClass('open')) {
            other_li =  parent.parent().children('.open').not(parent);
            if (other_li.children('ul').length > 0) {
                other_li.children('ul').slideUp(400, function () {
                    other_li.removeClass('open');
                });
            } else {
                other_li.removeClass('open');
            }

            parent.addClass('open');
            ul.slideDown();

            qa_option.eq(index).prop({'selected' : true});
        }
    });

    $('#qa_select').change(function () {
        qa_li.eq(qa_option.filter(':selected').index()).trigger('click');
    });

    myalert = function (msg) {
        var div = $('<div>').appendTo('body');

        div.attr({'title' : '系統訊息'});
        div.html(msg);
        div.dialog({
            modal : true
        });
    };
    window.myalert = myalert;

    myajax = function (option) {
        var op = {
            dataType : 'json',
            type : 'post'
        };

        $.extend(op, option);
        $.ajax(op);
    };
    window.myajax = myajax;

    myprocessing = function (msg) {
        var div = $('<div>').appendTo('body');

        if (!msg) {
            msg = '處理中';
        }
        div.attr({'title' : '系統訊息'});
        div.html(msg);
        div.dialog({
            modal : true,
            create: function() {
                div.parent().find('.ui-button').remove();
            }
        });
        return div;
    };
    window.myprocessing = myprocessing;
});