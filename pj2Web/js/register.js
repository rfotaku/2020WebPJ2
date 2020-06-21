
$(function () {
        $("#register_form").validate({
            errorElement:"p",
            rules: {
                username: {
                    required: true,
                    minlength: 2,
                    userReg: /^\w+$/,
                    remote: "../../pj2Server/php/existUser.php"
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 5,
                    bigPWD: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]+$/
                },
                checkPWD: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
            },
            messages: {
                username: {
                    required: "请输入用户名",
                    minlength: "用户名必需由至少两个字符组成",
                    remote: "该用户名已存在，不可重复"
                },
                password: {
                    required: "请输入密码",
                    minlength: "密码长度不能小于 5 个字符"
                },
                confirm_password: {
                    required: "请输入密码",
                    minlength: "密码长度不能小于 5 个字符",
                    equalTo: "两次密码输入不一致"
                },
                email: "请输入正确的邮箱",
            }
        })
});