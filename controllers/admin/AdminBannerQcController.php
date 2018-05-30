<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 07/05/2018
 * Time: 10:59 CH
 */

class AdminBannerQcController extends Controller{
    public function indexAction(){
        // action này in ra danh sách nhà sản xuất
        $this->layout->tieu_de = "Danh sách banner quảng cáo";
        $this->layout->meta_des ="Trang quản trị| danh sách ";
        $this->view->title = "DANH SÁCH ";
        // admin-nha-san-xuat
        // LOAD MODEL

        $objModel = new BannerQcModel();
        $this->view->list = $objModel->getList();

    }

    public function addAction(){
        $this->layout->tieu_de = "Thêm Link Quảng Cáo";
        $this->layout->meta_des ="Trang quản trị| Thêm ";
        $this->view->title = "Thêm Link Quảng Cáo";
        // thêm mới

//        echo '<pre>'.__FILE__.'::'.__METHOD__.'('.__LINE__.')<br>';
//            print_r($_POST);
//        echo '</pre>';
        //1. Kiểm tra hợp lệ của dữ liệu
        if(isset($_POST['submit'])) {

            //2. Tạo model xử lý ghi vào CSDL
            $obModelQC = new BannerQcModel();
//            public $id ;
//            public $ten_the_loai;
//            public $ngay_them;
//            public $ngay_cap_nhap;
            $obModelQC->banner = $_POST['txt_banner'];
            $obModelQC->link = $_POST['txt_link'];
            $obModelQC->ngay_them = date('Y-m-d H:i:s');

            $res = $obModelQC->SaveNew();
            if (is_numeric($res)) {
                $this->view->msg = "Thêm mới thành công!";
            } else
                $this->view->msg = $res;
        }
    }
    public function editAction(){
        $this->layout->tieu_de = "Sửa Thông tin";
        $this->layout->meta_des ="Trang quản trị| Sửa ";
        $this->view->title = "SỬA Thông Tin";
        //,,.,....
        if(!isset($_GET['id'])) die("Khong xac dinh ID");

        $id = intval($_GET['id']);


        //1. Tạo model, load thông tin lên form
        $obModelQCEdit = new BannerQcModel();

        $this->view->objQC = $obModelQCEdit->loadOne($id);

        //2. Xử lý ghi vào DB

        if(isset($_POST['submit'])) {

            //2. Tạo model xử lý ghi vào CSDL
            $obModelQC = new BannerQcModel();
//            public $id ;
//            public $ten_the_loai;
//            public $ngay_them;
//            public $ngay_cap_nhap;

            $obModelQC->banner = $_POST['txt_banner'];
            $obModelQC->link = $_POST['txt_link'];
            $obModelQC->ngay_cap_nhat = date('Y-m-d H:i:s');


            $res = $obModelQCEdit->SaveUpdate($id);
            if (is_numeric($res)) {
                $this->view->objQC  = $obModelQCEdit;
                $this->view->msg = "Cập nhật thành công!";
            } else
                $this->view->msg = $res;
        }





    }

}