$(function () {
    var cms = new SerffCMS($('body'));

    cms.initTranslationSettings();
    cms.initPageEditSettings();
    cms.drawTopBar();
});

var SerffCMS = function (body) {
    var self = this;
    this.drawTopBar = function () {
        $(body).prepend(this.topBarHtml());
    };

    this.topBarHtml = function () {
        return "<div class=\"serff_top_bar\">" +
            this.translationButton() +
            this.editPageButton() +
            "<div class='menu_item float_right'><a href='/logout'>Uitloggen</a></div> " +
            "<div class='menu_item float_right'><a href='/dashboard'>Naar Admin Panel</a></div> " +
            "</div>";
    };
    
    this.editPageButton = function() {
        if(PagesRoutes.currentPage != '') {
            return "<div class='menu_item'><a target='_blank' href='" + PagesRoutes.editPageRoute + "'>Bewerk Pagina</a></div> ";
        }
        return '';
    };

    this.translationButton = function () {
        label = 'Bewerkingen Aan';
        if (TRANSLATION_SETTINGS.enabled) {
            label = 'Bewerkingen Uit';
        }
        return "<div class='menu_item'><a href='" + TranslationRoutes.translationToggle + "'>" + label + "</a></div> ";
    };

    this.initPageEditSettings = function () {
        $('.page-editor-element').on("contextmenu", function (evt) {
            evt.preventDefault();
        });
        $('.page-editor-element').mousedown(function (e) {
            e.preventDefault();
            var element = $(this);
            if (e.button == 2) {
                var key = $(this)[0].id;
                $.ajax({
                    url: PagesRoutes.valueGet,
                    method: 'GET',
                    data: {key: key}
                }).done(function (response) {
                    var value = response;

                    self.showPageUpdateModal(key, value, element);
                });
            }
            return false;
        });

    };

    this.initTranslationSettings = function () {
        $('.translation-element').on("contextmenu", function (evt) {
            evt.preventDefault();
        });
        $('.translation-element').mousedown(function (e) {
            e.preventDefault();
            var element = $(this);
            if (e.button == 2) {
                var key = $(this)[0].id;
                $.ajax({
                    url: TranslationRoutes.translationGet,
                    method: 'GET',
                    data: {key: key, locale: GENERAL_SETTINGS.locale}
                }).done(function (response) {
                    var value = response;

                    self.showUpdateModal(key, value, element);
                });
            }
            return false;
        });
    }

    this.showUpdateModal = function (key, value, element) {
        swal({
            title: "Translate!",
            text: "Edit the following text:",
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            animation: "slide-from-top",
            inputValue: value,
        }, function (inputValue) {
            if (inputValue === false) return false;
            if (inputValue === "") {
                swal.showInputError("You need to write something!");
                return false;
            }

            //Save / update translation
            $.ajax({
                url: TranslationRoutes.translationUrl,
                method: "GET",
                data: {key: key, value: inputValue, locale: GENERAL_SETTINGS.locale}
            }).done(function () {
                element[0].innerHTML = inputValue;
                swal("Ok!", "The translation is saved!", "success");
            }).fail(function () {
                swal.showInputError("Error during save. Are you logged in?");
            });
        });
    };
    
    this.showPageUpdateModal = function(key, value, element)
    {
        $('#editor-content').html(value);
        $('#pageUpdateModal').modal();
        $('#pageUpdateSaveButton').on('click', function() {
            var inputValue = $('#editor-content').val();
            $.ajax({
                url: PagesRoutes.updateUrl,
                method: "GET",
                data: {key:key, value:inputValue},
                error: function () {
                    swal.showInputError("Error during save. Are you logged in?");
                }
            }).done(function(data) {
                element[0].innerHTML = inputValue;
                console.log(data);
                swal("Ok!", "The page is saved!", "success");
            });
            $.modal.close();
        });
    }

};