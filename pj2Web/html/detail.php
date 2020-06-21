<?php
session_start();
//echo $_SESSION['username']; ;
?>
    <!DOCTYPE html>
    <html lang="zh">
    <head>
        <meta charset="UTF-8">
        <title>图片详情</title>
        <link rel="stylesheet" type="text/css" href="../css/reset.css"/>
        <link rel="stylesheet" type="text/css" href="../css/Detail.css"/>
    </head>
    <?php


    $user = 'root';
    $password = '123456';
    $db = 'Pj2';
    $host = 'localhost';
    $port = 3306;
    $serve = 'localhost:3306';

    $username=$_SESSION['username'];
    $con = new Mysqli($serve, $user, $password, $db);
    $con->query("SET NAMES utf8");

    $path = $_GET['path'];
    $sql="select * from travelimage where path='$path'";
    $result=$con->query($sql);
    $pic=$result->fetch_row();


    ?>
    <?php

    $sql="select traveluser.username,travelimage.uid,travelimage.imageid from travelimage inner join traveluser on traveluser.uid=travelimage.uid where path='$path'";
    $result=$con->query($sql);
    $row=$result->fetch_row();
    $user=$row[0];
    $imageid=$row[2];
    ?>
    <?php
    $sql="select * from travelimagefavor where imageid='$row[2]'";
    $result=$con->query($sql);
    $count = mysqli_num_rows($result);
    ?>
    <?php

    $sql="select geocountries.CountryName,travelimage.CountryCodeISO,travelimage.CityCode,travelimage.PATH from travelimage inner join geocountries on travelimage.`CountryCodeISO`=geocountries.ISO where path='$path'";
    $result=$con->query($sql);
    $row=$result->fetch_row();
    $country=$row[0];
    $citycode=$row[2];

    $sql="SELECT * FROM geocities WHERE `GeoNameID`='$citycode'";
    $result=$con->query($sql);
    $row=$result->fetch_row();
    $city=$row[1];

    ?>



    <body>

    <header>
        <nav>
            <ul id="navList">
                <li><a href="real_index.html" class="navItem">首    页</a></li>
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
                                <div><img src="../background/login.png" class="icon"/><span class="opt">登    入</span></div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
    <div id="background">
        <div class="blank"></div>
        <div id="main">
            <h1>图片详情</h1>
            <img  src="../upfile/<?php echo $path; ?>"/>
            <div id="info">
                <p>
                    标题：<?php echo $pic[1]; ?><br/>
                    拍摄者： <?php echo $user; ?><br/>
                <div id="msg">描述：<?php echo $pic[2]; ?>></div>
                主题：人物<br/>
                拍摄国家：<?php echo $country;?><br/>
                拍摄城市：<?php echo $city;?><br/>
                </p>
            </div>
        </div>
        <div class="blank"></div>
    </div>
    <footer><p class="foot">制作者：邓泽 学号：18307130177</p></footer>
    </body>
</html>




    </body>
    <script defer>

        let notlike= document.getElementById('like');
        <?php


        $sql="select * from traveluser where username='$username'";
        $result=$con->query($sql);
        $row=$result->fetch_row();
        $uid=$row[0];

        $sql="select * from travelimagefavor where imageid='$imageid' and uid='$uid'";
        $result=$con->query($sql);
        $valid='false';


        if(mysqli_num_rows($result)>0)
            $valid='true';
        else
            $valid='false';



        ?>

        if(<?php echo $valid; ?>){
            notlike.style.color="red";
            notlike.setAttribute('href','../php/detailCancelFavored.php?path='+'<?php echo $path; ?>');
            notlike.onclick = function () {
                //alert('若已登陆马上取消收藏，若未登录跳转到登录界面，请登录后操作...');
            }
        }
        else{
            notlike.style.color="white";
            notlike.setAttribute('href','../php/setFavored.php?path='+'<?php echo $path; ?>');
            notlike.onclick = function () {
                //alert('若已登陆马上收藏，若未登录跳转到登录界面，请登录后操作...');
            }
        }

    </script>

<?php
mysqli_free_result($result);
mysqli_close($con);//关闭mysql链接答
?>