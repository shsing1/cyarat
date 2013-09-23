/*global $*/
/*jslint browser: true */
$(function () {
    'use strict';

    var form = $('form'),
        mindate = $('#mindate'),
        maxdate = $('#maxdate'),
        onMouseOutOpacity,
        search_date = $('.search_date');

    if (form.length > 0) {
        form.validationEngine({
            validationEventTrigger : "",
            showOneMessage : true
        });

        mindate.datepicker({
            minDate: "-6M",
            maxDate: "+0D",
            onClose: function(selectedDate) {
                if (selectedDate) {
                    maxdate.datepicker("option", "minDate", selectedDate);
                }
            }
        });
        maxdate.datepicker({
            minDate: "-6M",
            maxDate: "+0D",
            onClose: function(selectedDate) {
                if (selectedDate) {
                    mindate.datepicker("option", "maxDate", selectedDate);
                }
            }
        });
    }

    // 詳細頁相簿模組
    if ($('#thumbs').length > 0) {
        // We only want these styles applied when javascript is enabled
        $('div.navigation').css({'width' : '182px', 'float' : 'left'});
        $('div.content').css('display', 'block');

        // Initially set opacity on thumbs and add
        // additional styling for hover effect on thumbs
        onMouseOutOpacity = 0.67;
        $('#thumbs ul.thumbs li').opacityrollover({
            mouseOutOpacity:   onMouseOutOpacity,
            mouseOverOpacity:  1.0,
            fadeSpeed:         'fast',
            exemptionSelector: '.selected'
        });

        // Initialize Advanced Galleriffic Gallery
        $('#thumbs').galleriffic({
            delay:                     2500,
            numThumbs:                 10,
            preloadAhead:              10,
            enableTopPager:            false,
            enableBottomPager:         true,
            maxPagesToShow:            1,
            imageContainerSel:         '#slideshow',
            controlsContainerSel:      '#controls',
            captionContainerSel:       '#caption',
            loadingContainerSel:       '#loading',
            renderSSControls:          false,
            renderNavControls:         true,
            playLinkText:              'Play Slideshow',
            pauseLinkText:             'Pause Slideshow',
            prevLinkText:              '&lsaquo; Previous',
            nextLinkText:              'Next &rsaquo;',
            nextPageLinkText:          'Next &rsaquo;',
            prevPageLinkText:          '&lsaquo; Prev',
            enableHistory:             false,
            autoStart:                 false,
            syncTransitions:           true,
            defaultTransitionDuration: 900,
            onSlideChange:             function(prevIndex, nextIndex) {
                // 'this' refers to the gallery, which is an extension of $('#thumbs')
                this.find('ul.thumbs').children()
                    .eq(prevIndex).fadeTo('fast', onMouseOutOpacity).end()
                    .eq(nextIndex).fadeTo('fast', 1.0);
            },
            onPageTransitionOut:       function(callback) {
                this.fadeTo('fast', 0.0, callback);
            },
            onPageTransitionIn:        function() {
                this.fadeTo('fast', 1.0);
            }
        });
    }

    if (search_date.length > 0) {
        search_date.click(function (evt) {
            evt.preventDefault();
            var form = $('<form>').attr({'action' : 'activity_list.php', 'method' : 'POST'}).appendTo('body'),
                input = $('<input>').attr({'name' : 'date', 'value' : $(this).val()});

            input.appendTo(form);

            form.get(0).submit();
        });
    }
});