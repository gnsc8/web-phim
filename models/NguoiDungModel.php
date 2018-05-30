<?php
class NguoiDungModel extends MyModel
{
    public $id ;
    public $ho_ten;
    public $username;
    public $passwd;
    public $dia_chi;
    public $dien_thoai;
    public $email;
    public $ngay_dang_ky;
    public $nhom_tai_khoan;
    protected $tb_name = 'tb_nguoi_dung';
    protected $tb_name2 = 'tb_nhom_user';
    public function getList($params = null){

        $sql = "SELECT * FROM $this->tb_name,$this->tb_name2 WHERE $this->tb_name.id_nhom_user=$this->tb_name2.id ORDER BY $this->tb_name.id DESC ";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while($row = mysqli_fetch_assoc($res)){
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }
    public function SaveNew(){

        $sqlInsert = "INSERT INTO $this->tb_name(ho_ten,username,passwd,email,ngay_dang_ky,id_nhom_user)
          VALUES ('$this->ho_ten','$this->username','$this->passwd','$this->email','$this->ngay_dang_ky','$this->nhom_tai_khoan')";

        $res = $this->ExecQuery($sqlInsert);

        if($res)
            return mysqli_insert_id($this->getConn()); // trả về ID mới
        else
            return "Không insert được";
    }
    public function loadOne($id){
        $sql = "SELECT * FROM $this->tb_name WHERE id= $id";
        $objRes = new stdClass();
        $res = mysqli_query($this->getConn(), $sql);
        if(mysqli_errno($this->getConn()))
        {
            $objRes->error = mysqli_error($this->getConn());
            return $objRes;
        }

        if(mysqli_num_rows($res) != 1){
            $objRes->error = "Lỗi không xác định bản ghi cần chỉnh sửa";
            return $objRes;
        }

        $row = mysqli_fetch_assoc($res); // lấy dòng dữ liệu
        foreach($row as $field_name => $value)
            $objRes->$field_name = $value;

        return $objRes;

    }

    public function SaveUpdate(){

        $sqlUpdate = "Update $this->tb_name SET ho_ten = '$this->ho_ten',
                     dia_chi='$this->dia_chi', dien_thoai = '$this->dien_thoai',email = '$this->email'
                    WHERE id = $this->id
                    ";


        $res = mysqli_query($this->getConn(),$sqlUpdate);

        if(mysqli_errno($this->getConn()))
            return mysqli_error($this->getConn());

        if($res)
            return mysqli_insert_id($this->getConn()); // trả về ID mới
        else
            return "Không cập nhật  được";

    }
    public function checkLogin(){
        $sql = "SELECT * FROM $this->tb_name WHERE username='$this->username' AND passwd ='$this->passwd'";

        $res = $this->ExecQuery($sql);

        if(mysqli_num_rows($res)==1){
            // thông tin hợp lệ
            $obj = new stdClass();
            $row = mysqli_fetch_assoc($res);

            $obj->id = $row['id'];
            $obj->ho_ten = $row['ho_ten'];
            $obj->username = $row['username'];
            $obj->email = $row['email'];
            $obj->id_nhom_user = $row['id_nhom_user'];

            return $obj;
        }else{
            return "Thông tin đăng nhập không đúng!";
        }
    }
    public function checkUsername(){
        $sql = "SELECT username FROM tb_nguoi_dung WHERE username='$this->username'";

        $resCheck = mysqli_query($this->getConn(), $sql);
        if(mysqli_errno($this->getConn()))
            return mysqli_error($this->getConn());

        if(mysqli_num_rows($resCheck)>0){
            echo "<script>alert('Username đã tồn tại');</script>";
        }
    }
    public function checkEmail(){
        $sql = "SELECT email FROM $this->tb_name WHERE email='$this->email'";

        $resCheck = mysqli_query($this->getConn(), $sql);
        if(mysqli_errno($this->getConn()))
            return mysqli_error($this->getConn());

        if(mysqli_num_rows($resCheck)>0){
            echo "<script>alert('Email đã tồn tại');</script>";
        }
    }
}