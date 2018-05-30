<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 07/05/2018
 * Time: 11:07 CH
 */

class AdminChiTietTheLoaiController extends Controller
{

    public function indexAction(){
// action này in ra danh sách nhà sản xuất
        $this->layout->tieu_de = "Danh sách chi tiết";
        $this->layout->meta_des ="Trang quản trị| danh sách ";
        $this->view->title = "Danh Sách Chi Tiết";
        // admin-chuc-nang
        // LOAD MODEL

        $objModel = new ChiTietTheLoaiModel();
        $this->view->list = $objModel->getList();

    }

    public function addAction(){
       $this->layout->meta_des ="Trang quản trị| Thêm Tập Film Mới";
        $objModel = new ChiTietTheLoaiModel();
        $this->view->film = $objModel->getFilm();
        $this->view->the_loai = $objModel->getTheLoai();

        //1. Kiểm tra hợp lệ của dữ liệu
        if(isset($_POST['submit'])) {

            //2. Tạo model xử lý ghi vào CSDL
            $obModel = new ChiTietTheLoaiModel();
            $obModel->ten_film =$_POST['txt_ten_film'];
            $obModel->ten_the_loai = $_POST['txt_ten_the_loai'];
           
            

            $res = $obModel->SaveNew();
            if (is_numeric($res)) {
                $this->view->msg = "Thêm mới thành công!";
            } else
                $this->view->msg = $res;
        }
    }
    public function editAction(){
       $this->layout->meta_des ="Trang quản trị| Sửa ";
        $objModel = new ChiTietTheLoaiModel();
        $this->view->film = $objModel->getFilm();
        $this->view->the_loai = $objModel->getTheLoai();
        if(!isset($_GET['id'])) die("Khong xac dinh ID");

        $id = intval($_GET['id']);


        //1. Tạo model, load thông tin lên form
        $obModelCT = new ChiTietTheLoaiModel();
        
        $this->view->objCT =  $obModelCT->loadOne($id);

        //2. Xử lý ghi vào DB

        if(isset($_POST['submit'])) {
            //1. Kiểm tra hợp lệ của dữ liệu
            // tự làm



            //2.Nếu không có lỗi  Tạo model xử lý ghi vào CSDL
            $obModel = new ChiTietTheLoaiModel();
            $obModel->id =$id;
            $obModel->ten_film =$_POST['txt_ten_film'];
            $obModel->ten_the_loai = $_POST['txt_ten_the_loai'];
        



            $res = $obModel->SaveUpdate();
            if (is_numeric($res)) {
                $this->view->objCT=$obModel;
                $this->view->msg = "Cập nhật thành công!";
            } else
                $this->view->msg = $res;
        }





    }
}