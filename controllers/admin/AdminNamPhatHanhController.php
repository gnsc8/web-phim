<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 07/05/2018
 * Time: 11:07 CH
 */

class AdminNamPhatHanhController extends Controller
{

    public function indexAction(){
// action này in ra danh sách nhà sản xuất
        $this->layout->tieu_de = "Danh sách năm phát hành";
        $this->layout->meta_des ="Trang quản trị| danh sách năm phát hành";
        $this->view->title = "DANH SÁCH NĂM PHÁT HÀNH";
        // admin-chuc-nang
        // LOAD MODEL

        $objModel = new NamPhatHanhModel();
        $this->view->list = $objModel->getList();

    }

    public function addAction(){
        // thêm mới
        $this->layout->meta_des ="Trang quản trị| danh sách năm phát hành";
//        echo '<pre>'.__FILE__.'::'.__METHOD__.'('.__LINE__.')<br>';
//            print_r($_POST);
//        echo '</pre>';
        //1. Kiểm tra hợp lệ của dữ liệu
        if(isset($_POST['txt_nam_phat_hanh'])) {

            //2. Tạo model xử lý ghi vào CSDL
            $obModelNPH = new NamPhatHanhModel();

            $obModelNPH->nam_phat_hanh = $_POST['txt_nam_phat_hanh'];
            

            $res = $obModelNPH->SaveNew();
            if (is_numeric($res)) {
                $this->view->msg = "Thêm mới thành công!";
            } else
                $this->view->msg = $res;
        }
    }
    public function editAction(){
        $this->layout->meta_des ="Trang quản trị| danh sách năm phát hành";
        //,,.,....
        if(!isset($_GET['id'])) die("Khong xac dinh ID");

        $id = intval($_GET['id']);


        //1. Tạo model, load thông tin lên form
        $obModelNPH = new NamPhatHanhModel();

        $this->view->objNPH =  $obModelNPH->loadOne($id);

        //2. Xử lý ghi vào DB

        if(isset($_POST['txt_nam_phat_hanh'])) {
            //1. Kiểm tra hợp lệ của dữ liệu
            // tự làm



            //2.Nếu không có lỗi  Tạo model xử lý ghi vào CSDL
            $obModelEdit = new NamPhatHanhModel();
            $obModelEdit->id = $id;
            $obModelEdit->nam_phat_hanh = $_POST['txt_nam_phat_hanh'];
        



            $res = $obModelEdit->SaveUpdate();
            if (is_numeric($res)) {
                $this->view->objNPH  = $obModelEdit;
                $this->view->msg = "Cập nhật thành công!";
            } else
                $this->view->msg = $res;
        }





    }
}