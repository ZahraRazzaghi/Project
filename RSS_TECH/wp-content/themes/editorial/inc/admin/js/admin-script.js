jQuery(document).ready(function($) {
    "use strict";

    /**
     * Script for switch option
     */
    $('.switch_options').each(function() {
        //This object
        var obj = $(this);

        var switchPart = obj.children('.switch_part').attr('data-switch');
        var input = obj.children('input'); //cache the element where we must set the value
        var input_val = obj.children('input').val(); //cache the element where we must set the value

        obj.children('.switch_part.'+input_val).addClass('selected');
        obj.children('.switch_part').on('click', function(){
            var switchVal = $(this).attr('data-switch');
            obj.children('.switch_part').removeClass('selected');
            $(this).addClass('selected');
            $(input).val(switchVal).change(); //Finally change the value to 1
        });

    });

    /**
     * Script for image selected from radio option
     */
     $('.controls#editorial-img-container li img').click(function(){
        $('.controls#editorial-img-container li').each(function(){
            $(this).find('img').removeClass ('editorial-radio-img-selected') ;
        });
        $(this).addClass ('editorial-radio-img-selected') ;
    });

});