<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 07/05/2018
 * Time: 11:07 CH
 */

class AdminChiTietDanhMucController extends Controller
{

    public function indexAction(){
// action này in ra danh sách nhà sản xuất
        $this->layout->tieu_de = "Danh sách chi tiết";
        $this->layout->meta_des ="Trang quản trị| danh sách ";
        $this->view->title = "Danh Sách Chi Tiết Danh Muc";
        // admin-chuc-nang
        // LOAD MODEL

        $objModel = new ChiTietDanhMucModel();
        $this->view->list = $objModel->getList();

    }

    public function addAction(){
       $this->layout->meta_des ="Trang quản trị| Thêm Tập Film Mới";
        $objModel = new ChiTietDanhMucModel();
        $this->view->film = $objModel->getFilm();
        $this->view->danh_muc = $objModel->getDanhMuc();

        //1. Kiểm tra hợp lệ của dữ liệu
        if(isset($_POST['submit'])) {


            //2. Tạo model xử lý ghi vào CSDL
            $obModel = new ChiTietDanhMucModel();
            $obModel->ten_film =$_POST['txt_ten_film'];
            $obModel->ten_danh_muc = $_POST['txt_ten_danh_muc'];
           
            

            $res = $obModel->SaveNew();
            if (is_numeric($res)) {
                $this->view->msg = "Thêm mới thành công!";
            } else
                $this->view->msg = $res;
        }
    }
    public function editAction(){
       $this->layout->meta_des ="Trang quản trị| Sửa ";
        $objModel = new ChiTietDanhMucModel();
        $this->view->film = $objModel->getFilm();
        $this->view->danh_muc = $objModel->getDanhMuc();
        if(!isset($_GET['id'])) die("Khong xac dinh ID");
        
        $id = intval($_GET['id']);

        //1. Tạo model, load thông tin lên form
        $obModel = new ChiTietDanhMucModel();
        
        $this->view->objDMCT =  $obModel->loadOne($id);
        $id_film = $this->view->objDMCT->id_film;

        if(isset($_POST['submit'])) {
            



            //2.Nếu không có lỗi  Tạo model xử lý ghi vào CSDL
            $obModel = new ChiTietDanhMucModel();
            $id_dm = $_POST['txt_ten_danh_muc'];
        



            $res = $obModel->SaveUpdate($id,$id_film,$id_dm);

            if (is_numeric($res)) {
                $this->view->objDMCT=$obModel;
                $this->view->msg = "Cập nhật thành công!";
            } else
                $this->view->msg = $res;
        }





    }
}