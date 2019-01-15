$(document).ready(function () {

    $(document).on('click', '.addElement', function () {
        $('#footer_action_button').text(" Add");
        $('#footer_action_button').addClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('.actionBtn').removeClass('edit');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').addClass('add');
        $('.modal-title').text('Add');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        $('#N').val('');
        $('#myModal').modal('show');

        if ($(".inputValidation").length !== $('.inputValidation').filter(function () {
            return $.trim(this.value)
        }).length) {
            $('.actionBtn').prop('disabled', true);
            $('.inputValidation').css("border", "2px solid red");
        }else{
            $('.actionBtn').prop('disabled', false);
            $('.inputValidation').css("border", "2px solid green");
        }
    });

    $(document).on('click', '.updateElement', function () {
        $('#footer_action_button').text(" Update");
        $('#footer_action_button').addClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('.actionBtn').removeClass('add');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').addClass('edit');
        $('.modal-title').text('Edit');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        $('#I').val($(this).data('id'));
        $('#N').val($(this).data('name'));
        $('#P').val($(this).data('passport'));
        $('#myModal').modal('show');

        var nameInput = $('#N').val().length;
        if (nameInput === 0) {
            $('#N').css("border", "2px solid red");
        } else {
            $('#N').css("border", "2px solid green");
        }
    });

    $(document).on('click', '.deleteElement', function () {
        $('#footer_action_button').text(" Delete");
        $('#footer_action_button').removeClass('glyphicon-check');
        $('#footer_action_button').addClass('glyphicon-trash');
        $('.actionBtn').removeClass('edit');
        $('.actionBtn').removeClass('add');
        $('.actionBtn').removeClass('btn-success');
        $('.actionBtn').addClass('btn-danger');
        $('.actionBtn').addClass('delete');
        $('.modal-title').text('Delete');
        $('.did').text($(this).data('id'));
        $('.deleteContent').show();
        $('.form-horizontal').hide();
        $('.dname').html($(this).data('name'));
        $('#myModal').modal('show');
    });

    $(document).on('click', '.search', function () {
        $.ajax({
            type: 'post',
            url: 'tenants/search',
            data: {
                '_token': $('input[name=_tokenSearch]').val(),
                'name': $('#nameSearch').val(),
                'passport': $('#passportSearch').val(),
            },
            success: function (data) {
                var newTable = "<tbody class='tbody'>";
                $.each(data.result, function(index, item) {
                    newTable += "<tr class='table-text rowInList" +
                            item.id + "'> <td> <div>" + item.name + "</div> </td> <td> <div>" + item.passport + "</div> </td> <td> <button data-id='" +
                            item.id + "' data-name='" + item.name + "' data-passport='" + item.passport + "' type='submit' class='btn btn-danger deleteElement'> <i class='fa fa-btn fa-trash'>Delete</i></button></td>" +
                            "<td> <button data-id='" +
                            item.id + "' data-name='" + item.name + "' data-passport='" + item.passport +  "' type='submit' class='btn btn-info updateElement'> <i class='fa fa-btn fa-trash'>Update</i></button></td></tr>";
                });
                newTable += "</tbody>";
                $('.tbody').replaceWith(newTable);
            }
        });

    });


    $('.modal-footer').on('click', '.edit', function () {
        $.ajax({
            type: 'post',
            url: 'tenants/update',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('#I').val(),
                'name': $('#N').val(),
                'passport': $('#P').val()
            },
            success: function (data) {
                $('.rowInList' + data.id).replaceWith("<tr class='table-text rowInList" +
                            data.id + "'> <td> <div>" + data.name + "</div> </td> <td> <div>" + data.passport + "</div> </td> <td> <button data-id='" +
                            data.id + "' data-name='" + data.name + "' data-passport='" + data.passport + "' type='submit' class='btn btn-danger deleteElement'> <i class='fa fa-btn fa-trash'>Delete</i></button></td>" +
                            "<td> <button data-id='" +
                            data.id + "' data-name='" + data.name + "' data-passport='" + data.passport +  "' type='submit' class='btn btn-info updateElement'> <i class='fa fa-btn fa-trash'>Update</i></button></td></tr>");
            }
        });

    });
    $(".inputValidation").change(function () {
        var valueLength = this.value.length;
        if (valueLength === 0) {
            $(this).css("border", "2px solid red");
        } else {
            $(this).css("border", "2px solid green");
        }

        if ($(".inputValidation").length !== $('.inputValidation').filter(function () {
            return $.trim(this.value)
        }).length) {
            $('.actionBtn').prop('disabled', true);
        }else{
            $('.actionBtn').prop('disabled', false);
        }
    });

    $('.modal-footer').on('click', '.delete', function () {
        $.ajax({
            type: 'post',
            url: 'tenants/destroy',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('.did').text()
            },
            success: function (data) {
                $('.rowInList' + $('.did').text()).remove();
            }
        });
    });

    $('.modal-footer').on('click', '.add', function () {
        $.ajax({
            type: 'post',
            url: 'tenants/store',
            data: {
                '_token': $('input[name=_token]').val(),
                'name': $('#N').val(),
                'passport': $('#P').val()
            },
            success: function (data) {
                if ((data.errors)) {
                    $('.error').removeClass('hidden');
                    $('.error').text(data.errors.number);
                } else {
                    $('.error').remove();
                    $('#table').append("<tr class='table-text rowInList" +
                            data.id + "'> <td> <div>" + data.name + "</div> </td> <td> <div>" + data.passport + "</div> </td> <td> <button data-id='" +
                            data.id + "' data-name='" + data.name + "' data-passport='" + data.passport + "' type='submit' class='btn btn-danger deleteElement'> <i class='fa fa-btn fa-trash'>Delete</i></button></td>" +
                            "<td> <button data-id='" +
                            data.id + "' data-name='" + data.name + "' data-passport='" + data.passport +  "' type='submit' class='btn btn-info updateElement'> <i class='fa fa-btn fa-trash'>Update</i></button></td></tr>");
                }
            }
        });
        $('#N').val('');
        $('#P').val('');
    });

});