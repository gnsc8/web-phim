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

        //phân trang
        $objModel = new TapFilmModel();

        $this->view->total_records = $objModel->countTapFilm();

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

        $this->view->tap_film = $objModel->getlist($start,$limit);


    }

    public function addAction(){
        $objModel = new TapFilmModel();
        if (isset($_GET['id'])){
            $id= intval($_GET['id']);
            $this->view->loadOne = $objModel->loadOne($id);
        }
       $this->layout->meta_des ="Trang quản trị| Thêm Tập Film Mới";


        $this->view->film = $objModel->getFilm();
        //1. Kiểm tra hợp lệ của dữ liệu
        if(isset($_POST['submit'])) {

            //2. Tạo model xử lý ghi vào CSDL
            $obModel = new TapFilmModel();
            $obModel->ten_film = isset($_GET['id']) ? $obModel->ten_film = $id : $_POST['txt_ten_film'];
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