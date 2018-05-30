<?php
class MyMVC {

    /**
     * Hàm này xử lý các việc: Nhận tham số, lựa chọn controller, action, tự động nhứng file...
     */
    public function  run(){
//       echo __METHOD__;
        // Lấy các tham số truyền vào để xác định controller và action

        $controller = isset($_GET['controller'])?$_GET['controller']:'index';
        $action = isset($_GET['action'])?$_GET['action']:'index';

        $GLOBALS['current_controller']  = $controller;
        $GLOBALS['current_action']  = $action;

        if(!$this->checkACL($controller,$action)){
            echo "<meta charset='utf-8'><p style='color: red;text-align: center; font-weight: bold;'>Bạn chưa được cấp quyền sử dụng chức năng này!</p>";

            die();
        }
//        echo "Controller: $controller, action: $action";


        // chuyển chữ cái thường của controller thành chữ hoa sau đó tạo đối tượng.
       // controller: admin-san-pham, action: list
        // không thể dùng if để kiểm tra controller
        $classNameController = str_replace('-',' ', $controller); // tách chuỗi thành nhiều từ
        $classNameController = ucwords($classNameController);  // chuyển thành chữ hoa ở đầu các từ
        $classNameController = str_replace(' ','', $classNameController);
        $classNameController .='Controller';

        $objController = new $classNameController();

       // Gán giá trị controller và action hiện tại: Các giá trị lấy trên url
       $objController->currentController = $controller;
       $objController->currentAction = $action;



        // xử lý load action

        $functionName = str_replace('-',' ', $action); // tách chuỗi thành nhiều từ
        $functionName = ucwords($functionName);  // chuyển thành chữ hoa ở đầu các từ
        $functionName = str_replace(' ','', $functionName);
        $functionName .='Action';
        $functionName = lcfirst($functionName); // chuyển ký tự đầu tiên thành chữ thường

        // kiểm tra sự tồn tại của action trong đối tượng controller vừa tạo.
        if(!method_exists($objController,$functionName)){
           die("<br>Action <b>$functionName</b> not found!");
        }

        $objController->$functionName();// gọi action


        $objController->loadLayout(); // gọi lệnh nhúng file layout vào web.



    }
    public function checkACL($controller, $action){
        $str_check = $controller .'_'.$action;

        // mảng luôn cho phép đối với một số action:

        $default_allow = array('index_index', 'index_login','index_logout','index_reg','admin_login','index_thong-tin-phim','index_video','index_register','index_the-loai','index_quoc-gia','index_phim-bo','index_phim-le','index_hoat-hinh-anime','index_my-film');

        if(in_array($str_check, $default_allow))
            return true; // không cần kiểm tra trong CSDL

        if(empty($_SESSION['auth'])){
            // chưa đăng nhập
           header("location: ".base_url);
            return false;
        }
        if ($_SESSION['auth']->id == 1 && $_SESSION['auth']->id_nhom_user == 1){
            return true;
        }

        if(empty($_SESSION['auth']->permission_allow)){
            // kiểm tra trong csdl có các quyền nào được phép sử dụng
            $id_nhom_tai_khoan = $_SESSION['auth']->id_nhom_user;
            $sql_check = "SELECT * FROM tb_phan_quyen INNER  JOIN  tb_chuc_nang ON tb_phan_quyen.id_chuc_nang = tb_chuc_nang.id
                          WHERE tb_phan_quyen.id_nhom_user = $id_nhom_tai_khoan AND  tb_phan_quyen.trang_thai = 1";

            $objMyModel = new MyModel();

            $res = mysqli_query($objMyModel->getConn(),$sql_check); // lấy chuỗi kết nối CSDL
            if(mysqli_errno($objMyModel->getConn()))
            {
                die("Loi qua trinh kiem tra quyen: ". mysqli_error($objMyModel->getConn()));
            }

            $arrTmp = array();
            while($row = mysqli_fetch_assoc($res)){
                $arrTmp[] = $row['link']; // lấy link trong bảng chức năng để lưu vào session
            }

            $_SESSION['auth']->permission_allow = $arrTmp; // dưa danh sách các chức năng hợp lệ vào session
            // để khi vào các trang web sẽ không phải kết nối DB làm chậm tốc độ web

        }
        // đến đây thì đã có $_SESSION['auth']['permission_allow']
        if(in_array($str_check,$_SESSION['auth']->permission_allow )){
            return true;
        }else
            return false;
    }


}