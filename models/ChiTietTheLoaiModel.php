<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 07/05/2018
 * Time: 11:03 CH
 */

class ChiTietTheLoaiModel extends MyModel
{
    public $id;
    public $ten_film;
    public $ten_the_loai;
    public $tb_name="tb_chi_tiet_the_loai";
    public $tb_name_film="tb_film";
    public $tb_name_the_loai="tb_the_loai";

    public function getList($params = null){

        $sql = "SELECT $this->tb_name.*,$this->tb_name_film.ten_film,$this->tb_name_the_loai.ten_the_loai FROM $this->tb_name inner join $this->tb_name_film on $this->tb_name.id_film=$this->tb_name_film.id inner join $this->tb_name_the_loai on $this->tb_name.id_the_loai=$this->tb_name_the_loai.id ORDER  BY $this->tb_name.id DESC ";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while($row = mysqli_fetch_assoc($res)){
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }
    public function SaveNew($params = null){

        $sqlInsert = "INSERT INTO $this->tb_name(id_film,id_the_loai)
          VALUES ('$this->ten_film','$this->ten_the_loai')";

        $res = mysqli_query($this->getConn(),$sqlInsert);

        if(mysqli_errno($this->getConn()))
            return mysqli_error($this->getConn());

        if($res)
            return mysqli_insert_id($this->getConn()); // trả về ID mới
        else
            return "Không insert được";
    }
    public function loadOne($id){
        $sql = "SELECT tb_chi_tiet_the_loai.*,tb_film.ten_film,tb_the_loai.ten_the_loai 
                FROM tb_chi_tiet_the_loai 
                inner join tb_film on tb_chi_tiet_the_loai.id_film=tb_film.id 
                inner join tb_the_loai on tb_chi_tiet_the_loai.id_the_loai=tb_the_loai.id 
                WHERE tb_chi_tiet_the_loai.id = $id
                ORDER  BY tb_chi_tiet_the_loai.id DESC";
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

    public function SaveUpdate($id,$id_film,$id_tl){

        $sqlUpdate = "Update $this->tb_name SET id_film='$id_film',id_the_loai='$id_tl'
                    WHERE $this->tb_name.id = $id
                    ";


        $res = mysqli_query($this->getConn(),$sqlUpdate);

        if(mysqli_errno($this->getConn()))
            return mysqli_error($this->getConn());

        if($res)
            return mysqli_insert_id($this->getConn()); // trả về ID mới
        else
            return "Không cập nhật  được";

    }
    public function getTheLoai(){
        $sql = "SELECT * FROM tb_the_loai";
        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while($row = mysqli_fetch_assoc($res)){
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }
    public function getFilm(){
        $sql = "SELECT id,ten_film FROM tb_film";
        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while($row = mysqli_fetch_assoc($res)){
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }
}