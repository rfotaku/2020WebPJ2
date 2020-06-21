$(function () {
    $("#login_form").validate({
        errorElement:"p",
        rules:{
            username:{
                required: true,
                remote: "../../pj2Server/php/checkUser.php"
            },
            password:{
                required: true,
            }
        },
        message:{
            remote: "用户名不存在，请重新输入"
        }
    })
});