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



        $params = array();
        if(isset($_GET['search'])){

            $params['search'] = $_GET['search'];
        }

        $objModel = new ChiTietTheLoaiModel();

        //phân trang
        $this->view->total_records = $objModel->count($params);

        //tìm limit và current_page
        $this->view->current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        //số bản ghi trên 1 trang
        $limit = 10;

        // tổng số trang
        $this->view->total_page = ceil($this->view->total_records / $limit);

        // Giới hạn current_page trong khoảng 1 đến total_page
        if ($this->view->current_page > $this->view->total_page){
            $this->view->current_page = $this->view->total_page;
        }
        else if ($this->view->current_page < 1){
            $this->view->current_page = 1;
        }

        // Tìm Start
        $start = ($this->view->current_page - 1) * $limit;

        $this->view->list = $objModel->getlist($params,$start,$limit);

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
        print_r($this->view->objCT);
        $id_film = $this->view->objCT->id_film;

        //2. Xử lý ghi vào DB

        if(isset($_POST['submit'])) {
            //1. Kiểm tra hợp lệ của dữ liệu
            // tự làm



            //2.Nếu không có lỗi  Tạo model xử lý ghi vào CSDL
            $obModel = new ChiTietTheLoaiModel();
           
            $id_tl=$_POST['txt_ten_the_loai'];
        



            $res = $obModel->SaveUpdate($id,$id_film,$id_tl);
            if (is_numeric($res)) {
                $this->view->objCT=$obModel;
                $this->view->msg = "Cập nhật thành công!";
            } else
                $this->view->msg = $res;
        }





    }
}