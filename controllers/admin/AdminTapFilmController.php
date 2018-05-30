<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 07/05/2018
 * Time: 11:07 CH
 */

class AdminTapFilmController extends Controller
{

    public function indexAction(){
// action này in ra danh sách nhà sản xuất
        $this->layout->tieu_de = "Danh sách tập film";
        $this->layout->meta_des ="Trang quản trị| danh sách tập film";
        $this->view->title = "DANH SÁCH TẬP FILM";
        // admin-chuc-nang
        // LOAD MODEL

        $objModel = new TapFilmModel();
        $this->view->list = $objModel->getList();

    }

    public function addAction(){
       $this->layout->meta_des ="Trang quản trị| Thêm Tập Film Mới";
        $objModel = new TapFilmModel();
        $this->view->film = $objModel->getFilm();
        //1. Kiểm tra hợp lệ của dữ liệu
        if(isset($_POST['submit'])) {

            //2. Tạo model xử lý ghi vào CSDL
            $obModel = new TapFilmModel();
            $obModel->ten_film =$_POST['txt_ten_film'];
            $obModel->ten_tap = $_POST['txt_ten_tap'];
            $obModel->link_fb = $_POST['txt_link_fb'];
            $obModel->link_gd = $_POST['txt_link_gd'];
            $obModel->link_op = $_POST['txt_link_op'];
            

            $res = $obModel->SaveNew();
            if (is_numeric($res)) {
                $this->view->msg = "Thêm mới thành công!";
            } else
                $this->view->msg = $res;
        }
    }
    public function editAction(){
       $this->layout->meta_des ="Trang quản trị| Sửa tập film";
        if(!isset($_GET['id'])) die("Khong xac dinh ID");

        $id = intval($_GET['id']);


        //1. Tạo model, load thông tin lên form
        $obModelTF = new TapFilmModel();
        
        $this->view->objTF =  $obModelTF->loadOne($id);

        //2. Xử lý ghi vào DB

        if(isset($_POST['submit'])) {
            //1. Kiểm tra hợp lệ của dữ liệu
            // tự làm



            //2.Nếu không có lỗi  Tạo model xử lý ghi vào CSDL
            $obModelEdit = new TapFilmModel();
            $obModelEdit->id = $id;
            $obModelEdit->ten_fiml = $_POST['txt_ten_film'];
            $obModelEdit->ten_tap = $_POST['txt_ten_tap'];
            $obModelEdit->link_fb = $_POST['txt_link_fb'];
            $obModelEdit->link_gd = $_POST['txt_link_gd'];
            $obModelEdit->link_op = $_POST['txt_link_op'];
        



            $res = $obModelEdit->SaveUpdate();
            if (is_numeric($res)) {
                $this->view->objTF =$obModelEdit;
                $this->view->msg = "Cập nhật thành công!";
            } else
                $this->view->msg = $res;
        }





    }
}