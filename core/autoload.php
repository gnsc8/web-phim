<?php
require_once app_path.'/configs/app.php';
function app_autoload($className){
    // hàm tự động gọi khi khởi tạo đối tượng mà nó không tồn tại lớp.
    //1. Xác định thứ tự ưu tiên các file cần nhúng:
    // - Controller trước, model, các file khác.

    //2. Kiểm tra file cần nhúng có phải là controller hay không

//    die($className);

    if(substr($className,0,5) =='Admin')
        $file_path = controller_path.'/admin/'.$className.'.php';
    else
        $file_path = controller_path.'/frontend/'.$className.'.php';

//    die($file_path);
    if(file_exists($file_path))
        require_once  $file_path;
    else
    {
        //2.1: Kiểm tra đến thư mục model:
        $file_path = model_path.'/'.$className.'.php';
//        die($file_path);
        if(file_exists($file_path)){
            require_once $file_path;
        }else{
            //2.2 Kiểm tra file có ở trong thư mục core hay không?
            $file_path = app_path .'/core/'.$className.'.php';
//            die($file_path);
            if(file_exists($file_path))
                require_once  $file_path;
            else
            {
                $file_path = app_path .'/libs/'.$className.'.php';
                if(file_exists($file_path))
                    require_once  $file_path;
                else
                    die("Class name: <b>$className</b> not found!");
            }

        }
    }
}

// dành cho PHP7.x
// đổi tên hàm __autoload thành app_autoload
 spl_autoload_register('app_autoload');
