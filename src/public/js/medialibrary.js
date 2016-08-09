$(function () {
    $('.media-library').find('.image-library-container').each(function () {

        $(this).hover(function () {
            overlay = $(this).find('.library-overlay');
            overlay.show();
        }, function () {
            overlay = $(this).find('.library-overlay');
            overlay.hide();
        });

        $(this).click(function () {
            $('#mediaModalLabel').html($(this).find('#media-title').val());
            $('#mediaModalImage').attr('src', $(this).find('#media-image').val());
            $('#mediaModal').modal({});
        });
    })
});