<?php
class MyModel{
    private $conn = null;
    public function getConn()
    {
        global $config;
        if($this->conn == null){
            // chưa mở kết nối CSDL
            // thực hiện tạo kết nối CSDL

            $this->conn = mysqli_connect( $config['db']['host'],$config['db']['user'],$config['db']['passwd'])
                or die("Loi ket noi CSDL: " . mysqli_connect_error());

            mysqli_select_db($this->conn, $config['db']['dbname']);
            mysqli_set_charset($this->conn,'utf8');
        }


        // trả về biến kết nối
        return $this->conn;
    }

    // sau này tiếp tục cải tiến để hoàn thiện cho các trường hợp khác.
    public function ExecQuery($sqlStr){
        $res = mysqli_query($this->getConn(), $sqlStr);
        if(mysqli_errno($this->getConn()))
            die('Error query '. mysqli_error($this->getConn()));

        return $res;
    }

    public function __destruct()
    {
        if($this->conn != null)
            mysqli_close($this->conn);
    }

}