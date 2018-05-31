
<?php
class SearchFilmModel extends MyModel
{
    public $id;
    public $ten_film;
    public $ten_dao_dien;
    public $tb_name="tb_film";
    public function searchList($params = null){
        $dataRes = array();
        $sql = "SELECT * FROM $this->tb_name ";

         // lệnh sql chưa có where
        $strWhere = '';
        if(isset($params['search_ten_film']) && strlen($params['search_ten_film'])>0){
            if($strWhere =='')
                $strWhere .= " WHERE $this->tb_name.ten_film LIKE '%{$params['search_ten_film']}%' ";
            else
                $strWhere .= " AND  $this->tb_name.ten_film LIKE '%{$params['search_ten_film']}%' ";
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
}
