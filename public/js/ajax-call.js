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
                        toastr.success("Successfully Delete Admin !");
                    },
                });
            }
        });
    });
    var assigndriver = $("#assigndriver").val();
    if (assigndriver == 1 || assigndriver == 2) {
        var serviceordercolumns = [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
            },
            {
                data: "full_name",
                name: "full_name",
            },
            {
                data: "email_id",
                name: "email_id",
            },
            {
                data: "mobile_no",
                name: "mobile_no",
            },
            {
                data: "reg_number",
                name: "reg_number",
            },
            {
                data: "vehicle_model",
                name: "vehicle_model",
            },
            {
                data: "vehicle_variant",
                name: "vehicle_variant",
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
                data: "address_option",
                name: "address_option",
            },
            {
                data: "action",
                name: "action",
                orderable: true,
                searchable: true,
            },
        ];
    } else {
        var serviceordercolumns = [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
            },
            {
                data: "full_name",
                name: "full_name",
            },
            {
                data: "email_id",
                name: "email_id",
            },
            {
                data: "mobile_no",
                name: "mobile_no",
            },
            {
                data: "reg_number",
                name: "reg_number",
            },
            {
                data: "vehicle_model",
                name: "vehicle_model",
            },
            {
                data: "vehicle_variant",
                name: "vehicle_variant",
            },
            {
                data: "created_at",
                name: "created_at",
            },
            {
                data: "address_option",
                name: "address_option",
            },
            {
                data: "action",
                name: "action",
                orderable: true,
                searchable: true,
            },
        ];
    }
    // console.log(serviceordercolumns,'-------------------serviceOrder----------------');
    var ServiceOrdertable = $(".serviceorderdatatable").DataTable({
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
                    (d.start_date = $("#serviceOrderStartDate").val()),
                    ((d.end_date = $("#serviceOrderEndDate").val()),
                    (d.address_option = $(".addressOptionFilterBtn")
                        .find(":selected")
                        .val()));
            },
        },
        columns: serviceordercolumns,
    });
    $('.dataTables_filter input[type="search"]').css({
        width: "350px",
        height:"50px",
        display: "inline-block",
    });
    $(document).on("click", ".serviceOrderdeletebutton", function (e) {
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
                    url: $("#admindeletedeleteurl").val(),
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
                        ServiceOrdertable.row($(this).parents("tr"))
                            .remove()
                            .draw();
                        toastr.success("Successfully Delete Service Order!");
                    },
                });
            }
        });
    });
    $("select.addressOptionFilterBtn").change(function () {
        ServiceOrdertable.draw();
    });
    $("#serviceOrderFilterBtn").click(function () {
        ServiceOrdertable.draw();
    });
    $("#serviceOrderResetBtn").click(function () {
        location.reload();
    });
});
