jQuery(document).ready(function($){

   var editorial_upload;
   var editorial_selector;

   function editorial_add_file(event, selector) {

      var upload = $(".uploaded-file"), frame;
      var $el = $(this);
      editorial_selector = selector;

      event.preventDefault();

      // If the media frame already exists, reopen it.
      if ( editorial_upload ) {
         editorial_upload.open();
      } else {
         // Create the media frame.
         editorial_upload = wp.media.frames.editorial_upload =  wp.media({
            // Set the title of the modal.
            title: $el.data('choose'),

            // Customize the submit button.
            button: {
               // Set the text of the button.
               text: $el.data('update'),
               // Tell the button not to close the modal, since we're
               // going to refresh the page when the image is selected.
               close: false
            }
         });

         // When an image is selected, run a callback.
         editorial_upload.on( 'select', function() {
            // Grab the selected attachment.
            var attachment = editorial_upload.state().get('selection').first();
            editorial_upload.close();
            editorial_selector.find('.upload').val(attachment.attributes.url);
            if ( attachment.attributes.type == 'image' ) {
               editorial_selector.find('.screenshot').empty().hide().append('<img src="' + attachment.attributes.url + '" style="width:100%;">').slideDown('fast');
            }
            editorial_selector.find('.wid-upload-button').unbind().addClass('wid-remove-file').removeClass('wid-upload-button').val(editorial_l10n.remove);
            editorial_selector.find('.of-background-properties').slideDown();
            editorial_selector.find('.remove-image, .wid-remove-file').on('click', function() {
               editorial_remove_file( $(this).parents('.section') );
            });
         });
      }

      // Finally, open the modal.
      editorial_upload.open();
   }

   function editorial_remove_file(selector) {
      selector.find('.remove-image').hide();
      selector.find('.upload').val('');
      selector.find('.of-background-properties').hide();
      selector.find('.screenshot').slideUp();
      selector.find('.wid-remove-file').unbind().addClass('wid-upload-button').removeClass('wid-remove-file').val(editorial_l10n.upload);
      // We don't display the upload button if .upload-notice is present
      // This means the user doesn't have the WordPress 3.5 Media Library Support
      if ( $('.section-upload .upload-notice').length > 0 ) {
         $('.upload-button').remove();
      }
      selector.find('.upload-button').on('click', function(event) {
         editorial_add_file(event, $(this).parents('.sub-option'));
      });
   }

   $('body').on('click', '.remove-image, .wid-remove-file', function() {
      editorial_remove_file( $(this).parents('.sub-option') );
    });

    $('body').on('click', '.wid-upload-button', function( event ) {
      editorial_add_file(event, $(this).parents('.sub-option'));
    });

});