$(function() {

    if ( $.fn.dataTable.isDataTable( '#records_table' ) ) {
        var table = $('#records_table').DataTable();
    }
    else {
        table = $('#records_table').DataTable( {
            "paging": false,
            "searching": false,
            "bInfo" : false,
            "order": [[ 1, "desc" ]]
        } );
    }

    $(".request_btn").on("click", function (e) {
        e.preventDefault();
        let btn = $(this);
        $('#loader').show();
        btn.prop('disabled', true);
        $.get("application/ajaxGetData", function(response) {
            if (response) {
                table.clear().draw();
                let data = JSON.parse(response);
                for (let i = 0; i < data.length; i++ ) {
                    table.row.add([
                        data[i].name,
                        data[i].price,
                        data[i].timestamp,
                    ]).draw();
                }
            }

            $('#loader').hide();
            btn.removeAttr('disabled');
        });
    });

});

