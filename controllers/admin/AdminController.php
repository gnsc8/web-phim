<?php
class AdminController extends Controller{
    public function indexAction(){
        $this->layout->tieu_de = "Trang ADMIN";
        $this->layout->meta_des ="Trang quản trị";
        
    }
    public function loginAction(){
        $this->layout->tieu_de = "Login";
        
        $this->layout->disable_layout = 1;
//        [txt_username] => abc123
//        [txt_passwd] => 111111

        if(isset($_POST['submit'])){
            
            $txt_username = $_POST['txt_username'];
            $txt_passwd = md5($_POST['txt_pas']);

            $err = array(); // biến để ghi lỗi trong quá trình làm việc

            //1. Kiểm tra hợp lệ của dữ liệu: Tự làm

            //2. Kiểm tồn tại trong DB: Gọi model ra kiểm tra
            $objTaiKhoan = new UserModel();
            $objTaiKhoan->username = $txt_username;
            $objTaiKhoan->passwd = md5($txt_passwd);

            $checkLogin = $objTaiKhoan->checkLogin();
            if(is_a($checkLogin,'stdClass')){
                // nếu kết quả của hàm là 1 đối tượng kiểu stdClass ==> là đăng nhập thành công.
                // ghi vào session
                $_SESSION['auth'] = $checkLogin; // bỏ đối tượng này vào biến session
                // chuyển tran về trang chủ
                header('Location: '.base_url.'/?controller=admin');

            }else{
                $this->view->msg = $checkLogin;
            }


        }


    }
    public function logoutAction(){
        session_unset();// hủy hết session
        header('Location:'.base_url); // chuyển về trang login
    }

}