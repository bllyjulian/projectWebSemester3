<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<form action="upload.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label class="text-lg font-weight-bold" for="foto_profil">Foto Profil</label>
        <input type="file" class="form-control" required name="foto_profil" id="foto_profil" placeholder="">
    </div>
    <input type="submit" value="Unggah Gambar" name="submit">
</form>

</body>
</html>