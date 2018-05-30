<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 07/05/2018
 * Time: 10:25 CH
 */

class BannerQcModel extends MyModel
{   
    public $id;
    public $banner;
    public $link;
    public $id_tai_khoan=1;
    public $ngay_them;
    public $ngay_cap_nhat;
    public $tb_name='tb_banner_qc';
    public $tb_name_user='tb_user';
    public function getList($params = null){

        $sql = "SELECT $this->tb_name.*,$this->tb_name_user.username FROM $this->tb_name,$this->tb_name_user Where $this->tb_name.id_tai_khoan=$this->tb_name_user.id ORDER  BY id DESC ";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while($row = mysqli_fetch_assoc($res)){
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }
    public function SaveNew($params = null){

        $sqlInsert = "INSERT INTO $this->tb_name(banner,link_qc,id_tai_khoan,ngay_them)
          VALUES ('$this->banner','$this->link',$this->id_tai_khoan,'$this->ngay_them')";

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

    public function SaveUpdate($id){

        $sqlUpdate ="UPDATE $this->tb_name 
        SET banner='$this->banner',link_qc='$this->link',id_tai_khoan='$this->id_tai_khoan',ngay_cap_nhat='$this->ngay_cap_nhat' 
        WHERE id=$id";


        $res = mysqli_query($this->getConn(),$sqlUpdate);

        if(mysqli_errno($this->getConn()))
            return mysqli_error($this->getConn());

        if($res)
            return mysqli_insert_id($this->getConn()); // trả về ID mới
        else
            return "Không cập nhật  được";

    }
}