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
