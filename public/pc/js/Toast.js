let res = document.scripts;
let resPath = res[res.length - 1].src;
resPath = resPath.substring(0, resPath.lastIndexOf('/') + 1);
let node = document.createElement('script');
node.async = true;
node.charset = 'utf-8';
node.src = resPath + 'spop/spop.min.js';
let link = document.createElement('link');
link.rel = 'stylesheet';
link.href = resPath + 'spop/spop.min.css';
link.media = 'all';
let head = document.getElementsByTagName('head')[0];
head.appendChild(node);
head.appendChild(link);

// error
function ToastErr(msg, expire) {
    if(!expire){expire = 3000;}
    spop({
        template: msg,
        position: 'top-center',
        style: 'error',
        autoclose: expire
    })
}
// warn
function ToastWarn(msg, expire) {
    if(!expire){expire = 3000;}
    spop({
        template: msg,
        position: 'top-center',
        style: 'warning',
        autoclose: expire
    })
}
// info
function ToastInfo(msg, expire) {
    if(!expire){expire = 3000;}
    spop({
        template: msg,
        position: 'top-center',
        style: 'info',
        autoclose: expire
    })
}
// success
function ToastOk(msg, expire) {
    if(!expire){expire = 3000;}
    spop({
        template: msg,
        position: 'top-center',
        style: 'success',
        autoclose: expire
    })
}