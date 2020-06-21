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

let mtitle=getQueryVariable('title');
let mdescription=getQueryVariable('description');
let mcontent=getQueryVariable('content');

if(mpath!=false&&mtitle!=false&&mdescription!=false&&mcontent!=false)
    modify();



function modify() {
    let up_button=document.getElementById("up_button");
    let title=document.getElementsByName('upload_pic_title');
    let description=document.getElementsByName('upload_pic_description');
    let country=document.getElementById('first');
    let city=document.getElementById('second');
    let content=document.getElementsByName('upload_pic_theme')[0];

    document.getElementById("up_line").style.display = "none";
    let image = document.getElementById('ready_to_up_pics');
    image.setAttribute('src', '../upfile/' + mpath);
    up_button.required = false; //设置选择文件不一定要选
    title[0].value = decodeURI(mtitle);

    description[0].value = decodeURI(mdescription);

    switch (mcontent) {
        case 'Building':
            content.options[1].selected = true;
            break;
        case 'Wonder':
            content.options[2].selected = true;
            break;
        case 'Scenery':
            content.options[3].selected = true;
            break;
        case 'City':
            content.options[4].selected = true;
            break;
        case 'People':
            content.options[5].selected = true;
            break;
        case 'Animal':
            content.options[6].selected = true;
            break;
        case 'Other':
            content.options[7].selected = true;
            break;
    }

    let submit=document.getElementById('upload_submit');
    submit.innerHTML='Modify';
    let page=document.getElementsByClassName('up_til')[0];
    page.innerHTML='MODIFY';
    let form=document.getElementsByTagName('form')[0];
    form.setAttribute('action','../php/modify.php?path='+mpath);

}