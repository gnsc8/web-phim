<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 07/05/2018
 * Time: 11:03 CH
 */

class DienVienModel extends MyModel
{
    public $id;
    public $ten_dien_vien;
    public $gioi_thieu;
    public $tb_name="tb_dien_vien";
    public function getList($params = null){
        $dataRes = array();
        $sql = "SELECT * FROM $this->tb_name ";

         // lệnh sql chưa có where
        $strWhere = '';
        if(isset($params['search_hoten']) && strlen($params['search_hoten'])>0){
            if($strWhere =='')
                $strWhere .= " WHERE $this->tb_name.ten_dien_vien LIKE '%{$params['search_hoten']}%' ";
            else
                $strWhere .= " AND  $this->tb_name.ten_dien_vien LIKE '%{$params['search_hoten']}%' ";
        }
        $sql .= $strWhere;

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while($row = mysqli_fetch_assoc($res)){
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }
    public function SaveNew($params = null){

        $sqlInsert = "INSERT INTO $this->tb_name(ten_dien_vien,gioi_thieu)
          VALUES ('$this->ten_dien_vien','$this->gioi_thieu')";

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

        $sqlUpdate = "Update $this->tb_name SET ten_dien_vien = '$this->ten_dien_vien',gioi_thieu='$this->gioi_thieu'
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