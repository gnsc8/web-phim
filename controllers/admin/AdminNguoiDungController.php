<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 07/05/2018
 * Time: 9:03 CH
 */

class AdminNguoiDungController extends Controller{
    public function indexAction(){
        // action này in ra danh sách nhà sản xuất
        $this->layout->tieu_de = "Danh sách khách hàng";
        $this->layout->meta_des ="Trang quản trị| danh sách khách hàng";
        $this->view->title = "DANH SÁCH KHÁCH HÀNG";
        // admin-nha-san-xuat
        // LOAD MODEL

        $objModel = new NguoiDungModel();
        $this->view->list = $objModel->getList();

    }

    public function addAction(){
        $this->layout->meta_des ="Trang quản trị| danh sách khách hàng";
        // thêm mới

//        echo '<pre>'.__FILE__.'::'.__METHOD__.'('.__LINE__.')<br>';
//            print_r($_POST);
//        echo '</pre>';
        //1. Kiểm tra hợp lệ của dữ liệu
        if(isset($_POST['ho_ten'])) {

            //2. Tạo model xử lý ghi vào CSDL
            $obModelKH = new NguoiDungModel();

            $obModelKH->ho_ten = $_POST['ho_ten'];
            $obModelKH->username = $_POST['txt_username'];
            $obModelKH->passwd = $_POST['txt_pas'];
            $obModelKH->dia_chi = $_POST['dia_chi'];
            $obModelKH->dien_thoai = $_POST['dien_thoai'];
            $obModelKH->email = $_POST['email'];
            $obModelKH->ngay_dang_ky = date('Y-m-d H:i:s');
            $obModelKH->nhom_tai_khoan =3;


            $res = $obModelKH->SaveNew();
            if (is_numeric($res)) {
                $this->view->msg = "Thêm mới thành công!";
            } else
                $this->view->msg = $res;
        }
    }
    public function editAction(){
        $this->layout->meta_des ="Trang quản trị| danh sách khách hàng";
        //,,.,....
        if(!isset($_GET['id'])) die("Khong xac dinh ID");

        $id = intval($_GET['id']);


        //1. Tạo model, load thông tin lên form
        $obModelEdit = new NguoiDungModel();

        $this->view->objKH = $obModelEdit->loadOne($id);

        //2. Xử lý ghi vào DB

        if(isset($_POST['txt_ho_ten'])) {
            //1. Kiểm tra hợp lệ của dữ liệu
            // tự làm



            //2.Nếu không có lỗi  Tạo model xử lý ghi vào CSDL
            $obModelEdit = new NguoiDungModel();
            $obModelEdit->id = $id;
            $obModelEdit->ho_ten = $_POST['txt_ho_ten'];
            $obModelEdit->dia_chi = $_POST['txt_dia_chi'];
            $obModelEdit->dien_thoai = $_POST['txt_dien_thoai'];
            $obModelEdit->email = $_POST['txt_email'];
           

            $res = $obModelEdit->SaveUpdate();
            if (is_numeric($res)) {
                $this->view->objKH = $obModelEdit;
                $this->view->msg = "Cập nhật thành công!";
            } else
                $this->view->msg = $res;
        }





    }

}