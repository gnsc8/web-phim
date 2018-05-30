<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 07/05/2018
 * Time: 11:07 CH
 */

class AdminQuocGiaController extends Controller
{

    public function indexAction(){
// action này in ra danh sách nhà sản xuất
        $this->layout->tieu_de = "Danh sách quốc gia";
        $this->layout->meta_des ="Trang quản trị| danh sách quốc gia";
        $this->view->title = "DANH SÁCH QUỐC GIA";
        // admin-chuc-nang
        // LOAD MODEL

        $objModel = new QuocGiaModel();
        $this->view->list = $objModel->getList();

    }

    public function addAction(){
         $this->layout->meta_des ="Trang quản trị| danh sách quốc gia";
        // thêm mới

//        echo '<pre>'.__FILE__.'::'.__METHOD__.'('.__LINE__.')<br>';
//            print_r($_POST);
//        echo '</pre>';
        //1. Kiểm tra hợp lệ của dữ liệu
        if(isset($_POST['txt_ten_quoc_gia'])) {

            //2. Tạo model xử lý ghi vào CSDL
            $obModelQG = new QuocGiaModel();

            $obModelQG->ten_quoc_gia = $_POST['txt_ten_quoc_gia'];
            

            $res = $obModelQG->SaveNew();
            if (is_numeric($res)) {
                $this->view->msg = "Thêm mới thành công!";
            } else
                $this->view->msg = $res;
        }
    }
    public function editAction(){
         $this->layout->meta_des ="Trang quản trị| danh sách quốc gia";
        //,,.,....
        if(!isset($_GET['id'])) die("Khong xac dinh ID");

        $id = intval($_GET['id']);


        //1. Tạo model, load thông tin lên form
        $obModelQG = new QuocGiaModel();

        $this->view->objQG =  $obModelQG->loadOne($id);

        //2. Xử lý ghi vào DB

        if(isset($_POST['txt_ten_quoc_gia'])) {
            //1. Kiểm tra hợp lệ của dữ liệu
            // tự làm



            //2.Nếu không có lỗi  Tạo model xử lý ghi vào CSDL
            $obModelEdit = new QuocGiaModel();
            $obModelEdit->id = $id;
            $obModelEdit->ten_quoc_gia = $_POST['txt_ten_quoc_gia'];
        



            $res = $obModelEdit->SaveUpdate();
            if (is_numeric($res)) {
                $this->view->objQG  = $obModelEdit;
                $this->view->msg = "Cập nhật thành công!";
            } else
                $this->view->msg = $res;
        }





    }
}