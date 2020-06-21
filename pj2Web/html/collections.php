<?php
session_start();
//echo $_SESSION['username'];
if(isset($_SESSION['username'])){
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>我的收藏</title>
        <link rel="stylesheet" type="text/css" href="../css/reset.css"/>
        <link rel="stylesheet" type="text/css" href="../css/collection.css"/>
    </head>
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
                            <a class="menuItem" href="my_photos.html" >
                                <div><img src="../background/photo.png" class="icon"/><span class="opt">我的图片</span></div>
                            </a>
                        </li>
                        <li class="menuItem">
                            <a class="menuItem" href="collections.html" id="this">
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
            <h1>我的收藏</h1>
            <?php


            $username=$_SESSION['username'];
            $user = 'root';
            $password = 'root';
            $db = 'Pj2';
            $host = 'localhost';
            $port = 3306;
            $serve='localhost:3306';



            $con = new Mysqli($serve,$user,$password,$db);
            $con->query("SET NAMES utf8");

            $sql="select * from traveluser where username='$username'";
            $result=$con->query($sql);
            $row=$result->fetch_row();
            $uid=$row[0];

            $sql="select * from travelimagefavor where uid='$uid'";
            $result=$con->query($sql);
            //
            //    if(!mysqli_num_rows($result)){
            //
            //        $sql="select * from travelimagefavor where username='$username'";
            //        $result=$con->query($sql);
            //    }

            $page =empty($_GET['page']) ? 1:$_GET['page'];
            $pageRes = mysqli_fetch_assoc($result);
            $count = mysqli_num_rows($result);
            //每页显示数 每页显示五条
            $num = 5;
            //根据每页显示数可以求出来总页数
            $pageCount = ceil($count/$num);  //ceil取整
            if($pageCount>5)
                $pageCount=5;
            //根据总页数求出偏移量
            $offset = ($page-1)*$num; //起始位置
            $sql="select * from travelimagefavor where uid='$uid' limit $offset,$num";
            $res=$con->query($sql);
            //    if(!mysqli_num_rows($res)){
            //
            //        $sql="select * from travelimagefavor where username='$username' limit $offset,$num";
            //        $res=$con->query($sql);
            //    }

            if(mysqli_num_rows($res)>0)
            {

                while($rowfavor=$res->fetch_row()){
                    //while ($row=mysqli_fetch_assoc($res)){

                    $sql="select * from travelimage where imageid=$rowfavor[3]";
                    $result=$con->query($sql);


                    $row=$result->fetch_row();

                    echo '<div class="favoreach">
';
                    echo '<a href="./detail.php?path=';
                    echo $row[9];

                    echo '">';
                    echo '<img class="favorpics" src="../upfile/';
                    echo $row[9];
                    echo   '">';
                    echo '</a>';


                    echo '<article class="pic_word">';
                    echo '<h2>';
                    echo $row[1];
                    echo '</h2>';

                    echo '<p class="picword">';
                    echo $row[2];
                    echo '</p>';
                    echo '</article>';
                    echo '<div class="con_word">
                    <div class="size2">DON\'T LIKE <a class="like" ';
                    echo 'name="';
                    echo $row[9];
                    echo '" href="../php/myfavorCancelFavored.php?path=';
                    echo $row[9];
                    echo '&username=';
                    echo $username;
                    echo '" onclick="alert(\'取消收藏\')">';
                    echo '<i class="fa fa-heart" aria-hidden="true"></i></a></div>
                    </div></div>';
                }

                echo '<div id="page"> <a href="./myfavor.php?page=';
                echo ($page-1)>0 ? $page-1:1;
                echo '" >&lt&lt&nbsp</a>';
                $i=1;
                for(;$i<=$pageCount;$i=$i+1){
                    if($i==$page){
                        echo '<a style="font-size:40px;color:#00CCCC;"';
                    }
                    else{
                        echo '<a ';
                    }
                    echo 'href="./myfavor.php?page=';
                    echo $i;
                    echo '" > &nbsp'.$i.' &nbsp</a> ';
                }
                echo '<a href="./myfavor.php?page=';
                echo ($page+1)<=$pageCount ? $page+1:$pageCount;
                echo '" > >> </a></div>';



            }
            else{
                echo "<div id=\"pic_line\">You haven't favored any pictures!
                <br>
                Please create sth!!</div>";
            }


            mysqli_free_result($result);
            mysqli_close($con);


            ?>
        </div>
        <div class="blank"></div>
    </div>
    <footer><p class="foot">制作者：邓泽 学号：18307130177</p></footer>
    </body>
    </html>

<?php }else{
    echo 'Please log in first!';
    echo "<script>window.location.href='login.html'</script>";
}?>