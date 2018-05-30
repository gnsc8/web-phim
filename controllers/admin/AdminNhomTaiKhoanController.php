<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 07/05/2018
 * Time: 9:13 CH
 */

class AdminNhomTaiKhoanController extends Controller
{
public function indexAction(){
    // action này in ra danh sách nhóm tài khoản
    $this->layout->tieu_de = "Danh sách nhóm tài khoản";
    $this->layout->meta_des ="Trang quản trị| danh sách nhóm tài khoản";
    $this->view->title = "DANH SÁCH NHÓM TÀI KHOẢN";
    // admin-nhom-tai-khoan
    // LOAD MODEL

    $objModel = new NhomTaiKhoanModel();
    $this->view->list = $objModel->getList();

}

    public function addAction(){
        $this->layout->meta_des ="Trang quản trị| danh sách nhóm tài khoản";
        // thêm mới

//        echo '<pre>'.__FILE__.'::'.__METHOD__.'('.__LINE__.')<br>';
//            print_r($_POST);
//        echo '</pre>';
        //1. Kiểm tra hợp lệ của dữ liệu
        if(isset($_POST['txt_ten_nhom'])) {

            //2. Tạo model xử lý ghi vào CSDL
            $obModelNTK = new NhomTaiKhoanModel();

            $obModelNTK->ten_nhom = $_POST['txt_ten_nhom'];
            


           


            $res =  $obModelNTK->SaveNew();
            if (is_numeric($res)) {
                $this->view->msg = "Thêm mới thành công!";
            } else
                $this->view->msg = $res;
        }

    }
    public function editAction(){
        $this->layout->meta_des ="Trang quản trị| danh sách nhóm tài khoản";
        //,,.,....
        if(!isset($_GET['id'])) die("Khong xac dinh ID");

        $id = intval($_GET['id']);


        //1. Tạo model, load thông tin lên form
        $obModelNTK = new NhomTaiKhoanModel();

        $this->view->objNTK =  $obModelNTK->loadOne($id);

        //2. Xử lý ghi vào DB

        if(isset($_POST['txt_ten_nhom'])) {
            //2.Nếu không có lỗi  Tạo model xử lý ghi vào CSDL
            $obModelEdit = new NhomTaiKhoanModel();
            $obModelEdit->id = $id;
            $obModelEdit->ten_nhom = $_POST['txt_ten_nhom'];


            $res = $obModelEdit->SaveUpdate();
            if (is_numeric($res)) {
                $this->view->objNTK  = $obModelEdit;
                $this->view->msg = "Cập nhật thành công!";
            } else
                $this->view->msg = $res;
        }





    }
}