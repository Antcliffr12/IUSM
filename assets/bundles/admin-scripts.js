/*
 * Attaches the image uploader to the input field
 */
jQuery(document).ready(function($){

    // Instantiates the variable that holds the media library frame.
    var meta_image_frame;

    // Runs when the image button is clicked.
    $('.meta-image-button').click(function(e){

        // Prevents the default action from occuring.
        e.preventDefault();

        // If the frame already exists, re-open it.
        if ( meta_image_frame ) {
            meta_image_frame.open();
            return;
        }

        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: meta_image.title,
            button: { text:  meta_image.button },
            library: { type: 'image' }
        });

        // Runs when an image is selected.
        meta_image_frame.on('select', function(){

            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = meta_image_frame.state().get('selection').first().toJSON();

            // Sends the attachment URL to our custom image input field.
            $('.meta-image').val(media_attachment.url);
        });

        // Opens the media library frame.
        meta_image_frame.open();
    });

    $('.meta-image-remove-image').click(function(){
        $('.meta-image').attr('value', '');
    });


});
/*
 Disables banner text input field for Section Banner Title in admin.
 */
jQuery(document).ready(function($){

    var titleDisplay = $('#section-banner-title-display'),
        titleInput = $('#section-level-banner-title').find('input[type="text"]');


    if(titleDisplay.length > 0){
        var buttons = titleDisplay.find('input[type="radio"]');
        var value = titleDisplay.find('input:checked').val();
        if(value != 'normal'){
            titleInput.prop('disabled', true);
        }else{
            titleInput.prop('disabled', false);
        }

        buttons.change(function(){
            if(this.value != 'normal'){
                titleInput.prop('disabled', true);
            }else{
                titleInput.prop('disabled', false);
            }
        });
    }

});
jQuery('document').ready(function($){

    var root = $('#taxonomy-post_tag');
    var selector = root.find('select.tag-selector');
    var addButton = root.find('input[type="button"].tag-selector-add')
    var tagCheckList = root.find('.tagchecklist');
    var inputFieldCont = root.find('.tagInputFields');

    var index = tagCheckList.data('index');
    addButton.click(function(){
        var value = selector.val();
        if(value !== '0') {
            var newIndex = index + 1;
            var appendedHtml = '<span><button data-tag-value="'+ value +'" type="button" id="post_tag-check-num-' + newIndex + '" class="ntdelbutton">';
            appendedHtml += '<span class="remove-tag-icon" aria-hidden="true"></span>';
            appendedHtml += '<span class="screen-reader-text">Remove term:' + value + '</span>';
            appendedHtml += '</button>&nbsp;' + value + '</span>';

            tagCheckList.append(appendedHtml);
            selector.find('option[value="' + value + '"]').remove(); //remove new value.
            tagCheckList.attr('data-index', newIndex); //update index value.
            addInputFields(value);
            removeTags();
        }
    });


    function removeTags() {
        tagCheckList.find('button.ntdelbutton').each(function () {
            var _this = $(this);
            var removedValue = _this.data('tag-value');
            _this.click(function () {
                selector.append('<option value="' + removedValue + '">' + removedValue + '</option>'); //add value back to dropdown list
                tagCheckList.attr('data-index', index - 1);
                //remove item
                _this.parent().remove();
                removeInputFields(removedValue);
            });
        });
    }
    removeTags();


    function addInputFields(value){
        var html = '<input type="hidden" name="tax_input[post_tag][]" value="'+ value +'" />';
        inputFieldCont.append(html);
    }

    function removeInputFields(value){
        inputFieldCont.find('input[value="'+ value +'"]').remove();
    }
});