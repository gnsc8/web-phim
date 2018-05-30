<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 07/05/2018
 * Time: 11:03 CH
 */

class AdminDienVienController extends Controller
{
    public function indexAction(){
// action này in ra danh sách nhà sản xuất
        $this->layout->tieu_de = "Danh sách diễn viên";
        $this->layout->meta_des ="Trang quản trị| danh sách diễn viên";
        $this->view->title = "DANH SÁCH Diễn Viên";
        $params = array();
        if(isset($_GET['search_hoten'])){

            $params['search_hoten'] = $_GET['search_hoten'];
        }

        $objModel = new DienVienModel();

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

        $this->view->dien_vien = $objModel->getlist($params,$start,$limit);

    }

    public function addAction(){
        
        $this->layout->meta_des ="Trang quản trị| danh sách diễn viên";
        
        // thêm mới

//        echo '<pre>'.__FILE__.'::'.__METHOD__.'('.__LINE__.')<br>';
//            print_r($_POST);
//        echo '</pre>';
        //1. Kiểm tra hợp lệ của dữ liệu
        if(isset($_POST['txt_ten_dien_vien'])) {

            //2. Tạo model xử lý ghi vào CSDL
            $obModelDV = new DienVienModel();

            $obModelDV->ten_dien_vien = $_POST['txt_ten_dien_vien'];
            $obModelDV->gioi_thieu = $_POST['txt_gioi_thieu'];


           


            $res =  $obModelDV->SaveNew();
            if (is_numeric($res)) {
                $this->view->msg = "Thêm mới thành công!";
            } else
                $this->view->msg = $res;
        }

    }
    public function editAction(){
        
        $this->layout->meta_des ="Trang quản trị| danh sách diễn viên";
       
        //,,.,....
        if(!isset($_GET['id'])) die("Khong xac dinh ID");

        $id = intval($_GET['id']);


        //1. Tạo model, load thông tin lên form
        $obModelDV = new DienvienModel();

        $this->view->objDV =  $obModelDV->loadOne($id);

        //2. Xử lý ghi vào DB

        if(isset($_POST['txt_ten_dien_vien'])) {
            //2.Nếu không có lỗi  Tạo model xử lý ghi vào CSDL
            $obModelEdit = new DienVienModel();
            $obModelEdit->id = $id;
            $obModelEdit->ten_dien_vien = $_POST['txt_ten_dien_vien'];
            $obModelEdit->gioi_thieu = $_POST['txt_gioi_thieu'];
          


            $res = $obModelEdit->SaveUpdate();
            if (is_numeric($res)) {
                $this->view->objDV  = $obModelEdit;
                $this->view->msg = "Cập nhật thành công!";
            } else
                $this->view->msg = $res;
        }





    }
}