<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 07/05/2018
 * Time: 11:03 CH
 */

class AdminFilmController extends Controller
{
    public function indexAction(){
// action này in ra danh sách nhà sản xuất
        $this->layout->tieu_de = "Danh Sách Film";
        $this->layout->meta_des ="Trang quản trị| Danh Sách Film";
        $this->view->title = "Danh Sách Film";
        $params = array();
        if(isset($_GET['search_ten_film'])){
            //1. kiểm tra hợp lệ của chuỗi search_username Việc này tự làm

            //2. nếu kiểm tra ok thì gán vào mảng
            $params['search_ten_film'] = $_GET['search_ten_film'];
        }
        if(isset($_GET['search_danh_muc'])){
            //1. kiểm tra hợp lệ của chuỗi search_username Việc này tự làm

            //2. nếu kiểm tra ok thì gán vào mảng
            $params['search_danh_muc'] = $_GET['search_danh_muc'];
        }

        if(isset($_GET['search_nam_phat_hanh'])){
            //1. kiểm tra hợp lệ của chuỗi search_username Việc này tự làm

            //2. nếu kiểm tra ok thì gán vào mảng
            $params['search_nam_phat_hanh'] = $_GET['search_nam_phat_hanh'];
        }
        if(isset($_GET['search_quoc_gia'])){
            //1. kiểm tra hợp lệ của chuỗi search_username Việc này tự làm

            //2. nếu kiểm tra ok thì gán vào mảng
            $params['search_quoc_gia'] = $_GET['search_quoc_gia'];
        }
    
        // làm tương tự với các biến khác.
        if(isset($_GET['order'])){
            //1. kiểm tra hợp lệ của chuỗi order Việc này tự làm
            //2. nếu kiểm tra ok thì gán vào mảng
            $params['order'] = $_GET['order'];
        }
         if(isset($_GET['col'])){
            //1. kiểm tra hợp lệ của chuỗi col Việc này tự làm
            //2. nếu kiểm tra ok thì gán vào mảng
            $params['col'] = $_GET['col'];
        }
        // tạo model
        $objModelFilm = new FilmModel();
            //***** xử lý phân trang 
        //$currentPage = @intval($_GET['page']);
//        if($currentPage <=0)
//            $currentPage = 1;
        $this->view->total_records = $objModelFilm->countList($params);
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

        // tạo model
        $this->view->list =$objModelFilm->getList($params,$start,$limit);
        $this->view->danh_muc =$objModelFilm->getDanhMuc();
        $this->view->nam_phat_hanh =$objModelFilm->getNamPhatHanh();
        $this->view->quoc_gia = $objModelFilm->getQuocGia();
   }

    public function addAction(){
        
        //lấy thông tin đưa ra form
        $this->layout->meta_des ="Trang quản trị| Thêm Phim Mới";
        $objModel = new FilmModel();
        $this->view->danh_muc = $objModel->getDanhMuc();
        $this->view->dao_dien = $objModel->getDaoDien();
        $this->view->nam_phat_hanh = $objModel->getNamPhatHanh();
        $this->view->quoc_gia = $objModel->getQuocGia();
        // thêm mới

//        echo '<pre>'.__FILE__.'::'.__METHOD__.'('.__LINE__.')<br>';
//            print_r($_POST);
//        echo '</pre>';
        //1. Kiểm tra hợp lệ của dữ liệu
        if(isset($_POST['submit'])) {

            //2. Tạo model xử lý ghi vào CSDL
            $obModeladd = new FilmModel();

            $obModeladd->ten_film = $_POST['ten_film'];
            $obModeladd->ten_film_english = $_POST['ten_film_english'];
            $obModeladd->link_anh = $_POST['link_anh'];
            $obModeladd->thong_tin_film = $_POST['thong_tin_film'];
            $obModeladd->danh_muc = $_POST['danh_muc'];
            $obModeladd->dao_dien = $_POST['dao_dien'];
            $obModeladd->thoi_luong = $_POST['thoi_luong'];
            $obModeladd->quoc_gia = $_POST['quoc_gia'];
            $obModeladd->nam_phat_hanh = $_POST['nam_phat_hanh'];
            $obModeladd->ngay_them = date('Y-m-d H:i:s');


            $res =  $obModeladd->SaveNew();
            if (is_numeric($res)) {
                $this->view->msg = "Thêm mới thành công!";
            } else
                $this->view->msg = $res;
        }
    }
    public function editAction(){
        $this->layout->meta_des ="Trang quản trị| Sửa Thông Tin Film";
        $objModel = new FilmModel();
        $this->view->danh_muc = $objModel->getDanhMuc();
        $this->view->dao_dien = $objModel->getDaoDien();
        $this->view->nam_phat_hanh = $objModel->getNamPhatHanh();
        $this->view->quoc_gia = $objModel->getQuocGia();
        if(!isset($_GET['id'])) die("Khong xac dinh ID");

        $id = intval($_GET['id']);


        //1. Tạo model, load thông tin lên form
        $obModelF = new FilmModel();

        $this->view->objF =  $obModelF->loadOne($id);

        //2. Xử lý ghi vào DB

        if(isset($_POST['ten_film'])) {
            //2.Nếu không có lỗi  Tạo model xử lý ghi vào CSDL
            $obModelEdit = new FilmModel();
            $obModelEdit->id = $id;

            $obModelEdit->ten_film = $_POST['ten_film'];
            $obModelEdit->ten_film_english = $_POST['ten_film_english'];
            $obModelEdit->link_anh = $_POST['link_anh'];
            $obModelEdit->thong_tin_film = $_POST['thong_tin_film'];
            $obModelEdit->danh_muc = $_POST['danh_muc'];
            $obModelEdit->dao_dien = $_POST['dao_dien'];
            $obModelEdit->thoi_luong = $_POST['thoi_luong'];
            $obModelEdit->quoc_gia = $_POST['quoc_gia'];
            $obModelEdit->nam_phat_hanh = $_POST['nam_phat_hanh'];
            $obModelEdit->ngay_cap_nhat = date('Y-m-d H:i:s');


            $res = $obModelEdit->SaveUpdate();
            if (is_numeric($res)) {
                $this->view->objF  = $obModelEdit;
                $this->view->msg = "Cập nhật thành công!";
            } else
                $this->view->msg = $res;
        }
    }
    public function deleteAction(){
        //,,.,....
        if(!isset($_GET['id'])) die("Khong xac dinh ID");

        $id = intval($_GET['id']);


            //2.Nếu không có lỗi  Tạo model xử lý ghi vào CSDL
            $obModelFEdit = new FilmModel();
            $obModelFEdit->id = $id;


            $res = $obModelFEdit->Delete($id);
            if (is_numeric($res)) {
                $this->view->msg = "Xóa thành công!";
            } else
                $this->view->msg = $res;

    }
}
