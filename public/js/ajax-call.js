$(document).ready(function () {
    var Admintable = $(".admin").DataTable({
        processing: true,
        serverSide: true,
        pageLength: 15,
        bPaginate: true,
        bLengthChange: false,
        bFilter: true,
        bInfo: false,
        bAutoWidth: false,
        ordering: false,
        ajax: {
            url: $("#adminurl").val(),
            type: "Get",
            data: function (d) {
                (d._token = "{{ csrf_token() }}"),
                    (d.start_date = $("#adminStartDate").val()),
                    (d.end_date = $("#adminEndDate").val());
            },
        },
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
            },
            {
                data: "name",
                name: "name",
            },
            {
                data: "email",
                name: "email",
            },
            {
                data: "contact",
                name: "contact",
            },
            {
                data: "status",
                name: "status",
            },
            {
                data: "created_at",
                name: "created_at",
            },
            {
                data: "action",
                name: "action",
                orderable: true,
                searchable: true,
            },
        ],
    });
    $("#adminFilterBtn").click(function () {
        Admintable.draw();
    });
    $("#adminResetBtn").click(function () {
        location.reload();
    });

    $(document).on("click", ".admindeletebutton", function (e) {
        e.preventDefault();
        var id = $(this).data("id");
        var form = $(this).closest("form");
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        swal({
            title: `Are you sure you want to delete this record?`,
            text: "If you delete this, it will be gone forever.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "POST",
                    url: $("#admindeleteurl").val(),
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    data: {
                        _token: $("#token").val(),
                        id: id,
                    },
                    success: function (data) {
                        Admintable.row($(this).parents("tr")).remove().draw();
                    },
                });
            }
        });
    });
});
