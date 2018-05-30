<?php
class IndexController extends Controller
{

    public function indexAction()
    {   $objModel = new FilmModel();
        $this->layout->tieu_de = "xem phim";
        $this->layout->meta_des = "xem phim online";
        $this->view->title = "index";
        $this->view->the_loai_header = $objModel->getTheLoai();
        $this->view->quoc_gia_header = $objModel->getQuocGia();

        if (isset($_POST['submit-login'])) {
            // xử lý sự kiện đăng nhập
            $username = $_POST['username-login'];
            $password = $_POST['password-login'];

            //1. Kiểm tra hợp lệ của dữ liệu: Tự làm

            //2. Kiểm tồn tại trong DB: Gọi model ra kiểm tra
            $objTaiKhoan = new NguoiDungModel();
            $objTaiKhoan->username = $username;
            $objTaiKhoan->passwd = md5($password);

            $checkLogin = $objTaiKhoan->checkLogin();
            if (is_a($checkLogin, 'stdClass')) {
                // nếu kết quả của hàm là 1 đối tượng kiểu stdClass ==> là đăng nhập thành công.
                // ghi vào session
                $_SESSION['auth'] = $checkLogin; // bỏ đối tượng này vào biến session
                // chuyển tran về trang chủ
                //header('Location:' . base_url);

            } else {
                echo "<script type='text/javascript'>alert('Thông tin tài khoản chưa đúng');</script>";
            }
        }

            //$this->view->list = $objModel->getList();

        if(isset($_GET['search_ten_film']) && strlen($_GET['search_ten_film']) > 0){
            $params = array();
            if(isset($_GET['search_ten_film'])){
                $params['search_ten_film'] = $_GET['search_ten_film'];
            }

            $objModel = new SearchFilmModel();
            $this->view->total_records = $objModel->count($params);
            //tìm limit và current_page
            $this->view->current_page = isset($_GET['page']) ? $_GET['page'] : 1;
            //số bản ghi trên 1 trang
            $limit = 32;

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

            $this->view->search = $objModel->searchList($params,$start,$limit);
        }else{
            $this->view->slide = $objModel->getSlide();
            $this->view->danh_muc = $objModel->getDanhMuc();

            $this->view->phim_bo = $objModel->listDanhMucPhimBo();
            $this->view->phim_le = $objModel->listDanhMucPhimLe();
            $this->view->phim_chieu_rap = $objModel->listDanhMucPhimChieuRap();
            $this->view->phim_anime = $objModel->listDanhMucPhimAnime();
        }







    }

    public function thongtinphimAction()
    {
        /*if (strtoupper($_GET['id']) == 'full'){
            $id = 1;
        }elseif (is_numeric($_GET['id'])){
            $id = $_GET['id'];
        }*/
        if (!isset($_GET['id'])) die("Khong xac dinh ID");
        $id = intval($_GET['id']);

        if (!isset($_GET['id_dm'])) die("Danh Muc Khong Xac Dinh");
        $id_dm = intval($_GET['id_dm']);

        $objModel = new FilmModel();
        $this->view->the_loai_header = $objModel->getTheLoai();
        $this->view->quoc_gia_header = $objModel->getQuocGia();
        if (isset($_POST['submit-login'])) {
            // xử lý sự kiện đăng nhập
            $username = $_POST['username-login'];
            $password = $_POST['password-login'];

            //1. Kiểm tra hợp lệ của dữ liệu: Tự làm

            //2. Kiểm tồn tại trong DB: Gọi model ra kiểm tra
            $objTaiKhoan = new NguoiDungModel();
            $objTaiKhoan->username = $username;
            $objTaiKhoan->passwd = md5($password);

            $checkLogin = $objTaiKhoan->checkLogin();
            if (is_a($checkLogin, 'stdClass')) {
                // nếu kết quả của hàm là 1 đối tượng kiểu stdClass ==> là đăng nhập thành công.
                // ghi vào session
                $_SESSION['auth'] = $checkLogin; // bỏ đối tượng này vào biến session
                // chuyển tran về trang chủ
                //header('Location:' . base_url);

            } else {
                $this->view->msg = $checkLogin;
            }
        }

        $obModelF = new ThongTinPhimModel();

        $this->view->objthong_tin_phim = $obModelF->loadOne($id);
        $this->view->dien_vien = $obModelF->loadDienVienFilm($id);
        $this->view->the_loai = $obModelF->loadTheLoaiFilm($id);

        $this->view->relate = $obModelF->loadRelated($id_dm);
    }

    public function videoAction()
    {
        if (!isset($_GET['id'])) die("Khong xac dinh ID");
        $id = intval($_GET['id']);
        if (!isset($_GET['tap'])) die("Khong xac dinh Tap");
        $tap = $_GET['tap'];

        $objModel = new FilmModel();
        $this->view->the_loai_header = $objModel->getTheLoai();
        $this->view->quoc_gia_header = $objModel->getQuocGia();
        if (isset($_POST['submit-login'])) {
            // xử lý sự kiện đăng nhập
            $username = $_POST['username-login'];
            $password = $_POST['password-login'];

            //1. Kiểm tra hợp lệ của dữ liệu: Tự làm

            //2. Kiểm tồn tại trong DB: Gọi model ra kiểm tra
            $objTaiKhoan = new NguoiDungModel();
            $objTaiKhoan->username = $username;
            $objTaiKhoan->passwd = md5($password);

            $checkLogin = $objTaiKhoan->checkLogin();
            if (is_a($checkLogin, 'stdClass')) {
                // nếu kết quả của hàm là 1 đối tượng kiểu stdClass ==> là đăng nhập thành công.
                // ghi vào session
                $_SESSION['auth'] = $checkLogin; // bỏ đối tượng này vào biến session
                // chuyển tran về trang chủ
                //header('Location:' . base_url);

            } else {
                $this->view->msg = $checkLogin;
            }
        }

        $obModelVideo = new VideoModel();
        $this->view->video = $obModelVideo->loadOne($id, $tap);
        $this->view->list = $obModelVideo->getList($id);
    }

    public function registerAction()
    {
        $objModel = new FilmModel();
        $this->view->the_loai_header = $objModel->getTheLoai();
        $this->view->quoc_gia_header = $objModel->getQuocGia();
        if (isset($_POST['submit-login'])) {
            // xử lý sự kiện đăng nhập
            $username = $_POST['username-login'];
            $password = $_POST['password-login'];

            //1. Kiểm tra hợp lệ của dữ liệu: Tự làm

            //2. Kiểm tồn tại trong DB: Gọi model ra kiểm tra
            $objTaiKhoan = new NguoiDungModel();
            $objTaiKhoan->username = $username;
            $objTaiKhoan->passwd = md5($password);

            $checkLogin = $objTaiKhoan->checkLogin();
            if (is_a($checkLogin, 'stdClass')) {
                // nếu kết quả của hàm là 1 đối tượng kiểu stdClass ==> là đăng nhập thành công.
                // ghi vào session
                $_SESSION['auth'] = $checkLogin; // bỏ đối tượng này vào biến session
                // chuyển tran về trang chủ
                header('Location:' . base_url);

            } else {
                $this->view->msg = $checkLogin;
            }
        }

//        echo '<pre>'.__FILE__.'::'.__METHOD__.'('.__LINE__.')<br>';
//            print_r($_POST);
//        echo '</pre>';
        //1. Kiểm tra hợp lệ của dữ liệu
        if (isset($_POST['register-submit'])) {

            //2. Tạo model xử lý ghi vào CSDL
            $objTaiKhoan = new NguoiDungModel();

            $objTaiKhoan->ho_ten = $_POST['name'];
            $objTaiKhoan->username = $_POST['username'];
            $objTaiKhoan->passwd = md5($_POST['confirm-password']);
            $objTaiKhoan->email = $_POST['email'];
            $objTaiKhoan->ngay_dang_ky = date('Y-m-d H:i:s');
            $objTaiKhoan->nhom_tai_khoan = 3;

            print_r($_POST);
            $res = $objTaiKhoan->SaveNew();
            if (is_numeric($res)) {
                $checkLogin = $objTaiKhoan->checkLogin();
                if (is_a($checkLogin, 'stdClass')) {
                    // nếu kết quả của hàm là 1 đối tượng kiểu stdClass ==> là đăng nhập thành công.
                    // ghi vào session
                    $_SESSION['auth'] = $checkLogin; // bỏ đối tượng này vào biến session
                    // chuyển tran về trang chủ
                    header('Location:' . base_url);
                }
            } else
                $this->view->msg = $res;
        }


    // $objModelND = new NguoiDungModel();

    //if (isset($_POST['']))
}
    public function quocgiaAction(){
        if(!isset($_GET['id'])) die("Khong xac dinh ID");
        $id = intval($_GET['id']);

        $objModel = new FilmModel();
        $this->view->the_loai_header = $objModel->getTheLoai();
        $this->view->quoc_gia_header = $objModel->getQuocGia();
        if(isset($_POST['submit-login'])){
            // xử lý sự kiện đăng nhập
            $username = $_POST['username-login'];
            $password = $_POST['password-login'];

            //1. Kiểm tra hợp lệ của dữ liệu: Tự làm

            //2. Kiểm tồn tại trong DB: Gọi model ra kiểm tra
            $objTaiKhoan = new NguoiDungModel();
            $objTaiKhoan->username = $username;
            $objTaiKhoan->passwd = md5($password);

            $checkLogin = $objTaiKhoan->checkLogin();
            if(is_a($checkLogin,'stdClass')){
                // nếu kết quả của hàm là 1 đối tượng kiểu stdClass ==> là đăng nhập thành công.
                // ghi vào session
                $_SESSION['auth'] = $checkLogin; // bỏ đối tượng này vào biến session
                // chuyển tran về trang chủ
                //header('Location:'.base_url);

            }else{
                $this->view->msg = $checkLogin;
            }
        }

        $objModelQG = new TimKiemModel();
        $this->view->total_records = $objModelQG->getTongQuocGia($id);
        //tìm limit và current_page
        $this->view->current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        //số bản ghi trên 1 trang
        $limit = 32;

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

        $this->view->quoc_gia = $objModelQG->getQuocGia($start,$limit,$id);
        $this->view->ten_quoc_gia = $objModelQG->getTenQuocGia($id);
    }
    public function theloaiAction(){
        if(!isset($_GET['id'])) die("Khong xac dinh ID");
        $id = intval($_GET['id']);

        $objModel = new FilmModel();
        $this->view->the_loai_header = $objModel->getTheLoai();
        $this->view->quoc_gia_header = $objModel->getQuocGia();
        if(isset($_POST['submit-login'])){
            // xử lý sự kiện đăng nhập
            $username = $_POST['username-login'];
            $password = $_POST['password-login'];

            //1. Kiểm tra hợp lệ của dữ liệu: Tự làm

            //2. Kiểm tồn tại trong DB: Gọi model ra kiểm tra
            $objTaiKhoan = new NguoiDungModel();
            $objTaiKhoan->username = $username;
            $objTaiKhoan->passwd = md5($password);

            $checkLogin = $objTaiKhoan->checkLogin();
            if(is_a($checkLogin,'stdClass')){
                // nếu kết quả của hàm là 1 đối tượng kiểu stdClass ==> là đăng nhập thành công.
                // ghi vào session
                $_SESSION['auth'] = $checkLogin; // bỏ đối tượng này vào biến session
                // chuyển tran về trang chủ
                //header('Location:'.base_url);

            }else{
                $this->view->msg = $checkLogin;
            }
        }
        //phân trang
        $objModelTL = new TimKiemModel();
        $this->view->total_records = $objModelTL->getTongTheLoai($id);

        //tìm limit và current_page
        $this->view->current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        //số bản ghi trên 1 trang
        $limit = 32;

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

        $this->view->the_loai = $objModelTL->getTheLoai($start,$limit,$id);
        $this->view->ten_the_loai = $objModelTL->getTenTheLoai($id);
    }
    public function myfilmAction(){
        //menu
        $objModel = new FilmModel();
        $this->view->the_loai_header = $objModel->getTheLoai();
        $this->view->quoc_gia_header = $objModel->getQuocGia();
        //đăng nhập
        if(isset($_POST['submit-login'])){
            // xử lý sự kiện đăng nhập
            $username = $_POST['username-login'];
            $password = $_POST['password-login'];

            //1. Kiểm tra hợp lệ của dữ liệu: Tự làm

            //2. Kiểm tồn tại trong DB: Gọi model ra kiểm tra
            $objTaiKhoan = new NguoiDungModel();
            $objTaiKhoan->username = $username;
            $objTaiKhoan->passwd = md5($password);

            $checkLogin = $objTaiKhoan->checkLogin();
            if(is_a($checkLogin,'stdClass')){
                // nếu kết quả của hàm là 1 đối tượng kiểu stdClass ==> là đăng nhập thành công.
                // ghi vào session
                $_SESSION['auth'] = $checkLogin; // bỏ đối tượng này vào biến session
                // chuyển tran về trang chủ
                //header('Location:'.base_url);

            }else{
                $this->view->msg = $checkLogin;
            }
        }
        //thêm phim vào ưa thích
        //if(!isset($_GET['id'])) die("Khong xac dinh ID");

        if ($_SESSION['auth']->id_nhom_user == 3){
            $id_user = intval($_SESSION['auth']->id);
        }else{
            echo "<meta charset='utf-8'><p style='color: red;text-align: center; font-weight: bold;font-size:3em;'>Tài khoản của quản trị viên không có quyền truy cập!</p>";
            die();
        }
        $objTimKiem = new TimKiemModel();

        if (isset($_SESSION['id'])){
            $id_film = $_SESSION['id'];
            $notification = (string)$objTimKiem->checkFilm($id_user,$id_film);
            print_r("<script type='text/javascript'>alert('$notification');</script>") ;
            unset($_SESSION['id']);
        }

        //phân trang
        $this->view->total_records = $objTimKiem->getTongMyFilm($id_user);

        //tìm limit và current_page
        $this->view->current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        //số bản ghi trên 1 trang
        $limit = 32;

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

        $this->view->my_film = $objTimKiem->getListMyFilm($id_user,$limit,$start);
        //$this->view->ten_my_film = $objTimKiem->getTenTheLoai($id);
    }
    public function phimboAction(){

        $objModel = new FilmModel();
        $this->view->the_loai_header = $objModel->getTheLoai();
        $this->view->quoc_gia_header = $objModel->getQuocGia();
        if(isset($_POST['submit-login'])){
            // xử lý sự kiện đăng nhập
            $username = $_POST['username-login'];
            $password = $_POST['password-login'];

            //1. Kiểm tra hợp lệ của dữ liệu: Tự làm

            //2. Kiểm tồn tại trong DB: Gọi model ra kiểm tra
            $objTaiKhoan = new NguoiDungModel();
            $objTaiKhoan->username = $username;
            $objTaiKhoan->passwd = md5($password);

            $checkLogin = $objTaiKhoan->checkLogin();
            if(is_a($checkLogin,'stdClass')){
                // nếu kết quả của hàm là 1 đối tượng kiểu stdClass ==> là đăng nhập thành công.
                // ghi vào session
                $_SESSION['auth'] = $checkLogin; // bỏ đối tượng này vào biến session
                // chuyển tran về trang chủ
                //header('Location:'.base_url);

            }else{
                $this->view->msg = $checkLogin;
            }
        }

        $objModelPB = new TimKiemModel();
        $this->view->total_records = $objModelPB->getTongPhimBo();
        //tìm limit và current_page
        $this->view->current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        //số bản ghi trên 1 trang
        $limit = 32;

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

        $this->view->phim_bo = $objModelPB->getListPhimBo($limit,$start);
    }
    public function phimleAction(){

        $objModel = new FilmModel();
        $this->view->the_loai_header = $objModel->getTheLoai();
        $this->view->quoc_gia_header = $objModel->getQuocGia();
        if(isset($_POST['submit-login'])){
            // xử lý sự kiện đăng nhập
            $username = $_POST['username-login'];
            $password = $_POST['password-login'];

            //1. Kiểm tra hợp lệ của dữ liệu: Tự làm

            //2. Kiểm tồn tại trong DB: Gọi model ra kiểm tra
            $objTaiKhoan = new NguoiDungModel();
            $objTaiKhoan->username = $username;
            $objTaiKhoan->passwd = md5($password);

            $checkLogin = $objTaiKhoan->checkLogin();
            if(is_a($checkLogin,'stdClass')){
                // nếu kết quả của hàm là 1 đối tượng kiểu stdClass ==> là đăng nhập thành công.
                // ghi vào session
                $_SESSION['auth'] = $checkLogin; // bỏ đối tượng này vào biến session
                // chuyển tran về trang chủ
                //header('Location:'.base_url);

            }else{
                $this->view->msg = $checkLogin;
            }
        }

        $objModelPL = new TimKiemModel();
        $this->view->total_records = $objModelPL->getTongPhimLe();
        //tìm limit và current_page
        $this->view->current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        //số bản ghi trên 1 trang
        $limit = 32;

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

        $this->view->phim_le = $objModelPL->getListPhimLe($limit,$start);
    }
    public function hoathinhanimeAction(){

        $objModel = new FilmModel();
        $this->view->the_loai_header = $objModel->getTheLoai();
        $this->view->quoc_gia_header = $objModel->getQuocGia();
        if(isset($_POST['submit-login'])){
            // xử lý sự kiện đăng nhập
            $username = $_POST['username-login'];
            $password = $_POST['password-login'];

            //1. Kiểm tra hợp lệ của dữ liệu: Tự làm

            //2. Kiểm tồn tại trong DB: Gọi model ra kiểm tra
            $objTaiKhoan = new NguoiDungModel();
            $objTaiKhoan->username = $username;
            $objTaiKhoan->passwd = md5($password);

            $checkLogin = $objTaiKhoan->checkLogin();
            if(is_a($checkLogin,'stdClass')){
                // nếu kết quả của hàm là 1 đối tượng kiểu stdClass ==> là đăng nhập thành công.
                // ghi vào session
                $_SESSION['auth'] = $checkLogin; // bỏ đối tượng này vào biến session
                // chuyển tran về trang chủ
                //header('Location:'.base_url);

            }else{
                $this->view->msg = $checkLogin;
            }
        }

        $objModelA = new TimKiemModel();
        $this->view->total_records = $objModelA->getTongPhimAnime();
        //tìm limit và current_page
        $this->view->current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        //số bản ghi trên 1 trang
        $limit = 32;

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

        $this->view->phim_anime = $objModelA->getListPhimAnime($limit,$start);
    }
    public function logoutAction(){
        session_unset();// hủy hết session
        header('Location: '.base_url); // chuyển về trang chủ
    }
    public function searchAction(){
        $objModel = new FilmModel();
        $this->view->the_loai_header = $objModel->getTheLoai();
        $this->view->quoc_gia_header = $objModel->getQuocGia();
        if(isset($_POST['submit-login'])){
            // xử lý sự kiện đăng nhập
            $username = $_POST['username-login'];
            $password = $_POST['password-login'];

            //1. Kiểm tra hợp lệ của dữ liệu: Tự làm

            //2. Kiểm tồn tại trong DB: Gọi model ra kiểm tra
            $objTaiKhoan = new NguoiDungModel();
            $objTaiKhoan->username = $username;
            $objTaiKhoan->passwd = md5($password);

            $checkLogin = $objTaiKhoan->checkLogin();
            if(is_a($checkLogin,'stdClass')){
                // nếu kết quả của hàm là 1 đối tượng kiểu stdClass ==> là đăng nhập thành công.
                // ghi vào session
                $_SESSION['auth'] = $checkLogin; // bỏ đối tượng này vào biến session
                // chuyển tran về trang chủ
                //header('Location:'.base_url);

            }else{
                $this->view->msg = $checkLogin;
            }
        }

         $params = array();
        if(isset($_GET['search_ten_film'])){
            $params['search_ten_film'] = $_GET['search_ten_film'];
        }

        $objModel = new SearchFilmModel();
        $this->view->total_records = $objModel->count($params);
        //tìm limit và current_page
        $this->view->current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        //số bản ghi trên 1 trang
        $limit = 32;

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

        $this->view->search = $objModel->searchList($params,$start,$limit);
    }


    }
