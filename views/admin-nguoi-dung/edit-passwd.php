<meta charset="utf-8">
<?php
require_once 'model/Database.php';
require_once 'model/NhanVienModel.php';
$obModelTL = new NhanVienModel();
$con = new Database();
$mang_nv = array();
$mang_nv = $obModelTL->loadList();
$kt_id = array();
$setPassWD = '';
foreach ($mang_nv as $row) 
    $kt_id[] = $row->id;
$errMsg = array();
/*      echo '<pre>'.__FILE__.'::'.__FUNCTION__.'('.__LINE__.')<br>';
        print_r($TT_NV);
        echo '</pre>';*/
        // print_r($kt_id);
//print_r($mang_nv);
//kiểm tra id có hợp lệ hay không
//nếu không in lệnh die ở dưới cùng
if (in_array($_GET['id'],$kt_id)) {
    if (isset($_GET['id'])) {
    	$TT_NV = $obModelTL->loadOne($_GET['id']);
        $setPassWD = $TT_NV->PASSWORD;
    print_r($setPassWD);
    if (isset($_POST['submit'])) {
        $passwd_new = md5($_POST['passwd_new']);
        $passwd_confirm = md5($_POST['passwd_confirm']);
        $passwd_old = md5($_POST['passwd_old']);
        // Bước 2 : Kiểm tra tính hợp lệ của mật khẩu
        if ($passwd_old === $setPassWD) { // so sánh mật khẩu cũ và mới        
            if (empty($passwd_new) || empty($passwd_old) || empty($passwd_confirm))
                $errMsg[] = 'Nhập mật khẩu';
            if(!preg_match('/^[a-z0-9.!@#$%^&*()]{10,50}$/',$passwd_new))
            $errMsg[] = 'Mật khẩu phải có ít nhất 10 ký tự trong đó có chữ thường,chữ số, và ký tự đặc biệt';
            //kiểm tra mật khẩu đã đúng chưa nếu đúng thực hiện bước 3
            if ($passwd_new === $passwd_confirm) {
                // Bước 3: Gọi hàm xử lý lưu vào CSDL
                if(empty($errMsg)){
                    // đưa thông tin đồng thời mã hóa mật khẩu md5
                    $obModelTL->PASSWORD = $passwd_new;
                    // mảng errMsg rỗng ==> không có lỗi thì mới làm việc ghi db
                    $res = $obModelTL->passwdUpdate($_GET['id']); // nếu ghi thành công thì trả về kiểu số là ID
                    // nếu lỗi thì trả về không phải kiểu số mà là chuỗi thông báo lỗi.
                    if(is_numeric($res)){
                        echo "<script>alert('Cập nhập CSDL thành công!');</script>";
                    }else
                        echo "<script>alert('Lỗi: $res')"; // lúc này res là chuỗi
                }
            }else{
                echo "<script>alert('Hai mật khẩu mới không giống nhau');</script>";
            }
        }else{
            echo "<script>alert('Sai mật khẩu cũ');</script>";
        }
     }    
    if(count($errMsg)>0)
            foreach($errMsg as $msg )
                echo "<script>alert('$msg');</script>";
        }
}else{
    die('khong co tai khoan nao phu hop voi id nay');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sửa thông tin nhân viên</title>
</head>
<body>
    <h1 align="center"> Thay đổi Password </h1>
<?php
    
/*    [id] => 2
    [ho_ten] => Nguyễn Thị B
    [gioi_tinh] => 1
    [dia_chi] => Royal City
    [dien_thoai] => 962375614
    [email] => nguyenthib@gmail.com
    [ten_dang_nhap] => nguyenthib*/
?>
<form action="" method="post">
    <table align="center">
        <tr><td>Tên đăng nhập</td><td><input type="text" name="ten_dang_nhap" readonly value="<?php echo $TT_NV->ten_dang_nhap; ?>"></td><tr>
        <tr><td>Mật khẩu cũ</td><td><input type="password" name="passwd_old"></td></tr>
        <tr><td>Mật Khẩu mới</td><td><input type="password" name="passwd_new"></td></tr>
        <tr><td>Xác nhận mật khẩu</td><td><input type="password" name="passwd_confirm"></td></tr>
        <tr><td></td><td><input type="submit" name="submit" value="Update"></td></tr>
    </table>
</form>
</body>
</html>