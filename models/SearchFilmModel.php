<?php
class SearchFilmModel extends MyModel
{
    public $id;
    public $ten_film;
    public $ten_dao_dien;
    public $tb_name="tb_film";
    public function searchList($params = null,$start,$limit){
        $sql = "select * from tb_tap_film
INNER JOIN tb_film as tb3 ON tb_tap_film.id_film = tb3.id
WHERE tb_tap_film.id IN (select max(tb2.id) from tb_tap_film as tb2 GROUP BY tb2.id_film) 
";

        // lệnh sql chưa có where
        $strWhere = '';
        if(isset($params['search_ten_film']) && strlen($params['search_ten_film'])>0){
            if($strWhere =='')
                $strWhere .= " AND ten_film LIKE '%{$params['search_ten_film']}%' ";
            else
                $strWhere .= " AND  ten_film LIKE '%{$params['search_ten_film']}%' ";
        }
        $sql .= $strWhere;
        $strOrder = "ORDER BY tb_tap_film.id desc";
        $strLimit = " limit $start,$limit ";
        $sql .= $strOrder;
        $sql .= $strLimit;
        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while($row = mysqli_fetch_assoc($res)){
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }
    public function count($params = null){
        $sql = "SELECT COUNT(id) as tong FROM tb_film";

        $strWhere = '';
        if (isset($params['search_ten_film']) && strlen($params['search_ten_film']) > 0) {
            if ($strWhere == '')
                $strWhere .= " WHERE ten_film LIKE '%{$params['search_ten_film']}%' ";
            else
                $strWhere .= " AND  ten_film LIKE '%{$params['search_ten_film']}%' ";
        }

        $sql .= $strWhere;
        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $row = mysqli_fetch_assoc($res);

        $data = $row['tong'];
        mysqli_free_result($res);

        return $data;
    }
}

