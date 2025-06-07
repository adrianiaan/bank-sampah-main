
$("#form-jenis-sampah").on("submit", function(e) {
    
    e.preventDefault();
    $.ajax({
        url: $(this).attr("action"),
        method: $(this).attr("method"),
        data: new FormData(this),
        processData: false,
        dataType: "json",
        contentType: false,
        beforeSend: function () {
            $(document).find("span.text-danger").text("");
            $(".is-invalid").removeClass("is-invalid");
        },
        success: function (data) {
           console.log(data);
            if (data.status == 0) {
                $.each(data.error, function (prefix, val) {
                    $("input[name='"+prefix+"']").addClass("is-invalid");
                    $("select[name='"+prefix+"']").addClass("is-invalid");
                    $("textarea[name='"+prefix+"']").addClass("is-invalid");
                    $("span." + prefix + "_error").text(val[0]);
                   
                });
            } else {
                
                toastr.success(data.message);
                $('#jenissampah-table').DataTable().ajax.reload();
                
            }
        },
    });
});

$(document).on("submit", "#form-delete-jenis-sampah", function(e) {
    e.preventDefault();

    var form = $(this);
    var url = form.attr("action");

    $.ajax({
        url: url,
        method: "POST",
        dataType: "json",
        data: form.serialize(),
        success: function(data) {
            if (data.status == 0) {
                // Handle validation errors if applicable
                $.each(data.error, function(prefix, val) {
                    $("input[name='" + prefix + "']").addClass("is-invalid");
                    $("span." + prefix + "_error").text(val[0]);
                });
            } else {
                
                toastr.success('Data Berhasil Dihapus !!');
                $('#jenissampah-table').DataTable().ajax.reload();
            }
        },
        error: function(xhr, status, error) {
            // Handle error response
            console.log(xhr.responseText);
        }
    });
});

$(document).on('click','.open_edit_jenis_sampah',function(){
    const id= $(this).val();
    const name = $(this).data('name');
    const harga = $(this).data('harga'); 
    const kategori= $(this).data('kategori'); 
    const deskripsi= $(this).data('deskripsi'); 
    $('#jenis_sampah_id').val(id);
    $('#name-ubah').val(name);
    $('#deskripsi_ubah').text(deskripsi);
    $('#harga_ubah').val(harga);
    
    $('#kategori_ubah option').each(function () {
        if ($(this).val() == kategori) {
            $(this).prop('selected', true);
        }
    });
    $('#modalEditJenisSampah').modal('show');
});

$("#form-edit-jenis-sampah").on("submit", function(e) {
    
    e.preventDefault();
    $.ajax({
        url: $(this).attr("action"),
        method: $(this).attr("method"),
        data: new FormData(this),
        processData: false,
        dataType: "json",
        contentType: false,
        beforeSend: function () {
            $(document).find("span.text-danger").text("");
            $(".is-invalid").removeClass("is-invalid");
        },
        success: function (data) {
           console.log(data);
            if (data.status == 0) {
                $.each(data.error, function (prefix, val) {
                    $("input[name='"+prefix+"']").addClass("is-invalid");
                    $("select[name='"+prefix+"']").addClass("is-invalid");
                    $("textarea[name='"+prefix+"']").addClass("is-invalid");
                    $("span." + prefix + "_error").text(val[0]);
                   
                });
            } else {
                
                toastr.success(data.message);
                $('#jenissampah-table').DataTable().ajax.reload();
                $('#modalEditJenisSampah').modal('hide');

                
            }
        },
    });
});