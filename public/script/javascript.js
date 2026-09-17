console.log('Berhasil');
$(document).ready(function () {

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
            columns: [
    {
        data: null,
        render: function (data, type, row, meta) {
            return meta.settings._iDisplayStart + meta.row + 1;
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
    }
]
        });

        $('#formBarang').on('submit', function(event){
            event.preventDefault();
            //Membersihkan error sebelumnya
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').text('');
            const formData = $(this).serialize();
            // console.log('submit berhasil');
            $.ajax({
                url:  BASE_URL + 'barang/create',
                type: 'POST',
                data: formData,

            success: function (response) {
                console.log(response);
                if (response.status) {
                    tabel.ajax.reload();
                    $('#formBarang')[0].reset();
                    const modalElement = document.getElementById('modalBarang');
                    const modal = bootstrap.Modal.getInstance(modalElement);
                    modal.hide();
                    
                    // Tampilkan pesan berhasil
                    $('#alertSukses').text(response.message);
                    $('#alertSuccess').removeClass('d-none');

                    // Hilangkan pesan setelah 3 detik
                    setTimeout(function () {
                        $('#alertSuccess').addClass('d-none');
                    }, 3000);
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

    });