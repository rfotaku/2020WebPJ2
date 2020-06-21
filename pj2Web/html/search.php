<?php
session_start();
//echo $_SESSION['username']; ;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>搜索图片</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css"/>
    <link rel="stylesheet" type="text/css" href="../css/search.css"/>
</head>




<body>

<header>
    <nav>
        <ul id="navList">
            <li><a href="real_index.html" class="navItem">首    页</a></li>
            <li><a href="browser.html" class="navItem">浏览图片</a></li>
            <li><a href="search.html" class="navItem" id="this">搜索图片</a></li>
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
        <div id="searchBox">
            <h1>搜索图片</h1>
            <div id="choice">
                <form action="#" method="GET" name="to_search">
                    <input name="choice" value="Filter_by_Title" type="radio" checked/>按标题搜索
                    <br>
                    <input id="frame1" name="filter_title" type="search" />
                    <br>
                    <br>
                    <input name="choice" value="Filter_by_Description" type="radio" />按描述搜索
                    <textarea id="frame2" name="filter_description" cols="6"></textarea>
                    <br>
                    <input id="fil" name="filter" type="submit" value="Filter" onclick="alert('已筛选')">
                </form>
            </div>
        </div>
        <div id="result">
            <?php
            if($_SERVER["REQUEST_METHOD"] != "GET"||($_GET['filter_description']==null&&$_GET['filter_title']==null)){
                echo "<h2>Please input something to search!</h2>";
            }
            else {

                $description = $_GET['filter_description'];
                $title = $_GET['filter_title'];
                $choice = $_GET['choice'];

                if ($choice == "Filter_by_Title") {
                    $which = 0;
                } else if ($choice == "Filter_by_Description") {
                    $which = 1;
                }

//       if($_GET['which']=0){
//           $which=0;
//       }
//       else if($_GET['which']=0){
//           $which=1;
//       }

                $user = 'root';
                $password = 'root';
                $db = 'Pj2';
                $host = 'localhost';
                $port = 3306;
                $serve = 'localhost:3306';
                $con = new Mysqli($serve, $user, $password, $db);
                $con->query("SET NAMES utf8");//解决中文乱码问题

                if ($which == 0) {
                    $sql = "select * from travelimage where title like '%$title%'";
                    $result = $con->query($sql);
                } else if ($which == 1) {
                    $sql = "select * from travelimage where description like '%$description%'";
                    $result = $con->query($sql);
                }


                $page = empty($_GET['page']) ? 1 : $_GET['page'];
                $pageRes = mysqli_fetch_assoc($result);
                $count = mysqli_num_rows($result);
                //每页显示数 每页显示五条
                $num = 5;
                //根据每页显示数可以求出来总页数
                $pageCount = ceil($count / $num);  //ceil取整
                if($pageCount>5)
                    $pageCount=5;
                //根据总页数求出偏移量
                $offset = ($page - 1) * $num; //起始位置

                if ($which == 0) {
                    $sql = "select * from travelimage where title like '%$title%' limit $offset,$num";
                    $result = $con->query($sql);

                } else if ($which == 1) {
                    $sql = "select * from travelimage where description like '%$description%' limit $offset,$num";
                    $result = $con->query($sql);
                }

                if (mysqli_num_rows($result) > 0) {

                    while ($row = $result->fetch_row()) {
                        //while ($row=mysqli_fetch_assoc($res)){


                        echo '<div class="result1">
';
                        echo '<a href="./detail.php?path=';
                        echo $row[9];
//               echo '&title=';
//               echo $row[1];
//               echo '&description=';
//               echo $row[2];
//               echo '&country=';
//               echo $row[11];
//               echo '&city=';
//               echo $row[12];
//               echo '&content=';
//               echo $row[10];
//               echo '&author=';
//               echo $row[8];
//               echo '&favorNum=';
//               echo $row[13];
//
//               $sql = "select * from travelimagefavor where username='$username' and path='$row[9]'";
//               $res = $con->query($sql);
//               if (mysqli_num_rows($res) > 0) {
//                   echo '&favored=true';
//
//               }


                        echo '">';

                        echo '<img class="res_pic" src="../upfile/';
                        echo $row[9];
                        echo '">';
                        echo '</a>';


                        echo '<article class="res_word">';
                        echo '<h2>';
                        echo $row[1];
                        echo '</h2>';

                        echo '<p class="resword">';
                        echo $row[2];
                        echo '</p>';
                        echo '</article>';
                        echo '</div>';


                    }

                    echo '<div id="page"> <a href="./search.php?page=';
                    echo ($page-1)>0 ? $page-1:1;
                    echo '&choice=';
                    echo $choice;
                    echo '&filter_title=';
                    echo $title;
                    echo '&filter_description=';
                    echo $description;
                    echo '" >&lt&lt&nbsp</a>';
                    $i = 1;
                    for (; $i <= $pageCount; $i = $i + 1) {
                        if ($i == $page) {
                            echo '<a style="font-size:40px;color:#00CCCC;"';
                        } else {
                            echo '<a ';
                        }
                        echo 'href="./search.php?page=';
                        echo $i;
                        echo '&choice=';
                        echo $choice;
                        echo '&filter_title=';
                        echo $title;
                        echo '&filter_description=';
                        echo $description;
                        echo '" > &nbsp' . $i . ' &nbsp</a> ';
                    }
                    echo '<a href="./search.php?page=';
                    echo ($page+1)<=$pageCount ? $page+1:$pageCount;
                    echo '&choice=';
                    echo $choice;
                    echo '&filter_title=';
                    echo $title;
                    echo '&filter_description=';
                    echo $description;
                    echo '" > >> </a></div>';
                }
                else{
                    echo "<h2>No results</h2>";
                }


                mysqli_free_result($result);
                mysqli_close($con);

            }



            ?>
        </div>
    </div>
    <div class="blank"></div>
</div>
<footer><p class="foot">制作者：邓泽 学号：18307130177</p></footer>
</body>
</html>

