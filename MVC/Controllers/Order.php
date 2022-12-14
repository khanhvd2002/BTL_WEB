<?php
class Order extends controller
{

    public $order;
    function __construct()
    {
        unset($_SESSION['pageSub']);
        $_SESSION['page'] = "Order";
        $this->order = $this->model('OrderSP');
    }

    public function index()

    {
        if (isset($_SESSION['user']['userID'])) {
            $result = $this->order->getAll($_SESSION['user']['userID']);
            $this->view('MasterLayout', [
                'page' => 'content/gioHang',
                'dataOrder' => $result
            ]);
        } else {
            header('Location: /BTL_WEB/auth');
        }
    }
    //kick vào thêm giỏ hàng
    public function orderSingle($idProduct)
    {
        if (isset($_SESSION['user'])) {
            $IdUser = $_SESSION['user']['userID'];
            $result1 = $this->order->addOneOrder($idProduct);
            $result = $this->order->getAll($IdUser);
            $this->view('MasterLayout', [
                'page' => 'content/gioHang',
                'dataOrder' => $result
            ]);
        } else {
            $this->render('login/LoginForm');
        }
    }

    //click vào đặt số lượng sản phẩm 
    public function addMultiProduct()
    {
        if (isset($_SESSION['user'])) {
            $IdUser = $_SESSION['user']['userID'];
            $idProduct = $_POST['txtIDproduct'];
            $soLuong = $_POST['txtSLMua'];
            $result1 = $this->order->addMultiOrder($idProduct, $soLuong, $IdUser);
            $result = $this->order->getAll($IdUser);
            $this->view('MasterLayout', [
                'page' => 'content/gioHang',
                'dataOrder' => $result
            ]);
        } else {
            $this->render('login/LoginForm');
        }
    }

    //DELE ORDER
    public function HuyOrder()
    {
        if (isset($_SESSION['user'])) {
            $IdUser = $_SESSION['user']['userID'];
            $idProduct = $_POST['strOrder'];
            $arrIDproduct = explode('_', $idProduct);
            var_dump($arrIDproduct[0]);
            var_dump($IdUser);
            for ($i = 0; $i < count($arrIDproduct); $i++) {
                $this->order->deleOrder($IdUser, $arrIDproduct[$i]);
            }
            $result1 = $this->order->getAll($IdUser);
            $this->view('MasterLayout', [
                'page' => 'content/gioHang',
                'dataOrder' => $result1
            ]);
        } else {
            $this->render('login/LoginForm');
        }
    }
    public function thanhToan()
    {
        if (isset($_SESSION['user'])) {
            $IdUser = $_SESSION['user']['userID'];
            $idProduct = $_POST['strOrder'];
            $arrIDproduct = explode('_', $idProduct);
            $sl = $_POST['strOrderSL'];
            $arrSL =  explode('_', $sl);
            $Kho = $_POST['strOrderKho'];
            $arrKho =  explode('_', $Kho);
            for ($i = 0; $i < count($arrIDproduct); $i++) {
                $this->order->ThanhToanSauKhiSua($arrIDproduct[$i], $arrSL[$i], $arrKho[$i], $IdUser);
                echo $arrIDproduct[$i] . "id", $arrSL[$i] . "sl", $arrKho[$i] . "kho", $IdUser . "kten";
            }
            $result = $this->order->getAll($_SESSION['user']['userID']);
            $this->view('MasterLayout', [
                'page' => 'content/gioHang',
                'dataOrder' => $result
            ]);
        } else {
            $this->render('login/LoginForm');
        }
    }
}
