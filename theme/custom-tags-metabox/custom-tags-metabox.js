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