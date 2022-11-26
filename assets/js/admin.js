/* global jQuery */
jQuery(function($){

    $(document).on('click', '#wcforce-test', function(){
        
        handleWPMediaUpload('wpmedia-box');
    })
    
    var frame;
    
    function handleWPMediaUpload(dom_box, field){
        
        var wp_media_type = 'image';
        // if (field.type == 'audio') {
        //     wp_media_type = 'audio,video';
        // }
        
        // If the media frame already exists, reopen it.
        if ( frame ) {
          frame.open();
          return;
        }
        
            const params = {
                    title: 'Choose Images',
                    library: {
                        type: wp_media_type
                    },
                    button: {
                        text: 'Add Image'
                    },
                    multiple: true
                }
        
        frame = wp.media(params);

        frame.on('close',function() {
            var selection = frame.state().get('selection');
            console.log('close', selection);
            if(!selection.length){
                
            }
        });
        
        frame.on( 'select',function() {
            var state = frame.state();
            var attachment = frame.state().get('selection').toJSON();
            // var selection = state.get('selection');
            console.log('select', attachment);
            
            // selection.each(function(attachment) {
            //     console.log(attachment.attributes);
            // });
        });
        
        frame.open();
    }
})

function wcforce_get_wp_media(params){
    return wp.media(params);
}