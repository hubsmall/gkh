$(document).ready(function () {


    $(document).on('click', '#archive', function () {
        $('#footer_action_button').text(" Continue");
        $('#footer_action_button').removeClass('glyphicon-check');
        $('#footer_action_button').addClass('glyphicon-trash');
        $('.actionBtn').removeClass('edit');
        $('.actionBtn').removeClass('add');
        $('.actionBtn').removeClass('btn-success');
        $('.actionBtn').addClass('btn-danger');
        $('.actionBtn').addClass('delete');
        $('.modal-title').text('Archivation');
        $('.deleteContent').show();
        $('.form-horizontal').hide();
        $('.dname').html($(this).data('name'));
        $('#myModal').modal('show');
    });

    
    
    $('.modal-footer').on('click', '.delete', function () {
        $.ajax({
            type: 'get',
            url: 'reports/archivation',
            data: {
            },
            success: function (data) {

            }
        });
    });
});