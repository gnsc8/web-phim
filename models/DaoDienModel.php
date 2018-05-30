<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 07/05/2018
 * Time: 11:03 CH
 */

class DaoDienModel extends MyModel
{
    public $id;
    public $ten_dao_dien;
    public $gioi_thieu;
    public $tb_name="tb_dao_dien";
    public function getList($params = null,$start,$limit){

        $sql = "SELECT * FROM $this->tb_name ";

        // lệnh sql chưa có where
        $strWhere = '';
        if(isset($params['search_hoten']) && strlen($params['search_hoten'])>0){
            if($strWhere =='')
                $strWhere .= " WHERE $this->tb_name.ten_dao_dien LIKE '%{$params['search_hoten']}%' ";
            else
                $strWhere .= " AND  $this->tb_name.ten_dao_dien LIKE '%{$params['search_hoten']}%' ";
        }
        $strLimit = " LIMIT $start, $limit";
        $sql .= $strWhere;
        $sql .= $strLimit;
        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while($row = mysqli_fetch_assoc($res)){
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }
    public function SaveNew($params = null){

        $sqlInsert = "INSERT INTO $this->tb_name(ten_dao_dien,gioi_thieu)
          VALUES ('$this->ten_dao_dien','$this->gioi_thieu')";

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

        $sqlUpdate = "Update $this->tb_name SET ten_dao_dien = '$this->ten_dao_dien',gioi_thieu='$this->gioi_thieu'
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
    public function count($params = null){
        $sql = "SELECT COUNT(id) as tong FROM tb_dao_dien";

        $strWhere = '';
        if (isset($params['search_hoten']) && strlen($params['search_hoten']) > 0) {
            if ($strWhere == '')
                $strWhere .= " WHERE ten_dao_dien LIKE '%{$params['search_hoten']}%' ";
            else
                $strWhere .= " AND  ten_dao_dien LIKE '%{$params['search_hoten']}%' ";
        }

        $sql .= $strWhere;
        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $row = mysqli_fetch_assoc($res);

        $data = $row['tong'];
        mysqli_free_result($res);

        return $data;
    }
}