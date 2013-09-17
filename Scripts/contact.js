/*global $*/
/*jslint browser: true */
$(function () {
    'use strict';

    var form = $('form');

    form.validationEngine({
        showOneMessage : true
    }).submit(function (evt) {
        evt.preventDefault();
        var data,
            mask;
        if (form.validationEngine('validate')) {
            data = form.find(':input');
            mask = window.myprocessing();
            window.myajax({
                'url' : 'ajax_contact.php',
                'data' : data,
                'success' : function (rs) {
                    mask.dialog("destroy");
                    if (rs.error) {
                        window.myalert(rs.msg);
                    } else {
                        window.myalert(rs.msg);
                        form.get(0).reset();
                    }

                }
            });
        }
    });

    // myalert();
});