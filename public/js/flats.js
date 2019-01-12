$(document).ready(function () {


    function addBlockSelect(blockid) {
        $.ajax({
            type: 'post',
            url: 'blocks/search',
            data: {
                '_token': $('input[name=_tokenSearch]').val(),
                'street_id': $('#S').val()
            },
            success: function (data) {
                var newSelect = "";
                if (data.result.length !== 0) {
                    newSelect = "<select class='custom-select mr-sm-2' id='B'>";
                    $.each(data.result, function (index, item) {
                        if (blockid && item.id === blockid) {
                            newSelect += "<option selected value='" + item.id + "'>" + item.number + "</option>";
                        } else {
                            newSelect += "<option value='" + item.id + "'>" + item.number + "</option>";
                        }
                    });
                    newSelect += " </select>";
                } else {
                    newSelect = "<select disabled class='custom-select mr-sm-2' id='B'></select>";
                }
                $('#B').replaceWith(newSelect);
            }
        });
    }

    $(document).on('change', '#S', function () {
        addBlockSelect();
       
    });
    $(document).on('change', '#streetIdSearch', function () {
        $.ajax({
            type: 'post',
            url: 'blocks/search',
            data: {
                '_token': $('input[name=_tokenSearch]').val(),
                'street_id': $('#streetIdSearch').val()
            },
            success: function (data) {
                var newSelect = "";
                if (data.result.length !== 0) {
                    newSelect = "<select class='custom-select mr-sm-2' id='blockIdSearch'><option value='' selected>choose</option>";
                    $.each(data.result, function (index, item) {
                        newSelect += "<option value='" + item.id + "'>" + item.number + "</option>";
                    });
                    newSelect += " </select>";
                } else {
                    newSelect = "<select disabled class='custom-select mr-sm-2' id='blockIdSearch'></select>";
                }
                $('#blockIdSearch').replaceWith(newSelect);
            }
        });
    });

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
        //$('#I').val($(this).data(''));
        $('#N').val('');
        $('#myModal').modal('show');

        var nameInput = $('#N').val().length;
        if (nameInput === 0) {
            $('#N').css("border", "2px solid red");
        } else {
            $('#N').css("border", "2px solid green");
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
        $('#O').val($(this).data('owner'));
        $('#S').val($(this).data('streetid'));
        $('#A').val($(this).data('area'));
        addBlockSelect($(this).data('blockid'));        
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
            url: 'flats/search',
            data: {
                '_token': $('input[name=_tokenSearch]').val(),
                'number': $('#nameSearch').val(),
                'street_id': $('#streetIdSearch').val(),
                'block_id': $('#blockIdSearch').val()
            },
            success: function (data) {
                var newTable = "<tbody class='tbody'>";
                $.each(data.result, function (index, item) {
                    newTable += "<tr class='table-text rowInList" +
                            item.id + "'> <td> <div>" + item.number + "</div> </td> <td> <div>" + item.block.number +
                            "</div> </td> <td> <div>" + item.block.street.name + "</div> </td> <td> <div>" + item.owner.name +"</div> </td> <td> <div>" + item.area +
                            "</div> </td> <td> <button data-id='" +
                            item.id + "' data-name='" + item.number + "' data-blockid='" + item.block.id +
                            "' data-blocknumber='" + item.block.number + "' data-streetid='" + item.block.street.id
                            + "' data-owner='" + item.owner.id +
                            "' type='submit' class='btn btn-danger deleteElement'> <i class='fa fa-btn fa-trash'>Delete</i></button></td>" +
                            "<td> <button data-id='" +
                            item.id + "' data-name='" + item.number + "' data-blockid='" + item.block.id
                            + "' data-blocknumber='" + item.block.number + "' data-streetid='"
                            + item.block.street.id + "' data-owner='" + item.owner.id + "' data-area='" + item.area
                            + "' type='submit' class='btn btn-info updateElement'> <i class='fa fa-btn fa-trash'>Update</i></button></td></tr>";
                });
                newTable += "</tbody>";
                $('.tbody').replaceWith(newTable);
            }
        });

    });


    $('.modal-footer').on('click', '.edit', function () {
        $.ajax({
            type: 'post',
            url: 'flats/update',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('#I').val(),
                'number': $('#N').val(),
                'block_id': $('#B').val(),
                'area': $('#A').val()
            },
            success: function (data) {
                $('.rowInList' + data.id).replaceWith("<tr class='table-text rowInList" +
                        data.id + "'> <td> <div>" + data.number + "</div> </td> <td> <div>" + data.block.number +
                        "</div> </td> <td> <div>" + data.block.street.name + "</div> </td> <td> <div>" + data.owner.name+"</div> </td> <td> <div>" + data.area +
                        "</div> </td> <td> <button data-id='" +
                        data.id + "' data-name='" + data.number + "' data-blockid='" + data.block.id +
                        "' data-blocknumber='" + data.block.number + "' data-streetid='" + data.block.street.id
                        + "' data-owner='" + data.owner.id +
                        "' type='submit' class='btn btn-danger deleteElement'> <i class='fa fa-btn fa-trash'>Delete</i></button></td>" +
                        "<td> <button data-id='" +
                        data.id + "' data-name='" + data.number + "' data-blockid='" + data.block.id
                        + "' data-blocknumber='" + data.block.number + "' data-streetid='"
                        + data.block.street.id + "' data-owner='" + data.owner.id + "' data-area='" + data.area
                        + "' type='submit' class='btn btn-info updateElement'> <i class='fa fa-btn fa-trash'>Update</i></button></td></tr>");
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
        if ($('#N').val().length === 0) {
            $('.actionBtn').prop('disabled', true);
        } else {
            $('.actionBtn').prop('disabled', false);
        }
    });

    $('.modal-footer').on('click', '.delete', function () {
        $.ajax({
            type: 'post',
            url: 'flats/destroy',
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
            url: 'flats/store',
            data: {
                '_token': $('input[name=_token]').val(),
                'number': $('#N').val(),
                'block_id': $('#B').val(),
                'tenant_id': $('#O').val(),
                'area': $('#A').val()
            },
            success: function (data) {
                if ((data.errors)) {
                    $('.error').removeClass('hidden');
                    $('.error').text(data.errors.number);
                } else {
                    $('.error').remove();
                    $('#table').append("<tr class='table-text rowInList" +
                            data.id + "'> <td> <div>" + data.number + "</div> </td> <td> <div>" + data.block.number +
                            "</div> </td> <td> <div>" + data.block.street.name + "</div> </td> <td> <div>" + data.owner.name+"</div> </td> <td> <div>" + data.area +
                            "</div> </td> <td> <button data-id='" +
                            data.id + "' data-name='" + data.number + "' data-blockid='" + data.block.id +
                            "' data-blocknumber='" + data.block.number + "' data-streetid='" + data.block.street.id
                            + "' data-owner='" + data.owner.id +
                            "' type='submit' class='btn btn-danger deleteElement'> <i class='fa fa-btn fa-trash'>Delete</i></button></td>" +
                            "<td> <button data-id='" +
                            data.id + "' data-name='" + data.number + "' data-blockid='" + data.block.id
                            + "' data-blocknumber='" + data.block.number + "' data-streetid='"
                            + data.block.street.id + "' data-owner='" + data.owner.id + "' data-area='" + data.area
                            + "' type='submit' class='btn btn-info updateElement'> <i class='fa fa-btn fa-trash'>Update</i></button></td></tr>");
                }
            }
        });
        $('#N').val('');
        $('#B').val('');
        $('#O').val('');
    });

});