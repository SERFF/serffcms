(function ($) {
    $.Redactor.prototype.imageedit = function () {

        return {
            getTemplate: function () {
                return String()
                    + '<div class="modal-section" id="redactor-modal-imageedit">'
                    + '<section>'
                    + '<label>Enter a text</label>'
                    + '<textarea id="mymodal-textarea" rows="6"></textarea>'
                    + '</section>'
                    + '<section>'
                    + '<button id="redactor-modal-button-action">Insert</button>'
                    + '<button id="redactor-modal-button-cancel">Cancel</button>'
                    + '</section>'
                    + '</div>';
            },
            init: function () {
                console.log(this.opts.imageEditable);
            },
            show: function () {
                this.modal.addTemplate('imageedit', this.imageedit.getTemplate());
                this.modal.load('imageedit', 'imageedit Modal', 400);

                var button = this.modal.getActionButton();
                button.on('click', this.imageedit.insert);

                this.modal.show();

                $('#mymodal-textarea').focus();
            },
            insert: function () {
                var html = $('#mymodal-textarea').val();

                this.modal.close();
                this.insert.html(html);
            }
        };
    }
})(jQuery);