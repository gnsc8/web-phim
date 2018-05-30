<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 07/05/2018
 * Time: 11:03 CH
 */

class AdminSlideController extends Controller
{
    public function indexAction(){
// action này in ra danh sách nhà sản xuất
        $this->layout->tieu_de = "Danh sách slide";
        $this->layout->meta_des ="Trang quản trị| danh sách slide";
        $this->view->title = "DANH SÁCH Slide";
        // admin-banner-qc
        // LOAD MODEL

        $objModel = new SlideModel();
        $this->view->list = $objModel->getList();

    }

    public function addAction(){
        $this->layout->meta_des ="Trang quản trị| danh sách Slide";
         $obModelSL = new SlideModel();
        $this->view->ten_film = $obModelSL->getFilm();
        // thêm mới

//        echo '<pre>'.__FILE__.'::'.__METHOD__.'('.__LINE__.')<br>';
//            print_r($_POST);
//        echo '</pre>';
        //1. Kiểm tra hợp lệ của dữ liệu
        if(isset($_POST['submit'])) {


            //2. Tạo model xử lý ghi vào CSDL
            $obModelSL = new SlideModel();

            $obModelSL->ten_film = $_POST['txt_ten_film'];
            $obModelSL->link = $_POST['txt_link'];


           


            $res =  $obModelSL->SaveNew();
            if (is_numeric($res)) {
                $this->view->msg = "Thêm mới thành công!";
            } else
                $this->view->msg = $res;
        }

    }
    public function editAction(){
        
        $this->layout->meta_des ="Trang quản trị| danh sách Slide";
        $obModelSL = new SlideModel();
        $this->view->ten_film = $obModelSL->getFilm();
        //,,.,....
        if(!isset($_GET['id'])) die("Khong xac dinh ID");

        $id = intval($_GET['id']);


        //1. Tạo model, load thông tin lên form
        $obModelSL = new SlideModel();

        $this->view->objSL =$obModelSL->loadOne($id);

        //2. Xử lý ghi vào DB

        if(isset($_POST['submit'])) {
            //1. Kiểm tra hợp lệ của dữ liệu
            // tự làm



            //2.Nếu không có lỗi  Tạo model xử lý ghi vào CSDL
            $obModelEdit = new SlideModel();
            $obModelEdit->id = $id;
            $obModelEdit->ten_film = $_POST['txt_ten_film'];
            $obModelEdit->link= $_POST['txt_link'];
          


            $res = $obModelEdit->SaveUpdate();
            if (is_numeric($res)) {
                $this->view->objSL  = $obModelEdit;
                $this->view->msg = "Cập nhật thành công!";
            } else
                $this->view->msg = $res;
        }





    }
}