<?php

require_once "./Classes/PHPExcel.php";
//tao ket noi 
$con = mysqli_connect('localhost', 'root', '', 'shopQuanAo_btlWeb');
$thongbao = '';
$productID = '';
$danhMucID = '';
$tenSanPham = '';
$moTaSanPham = '';
$giaSanPham = '';
$xuatXu = '';
$soLuongKho = '';
$pathImage = '';
$sql_dm = "SELECT * FROM tblDanhMuc";
$getDanhMuc = mysqli_query($con, $sql_dm);
if (isset($_POST['btnLuu'])) {
    $productID = $_POST['txtproductID'];
    $danhMucID = $_POST['txtdanhMucID'];
    $tenSanPham = $_POST['txttenSanPham'];
    $moTaSanPham = $_POST['txtmoTaSanPham'];
    $giaSanPham = $_POST['txtgiaSanPham'];
    $xuatXu = $_POST['txtxuatXu'];
    $soLuongKho = $_POST['txtsoLuongKho'];
    // $sql="Insert into tblproducts Values('$productID','$danhMucID','$tenSanPham','$moTaSanPham','$giaSanPham','$xuatXu','$soLuongKho','$pathImage')";
    // $kq=mysqli_query($con,$sql);
    //if($kq) $thongbao="Them moi thanh cong";
    //else $thongbao="Them moi that bai";
    $pathImage = basename($_FILES["fileToUpload"]["name"]);
    $target_dir = "./upload/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        // var_dump($target_file);
        // var_dump($_FILES["fileToUpload"]["tmp_name"]);

        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
        $sql = "INSERT INTO tblproducts VALUES (null,'$danhMucID','$tenSanPham','$moTaSanPham','$giaSanPham','$xuatXu','$soLuongKho','$pathImage')";
        $result = mysqli_query($con, $sql);
        if ($result) {
            echo "<script> alret('Th??m m???i d??? li???u th??nh c??ng'); </script>";
            header('Location:qlSanPham.php');
            die();
        } else {
            echo "<script> alret('Th??m m???i d??? li???u th???t b???i'); </script>";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <style type="text/css">
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 130px;
            background: pink;
            z-index: 10;
        }

        #logo_Shop {
            width: 200px;
            height: 200px
        }

        .logo_contenner {
            display: flex;
            font-family: monospace;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            top: 50px;
            position: fixed;
            transform: translateY(-50%);
            left: 15px;

        }

        h1 {
            font-family: Impact;
            font-weight: bold;
            color: white;
            font-style: italic;

        }

        .content2 {
            height: 400px;
            padding-top: 100px;
            padding-left: 100px;
        }

        h2 {
            font-family: Impact;
            font-weight: bold;
            color: pink;
            font-style: italic;
            padding-left: 400px;

        }

        .btn {
            display: inline-block;
            font-weight: 400;
            background: pink;
            color: white;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            border-color: pink;
            margin-left: 400px;
        }

        .mau {
            color: pink;
            padding-left: 50px;
        }

        .col1 {
            padding-left: 100px;
            height: 40px;
            margin-bottom: 1rem;
            box-sizing: border-box;
            font-size: 1rem;
            font-weight: 400 px;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #fff;
            -webkit-text-size-adjust: 100%;
        }

        .form-control {
            display: block;
            width: 90%;
            height: calc(1.5em + .75rem + 2px);
            padding: .375rem .75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        button,
        input {
            overflow: visible;
        }

        button,
        input,
        optgroup,
        select,
        textarea {
            margin: 0;
            font-family: inherit;
            font-size: inherit;
            line-height: inherit;
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TH??M S???N PH???M</title>
</head>

<body>
    <div class="header">
        <nav>
            <div class="logo_contenner">
                <img id="logo_Shop" src="http://localhost/BTL_WEB/public/img/LOGO.png">
                <h1>QU???N L?? S???N PH???M</h1>
            </div>
        </nav>
    </div>
    <form method="post" enctype="multipart/form-data">
        <div class="content2">
            <table>
                <h2>Th??m Th??ng tin S???n ph???m</h2>
                <div class="form-group">
                    <label for="title" class=" mau">Danh M???c</label>
                    <select name="txtdanhMucID" class="form-control" aria-describedby="helpId">
                        <?php while ($row = mysqli_fetch_assoc($getDanhMuc)) : ?>
                            <option value="<?php echo $row['danhMucID'] ?>"><?php echo $row['tenDanhMuc'] ?></option>
                        <?php endwhile ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="title" class=" mau">T??n S???n Ph???m</label>
                    <input type="text" value="<?php echo $tenSanPham ?>" name="txttenSanPham" id="" class="form-control" placeholder="" aria-describedby="helpId">
                </div>
                <div class="form-group">
                    <label for="intro" class=" mau">M?? T??? S???n Ph???m</label>
                    <input type="text" value="<?php echo $moTaSanPham ?>" name="txtmoTaSanPham" id="" class="form-control" placeholder="" aria-describedby="helpId">
                </div>
                <div class="form-group">
                    <label for="detail" class=" mau">G??a S???n Ph???m</label>
                    <input type="number" value="<?php echo $giaSanPham ?>" name="txtgiaSanPham" id="" class="form-control" placeholder="" aria-describedby="helpId">
                </div>
                <div class="form-group">
                    <label for="status" class=" mau">Xu???t X???</label>
                    <input type="text" value="<?php echo $xuatXu ?>" name="txtxuatXu" id="" class="form-control" placeholder="" aria-describedby="helpId">
                </div>
                <div class="form-group">
                    <label for="status" class=" mau">S??? L?????ng</label>
                    <input type="number" value="<?php echo $soLuongKho ?>" name="txtsoLuongKho" id="" class="form-control" placeholder="" aria-describedby="helpId">
                </div>
                <div class="form-group">
                    <label for="status" class="mau">Anh</label>
                    <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
                </div>

                <tr>
                    <td class="col1"></td>
                    <td class="col2">
                        <input class="btn" type="submit" name="btnLuu" value="L??u">
                    </td>

                </tr>
            </table>

    </form>
    </div>

</body>

<script>
    function checkDieuKien() {

    }
</script>

</html>