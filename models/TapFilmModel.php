<?php
class TapFilmModel extends MyModel{
    public $id ;
    public $ten_film;
    public $ten_tap;
    public $link_fb;
    public $link_gd;
    public $link_op;
    protected $tb_name = 'tb_tap_film';
    protected $tb_name_film ='tb_film';

    public function SaveNew($id){

        $sqlInsert = "INSERT INTO $this->tb_name(id_film,ten_tap,link_fb,link_gd,link_op)
          VALUES ('$this->ten_film','$this->ten_tap','$this->link_fb','$this->link_gd','$this->link_op')";

        $res = mysqli_query($this->getConn(),$sqlInsert);

        if(mysqli_errno($this->getConn()))
            return mysqli_error($this->getConn());

        if($res)
            return mysqli_insert_id($this->getConn()); // trả về ID mới
        else
            return "Không insert được";
    }

    public function loadOne($id){
        $sql = "SELECT tb_tap_film.*,tb_film.ten_film FROM tb_tap_film,tb_film WHERE tb_tap_film.id_film = tb_film.id AND tb_film.id= $id";
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

        $sqlUpdate = "Update $this->tb_name SET ten_tap = '$this->ten_tap',link_fb='$this->link_fb',link_gd='$this->link_gd',link_op='$this->link_op' WHERE id = $this->id";


        $res = mysqli_query($this->getConn(),$sqlUpdate);

        if(mysqli_errno($this->getConn()))
            return mysqli_error($this->getConn());

        if($res)
            return mysqli_insert_id($this->getConn()); // trả về ID mới
        else
            return "Không cập nhật  được";

    }
    public function getFilm(){
        $sql = "SELECT * FROM $this->tb_name_film";
        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while($row = mysqli_fetch_assoc($res)){
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }
    public function countTapFilm(){
        $sql = "SELECT COUNT(id) as tong FROM tb_tap_film";
        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $row = mysqli_fetch_assoc($res);
            $data = $row['tong'];

        mysqli_free_result($res);

        return $data;
    }
    public function getlist($start,$limit){

        $sql = "SELECT $this->tb_name.id,$this->tb_name_film.ten_film,$this->tb_name.ten_tap,$this->tb_name.link_fb,$this->tb_name.link_gd,$this->tb_name.link_op 
FROM $this->tb_name,$this->tb_name_film 
WHERE $this->tb_name.id_film = $this->tb_name_film.id 
ORDER BY $this->tb_name.id DESC 
LIMIT $start,$limit";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while($row = mysqli_fetch_assoc($res)){
            $data[] = $row;
        }

        mysqli_free_result($res);

        return $data;
    }
}