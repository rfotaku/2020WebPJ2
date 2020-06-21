<?php
session_start();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>首页</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/real_index.css">
</head>
<body>

<header>
    <nav>
        <ul id="navList">
            <li><a href="real_index.html" class="navItem" id="this">首    页</a></li>
            <li><a href="browser.html" class="navItem">浏览图片</a></li>
            <li><a href="search.html" class="navItem">搜索图片</a></li>
            <li class="usrItem">
                <a href="#" class="usrItem">个人中心</a>
                <ul id="usrMenu">
                    <li class="menuItem">
                        <a class="menuItem" href="upload.html">
                            <div><img src="../background/add.png" class="icon" /><span class="opt">上    传</span></div>
                        </a>
                    </li>
                    <li class="menuItem">
                        <a class="menuItem" href="my_photos.html">
                            <div><img src="../background/photo.png" class="icon"/><span class="opt">我的图片</span></div>
                        </a>
                    </li>
                    <li class="menuItem">
                        <a class="menuItem" href="collections.html">
                            <div><img src="../background/collection.png" class="icon"/><span class="opt">我的收藏</span></div>
                        </a>
                    </li>
                    <li class="menuItem">
                        <a href="../index.html" class="menuItem">
                            <div><img src="../background/login.png" class="icon"/><span class="opt">登    出</span></div>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</header>
<div id="background">
    <a href="Detail.html"><img src="../background/study.png" id="head_img"/></a>
    <div id="sup">
        <div id="top">
            <a href="#navList" class="top">回到顶部</a>
        </div>
        <button id="refresh" onclick="alert('图片已刷新')">
            刷新图片
        </button>
    </div>
    <div id="main">
        <?php

        $user = 'root';
        $password = 'root';
        $db = 'Pj2';
        $host = 'localhost';
        $port = 3306;
        $serve='localhost:3306';



        $con = new Mysqli($serve,$user,$password,$db);
        $con->query("SET NAMES utf8");

        if($_GET["fresh"]==true){
            $sql="select * from travelimage order by Rand() limit 0,8";
            //unset($_SESSION['fresh']);
        }else {
            $sql = "select * from travelimage order by FavoredNum desc limit 0,8"; //如果收藏数>0的小于8个之后按照imageid递减
        }


        $result=$con->query($sql);


        if(mysqli_num_rows($result)>0) {
            while ($row = $result->fetch_row()) {
                echo "<div class='cell'>";
                echo '<a href="html/detail.php?path=';
                echo $row[9];

                echo '">';
                echo '<img class="pic" src="../travel-images/normal/small/';
                echo $row[9];
                echo '"/></a>';
                echo '<div class="msg">';
                echo '<p class="pic_title">';
                echo $row[1];
                echo '</p>';
                echo '<p class="pic_detail">';
                echo $row[2];
                echo '</p></div>';
                echo '</div>';

            }
        }


        ?>
    </div>
    <footer><p class="foot">制作者：邓泽 学号：18307130177</p></footer>
</div>


<section >



    <!-- 热门图片展示 -->


</section>

</body>











<footer>

    <div>

        <div>

            <p>LEARN MORE</p>

            <p>How it works?</p>

            <p>Meeting tools</p>

            <p>Live streaming</p>

            <p>Contact Method</p>

        </div>

        <div>

            <p>ABOUT US</p>

            <P>About us</P>

            <p>Features</p>

            <p>Privacy police</p>

            <p>Terms & Conditions</p>

        </div>

        <div>

            <p>SUPPORT</p>

            <p>FAQ</p>

            <p>Contact us</p>

            <p>Live chat</p>

            <p>Phone call</p>

        </div>

        <div>

            <p>ENJOY YOUR LIFE</p>

            <p>Copyright &copy 2010-2021 Yiling Zhao. </p>
            <p>All rights reserved.</p>
            <p> 备案号：18300290055</p>

        </div>

        <div>
            <p>

                <!-- wechat -->
                <img id="icon" src="img/二维码.jpg" />

            </p>

        </div>



    </div>


</footer>



</body>


</html>