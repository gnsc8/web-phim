<?php
class AdminModel extends MyModel
{
    public $id ;
    public $ho_ten;
    public $username;
    public $passwd;
    public function checkLogin(){
        $sql = "SELECT * FROM tb_user WHERE username='$this->username' AND passwd ='$this->passwd'";
        echo $sql;

        $resCheck = mysqli_query($this->getConn(), $sql);
        if(mysqli_errno($this->getConn()))
            return mysqli_error($this->getConn());

        if(mysqli_num_rows($resCheck)==1){
            // thông tin hợp lệ
            $obj = new stdClass();
            $row = mysqli_fetch_assoc($resCheck);

            $obj->id = $row['id'];
            $obj->ho_ten = $row['ho_ten'];
            $obj->username = $row['username'];
            $obj->email = $row['email'];
            $obj->id_nhom_user = $row['id_nhom_user'];
            print_r($obj);
            print_r($row);
            return $obj;
        }else{
            return "Thông tin đăng nhập không đúng!";
        }
    }

}