<?php
session_start();
//echo $_SESSION['username'];
if(isset($_SESSION['username'])):
    ?>
    <!DOCTYPE html>
    <html>
<head>
    <meta charset="UTF-8">
    <title>上传图片</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css"/>
    <link rel="stylesheet" type="text/css" href="../css/upload.css"/>
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
                            <a class="menuItem" href="upload.html" id="this">
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
            <h1>上传图片</h1>
            <div id="uploadBox">
                <input type="file" accept="image/gif,image/jpeg, image/png, image/jpg" id="choose" onchange="showImg(this)"/>
                <label for="choose">
                    <img src="../background/upload.png" id="uploadIcon"/>
                </label>
            </div>
            <form id="pic_form" action="../php/upload.php" method="POST">
                <p>
                    <label for="pic_title">图片标题：</label>
                    <input type="text" id="pic_title">
                </p>
                <p>
                    <label for="pic_msg">图片描述：</label>
                    <input type="text" id="pic_msg">
                </p>
                <p>
                    拍摄国家：
                    <select id="first" class="form-control" name="upload_pic_country" onChange="change()" required>
                        <option selected="selected" value=""disabled selected hidden>COUNTRY</option>

                        <?php
                        $user = 'root';
                        $password = 'root';
                        $db = 'Pj2';
                        $host = 'localhost';
                        $port = 3306;
                        $serve='localhost:3306';



                        $con = new Mysqli($serve,$user,$password,$db);
                        $con->query("SET NAMES utf8");


                        $sql="select geocountries.CountryName,geocountries.ISO from geocountries";
                        $result=$con->query($sql);
                        $count = mysqli_num_rows($result);
                        while($row=$result->fetch_row()){
                            echo '<option>';
                            echo  $country=$row[0];
                            echo '</option>';
                        }

                        ?>

                        <!--                                   <option>China</option>-->
                        <!--                                   <option>Japan</option>-->
                        <!--                                   <option>Italy</option>-->
                        <!--                                   <option>America</option>-->
                    </select>
                </p>
                <script>

                    function change(){

                        let x = document.getElementById("first");

                        let y = document.getElementById("second");

                        y.options.length = 0; // 清除second下拉框的所有内容

                        let i = 0;
                        let count=x.options.length;

                        /*
                        jquery
                        先获取大类选择框的值，并通过$.getJSON方法传递给后台，读取后台返回的JSON数据，
                        并通过$.each方法遍历JSON数据，最后将option追加到小类里。
                        * */

                        $.getJSON("../php/findRelatedCity.php",{first:$("#first").val()},function(json){
                            let second = $("#second");


                            $.each(json,function(index,array){
                                //var option = "<option value='"+array['id']+"'>"+array['title']+"</option>";
                                y.options.add(new Option(array['city'], array['city']));
                            });
                        });


                    }


                </script>
                <p>
                   拍摄城市：
                    <select id="second" class="form-control" name="upload_pic_city" required>
                        <option selected="selected" value=""disabled selected hidden >CITY</option>
                    </select>
                </p>
                <p>
                    主题：
                    <select  class="form-control" name="upload_pic_theme" required>
                        <option selected="selected" value=""disabled selected hidden>CONTENT</option>
                        <option>Building</option>
                        <option>Wonder</option>
                        <option>Scenery</option>
                        <option>City</option>
                        <option>People</option>
                        <option>Animal</option>
                        <option>Other</option>
                    </select>
                </p>
                <button onclick="alert('提交成功')">提    交</button>
            </form>
        </div>
        <div class="blank"></div>
    </div>
    <script type="text/javascript">
        function showImg(input) {
            var file = input.files[0];
            var reader = new FileReader()
            // 图片读取成功回调函数
            reader.onload = function(e) {
                document.getElementById('uploadIcon').src=e.target.result
            }
            reader.readAsDataURL(file)
        }
    </script>
    <footer><p class="foot">制作者：邓泽 学号：18307130177</p></footer>
    </body>
</html>







    <script src="../js/upload.js"></script>
    <script src="../js/modify.js"></script>
    <script defer>
        <?php
        if($_GET['cityCode']!=''&&$_GET['countryCode']!='')
        {
            $cityCode=$_GET['cityCode'];
            $countryCode=$_GET['countryCode'];

            $sql="select geocountries.CountryName from geocountries where ISO='$countryCode'";
            $result=$con->query($sql);
            $row=$result->fetch_row();
            $country=$row[0];

            $sql="SELECT * FROM geocities WHERE `GeoNameID`='$cityCode'";
            $result=$con->query($sql);
            $row=$result->fetch_row();
            $city=$row[1];

            $sql="SELECT * FROM geocities where `CountryCodeISO`='$countryCode'";
            $result=$con->query($sql);

        }

        ?>

        function getQueryVariable(variable)
        {
            let query = window.location.search.substring(1);
            let vars = query.split("&");
            for (let i=0;i<vars.length;i++) {
                let pair = vars[i].split("=");
                if(pair[0] == variable){return pair[1];}
            }
            return(false);
        }
        let mcountrycode=getQueryVariable('countryCode');
        let mcityCode=getQueryVariable('cityCode');

        if(mcountrycode!=false&&mcityCode!=false) {

            let country = document.getElementById('first');
            let city = document.getElementById('second');

            for (let i = 0; i < <?php echo $count; ?>; i++) {
                if (country.options[i].value == "<?php echo $country; ?>") {
                    country.options[i].selected = true;
                    break;
                }

            }
            city.options.length = 1; // 清除second下拉框的所有内容

            $.getJSON("../php/findRelatedCity.php", {first: $("#first").val()}, function (json) {

                $.each(json, function (index, array) {

                    //var option = "<option value='"+array['id']+"'>"+array['title']+"</option>";
                    city.options.add(new Option(array['city'], array['city']));
                });


                for (let i = 0; i < city.options.length; i++) {
                    if (city.options[i].innerText == "<?php echo $city; ?>") {
                        city.options[i].selected = true;
                        break;
                    }

                }
            });

        }

    </script>



<?php else:
    echo 'Please log in first!';
    echo "<script>window.location.href='login.html'</script>";
    ?>
<?php endif ?>