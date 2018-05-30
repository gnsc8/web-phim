<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 07/05/2018
 * Time: 11:07 CH
 */

class AdminChucNangController extends Controller
{

    public function indexAction(){
// action này in ra danh sách nhà sản xuất
        $this->layout->tieu_de = "Danh sách chức năng";
        $this->layout->meta_des ="Trang quản trị| danh sách chức năng";
        $this->view->title = "DANH SÁCH CHỨC NĂNG";
        // admin-chuc-nang
        // LOAD MODEL

        $objModel = new ChucNangModel();
        $this->view->list = $objModel->getList();

    }

    public function addAction(){
        $this->layout->tieu_de = "Thêm chức năng";
        $this->layout->meta_des ="Trang quản trị| thêm chức năng";
        $this->view->title = "THÊM CHỨC NĂNG";
//        echo '<pre>'.__FILE__.'::'.__METHOD__.'('.__LINE__.')<br>';
//            print_r($_POST);
//        echo '</pre>';
        //1. Kiểm tra hợp lệ của dữ liệu
        if(isset($_POST['txt_ten_chuc_nang'])) {

            //2. Tạo model xử lý ghi vào CSDL
            $obModelCN = new ChucNangModel();

            $obModelCN->ten_chuc_nang = $_POST['txt_ten_chuc_nang'];
            $obModelCN->link = $_POST['txt_link'];

            $res = $obModelCN->SaveNew();
            if (is_numeric($res)) {
                $this->view->msg = "Thêm mới thành công!";
            } else
                $this->view->msg = $res;
        }
    }
    public function editAction(){
        $this->layout->tieu_de = "Sửa chức năng";
        $this->layout->meta_des ="Trang quản trị| sửa chức năng";
        $this->view->title = "SỬA CHỨC NĂNG";
        //,,.,....
        if(!isset($_GET['id'])) die("Khong xac dinh ID");

        $id = intval($_GET['id']);


        //1. Tạo model, load thông tin lên form
        $obModelCN = new ChucNangModel();

        $this->view->objCN =  $obModelCN->loadOne($id);

        //2. Xử lý ghi vào DB

        if(isset($_POST['txt_ten_chuc_nang'])) {
            //1. Kiểm tra hợp lệ của dữ liệu
            // tự làm



            //2.Nếu không có lỗi  Tạo model xử lý ghi vào CSDL
            $obModelEdit = new ChucNangModel();
            $obModelEdit->id = $id;
            $obModelEdit->ten_chuc_nang = $_POST['txt_ten_chuc_nang'];
            $obModelEdit->link =$_POST['txt_link']; // sau này đăng nhập thì sẽ lấy trong session ra



            $res = $obModelEdit->SaveUpdate();
            if (is_numeric($res)) {
                $this->view->objCN  = $obModelEdit;
                $this->view->msg = "Cập nhật thành công!";
            } else
                $this->view->msg = $res;
        }





    }
}