$(document).ready(function(){
$('.btnprn').printPage();
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
                    newSelect = "<select class='custom-select mr-sm-2' name='block_id'  id='blockIdSearch'><option value='' selected>choose</option>";
                    $.each(data.result, function (index, item) {
                        newSelect += "<option value='" + item.id + "'>" + item.number + "</option>";
                    });
                    newSelect += " </select>";
                } else {
                    newSelect = "<select disabled class='custom-select mr-sm-2' name='block_id' id='blockIdSearch'></select>";
                }
                $('#blockIdSearch').replaceWith(newSelect);
            }
        });

    });