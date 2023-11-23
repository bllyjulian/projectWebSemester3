<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link id="pagestyle" href="../admin/assets/css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />
</head>

<body>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <form method="post" action="../admin/crudphp/proses.php?aksi=bukti" id="editEvent">
            <div class="form-group ">
                <label class="text-lg font-weight-bold" for="id_transaksi">ID transaksi</label>
                <input type="text" class="form-control" name="id_transaksi" id="id_transaksi" autocomplete="off">
            </div>
            <div class="form-group ">
                <label class="text-lg font-weight-bold" for="bukti_pembayaran">Bukti</label>
                <input type="file" class="form-control" name="bukti_pembayaran" id="bukti_pembayaran"
                    autocomplete="off">
            </div>
            <div class="form-group mt-2">
                <button style="height: 55px;" type="submit" class="btn btn-primary btn-md btn-block w-100" id="submit">
                    Simpan
                </button>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function () {
            $('#editEvent').submit(function (event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menyimpan perubahan?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pengguna mengonfirmasi, lanjutkan dengan pengiriman formulir
                        var formData = new FormData(this);

                        $.ajax({
                            type: 'POST',
                            url: '../admin/crudphp/proses.php?aksi=bukti',
                            data: formData,
                            processData: false,
                            contentType: false,
                            dataType: 'json',
                            success: function (response) {
                                if (response.sukses) {
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: response.pesan,
                                        icon: 'success'
                                    }).then(() => {
                                        window.location.href = 'dataakun'; // Arahkan ke event.php di dalam folder pages
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal!',
                                        text: response.pesan,
                                        footer: '<a href="">Perlu bantuan?</a>'
                                    });
                                }
                            },
                            error: function () {
                                // Tangani kesalahan
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>