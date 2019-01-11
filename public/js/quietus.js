$(document).ready(function () {

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
        $('#P').val($(this).data('paystatus'));      
        $('#myModal').modal('show');       
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
            url: 'quietus/search',
            data: {
                '_token': $('input[name=_tokenSearch]').val(),
                'created_at': $('#dateSearch').val(),
                'street_id': $('#streetIdSearch').val(),
                'block_id': $('#blockIdSearch').val(),
                'flat_id': $('#flatIdSearch').val()
            },
            success: function (data) {
                var newTable = "<tbody class='tbody'>";
                $.each(data.result, function (index, item) {
                    newTable += "<tr class='table-text rowInList"+item.id+"'> <td> <div>"+item.pay_status
                            +"</div> </td> <td> <div>"+item.flat.number+"</div> </td> <td> <div>"+item.flat.block.number
                            +"</div> </td> <td> <div>"+item.flat.block.street.name+"</div> </td> <td> <div>"+item.created_at+"</div> </td> <td> <button data-id='"
                            +item.id+"' type='submit' class='btn btn-danger deleteElement'> <i class='fa fa-btn fa-trash'>Delete</i></button></td><td> <button data-id='"
                            +item.id+"' data-paystatus='"+item.pay_status+"' type='submit' class='btn btn-info updateElement'> <i class='fa fa-btn fa-trash'>Update</i></button></td></tr>";
                });
                newTable += "</tbody>";
                $('.tbody').replaceWith(newTable);
            }
        });

    });
   $('.modal-footer').on('click', '.edit', function () {
        $.ajax({
            type: 'post',
            url: 'quietus/update',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('#I').val(),
                'pay_status': $('#P').val()
            },
            success: function (data) {
                $('.rowInList' + data.id).replaceWith("<tr class='table-text rowInList"+data.id+"'> <td> <div>"+data.pay_status
                            +"</div> </td> <td> <div>"+data.flat.number+"</div> </td> <td> <div>"+data.flat.block.number
                            +"</div> </td> <td> <div>"+data.flat.block.street.name+"</div> </td> <td> <div>"+data.created_at+"</div> </td> <td> <button data-id='"
                            +data.id+"' type='submit' class='btn btn-danger deleteElement'> <i class='fa fa-btn fa-trash'>Delete</i></button></td><td> <button data-id='"
                            +data.id+"' data-paystatus='"+data.pay_status+"' type='submit' class='btn btn-info updateElement'> <i class='fa fa-btn fa-trash'>Update</i></button></td></tr>");
            }
        });

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