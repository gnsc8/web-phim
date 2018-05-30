<?php
class TimKiemModel extends MyModel{
    public function getTongTheLoai($id){
        $sql = "SELECT COUNT(id_film) AS tong FROM tb_chi_tiet_the_loai WHERE id_the_loai = $id";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $row = mysqli_fetch_assoc($res);
            $data = $row['tong'];
        mysqli_free_result($res);

        return $data;
    }
    public function getTheLoai($start,$limit,$id){

            $sql = "select * from tb_tap_film
INNER JOIN tb_film as tb3 ON tb_tap_film.id_film = tb3.id
WHERE tb_tap_film.id IN (select max(tb2.id) from tb_tap_film as tb2 GROUP BY tb2.id_film) 
AND tb_tap_film.id_film IN (select DISTINCT id_film from tb_chi_tiet_the_loai as tb3  WHERE id_the_loai = $id)  
ORDER BY tb_tap_film.id desc
limit $start,$limit";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while($row = mysqli_fetch_assoc($res)){
            $data[] = $row;
        }

        mysqli_free_result($res);

        return $data;
    }
    public function getTenTheLoai($id){
        $sql = "SELECT ten_the_loai FROM tb_the_loai WHERE id=$id";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $row = mysqli_fetch_assoc($res);
            $data = $row['ten_the_loai'];
        mysqli_free_result($res);

        return $data;
    }
    public function getTongQuocGia($id){
        $sql = "SELECT COUNT(id_quoc_gia) as tong FROM tb_film WHERE id_quoc_gia = $id";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $row = mysqli_fetch_assoc($res);
        $data = $row['tong'];
        mysqli_free_result($res);

        return $data;
    }
    public function getQuocGia($start,$limit,$id){

        $sql = "select * from tb_tap_film
INNER JOIN tb_film as tb3 ON tb_tap_film.id_film = tb3.id
WHERE tb_tap_film.id IN (select max(tb2.id) from tb_tap_film as tb2 GROUP BY tb2.id_film) 
AND tb3.id_quoc_gia = $id
ORDER BY tb_tap_film.id desc
limit $start,$limit";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while($row = mysqli_fetch_assoc($res)){
            $data[] = $row;
        }

        mysqli_free_result($res);

        return $data;
    }
    public function getTenQuocGia($id){
        $sql = "SELECT ten_quoc_gia FROM tb_quoc_gia WHERE id=$id";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $row = mysqli_fetch_assoc($res);
        $data = $row['ten_quoc_gia'];
        mysqli_free_result($res);

        return $data;
    }
    public function getTongMyFilm($id_user){
        $sql = "SELECT COUNT(id_film) as tong FROM tb_ua_thich WHERE id_nguoi_dung = $id_user";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $row = mysqli_fetch_assoc($res);
        $data = $row['tong'];
        mysqli_free_result($res);

        return $data;
    }
    public function getListMyFilm($id_user,$limit,$start){

        $sql = "select * from tb_tap_film
INNER JOIN tb_film as tb3 ON tb_tap_film.id_film = tb3.id
WHERE tb_tap_film.id IN (select max(tb2.id) from tb_tap_film as tb2 GROUP BY tb2.id_film)
AND tb_tap_film.id_film IN (select DISTINCT id_film from tb_ua_thich as tb3  WHERE id_nguoi_dung = $id_user)
ORDER BY tb_tap_film.id desc
limit $start,$limit";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();
        while($row = mysqli_fetch_assoc($res)){
         $data[]=$row;
        }
        mysqli_free_result($res);

        return $data;
    }
    public function checkFilm($id_user,$id_film){
        $sql = "SELECT * FROM tb_ua_thich WHERE id_nguoi_dung=$id_user AND id_film =$id_film";

        $resCheck = mysqli_query($this->getConn(), $sql);
        if(mysqli_errno($this->getConn()))
            return mysqli_error($this->getConn());

        if(mysqli_num_rows($resCheck)==1){
            return "Phim đã có trong danh sách ưa thích của bạn!";
        }else{
            $sqlInsert = "INSERT INTO tb_ua_thich(id_nguoi_dung,id_film) VALUES ($id_user,$id_film)";

            $res = mysqli_query($this->getConn(), $sqlInsert);

            if (mysqli_errno($this->getConn()))
                return mysqli_error($this->getConn());

            return "Phim đã được thêm vào danh sách ưa thích của bạn";
        }
    }
    public function getTongPhimBo(){
        $sql = "SELECT COUNT(id_film) as tong FROM tb_chi_tiet_danh_muc WHERE id_danh_muc = 1";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $row = mysqli_fetch_assoc($res);
        $data = $row['tong'];
        mysqli_free_result($res);

        return $data;
    }
    public function getListPhimBo( $limit,$start){

        $sql = "select * from tb_tap_film
INNER JOIN tb_film as tb3 ON tb_tap_film.id_film = tb3.id
WHERE tb_tap_film.id IN (select max(tb2.id) from tb_tap_film as tb2 GROUP BY tb2.id_film)
AND tb_tap_film.id_film IN (select DISTINCT id_film from tb_chi_tiet_danh_muc as tb3  WHERE id_danh_muc = 1)
ORDER BY tb_tap_film.id desc
limit $start,$limit";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();
        while($row = mysqli_fetch_assoc($res)){
            $data[]=$row;
        }
        mysqli_free_result($res);

        return $data;
    }
    public function getTongPhimLe(){
        $sql = "SELECT COUNT(id_film) as tong FROM tb_chi_tiet_danh_muc WHERE id_danh_muc = 2";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $row = mysqli_fetch_assoc($res);
        $data = $row['tong'];
        mysqli_free_result($res);

        return $data;
    }
    public function getListPhimLe( $limit,$start){

        $sql = "select * from tb_tap_film
INNER JOIN tb_film as tb3 ON tb_tap_film.id_film = tb3.id
WHERE tb_tap_film.id IN (select max(tb2.id) from tb_tap_film as tb2 GROUP BY tb2.id_film)
AND tb_tap_film.id_film IN (select DISTINCT id_film from tb_chi_tiet_danh_muc as tb3  WHERE id_danh_muc = 2)
ORDER BY tb_tap_film.id desc
limit $start,$limit";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();
        while($row = mysqli_fetch_assoc($res)){
            $data[]=$row;
        }
        mysqli_free_result($res);

        return $data;
    }
    public function getTongPhimAnime(){
        $sql = "SELECT COUNT(id_film) as tong FROM tb_chi_tiet_danh_muc WHERE id_danh_muc = 4";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $row = mysqli_fetch_assoc($res);
        $data = $row['tong'];
        mysqli_free_result($res);

        return $data;
    }
    public function getListPhimAnime( $limit,$start){

        $sql = "select * from tb_tap_film
INNER JOIN tb_film as tb3 ON tb_tap_film.id_film = tb3.id
WHERE tb_tap_film.id IN (select max(tb2.id) from tb_tap_film as tb2 GROUP BY tb2.id_film)
AND tb_tap_film.id_film IN (select DISTINCT id_film from tb_chi_tiet_danh_muc as tb3  WHERE id_danh_muc = 4)
ORDER BY tb_tap_film.id desc
limit $start,$limit";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();
        while($row = mysqli_fetch_assoc($res)){
            $data[]=$row;
        }
        mysqli_free_result($res);

        return $data;
    }
}