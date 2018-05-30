<?php
class VideoModel extends MyModel{
    public function loadOne($id,$tap)
    {

        $sql = "SELECT tb_tap_film.*,ten_film,ten_film_english FROM tb_tap_film,tb_film WHERE tb_tap_film.id_film = tb_film.id and id_film = $id AND ten_tap = '$tap' ";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while($row = mysqli_fetch_assoc($res)){
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }
    public function getList($id){
        $sql = "SELECT id_film,ten_tap,ten_film,ten_film_english FROM tb_tap_film,tb_film WHERE tb_tap_film.id_film = tb_film.id and id_film= $id";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while($row = mysqli_fetch_assoc($res)){
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }
}