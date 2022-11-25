$("img").on('error',function () {
    $(this).attr('src', '/public/pc/logo.jpg');
});
