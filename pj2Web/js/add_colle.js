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



let mpath=getQueryVariable('path');

if(mpath!=false) {
    // alert("为助教提供的原始数据，信息可能不全！用户上传一定信息完整！");
    // setFavor();
}else{
    alert("为助教提供的原始数据,找不到这张图片在哪里，因此没有保存到本机对应的文件夹中，只能看到备用图片,这里自动回到首页...");
    window.location.href='../index.php';
}