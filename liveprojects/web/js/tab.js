// JavaScript Document
$(document).ready(function(e) {
     $('a[data-toggle="tab"]').on('shown.bs.tab', function () {

        //save the latest tab; use cookies if you like 'em better:

        localStorage.setItem('lastTab_leadview', $(this).attr('href'));

    });



    //go to the latest tab, if it exists:

    var lastTab_leadview = localStorage.getItem('lastTab_leadview');

    if ($('a[href=' + lastTab_leadview + ']').length > 0) {

        $('a[href=' + lastTab_leadview + ']').tab('show');

    }

    else

    {

        // Set the first tab if cookie do not exist

        $('a[data-toggle="tab"]:first').tab('show');

    }
});