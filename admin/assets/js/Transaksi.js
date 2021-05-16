
var jumlahBarang = 0;
var table;
var ColorTr = true;
function Draw(param = '') {
    table = $('#transaksi').DataTable({
        "processing": true,
        "serverSide": true,
        "pageLength": 50,
        "pagingType": "simple",
        "language": {
            "search": "",
            "info": "_START_ - _END_ of _TOTAL_ entries",
            "infoFiltered": "",
            "paginate": {
                "previous": `
                <button class='btn btn-primary'>
                    <i class="lni lni-chevron-left icon-primary text-white"></i>
                </button>
                `,
                "next": `
                <button class='btn btn-primary'>
                    <i class="lni lni-chevron-right icon-primary text-white"></i>
                </button>
                `
            }
        },

        "ajax": {
            "url": `./transaksi/get_dt${ObjToGet(param)}`,
        },
        "fnServerParams": function (aoData) {
            const limit = aoData.length;
            const offset = aoData.start;
            if (offset <= 0)
                aoData.page = 1;
            else
                aoData.page = offset / limit + 1;


        },
        "createdRow": function (row, data, dataIndex) {
            $(row).attr('data-id', data['id']);
            if (ColorTr == true)
                $(row).addClass('bg-white');

            // lebar card untuk mobile dan browser
            // if (IsMobile())
            //     $(row).css('width', '100%')
            // else
            $(row).css('min-width', '23%')
        },

        // posisi fitur datatable
        // "dom": "<'d-flex justify-content-between'l<'d-flex'<'#fitur.text-size-2'><'#table_search'f>>><t><'d-flex justify-content-between'ip>",
        "dom": "<'#wrapperSearch.d-flex justify-content-between padding-left-1'<'#table_search'f>><t><'d-flex justify-content-center'p>",

        'drawCallback': function (settings) {
            var api = this.api();
            var $table = $(api.table().node());

            if ($table.hasClass('cards')) {

                // Create an array of labels containing all table headers
                var labels = [];
                $('thead th', $table).each(function () {
                    const RemoveLabel = [''];
                    const value = $(this).text();
                    if (RemoveLabel.indexOf(value) != -1)
                        labels.push(value);

                });

                // Add data-label attribute to each cell
                $('tbody tr', $table).each(function () {
                    $(this).find('td').each(function (column) {
                        $(this).attr('data-label', labels[column]);
                    });
                });

                var max = 0;
                $('tbody tr', $table).each(function () {
                    max = Math.max($(this).height(), max);
                }).height(max);

            } else {
                // Remove data-label attribute from each cell
                $('tbody td', $table).each(function () {
                    $(this).removeAttr('data-label');
                });

                $('tbody tr', $table).each(function () {
                    $(this).height('auto');
                });
            }
        },
        "columns": [

            {
                "data": "id",
                "createdCell": function (td, cellData, rowData, row, col) {
                    $(td).addClass('p-0');
                    $(td).addClass('box-shadow');
                },
                "render": function (data, type, row, meta) {
                    let image = null;

                    if (row['detail_gambar'].length > 0)
                        image = `<img src='./assets/uploads/files/produk/${row['detail_gambar'][0]}' style='width:100%; height:200px'>`;


                    return `
                    <div class='d-flex flex-column position-relative'>
                        ${image}

                        <div class='padding-x-3 padding-top-3'>
                            <h5 class='fweight-600 margin-bottom-2  text-primary'>${row['nama_produk']}</h5>
                            <h6 class='text-muted margin-bottom-1'>${row['nama_jenis']}</h6>

                        </div>

                        <div class='padding-x-3 margin-top-3 padding-bottom-5'>
                            <div class='fweight-600 text-md-2'>Rp.${rp(row['harga'])}</div>
                        </div>

                        <div class='position-absolute text-muted text-sm-3' style='bottom:10px; right:10px;'>sisa ${row['stok']}</div>

                    </div>
                    `;

                }
            },

        ],

    });

    $('#wrapperSearch').css('padding-right', '100px')
    $('#table_search').addClass('w-100');
    $('#table_search').addClass('d-flex');
    $('#table_search .dataTables_filter').addClass('w-100');
    $('#table_search').append(`
    <div class='margin-top-2 margin-left-2'>
        <i class="lni lni-search icon-primary"></i>
    </div>`)

    $('#table_search label').addClass('w-100');

    $('#table_search input').attr({
        'placeholder': 'Cari',
        'class': 'padding-x-3 w-100',
        'style': 'height:40px; margin-left:0px; border:1px solid #ddd',
    })

    // fitur data

    // $('#fitur').html(`
    // <div class='d-flex'>
    //     <a href='#' data-toggle="modal" data-target="#ModalAddPangkat" class='btn btn-primary btn-sm text-size-1 mr-2'><i class="fas fa-plus"></i> Buat baru</a>
    //     <a href='' class='btn btn-light btn-sm text-size-1'><i class="fas fa-filter"></i> Filter</a>
    // </div>
    // `);

    $('.dataTables_wrapper').removeClass('container-fluid');

}

function ObjToGet(obj) {
    let tampung = '?';
    if (obj != null) {
        Object.keys(obj).forEach(function (key) {
            if (obj[key] != '')
                tampung += `${key}=${obj[key]}&`;
        });
    }
    return tampung;
}

function rp(bilangan) {
    var reverse = bilangan.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join('.').split('').reverse().join('');

    return ribuan;
}


$('#transaksi tbody').on('click', 'tr', function (evt) {
    const id = $(this).attr('data-id');
    $.ajax({
        url: './transaksi/cart/add',
        data: { id: id },
        type: 'POST',
        dataType: 'json',
        error: function () {
            alert('Sedang terjadi masalah, silahkan coba beberapa saat lagi');
        }
    }).done(function (response) {
        if (response.status_code != 200) {
            alert(response.message);
            return false;
        }

        // kalo sukses, maka load view cart
        showCart();
    })
})

$('#showSidebar').click(function (evt) {
    showSidebar();
})
$('#closeSidebar').click(function (evt) {
    hideSidebar();
})
$('#showSidebar-2').click(function (evt) {
    showSidebar('mysidebar-2');
})
$('#closeSidebar-2').click(function (evt) {
    hideSidebar('mysidebar-2');
})

function showSidebar(name = 'mysidebar') {
    $(`.${name}`).css('right', '0px');
}

function hideSidebar(name = 'mysidebar') {
    $(`.${name}`).css('right', '-400px');
}

$(document).delegate('#hapusItem', 'click', function (evt) {
    const id = $(this).attr('data-id');
    $.ajax({
        url: './transaksi/cart/hapus',
        data: { id: id },
        type: 'POST',
        dataType: 'json',
        error: function () {
            alert('Sedang terjadi masalah, silahkan coba beberapa saat lagi');
        }
    }).done(function (response) {
        if (response.status_code != 200) {
            alert(response.message);
            return false;
        }

        showCart();
    })
});

function showCart() {
    // kalo sukses, maka load view cart
    $('#listCart').load(`./transaksi/cart/view`, function (response, status, xhr) {
        if (status == "error") {
            var msg = "Sorry but there was an error: ";
            alert(msg + xhr.status + " " + xhr.statusText);

            return false;
        }

        showSidebar();
    })
}

// button data diri
$(document).delegate('#btnDataDiri', 'click', function (evt) {
    $.ajax({
        url: './transaksi/datadiri',
        type: 'POST',
        dataType: 'json',
        error: function () {
            alert('Sedang terjadi masalah, silahkan coba beberapa saat lagi');
            ButtonOff('btnDataDiri', `Selanjutnya <i class="lni lni-chevron-right"></i>`);

        },
        beforeSend: function () {
            ButtonOn('btnDataDiri');
        },
    }).done(function (response) {
        ButtonOff('btnDataDiri', `Selanjutnya <i class="lni lni-chevron-right"></i>`);
        if (response.status_code == 200)
            showSidebar('mysidebar-2');
        else
            alert(response.message);

    })
})


// button checkout
$('#storeCheckout').submit(function (evt) {
    evt.preventDefault();

    const beforeAcc = confirm("Apakah anda yakin, ingin memproses transaksi ini");
    const data = new FormData(this);
    // kalo pilih no
    if (!beforeAcc) return false;

    $.ajax({
        url: './transaksi/checkout',
        type: 'POST',
        data: data,
        dataType: 'json',
        processData: false,
        contentType: false,
        error: function () {
            alert('Sedang terjadi masalah, silahkan coba beberapa saat lagi');
            ButtonOff('btnCheckout', 'Checkout');

        },
        beforeSend: function () {
            ButtonOn('btnCheckout');
        },
    }).done(function (response) {
        ButtonOff('btnCheckout', 'Checkout');
        if (response.status_code == 200)
            document.location = response.action;
        else
            alert(response.message);

    })
})

function ButtonOn(idElement) {
    const button = $(`#${idElement}`);
    button.attr('disabled', 'disabled');
    button.html(`<img src='./assets/img/loading.svg' width='25'>`);
}

function ButtonOff(idElement, text) {
    const button = $(`#${idElement}`);
    button.removeAttr('disabled');
    button.html(text);

}
Draw();