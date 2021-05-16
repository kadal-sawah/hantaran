
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

    const nama_user = $('#userText').text();
    const username = $('#usernameText').text();
    $('#userText').html(`<input type='text' name='nama_user' value='${nama_user}' class='form-control'/>`);
    $('#usernameText').html(`<input type='text' name='username' value='${username}' class='form-control'/>`);
    $('#passwordText').html(`<input type='password' name='password' class='form-control'/>`);


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
        nama_user: $('#userText input').val(),
        username: $('#usernameText input').val(),
        password: $('#passwordText input').val(),
    };

    $.ajax({
        url: './saya/store',
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
