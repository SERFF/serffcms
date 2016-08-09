var selected_images = [];

$(function () {
    loadModal();

    init();
});

function update_gallery_preview(original_id, object, image_id) {
    var image_html = '';
    var items = object.val().split('|');
    var found = false;
    $.each(items, function (item, value) {
        if (!isNaN(parseInt(value))) {
            var source = GeneralRoutes.image_route.replace('/id/', '/' + value + '/').replace('/name/', '/exampleimage/').replace('/width/', '/150/').replace('/height', '/150');
            image_html += '<img id="' + image_id + '" class="img-rounded gallery-image-item" src="' + source + '">';
            found = true;
        }
    });
    if (found == false) {
        image_html += '<img id="' + image_id + '" class="img-rounded gallery-image-item" src="http://placehold.it/150x150">';
    }
    object.parent().find('#galleryWrapper' + image_id).remove();
    object.parent().append('<p id="galleryWrapper' + image_id + '">' + image_html + '</p>');

    set_gallery_functions(original_id, image_id, object);
}

function set_gallery_functions(original_id, image_id, image_object) {
    $('#galleryWrapper'+image_id).unbind('click');
    $('#galleryWrapper'+image_id).on('click', function () {
        $('#galleryModal').find('#max_gallery_items').val(99);
        $('#galleryModal').modal();
        $('#galleryModal').find('#finishSelectImages').unbind('click');
        $('#galleryModal').find('#finishSelectImages').on('click', function () {
            finishSelectGallery(original_id);
            update_gallery_preview(original_id, image_object, image_id);
        });
        selected_images = [];
        $('#galleryModal').find('.gallery_image').removeClass('active');
        $.ajax({
            url: GeneralRoutes.media_library_route,
            method: 'GET'
        }).done(function (result) {
            $.each(result, function (key, value) {
                addImageToGallery(value.thumb, value.id);
            });

            $('#galleryModal').find('img').each(function () {
                $(this).unbind('click');
                $(this).on('click', function () {
                    var max_items = $('#galleryModal').find('#max_gallery_items').val();
                    if (in_array(selected_images, $(this).attr('data-image-id'))) {
                        $(this).removeClass('active');
                        remove_from_array(selected_images, $(this).attr('data-image-id'))
                    } else {
                        if (selected_images.length == max_items) {
                            selected_images.shift();
                        }
                        selected_images[selected_images.length] = $(this).attr('data-image-id');
                    }
                    update_active_items();
                });
            });
        });
    });
}

function finishSelectImage(image_id, original_id) {
    var source = GeneralRoutes.image_route.replace('/id/', '/' + selected_images[0] + '/').replace('/name/', '/exampleimage/').replace('/width/', '/150/').replace('/height', '/150');
    console.log(image_id, original_id);
    $('#' + image_id).attr('src', source);
    $('#' + original_id).val(selected_images[0])
    $('#galleryModal').modal('hide');
    init();
}

function finishSelectGallery(original_id) {
    $('#' + original_id).val(selected_images.join('|'));
    $('#galleryModal').modal('hide');
    init();
}

function loadModal() {
    $.ajax({
        url: GeneralRoutes.modal_route,
        method: 'GET'
    }).done(function (result) {
        $('body').after(result);
    });
}

function addImageToGallery(url, id) {
    var imageUrl = GeneralRoutes.image_route.replace('/id/', '/' + id + '/').replace('/name/', '/gallery/').replace('/width/', '/150/').replace('/height', '/150');
    var html = '<img data-image-id="' + id + '" class="img-thumbnail gallery_image" id="galleryImage"  src="' + imageUrl + '">';
    $('#galleryModal').find('#gallery').append(html);
}

function update_active_items() {
    $('#galleryModal').find('.gallery_image').removeClass('active');

    $('#galleryModal').find('.gallery_image').each(function () {
        if (in_array(selected_images, $(this).attr('data-image-id'))) {
            $(this).addClass('active');
        }
    });

}

function in_array(array, value) {
    found = false;
    for (i = 0; i < array.length; i++) {
        if (array[i] == value) {
            found = true;
        }
    }
    return found;
}

function remove_from_array(array, value) {
    index = array.indexOf(value);
    if (index > -1) {
        array.splice(index, 1);
    }
    return array;
}

function init()
{
    $('input').each(function () {
        var image_id = '';
        var original_id = '';
        if ($(this).attr('cf_type') == 'image') {
            var source = GeneralRoutes.image_route.replace('/id/', '/' + $(this).val() + '/').replace('/name/', '/exampleimage/').replace('/width/', '/150/').replace('/height', '/150');
            image_id = 'image_' + $(this).attr('id').replace('.', '_');
            original_id = $(this).attr('id');
            $(this).attr('type', 'hidden');
            $(this).parent().find('#previewImage').remove();
            $(this).parent().append('<p id="previewImage"><img id="' + image_id + '" class="img-rounded gallery-image-item" src="' + source + '"></p>')
            $('#' + image_id).unbind('click');
            $('#' + image_id).on('click', function () {
                $('#galleryModal').find('#max_gallery_items').val(1);
                $('#galleryModal').modal();
                $('#galleryModal').find('#finishSelectImages').unbind('click');
                $('#galleryModal').find('#finishSelectImages').on('click', function () {
                    finishSelectImage(image_id, original_id);
                });
                selected_images = [];
                $('#galleryModal').find('.gallery_image').removeClass('active');
                $.ajax({
                    url: GeneralRoutes.media_library_route,
                    method: 'GET'
                }).done(function (result) {
                    $.each(result, function (key, value) {
                        addImageToGallery(value.thumb, value.id);
                    });

                    $('#galleryModal').find('img').each(function () {
                        $(this).unbind('click');
                        $(this).on('click', function () {
                            var max_items = $('#galleryModal').find('#max_gallery_items').val();
                            if (selected_images.length == max_items) {
                                selected_images.shift();
                            }
                            selected_images[selected_images.length] = $(this).attr('data-image-id');
                            update_active_items();
                        });
                    });
                });

            });
        }
        if ($(this).attr('cf_type') == 'gallery') {
            $(this).attr('type', 'hidden');
            image_id = 'gallery_' + $(this).attr('id').replace('.', '_');
            original_id = $(this).attr('id');
            var image_object = $(this);
            update_gallery_preview(original_id, image_object, image_id);
            set_gallery_functions(original_id, image_id, image_object);
        }
    });
}
