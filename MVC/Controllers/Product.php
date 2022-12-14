<?php
class Product extends controller
{
    public $sanpham;
    public $danhmuc;
    function __construct()
    {
        unset($_SESSION['pageSub']);
        $this->sanpham = $this->model('SanPham');
        $this->danhmuc = $this->model('DanhMuc');
    }
    public function Detail($id)
    {

        $result = $this->sanpham->getDetail($id);
        $result1 = $this->sanpham->getDetail($id);
        $tenSp = mysqli_fetch_assoc($result1);
        $_SESSION['pageSub'] = $tenSp['tenSanPham'];
        $this->view('MasterLayout', [
            'page' => 'content/chiTietSanPham',
            'data' => $result
        ]);
    }

    // LỌC SẢN PHẨM THEO DANH MỤC
    public function DanhMuc($id)
    {

        //ấy ra tên danh mục
        $this->danhmuc = $this->model('DanhMuc');
        $tenDM = $this->danhmuc->getByID($id);
        $DMuc = mysqli_fetch_assoc($tenDM);
        $result = $this->sanpham->getByCategory($id);
        $_SESSION['page'] = $DMuc['tenDanhMuc'];
        $idDM =  $DMuc['danhMucID'];
        $result = $this->sanpham->getByCategory($id);
        $this->view('MasterLayout', [
            'page' => 'content/danhMuc',
            'data' => $result,
            'idDanhMuc' =>  $idDM 
        ]);
    }


    //tham số Order nhận DESC OR ASC
    public function SortDanhMuc($id)
    {

        $order = $_POST['sortProduct'];
        //'ấy ra tên danh mục
        $tenDM = $this->danhmuc->getByID($id);
        $DMuc = mysqli_fetch_assoc($tenDM);
        $result = $this->sanpham->getByCategorySort($id,$order);
        $_SESSION['page'] = $DMuc['tenDanhMuc'];
        $idDM =  $DMuc['danhMucID'];
        $this->view('MasterLayout', [
            'page' => 'content/danhMuc',
            'data' => $result,
            'idDanhMuc' =>  $idDM 
        ]);
    }

    //SẢN PHẨM USER ĐÃ MUA
    public function DaMua()
    {
        $_SESSION['page'] = "Đã mua hàng";
        if (isset($_SESSION['user'])) {
            $idUser = $_SESSION['user']['userID'];
            $result = $this->sanpham->hangDaThanhToan($idUser);
            $this->view('MasterLayout', [
                'page' => 'content/daThanhToan',
                'dataThanhToan' => $result
            ]);
        }
    }

    // TÌM KIẾM SẢN PHẨM THEO TÊN
    public function SearchName()
    {
        if (isset($_POST['btnSearchProduct'])) {
            $stringName = $_POST['txtSearchName'];
            $result = $this->sanpham->TimKiemSP($stringName);
            $_SESSION['page'] = "Tìm kiếm";
            $this->view('MasterLayout', [
                'page' => 'content/product',
                'dataProduct' => $result
            ]);
        } else {
            header('Location: /BTL_WEB/home');
        }
    }
}
