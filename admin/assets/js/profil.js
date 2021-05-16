
var saclar = false;
var beforeEdit = '';
$(document).delegate('#gantiProfil', 'click', function (evt) {

    // kalo klik 'mode edit' maka
    if (saclar == false) {

        // ganti tiap div nya jadi inputan
        modeEditProfil();

        // ganti text 'mode edit'
        textSelesaiEdit();

    }



});

// mode edit profil
function modeEditProfil() {
    beforeEdit = $('#modeEdit').html();

    const email = $('#emailText').text();
    const alamat = $('#alamatText').text();
    const wa = ($('#whatsappText').text()).substr(1, $('#whatsappText').text().length);

    $('#emailText').html(`<input type='email' name='email' value='${email}' class='form-control'/>`);
    $('#alamatText').html(`<textarea name='alamat' class='form-control'>${alamat}</textarea>`);
    $('#whatsappText').html(`<input type='number' name='whatsapp' value='${wa}' class='form-control'/> <br/> <i class='text-muted'>ganti angka awal <b>0</b> dengan <b>62</b></i>`);


    // saclar turn on
    saclar = true;

}

function textGantiProfil() {
    $('#gantiProfil').html(`<i class="lni lni-pencil-alt"></i> Ganti profil`);
    $(document).find('#btnBatal').remove();
}

function textSelesaiEdit() {
    $('#gantiProfil').html(`<button class='btn btn-success' type='submit' name='selesaiEdit' id='btnSelesai'><i class="lni lni-checkmark-circle"></i> selesai</button>`);
    $('#wrapper-gantiProfil').prepend(`<div class='margin-top-1 margin-right-2 hover-pointer' id='btnBatal'><i class="lni lni-close"></i> Batal</div>`);
}

$(document).delegate('#btnBatal', 'click', function (evt) {
    $('#modeEdit').html(beforeEdit);

    // ganti text kesemula 'mode' edit'
    textGantiProfil();

    // matikan saklar
    saclar = false;

})

$(document).delegate('#btnSelesai', 'click', function (evt) {
    const data = {
        email: $('#emailText input').val(),
        alamat: $('#alamatText textarea').val(),
        whatsapp: $('#whatsappText input').val(),
    };

    $.ajax({
        url: './profil/store',
        type: 'POST',
        data: data,
        dataType: 'json',
        beforeSend: function () {
            LoadingButtonOn('selesaiEdit', 'tunggu sebentar...');
        },
        error: function () {
            LoadingButtonOff('selesaiEdit', `<i class="lni lni-checkmark-circle"></i> selesai`);
            textGantiProfil();
            alert('Sedang terjadi masalah, silahkan coba beberapa saat lagi');
        }
    }).done(function (response) {
        if (response.status_code == 200)
            document.location = response.action;
        else
            alert(response.message);

        LoadingButtonOff('selesaiEdit', `<i class="lni lni-checkmark-circle"></i> selesai`);

    })
})

function LoadingButtonOn(name, html = '') {
    const btn = $(document).find(`button[name=${name}]`);

    btn.html(html);
    btn.attr('disabled', 'disabled');
}

function LoadingButtonOff(name, html = '') {
    const btn = $(document).find(`button[name=${name}]`);

    btn.html(html);
    btn.removeAttr('disabled');
}


$('#uploadFile').change(function (evt) {
    const val = $(this).val();
    // kalo file yg di upload ga kosong
    if (val != '') {
        const form = new FormData();
        const file = evt.target.files[0];
        form.append('logo', file);
        console.log(form)
        $.ajax({
            url: './profil/updatelogo',
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: form,
        }).done(function (response) {
            if (response.status_code == 200)
                document.location = response.action;
            else
                alert(response.message);
        })
    }

})