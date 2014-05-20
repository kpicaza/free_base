(function($) {
    Drupal.behaviors.freeee = {
        attach: function(context, settings) {

            // Open modal window when $messages tpl variable is not empty.
            var messages = $('#messagesModal .modal-body').children('div').attr('class');
            if (messages) {
                $('a#messagesOp').trigger('click');
            }

            // Style "New" tag.
            $('span.new').addClass('label label-info');

            // Style images.
            $('.content img').addClass('img-thumbnail');
        }
    };
})(jQuery);
