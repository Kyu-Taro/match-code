$(function(){

    //サイトトップまでスクロール
    $('.scroll').click(function(){
        $('html,body').animate({
            'scrollTop':0
        },500)
    });

    //トップページのアニメーション
    setTimeout(function(){
        $('.top-title').fadeIn(1600);
    },500);

    setTimeout(function(){
        $('.top-coment').slideDown(2600);
    },10);

    //TOPページコンテンツを可視範囲に入ってから表示させる
    $('.scroll-section').css('display','none');
    $(window).on("scroll",function(){
        $('.scroll-section').each(function(){
            var imgPos = $(this).offset().top;
            var scroll = $(window).scrollTop();
            var windowHeight = $(window).height();
            if(scroll > imgPos - windowHeight + windowHeight / 5){
                $(this).fadeIn(3200);
            }
        });
    });

});