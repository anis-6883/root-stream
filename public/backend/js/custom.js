// Auto Selected
if ($("[data-selected]").length) {
    $("[data-selected]").each(function (i, obj) {
        $(this).val($(this).data("selected")).change();
    });
}

// Select 2
if ($(".select2").length) {
    $(".select2").select2();
}

// Dropify
$(".dropify").dropify();

// Dropify Icon
$(".dropify-wrapper .dropify-message span.file-icon").html(
    "<i class='fas fa-cloud-upload-alt text-muted'></i><p>Drag and drop a file here or click</p>"
);

// Required *
$("input:required, select:required, textarea:required")
    .prev()
    .append('<span class="required text-danger"> *</span>');

$(".dropify:required")
    .parent()
    .prev()
    .append('<span class="required text-danger"> *</span>');

// delete confirmation
$(document).on("click", ".btn-remove", function (e) {
    e.preventDefault();
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#1bcfb4",
        cancelButtonColor: "#fe7c96",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.value) {
            var link = $(this).attr("href");
            if (typeof link !== "undefined" && link !== "") {
                window.location.href = link;
            } else {
                $(this).closest("form").submit();
            }
        }
    });
});

//Ajax Delete
$(document).on("submit", ".ajax-delete", function () {
    var dis = this;
    var link = $(dis).attr("action");
    $.ajax({
        method: "POST",
        url: link,
        data: new FormData(dis),
        mimeType: "multipart/form-data",
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
            $("#preloader").css("display", "block");
        },
        success: function (data) {
            $("#preloader").css("display", "none");
            var json = JSON.parse(data);
            if (json["result"] == "success") {
                if ($("#data-table").length) {
                    $("#data-table").DataTable().ajax.reload(null, false);
                } else {
                    $(dis).closest("tr").remove();
                }
                toast("success", json["message"]);
            } else {
                toast("error", json["message"]);
            }
        },
    });
    return false;
});

//Ajax Modal Function
$(document).on("click", ".ajax-modal", function () {
    var link = $(this).data("href");
    if (typeof link == "undefined") {
        link = $(this).attr("href");
    }

    var title = $(this).data("title");

    $.ajax({
        url: link,
        beforeSend: function () {
            $("#preloader").css("display", "block");
        },
        success: function (data) {
            $("#preloader").css("display", "none");
            $("#main_modal .modal-title").html(title);
            $("#main_modal .modal-body").html(data);
            $("#main_modal .alert-success").css("display", "none");
            $("#main_modal .alert-danger").css("display", "none");
            $("#main_modal").modal("show");
            //Select2
            $("#main_modal select.select2").select2({
                dropdownParent: $("#main_modal"),
            });

            //Auto Selected
            if ($("#main_modal [data-selected]").length) {
                $("#main_modal [data-selected]").each(function (i, obj) {
                    $(this).val($(this).data("selected")).trigger("change");
                });
            }

            //validate
            // validate();

            $(".dropify").dropify();
            $(
                "#main_modal input:required, #main_modal select:required, #main_modal textarea:required"
            )
                .prev()
                .append('<span class="required text-danger"> *</span>');
            $(
                "#main_modal .ajax-screen-submit input:required, #main_modal .ajax-screen-submit select:required, #main_modal .ajax-screen-submit textarea:required"
            )
                .closest(".form-group")
                .find(".control-label")
                .append("<span class='required'> *</span>");
        },
        error: function (request, status, error) {
            console.log(request.responseText);
        },
    });

    return false;
});

//Ajax Modal Form Submit
$(document).on("submit", ".ajax-submit", function () {
    var link = $(this).attr("action");
    $.ajax({
        method: "POST",
        url: link,
        data: new FormData(this),
        mimeType: "multipart/form-data",
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
            $("#preloader").css("display", "block");
            $("#main_modal .alert").css("display", "none");
        },
        success: function (data) {
            $("#preloader").css("display", "none");
            var json = JSON.parse(data);

            if (json["result"] == "success") {
                if (
                    typeof json["redirect"] != "undefined" &&
                    json["redirect"] != ""
                ) {
                    window.setTimeout(function () {
                        window.location.replace(json["redirect"]);
                    }, 1000);
                    return true;
                }

                if ($("#data-table").length) {
                    $("#data-table").DataTable().ajax.reload(null, false);
                }

                $("#main_modal .alert-danger").css("display", "none");

                $("#main_modal").modal("hide");

                Toast.fire({
                    icon: "success",
                    title: json["message"],
                });
            } else {
                // console.log(json["message"]);
                jQuery.each(json["message"], function (i, val) {
                    $("#main_modal .alert-danger").html("<p>" + val + "</p>");
                });
                $("#main_modal .alert-success").css("display", "none");
                $("#main_modal .alert-danger").css("display", "block");
            }
        },
    });
    return false;
});

// function validate() {
//     //Validation Form
//     $(".validate").validate({
//         submitHandler: function (form) {
//             form.submit();
//         },
//         invalidHandler: function (form, validator) {},
//         errorPlacement: function (error, element) {},
//     });
// }
