<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 07/05/2018
 * Time: 11:03 CH
 */

class SlideModel extends MyModel
{
    public $id;
    public $ten_film;
    public $link;
    public $tb_name="tb_slide";
    public $tb_name_film="tb_film";

    public function getList($params = null){

        $sql = "SELECT $this->tb_name.*,$this->tb_name_film.ten_film FROM $this->tb_name,$this->tb_name_film WHERE $this->tb_name.id_film=$this->tb_name_film.id ORDER  BY $this->tb_name.id DESC ";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while($row = mysqli_fetch_assoc($res)){
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }
    public function SaveNew($params = null){

        $sqlInsert = "INSERT INTO $this->tb_name(id_film,link_slide)
          VALUES ('$this->ten_film','$this->link')";

        $res = mysqli_query($this->getConn(),$sqlInsert);

        if(mysqli_errno($this->getConn()))
            return mysqli_error($this->getConn());

        if($res)
            return mysqli_insert_id($this->getConn()); // trả về ID mới
        else
            return "Không insert được";
    }
    public function loadOne($id){
       
        $sql = "SELECT tb_slide.*,tb_film.ten_film FROM tb_slide,tb_film WHERE tb_film.id = tb_slide.id_film and tb_slide.id =$id";
        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while ($row = mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }
        mysqli_free_result($res);
        return $data;

    }

    public function SaveUpdate(){

        $sqlUpdate = "Update $this->tb_name SET id_film = '$this->ten_film',link_slide='$this->link'
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
    public function getFilm(){
        $sql = "SELECT * FROM tb_film";
        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while($row = mysqli_fetch_assoc($res)){
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }
}