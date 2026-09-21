console.log('Berhasil');
$(document).ready(function () {
    // inisialisasi tag html yang ingin kita modifikasi malalui javascript ke dalam variabel
    const btnSubmitAdmin = $('#btnSubmitAdmin');
    const judulModal = $('#judulModal');
    const btnTambahData = $('#btnTambahData');
    const formBarang = $('#formBarang');
    let idBarangHapus = null;

    // ketika tombol tambah data di klik akan mengubah judul modal dan tombol submit menjadi kasus tambah data
    btnTambahData.on('click', function(){
        formBarang.attr('action', BASE_URL + 'barang/create');
        judulModal.text('Form Tambah Data Barang');
        btnSubmitAdmin.text('Tambah Data');
        formBarang[0].reset();
        $('#id_barang').val('');
    });

    // inisiasi datatables ke dalam variabel tabel
      const tabel =  $('#tabelDashboardAdmin').DataTable({
            ajax: {
                url: BASE_URL + `barang/data`,
                dataSrc: '',
                 error: function (xhr, error, thrown) {
                console.log('Status:', xhr.status);
                console.log('Response:', xhr.responseText);
                console.log('Error:', error);
                console.log('Thrown:', thrown);
            }
            },
            // sesuaikan kolom dengan kolom yang ada pada view dashboard/index.php
            columns: [
    {
        data: null,
        render: function (data, type, row, meta) {
            return meta.row + 1;
        }
    },
    {
        data: 'nama_barang'
    },
    {
        data: 'kategori'
    },
    {
        data: 'jumlah'
    },
    {
        // generate tombol edit dan delete
        data: null,
        orderable: false,
        searchable: false,
        render: function(data, type, row){
            return `
                <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="${row.id}">Delete</button>
                <button type="button" class="btn btn-warning btn-sm btn-edit" data-id="${row.id}">Edit</button>
            `;
        }
    }

    ]
        });

        // event jika tombol edit diklik akan mengirimkan data id barang ke controller
        $(document).on('click', '.btn-edit', function(){
            const id = $(this).data('id');
            // gunakan request ajax untuk mendapatkan data barang yang ingin di edit
            $.ajax({
                url: BASE_URL + 'barang/' + id,
                type: 'GET',
                success: function(response){
                    console.log(response);
                    // jika data berhasil di dapat isi masing-masing input dengan data dari controller
                    if (response.status){
                        formBarang.attr('action', BASE_URL + 'barang/ubah/' + id);

                        $('#id_barang').val(
                            response.data.id
                        );

                        $('#nama_barang').val(
                            response.data.nama_barang
                        );

                        $('#kategori').val(
                            response.data.kategori
                        );

                        $('#jumlah').val(
                            response.data.jumlah
                        );

                        judulModal.text('Form Ubah Data Barang');
                        btnSubmitAdmin.text('Ubah Data');

                        const modalElement = document.getElementById('modalBarang');
                        const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
                        // menampilkan modal yang sudah berisi data barang
                        modal.show();
                    }
                },
                error: function(xhr){
                    console.log(xhr.responseJSON);
                }
            });
        });

        // mengirimkan data dari form tambah data ke controller
        $('#formBarang').on('submit', function(event){
            event.preventDefault();
            // Membersihkan error sebelumnya
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').text('');
            const formData = $(this).serialize();
            // console.log('submit berhasil');
            const url = formBarang.attr('action');
            // request ajax untuk mengirimkan value dari input form ke controller
            $.ajax({
                url:  url,
                type: 'POST',
                data: formData,

            success: function (response) {
                console.log(response);
                if (response.status) {
                    tabel.ajax.reload();
                    $('#formBarang')[0].reset();
                    $('#id_barang').val('');

                    const modalElement = document.getElementById('modalBarang');
                    const modal = bootstrap.Modal.getInstance(modalElement);
                    modal.hide();
                    
                    // Tampilkan pesan berhasil
                    $('#alertSuccessMessage').text(response.message);
                    $('#alertSuccess').removeClass('d-none');

                    // menghilangkan pesan setelah 3 detik
                    setTimeout(function () {
                        $('#alertSuccess').addClass('d-none');
                    }, 3000);

                    // kembalikan kondisi form menjadi default
                    formBarang.attr('action', BASE_URL + 'barang/create');
                    judulModal.text('Form Tambah Data Barang');
                    btnSubmitAdmin.text('Tambah Data');
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                if (xhr.status === 422) {

                const errors = xhr.responseJSON.errors;

                if (errors.nama_barang) {
                    $('#nama_barang')
                        .addClass('is-invalid');
                    $('#errorNamaBarang')
                        .text(errors.nama_barang);
                }

                if (errors.kategori) {
                    $('#kategori')
                        .addClass('is-invalid');
                    $('#errorKategori')
                        .text(errors.kategori);
                }

                if (errors.jumlah) {
                    $('#jumlah')
                        .addClass('is-invalid');
                    $('#errorJumlah')
                        .text(errors.jumlah);
                }
                }
            }
            });
        });

        $(document).on('click', '.btn-delete', function(){
            const id = $(this).data('id');
            idBarangHapus = id;

            const modalElement = document.getElementById('modalKonfirmasiHapus');
            const modal = bootstrap.Modal.getOrCreateInstance(modalElement);

            modal.show();
        });

        $('#btnKonfirmasiHapus').on('click', function(){
            if(!idBarangHapus){
                return;
            }

            $.ajax({
                url: BASE_URL + 'barang/' + idBarangHapus,
                type: 'DELETE',
                
                success: function(response){
                    console.log(response);

                    if(response.status){
                        tabel.ajax.reload();

                        const modalElement = document.getElementById('modalKonfirmasiHapus');
                        const modal = bootstrap.Modal.getOrCreateInstance(modalElement);

                        modal.hide();

                        $('#alertSuccessMessage').text(response.message);
                        $('#alertSuccess').removeClass('d-none');

                        setTimeout(function(){
                            $('#alertSuccess').addClass('d-none');
                        }, 3000);

                        idBarangHapus = null;
                    }
                },

                error: function(xhr){
                    console.log('Status: ', xhr.status);
                    console.log('Response: ', xhr.responseText);
                }
            })
        });

    });