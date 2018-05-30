<?php
class TheLoaiModel extends MyModel
{
    public $id ;
    public $ten_the_loai;
    public $ngay_them;
    public $ngay_cap_nhap;
    private $id_tai_khoan = 1;

    protected $tb_name = 'tb_the_loai';
    public function getList($params = null){

        $sql = "SELECT * FROM $this->tb_name ORDER  BY id DESC ";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while($row = mysqli_fetch_assoc($res)){
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }
    public function SaveNew($params = null){

        $sqlInsert = "INSERT INTO $this->tb_name(ten_the_loai,id_tai_khoan,ngay_them)
          VALUES ('$this->ten_the_loai',$this->id_tai_khoan,'$this->ngay_them')";

        $res = mysqli_query($this->getConn(),$sqlInsert);

        if(mysqli_errno($this->getConn()))
            return mysqli_error($this->getConn());

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

        $sqlUpdate = "Update $this->tb_name SET ten_the_loai = '$this->ten_the_loai',
                     id_tai_khoan='$this->id_tai_khoan', ngay_cap_nhap = '$this->ngay_cap_nhap'
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
}