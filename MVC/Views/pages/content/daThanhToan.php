<?php
if (!isset($_SESSION['user'])) {
    header('Location: /BTL_WEB');
}
?>
<style>
    .wrapOrder {
        margin: 16px 16px;
    }

    .container_Item {
        border: 1px solid;
        display: flex;
        flex-direction: row;
        max-width: 100%;
        max-height: 100px;
        min-height: 100px;
        align-items: center;
        justify-content: space-around;

    }

    .container_Item:first-child {
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;

    }

    .container_Item:last-child {
        border-bottom-left-radius: 6px;
        border-bottom-right-radius: 6px;
    }

    .imgItem {
        max-height: 80px;
        max-width: 15%;
        min-width: 15%;
        margin-right: 5%;
    }

    .tenSP {
        min-width: 20%;
        max-width: 20%;
    }

    .giaSp {
        min-width: 10%;
        max-width: 10%;
    }

    .soLuong {
        min-width: 10%;
        max-width: 10%;
    }

    .ngayOrder {
        flex-grow: 1;
    }

    .thanhTien {
        min-width: 10%;
        max-width: 10%;
    }

    .check_box {
        margin-left: 20px;
        max-width: 5%;
        min-width: 5%;
    }

    .btn_huyOrder {
        flex-grow: 1;
        cursor: pointer;
    }

    .header_content {
        text-align: center;
        font-size: x-large;
        font-family: auto;
        margin-top: 32px;
        margin-bottom: 26px;
        color: brown;
        color: brown;
    }

    .lablecs {
        font-size: 12px;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        font-weight: bold;
        color: #f27474;
    }

    .datHang {
        margin: 18px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .lablecss {
        font-size: 14px;
        font-weight: 600;
    }

    .TongMH {
        font-size: large;
        margin-top: 16px;
    }

    #ThanhToan {
        display: flex;
        justify-content: end;
        font-size: 16px;
        font-family: none;
        color: #4735dc;
        font-weight: bolder;
        display: none;

    }

    .txt_center {
        text-align: center;
    }

    .btn_huy_item {
        transform: translateX(50%);
    }

    .thanhTientxt {
        background: transparent;
        border: none;

    }

    #tongTienMua {
        font-size: x-large;
        font-family: emoji;
        font-weight: 600;
        margin-top: 40px;
        margin-left: 20px;
    }
</style>
<div class="wrap_container">
    <div class="header_content">
        <?php if (mysqli_num_rows($data['dataThanhToan']) > 0) : ?>
            DANH S??CH H??NG ???? THANH TO??N
        <?php endif ?>

        <div class="TongMH">

            <?php if (mysqli_num_rows($data['dataThanhToan']) == 0) : ?>
                <h2>Kh??ng c?? s???n ph???m n??o ???? thanh to??n</h2>
                <br>
                <img style="max-width: 400px;" src="http://localhost/btl_web/public/img/96758-empty-cart.gif" alt="">
                <br>
                <button type="button" onclick="location.href='http://localhost/btl_web/home'" class="btn btn-warning" style="margin-top: 36px;">??I MUA S???N PH???M NGAY TH??I N??O</button>
            <?php endif ?>

            <?php if (mysqli_num_rows($data['dataThanhToan']) > 0) : ?>

                <span class="badge badge-primary">B???n ???? mua <span style="font-weight: bolder; font-size: 16px;"><?php echo mysqli_num_rows($data['dataThanhToan']) ?></span> S???n ph???m</span>
                <br>


            <?php endif ?>
        </div>
    </div>
    <?php if (mysqli_num_rows($data['dataThanhToan']) > 0) : ?>
        <label id="tongTienMua"> </label>
        <div class="wrapOrder">
            <div id="ThanhToan"><span id="tongThanhToan"></span></div>
            <div class="container_Item">
                <div class="imgItem lablecs txt_center">H??NH ???NH SP</div>
                <div class="tenSP lablecs">T??N S???N PH???M</div>
                <div class="giaSp lablecs txt_center">GI?? B??N</div>
                <div class="soLuong lablecs txt_center">S??? L?????NG MUA</div>
                <div class="thanhTien lablecs txt_center">TH??NH TI???N</div>
                <div class="ngayOrder lablecs txt_center">NG??Y ?????T H??NG</div>
            </div>
            <?php while ($orderRow = mysqli_fetch_assoc($data['dataThanhToan'])) : ?>
                <div class="container_Item">
                    <?php if ($orderRow['pathImage'] == "") : ?>
                        <img class="imgItem lablecss" src="http://localhost/BTL_WEB/public/img/defautImg.gif" alt="gif">
                    <?php endif ?>
                    <?php if ($orderRow['pathImage'] != "") : ?>
                        <img class="imgItem lablecss" src="http://localhost/BTL_WEB/MVC/Views/pages/admin/quanlySanPham/upload/<?php echo $orderRow['pathImage'] ?>" alt="gif">
                    <?php endif ?>
                    <div class="tenSP lablecss">
                        <a href="http://localhost/btl_web/product/detail/<?php echo $orderRow['productID'] ?>">
                            <?php echo $orderRow['tenSanPham'] ?>
                        </a>
                    </div>
                    <div class="giaSp giaSP lablecss  txt_center"><?php echo $orderRow['giaSanPham'] ?></div>
                    <div class="soLuong lablecss txt_center"><?php echo $orderRow['TongSL'] ?></div>
                    <input type="text" class="thanhTientxt giaSP lablecss txt_center" disabled="disabled" value="<?php echo ($orderRow['TongSL'] * $orderRow['giaSanPham'])  ?>"></input>
                    <div class="ngayOrder lablecss txt_center"><?php echo $orderRow['ngayOrder'] ?></div>
                </div>
            <?php endwhile ?>
        </div>
    <?php endif ?>



</div>
<script>
    var p1 = "success";
</script>


<script>
    // H??M H??? TR???
    //FILE DA THANH TOAN VIEW
    function tienMuaHang() {
        var inputElems = document.getElementsByClassName("thanhTientxt"),
            total = 0;
        for (var i = 0; i < inputElems.length; i++) {
            total += parseInt(inputElems[i].value);
        }
        document.getElementById("tongTienMua").innerText = "T???ng H??a ????n l??: " + formatCash(total) + " VND";

    }
    tienMuaHang();
    //H??m ?????nh d???ng ti???n t??? VN
    function formatCash(str) {
        str = new String(str);
        return str.split('').reverse().reduce((prev, next, index) => {
            return ((index % 3) ? next : (next + ',')) + prev
        })

    }
</script>