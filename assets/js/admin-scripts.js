jQuery(document).ready(function ($) {


  /**
   * Settings screen JS
   */
  var FFW_PORT_Settings = {

    init : function() {
      this.general();
    },

    general : function() {

      if( $('.ffw_port-color-picker').length ) {
        $('.ffw_port-color-picker').wpColorPicker();
      }

        // Settings Upload field JS
        if( typeof wp == "undefined" || ffw_port_vars.new_media_ui != '1' ){
        //Old Thickbox uploader
        if ( $( '.ffw_port_settings_upload_button' ).length > 0 ) {
          window.formfield = '';

          $('body').on('click', '.ffw_port_settings_upload_button', function(e) {
            e.preventDefault();
            window.formfield = $(this).parent().prev();
            window.tbframe_interval = setInterval(function() {
              jQuery('#TB_iframeContent').contents().find('.savesend .button').val(ffw_port_vars.use_this_file).end().find('#insert-gallery, .wp-post-thumbnail').hide();
            }, 2000);
            tb_show(ffw_port_vars.add_new_download, 'media-upload.php?TB_iframe=true');
          });

          window.ffw_port_send_to_editor = window.send_to_editor;
          window.send_to_editor = function (html) {
            if (window.formfield) {
              imgurl = $('a', '<div>' + html + '</div>').attr('href');
              window.formfield.val(imgurl);
              window.clearInterval(window.tbframe_interval);
              tb_remove();
            } else {
              window.ffw_port_send_to_editor(html);
            }
            window.send_to_editor = window.ffw_port_send_to_editor;
            window.formfield = '';
            window.imagefield = false;
          }
        }
      } else {
        // WP 3.5+ uploader
        var file_frame;
        window.formfield = '';

        $('body').on('click', '.ffw_port_settings_upload_button', function(e) {

          e.preventDefault();

          var button = $(this);

          window.formfield = $(this).parent().prev();

          // If the media frame already exists, reopen it.
          if ( file_frame ) {
            //file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
            file_frame.open();
            return;
          }

          // Create the media frame.
          file_frame = wp.media.frames.file_frame = wp.media({
            frame: 'post',
            state: 'insert',
            title: button.data( 'uploader_title' ),
            button: {
              text: button.data( 'uploader_button_text' ),
            },
            multiple: false
          });

          file_frame.on( 'menu:render:default', function(view) {
                // Store our views in an object.
                var views = {};

                // Unset default menu items
                view.unset('library-separator');
                view.unset('gallery');
                view.unset('featured-image');
                view.unset('embed');

                // Initialize the views in our view object.
                view.set(views);
            });

          // When an image is selected, run a callback.
          file_frame.on( 'insert', function() {

            var selection = file_frame.state().get('selection');
            selection.each( function( attachment, index ) {
              attachment = attachment.toJSON();
              window.formfield.val(attachment.url);
            });
          });

          // Finally, open the modal
          file_frame.open();
        });


        // WP 3.5+ uploader
        var file_frame;
        window.formfield = '';
      }

    }

  }
  FFW_PORT_Settings.init();


});