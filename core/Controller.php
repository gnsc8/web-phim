<?php
class Controller {
    protected $view;
    protected $layout;
    public $currentAction;
    public $currentController;

    public function __construct()
    {
        $this->view = new stdClass();
        $this->layout = new stdClass();
        $film="";
    }

    public function showContent(){

        $file_view_path = app_path.'/views/'.strtolower($this->currentController).'/'.strtolower($this->currentAction).'.phtml';
        //vd: /?controller=admin-san-pham&action=list
        // đường dẫn file sẽ là: .../view/admin-san-pham/list.phtml
        if(file_exists($file_view_path))
            require_once $file_view_path;
        else{
            $file_v = str_replace(app_path,'',$file_view_path);
            die("File view <b>$file_v</b> not found!");
        }
    }

    public function loadLayout(){
        if(isset($this->layout->disable_layout)){
            $this->showContent();
            return;
        }

        if(substr($this->currentController,0,5) == 'admin') // chữ thường
        {
            // là đang vào controller của phần quản trị
            // nhúng layout của quản trị

            $file_layout = layout_path.'/admin.phtml';
            if(file_exists($file_layout))
                require_once $file_layout;
            else{
                die("File layout admin.phtml not found!");
            }

        }else{
            $file_layout = layout_path.'/master.phtml';
            if(file_exists($file_layout))
                require_once $file_layout;
            else{
                die("File layout master.phtml not found!");
            }
        }


    }


}