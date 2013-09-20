/*global $*/
/*jslint browser: true */
$(function () {
    'use strict';

    var container  = $('.masonry_panel');

    container.each(function () {
        $(this).masonry({
            columnWidth: 210,
            itemSelector: '.art_list',
            "gutter": 60
        });
    });
});