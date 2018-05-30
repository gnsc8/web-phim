<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 07/05/2018
 * Time: 10:59 CH
 */

class AdminTheLoaiController extends Controller{
    public function indexAction(){
        // action này in ra danh sách nhà sản xuất
        $this->layout->tieu_de = "Danh sách thể loại";
        $this->layout->meta_des ="Trang quản trị| danh sách thể loại";
        $this->view->title = "DANH SÁCH THỂ LOẠI";
        // admin-nha-san-xuat
        // LOAD MODEL

        $objModel = new TheLoaiModel();
        $this->view->list = $objModel->getList();

    }

    public function addAction(){
        $this->layout->tieu_de = "Thêm thể loại";
        $this->layout->meta_des ="Trang quản trị| Thêm thể loại";
        $this->view->title = "THÊM THỂ LOẠI";
        // thêm mới

//        echo '<pre>'.__FILE__.'::'.__METHOD__.'('.__LINE__.')<br>';
//            print_r($_POST);
//        echo '</pre>';
        //1. Kiểm tra hợp lệ của dữ liệu
        if(isset($_POST['ten_the_loai'])) {

            //2. Tạo model xử lý ghi vào CSDL
            $obModelTL = new TheLoaiModel();
//            public $id ;
//            public $ten_the_loai;
//            public $ngay_them;
//            public $ngay_cap_nhap;
            $obModelTL->ten_the_loai = $_POST['ten_the_loai'];
            $obModelTL->ngay_them = date('Y-m-d H:i:s');


            $res = $obModelTL->SaveNew();
            if (is_numeric($res)) {
                $this->view->msg = "Thêm mới thành công!";
            } else
                $this->view->msg = $res;
        }
    }
    public function editAction(){
        $this->layout->tieu_de = "Sửa thể loại";
        $this->layout->meta_des ="Trang quản trị| Sửa thể loại";
        $this->view->title = "SỬA THỂ LOẠI";
        //,,.,....
        if(!isset($_GET['id'])) die("Khong xac dinh ID");

        $id = intval($_GET['id']);


        //1. Tạo model, load thông tin lên form
        $obModelTLEdit = new TheLoaiModel();

        $this->view->objTL = $obModelTLEdit->loadOne($id);

        //2. Xử lý ghi vào DB

        if(isset($_POST['ten_the_loai'])) {
            //1. Kiểm tra hợp lệ của dữ liệu
            // tự làm



            //2.Nếu không có lỗi  Tạo model xử lý ghi vào CSDL
            $obModelTLEdit = new TheLoaiModel();
            $obModelTLEdit->id = $id;
            $obModelTLEdit->ten_the_loai = $_POST['ten_the_loai'];
            $obModelTLEdit->ngay_cap_nhap = date('Y-m-d H:i:s');


            $res = $obModelTLEdit->SaveUpdate();
            if (is_numeric($res)) {
                $this->view->objTL  = $obModelTLEdit;
                $this->view->msg = "Cập nhật thành công!";
            } else
                $this->view->msg = $res;
        }





    }

}