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