$(document).ready(function () {
    
    function addBlockSelect(blockid) {
        $.ajax({
            type: 'post',
            url: 'blocks/search',
            data: {
                '_token': $('input[name=_tokenSearch]').val(),
                'street_id': $('#Str').val()
            },
            success: function (data) {
                var newSelect = "";
                if (data.result.length !== 0) {
                    newSelect = "<select class='custom-select mr-sm-2 inputValidation' id='B'>";
                    newSelect += "<option selected value=''>choose</option>";
                    $.each(data.result, function (index, item) {
                        if (blockid && item.id === blockid) {
                            newSelect += "<option selected value='" + item.id + "'>" + item.number + "</option>";
                        } else {
                            newSelect += "<option value='" + item.id + "'>" + item.number + "</option>";
                        }
                    });
                    newSelect += " </select>";
                } else {
                    newSelect = "<select disabled class='custom-select mr-sm-2 inputValidation' id='B'></select>";
                }
                $('#B').replaceWith(newSelect);
            }
        });
    }

    function addFlatSelect(flatid) {
        $.ajax({
            type: 'post',
            url: 'flats/search',
            data: {
                '_token': $('input[name=_tokenSearch]').val(),
                'block_id': $('#B').val()
            },
            success: function (data) {
                var newSelect = "";
                if (data.result.length !== 0) {
                    newSelect = "<select class='custom-select mr-sm-2 inputValidation' id='F'>";
                    $.each(data.result, function (index, item) {
                        if (flatid && item.id === flatid) {
                            newSelect += "<option selected value='" + item.id + "'>" + item.number + "</option>";
                        } else {
                            newSelect += "<option value='" + item.id + "'>" + item.number + "</option>";
                        }
                    });
                    newSelect += " </select>";
                } else {
                    newSelect = "<select disabled class='custom-select mr-sm-2 inputValidation' id='F'></select>";
                }
                $('#F').replaceWith(newSelect);
            }
        });
    }

    $(document).on('change', '#B', function () {
        addFlatSelect();
    });

    $(document).on('change', '#Str', function () {
        addBlockSelect();
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
        $('#N').val('');
        $('#D').val('');
        $('#P').val('');
        $('#Str').val('');
        $('#B').val('');
        $('#F').val('');
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
    $(document).on('change', '#blockIdSearch', function () {
        $.ajax({
            type: 'post',
            url: 'flats/search',
            data: {
                '_token': $('input[name=_tokenSearch]').val(),
                'block_id': $('#blockIdSearch').val()
            },
            success: function (data) {
                var newSelect = "";
                if (data.result.length !== 0) {
                    newSelect = "<select class='custom-select mr-sm-2' id='flatIdSearch'><option value='' selected>choose</option>";
                    $.each(data.result, function (index, item) {
                        newSelect += "<option value='" + item.id + "'>" + item.number + "</option>";
                    });
                    newSelect += " </select>";
                } else {
                    newSelect = "<select disabled class='custom-select mr-sm-2' id='flatIdSearch'></select>";
                }
                $('#flatIdSearch').replaceWith(newSelect);
            }
        });

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
        $('#D').val($(this).data('date'));
        $('#P').val($(this).data('paystatus'));
        $('#Str').val($(this).data('streetid'));
        addBlockSelect($(this).data('blockid'));       
        $('#B').val($(this).data('blockid'));      
        addFlatSelect($(this).data('flatid'));
        $('#myModal').modal('show');
        
         $('.inputValidation').each(function (i, obj) {
            if (obj.value.length === 0) {
                $(obj).css("border", "2px solid red");
            } else {
                $(obj).css("border", "2px solid green");
            }
        });   
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
        $('.actionBtn').prop('disabled', false);
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
            url: 'quietus/search',
            data: {
                '_token': $('input[name=_tokenSearch]').val(),
                'date': $('#dateSearch').val(),
                'street_id': $('#streetIdSearch').val(),
                'block_id': $('#blockIdSearch').val(),
                'flat_id': $('#flatIdSearch').val()
            },
            success: function (data) {
                var newTable = "<tbody class='tbody'>";
                $.each(data.result, function (index, item) {
                    newTable += "<tr class='table-text rowInList" +
                        item.id + "'> <td> <div>" + item.pay_status +
                        "</div> </td> <td> <div>" + item.flat.number + "</div> </td> <td> <div>" + item.flat.block.number +
                        "</div> </td> <td> <div>" + item.flat.block.street.name +
                        "</div> </td> <td> <div>" + item.date +
                        "</div> </td> <td> <button data-id='" +
                        item.id +
                        "' type='submit' class='btn btn-danger deleteElement'> <i class='fa fa-btn fa-trash'>Delete</i></button></td>" +
                        "<td> <button data-id='" + item.id +  "' data-pay_status='" + item.pay_status +
                        "' data-flatid='" + item.flat.id
                        + "' data-blockid='" + item.flat.block.id + "' data-streetid='" + item.flat.block.street.id
                        + "' data-date='" + item.date
                        + "' type='submit' class='btn btn-info updateElement'> <i class='fa fa-btn fa-trash'>Update</i></button></td>"
                        + "<td> <form action='{{ url('reports/quietus') }}' method='GET'> <input type='text' name='id' hidden='' value='"+item.id+"'><button type='submit' class='btn btn-default'><i class='fa fa-plus'>Show report</i></button></form></td></tr>";
                });
                newTable += "</tbody>";
                $('.tbody').replaceWith(newTable);
            }
        });

    });
    
    $('.modal-footer').on('click', '.add', function () {
        $.ajax({
            type: 'post',
            url: 'quietus/store',
            data: {
                '_token': $('input[name=_token]').val(),
                'flat_id': $('#F').val(),
                'pay_status': $('#P').val(),
                'date': $('#D').val()
            },
            success: function (data) {
                if ((data.errors)) {
                    $('.error').removeClass('hidden');
                    $('.error').text(data.errors.number);
                } else {
                    $('.error').remove();
                    $('#table').append("<tr class='table-text rowInList" +
                        data.id + "'> <td> <div>" + data.pay_status +
                        "</div> </td> <td> <div>" + data.flat.number + "</div> </td> <td> <div>" + data.flat.block.number +
                        "</div> </td> <td> <div>" + data.flat.block.street.name +
                        "</div> </td> <td> <div>" + data.date +
                        "</div> </td> <td> <button data-id='" +
                        data.id +
                        "' type='submit' class='btn btn-danger deleteElement'> <i class='fa fa-btn fa-trash'>Delete</i></button></td>" +
                        "<td> <button data-id='" + data.id +  "' data-pay_status='" + data.pay_status +
                        "' data-flatid='" + data.flat.id
                        + "' data-blockid='" + data.flat.block.id + "' data-streetid='" + data.flat.block.street.id
                        + "' data-date='" + data.date
                        + "' type='submit' class='btn btn-info updateElement'> <i class='fa fa-btn fa-trash'>Update</i></button></td>"
                        + "<td> <form action='/reports/quietus' method='GET'> <input type='text' name='id' hidden='' value='"+data.id+"'><button type='submit' class='btn btn-default'><i class='fa fa-plus'>Show report</i></button></form></td></tr>");
                }
            }
        });
        $('#N').val('');
        $('#F').val('');
        $('#Str').val('');
        $('#D').val('');
        $('#B').val('');
        $('#P').val('');
    });
    
    
    $('.modal-footer').on('click', '.edit', function () {
        $.ajax({
            type: 'post',
            url: 'quietus/update',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('#I').val(),
                'pay_status': $('#P').val(),
                'flat_id': $('#F').val(),
                'date': $('#D').val()
            },
            success: function (data) {
                $('.rowInList' + data.id).replaceWith("<tr class='table-text rowInList" +
                        data.id + "'> <td> <div>" + data.pay_status +
                        "</div> </td> <td> <div>" + data.flat.number + "</div> </td> <td> <div>" + data.flat.block.number +
                        "</div> </td> <td> <div>" + data.flat.block.street.name +
                        "</div> </td> <td> <div>" + data.date +
                        "</div> </td> <td> <button data-id='" +
                        data.id +
                        "' type='submit' class='btn btn-danger deleteElement'> <i class='fa fa-btn fa-trash'>Delete</i></button></td>" +
                        "<td> <button data-id='" + data.id +  "' data-pay_status='" + data.pay_status +
                        "' data-flatid='" + data.flat.id
                        + "' data-blockid='" + data.flat.block.id + "' data-streetid='" + data.flat.block.street.id
                        + "' data-date='" + data.date
                        + "' type='submit' class='btn btn-info updateElement'> <i class='fa fa-btn fa-trash'>Update</i></button></td>"
                        + "<td> <form action='/reports/quietus' method='GET'> <input type='text' name='id' hidden='' value='"+data.id+"'><button type='submit' class='btn btn-default'><i class='fa fa-plus'>Show report</i></button></form></td></tr>");
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
        $('.inputValidation').each(function (i, obj) {
            if (obj.value.length === 0) {
                $(obj).css("border", "2px solid red");
            } else {
                $(obj).css("border", "2px solid green");
            }
        });
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
            url: 'quietus/destroy',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('.did').text()
            },
            success: function (data) {
                $('.rowInList' + $('.did').text()).remove();
            }
        });
    });
});