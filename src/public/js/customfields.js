$(function () {
    CustomFields.init();
});


var CustomFields = {
    toggleField: function (item) {

        var toggler = $('#toggler_' + item);
        var field_wrapper = toggler.closest('.field_item_wrapper');
        var is_active = !(field_wrapper.hasClass('active'));
        if (is_active) {

            field_wrapper.addClass('active');
        }
        else {
            field_wrapper.removeClass('active');
        }

        toggler.find('.toggler').toggleClass('fa-toggle-up', field_wrapper.hasClass('active'));
        toggler.find('.toggler').toggleClass('fa-toggle-down', !field_wrapper.hasClass('active'));
    },
    initRulesKeys: function (item) {
        var rulesKey = $(item).closest('#rulesGroup').find('#rulesKey');

        $.ajax({
            url: CustomFieldsVars.rules_values_route,
            method: 'GET',
            data: {type: $(item).val()},
            dataType: 'json'
        }).done(function (result) {
            $(rulesKey).find('option')
                .remove();

            $.each(result, function (key, value) {
                $.each(value, function (inner_key, inner_value) {
                    $(rulesKey).append($('<option>', {value: inner_key})
                        .text(inner_value));
                });
            });


        }).fail(function () {
            alert('Error!');
        })
    },
    initRules: function () {
        $('.rules-type').each(function () {
            CustomFields.initRulesKeys($(this));
        });

        $('#rulesType').on('change', function () {
            CustomFields.initRulesKeys($(this));
        });

        this.initRuleButtons();
    },
    initRuleButtons: function () {
        $('#btn-add-rules-item').unbind('click');
        $('.btn-delete-rules-item').unbind('click');
        $('#btn-add-rules-item').on('click', function (e) {
            e.preventDefault();
            var rulesGroup = $(this).closest('#rulesGroups').find('.rules-group').first();
            var ruleClone = rulesGroup.clone(true);
            // ruleClone.html('<div id="rulesGroup" class="rules-group">' + ruleClone.html() + "</div>");
            rulesGroup.closest('#rulesGroups').append(ruleClone);
            CustomFields.handleUpdateRules();
        });

        $('.btn-delete-rules-item').on('click', function (e) {
            e.preventDefault();
            $(this).closest('#rulesGroup').remove();
            CustomFields.handleUpdateRules();
        });
    },
    handleUpdateRules: function () {
        var counter = 0;
        $('#rulesGroups').find('.rules-group').each(function () {
            $(this).find('select').each(function () {
                $(this).attr('name', $(this).attr('name').replaceAll(/rules\[[0-9]]/g, 'rules[' + counter + ']'));
            });
            counter++;
        });

        this.initRuleButtons();
    },
    init: function () {
        $('#field_item_wrapper').each(function () {
            CustomFields.initInputCallbacks($(this));
        });

        $('#addInput').on('click', function (e) {
            e.preventDefault();

            var fieldItemsWrapper = $('#field_items_wrapper');
            fieldItemsWrapper.find('.field_item_wrapper').each(function () {
                $(this).removeClass('active');
            });


            var itemToAdd = $('#field_item_wrapper').clone(true);
            itemToAdd = CustomFields.handleItemToAdd(itemToAdd, $('.field_item_wrapper').size());

            fieldItemsWrapper.append(itemToAdd);
            $('#field_item_wrapper.active .input_sorter').html(fieldItemsWrapper.find('.field_item_wrapper').length.toString());

            CustomFields.initInputCallbacks(itemToAdd);
        });

        this.initRules();

    },
    postDeleteHandler: function () {
        var fieldItemsWrapper = $('#field_items_wrapper');
        var counter = 0;
        fieldItemsWrapper.find('.field_item_wrapper').each(function () {
            var id = $(this).find('.field_item_header a').attr('id').replace('toggler_', '');
            $(this).html($(this).html().replaceAll('[' + id + ']', counter));
            counter++;
            $(this).find('.input_sorter').html(counter);
        });
    },
    initInputCallbacks: function (item) {
        $(item).find('#deleteRow').on('click', function () {
            $(this).closest('#field_item_wrapper').remove();
            CustomFields.postDeleteHandler();
        });

        $(item).find('#input_label').on('change', function () {
            $(this).closest('#field_item_wrapper').find('#headerLabel').html($(this).val());
        });

        $(item).find('#input_name').on('change', function () {
            $(this).closest('#field_item_wrapper').find('#headerName').html($(this).val());
        });

        $(item).find('#input_type').on('change', function () {
            val = $(this).find('option:selected').text();
            $(this).closest('#field_item_wrapper').find('#headerType').html(val);
        });
    },
    handleItemToAdd: function (itemToAdd, amount) {
        itemToAdd.addClass('active');
        itemToAdd.find('input').each(function () {
            $(this).val('');
            $(this).attr('checked', false);
        });
        itemToAdd.find('textarea').each(function () {
            $(this).val('');
        });
        itemToAdd.find('select').each(function () {
            $(this).val($(this).find("option:first").val());
        });
        itemToAdd.find('.headerLabel').each(function () {
            $(this).html('');
        });
        return itemToAdd.html(itemToAdd.html().replaceAll('[0]', amount));
    }
};

String.prototype.replaceAll = function (search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};