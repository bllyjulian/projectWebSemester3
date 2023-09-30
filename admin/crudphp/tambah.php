<?php
    // session start
    if(!empty($_SESSION)){ }else{ session_start(); }
    require 'koneksi.php';
    if(!empty($_SESSION['ADMIN'])){ }else{
        echo '<script>alert("Maaf Login Dahulu !");window.location="login.php"</script>';
    }
    include 'navbar.php';
?>
<div class="container">
<div class="card-body">
                <form role="form text-left" method="post" action="../crudphp/proses.php?aksi=login" id="formlogin">
                  <!-- <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Name" aria-label="Name" aria-describedby="email-addon">
                  </div> -->
                  <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Masukkan Username" aria-label="Username" aria-describedby="email-addon" name="user" required="required" autocomplete="off">
                  </div>
                  <div class="mb-3">
                    <input type="password" class="form-control" placeholder="Masukkan Password" aria-label="Password" aria-describedby="password-addon" name="pass" required="required" autocomplete="off">
                  </div>
                  <div class="form-check form-check-info text-left">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
                    <label class="form-check-label" for="flexCheckDefault">
                      I agree the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and Conditions</a>
                    </label>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2" name="proses_login" >Login</button>
                  </div>
                  <p class="text-sm mt-3 mb-0">Already have an account? <a href="javascript:;" class="text-dark font-weight-bolder">Sign in</a></p>
                </form>
              </div>
    <div class="card mt-5">
        <div class="card-header">
            Tambah Data Mahasiswa
        </div>
        <div class="card-body">
            <form method="post" action="proses.php?aksi=tambah">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Kd barang</label>
                            <input type="text" class="form-control" required name="kd_barang" id="kd_barang" placeholder="">
                        </div>
                        
                        <div class="form-group">
                            <label for="">Nama barang</label>
                            <input type="text" class="form-control" required name="nama_barang" id="nama_barang" placeholder="">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Satuan</label>
                            <input type="text" class="form-control" required name="satuan" id="satuan" placeholder="">
                        </div>
                        
                        <div class="form-group">
                            <label for="">Harga</label>
                            <input type="number" class="form-control" required name="harga" id="harga" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="">Aksi</label>
                            <button type="submit" class="btn btn-primary btn-md btn-block">
                                Tambah
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include 'footer.php';?>