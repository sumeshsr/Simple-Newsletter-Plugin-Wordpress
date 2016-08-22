
/*
 *simple-newsletter.js
 */
(function( $ ) {
 

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
    jQuery('#upload_image_button').click(function() {
     formfield = jQuery('#upload_image').attr('name');
     tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
     return false;
    });
     
    window.send_to_editor = function(html) {
     imgurl = jQuery(html).attr('src');
     jQuery('#upload_image').attr('src' ,imgurl);
     if( imgurl == "" ){
        jQuery('#upload_image').fadeOut();
        jQuery('label[for="upload_image_button"]').fadeIn();
     }else{
        jQuery('#upload_image').removeClass('hidden').fadeIn();
         jQuery('label[for="upload_image_button"]').fadeOut();
     }
     tb_remove();
    }
});
$('form#simple_newsletter_table input[name="bulk_select"]').on( 'change' , function(){
    var checked = $(this).prop('checked');
    if( checked ){
        $(this).closest('table.table').find('td > input[type="checkbox"]').prop('checked' , true );
    }else{
        $(this).closest('table.table').find('td > input[type="checkbox"]').prop('checked' , false );
    }
});

$('form#simple_newsletter_table td > input[type="checkbox"]').on( 'change' , function(){
    var checkbox        = $('form#simple_newsletter_table td > input[type="checkbox"]');
    var checkedbox      = $('form#simple_newsletter_table td > input[type="checkbox"]:checked');
    var checked         = checkedbox.length;
    var total_checkbox  = checkbox.length;
    if( checked ==  total_checkbox ){
        $('form#simple_newsletter_table input[name="bulk_select"]').prop('checked' , true );
    }else{
        $('form#simple_newsletter_table input[name="bulk_select"]').prop('checked' , false );
    }
});

})(jQuery);