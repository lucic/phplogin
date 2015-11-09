<?php
//插入连接数据库的相干信息
require_once "webconfig.php";
//开启一个会话
session_start();
$error_msg = "";
//若是用户未登录，即未设置$_SESSION[""user_id""]时，履行以下代码
if(!isset($_SESSION["user_id"])){
    if(isset($_POST["submit"])){//用户提交登录表单时履行如下代码
        $dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $user_username = mysqli_real_escape_string($dbc,trim($_POST["username"]));
        $user_password = mysqli_real_escape_string($dbc,trim($_POST["password"]));
        if(!empty($user_username)&&!empty($user_password)){
            $query = "SELECT user_id,username FROM php_user WHERE `username`='".$user_username."' AND password='".$user_password."'";
   //         $query = "SELECT user_id,username FROM php_user WHERE username = 'root'";
            $data = mysqli_query($dbc,$query) or die (mysqli_error());
            //用用户名和暗码进行查询，若查到的记录正好为一条，则设置SESSION和COOKIE，同时进行页面重定向
            if(mysqli_num_rows($data)==1){
                $row = mysqli_fetch_array($data);
                $_SESSION["user_id"]=$row["user_id"];
                $_SESSION["username"]=$row["username"];
                setcookie("user_id",$row["user_id"],time()+(60*60*24*30));
                setcookie("username",$row["username"],time()+(60*60*24*30));
                $home_url = "userinfo.php";
                header("Location:".$home_url);
            }else{//若查到的记录不合错误，则设置错误信息
                $error_msg = "Sorry,you must enter a valid username and password to log in.";
            }
        }else{
            $error_msg = "Sorry， you must enter a valid username and password to log in.";
        }
    }
}else{//若是用户已经登录，则直接跳转到已经登录页面
    $home_url = "userinfo.php";
    header("Location:".$home_url);
}
?>
<html>
<body>
<h3>user - Log In</h3>
<!--经由过程$_SESSION[""user_id""]进行断定，若是用户未登录，则显示登录表单，让用户输入用户名和暗码-->
<?php
if(!isset($_SESSION["user_id"])){
    echo "<p class=\"error\">".$error_msg."</p>";
        ?>
    <!-- $_SERVER[""PHP_SELF""]代表用户提交表单时，调用自身php文件 -->
    <form method = "post" action="<?php echo $_SERVER["PHP_SELF"];?>">
        <fieldset>
            <legend>Log In</legend>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username"
                   value="<?php if(!empty($user_username)) echo $user_username; ?>" />
            <br/>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password"/>
        </fieldset>
        <input type="submit" value="Log In" name="submit"/>
    </form>
    <?php
}
?>
</body>
</html>