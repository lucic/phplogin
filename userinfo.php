<?php
//应用会话内存储的变量值之前必须先开启会话
session_start();
//若是会话没有被设置，查看是否设置了cookie
if(!isset($_SESSION["user_id"])){
    if(isset($_COOKIE["user_id"])&&isset($_COOKIE["username"])){
        //用cookie给session赋值
        $_SESSION["user_id"]=$_COOKIE["user_id"];
        $_SESSION["username"]=$_COOKIE["username"];
    }
}
//应用一个会话变量搜检登录状况
if(isset($_SESSION["username"])){
    echo "You are Logged as ".$_SESSION["username"]."<br/>";
    echo "<a href=\"logout.php\"> Log Out(".$_SESSION["username"].")</a>";
}
/**在已登录页面中，可以哄骗用户的session如$_SESSION[""username""]、
 * $_SESSION[""user_id""]对数据库进行查询，可以做很多多少很多多少工作*/
?>