<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 07/05/2018
 * Time: 9:03 CH
 */

class AdminUserController extends Controller{
    public function indexAction(){
        // action này in ra danh sách nhà sản xuất
        $this->layout->tieu_de = "Danh sách User";
        $this->layout->meta_des ="Trang quản trị| danh sách User";
        $this->view->title = "DANH SÁCH USER";
        // admin-nha-san-xuat
        // LOAD MODEL

        $objModel = new UserModel();
        $this->view->list = $objModel->getList();

    }

    public function addAction(){
        // thêm mới
        $this->layout->meta_des ="Trang quản trị| danh sách User";
//        echo '<pre>'.__FILE__.'::'.__METHOD__.'('.__LINE__.')<br>';
//            print_r($_POST);
//        echo '</pre>';
        //1. Kiểm tra hợp lệ của dữ liệu
        if(isset($_POST['ho_ten'])) {

            //2. Tạo model xử lý ghi vào CSDL
            $obModelU = new UserModel();

            $obModelU->ho_ten = $_POST['ho_ten'];
            $obModelU->username = $_POST['txt_username'];
            $obModelU->passwd = md5($_POST['txt_pas']);
            $obModelU->dia_chi = $_POST['dia_chi'];
            $obModelU->dien_thoai = $_POST['dien_thoai'];
            $obModelU->email = $_POST['email'];
            $obModelU->nhom_tai_khoan =1;


            $res = $obModelU->SaveNew();
             print_r($res);
            if (is_numeric($res)) {
                $this->view->msg = "Thêm mới thành công!";
            } else
                $this->view->msg = $res;
        }
    }
    public function editAction(){
        $this->layout->meta_des ="Trang quản trị| danh sách User";
        //,,.,....
        if(!isset($_GET['id'])) die("Khong xac dinh ID");

        $id = intval($_GET['id']);


        //1. Tạo model, load thông tin lên form
        $obModelEdit = new UserModel();

        $this->view->objUR = $obModelEdit->loadOne($id);

        //2. Xử lý ghi vào DB

        if(isset($_POST['txt_ho_ten'])) {
            //1. Kiểm tra hợp lệ của dữ liệu
            // tự làm



            //2.Nếu không có lỗi  Tạo model xử lý ghi vào CSDL
            $obModelEdit = new UserModel();
            $obModelEdit->id = $id;
            $obModelEdit->ho_ten = $_POST['txt_ho_ten'];
            $obModelEdit->dia_chi = $_POST['txt_dia_chi'];
            $obModelEdit->dien_thoai = $_POST['txt_dien_thoai'];
            $obModelEdit->email = $_POST['txt_email'];
            $obModelEdit->ngay_sinh = $_POST['txt_ngay_sinh'];
            $obModelEdit->gioi_tinh = $_POST['txt_gioi_tinh'];

           

            $res = $obModelEdit->SaveUpdate();
            if (is_numeric($res)) {
                $this->view->objUR = $obModelEdit;
                $this->view->msg = "Cập nhật thành công!";
            } else
                $this->view->msg = $res;
        }





    }

}