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
    },650);

    //TOPページコンテンツを可視範囲に入ってから表示させる
    $('.scroll-section').css('display','none');
    $(window).scroll(function(){
        $('.scroll-section').each(function(){
            var imgPos = $(this).offset().top;
            var scroll = $(window).scrollTop();
            var windowHeight = $(window).height();
            if(scroll > imgPos - windowHeight + windowHeight / 5){
                $('.scroll-section').fadeIn(3200);
            }
        });
    });

    $('.scroll-section2').css('display','none');
    $(window).scroll(function(){
        $('.scroll-section2').each(function(){
            var imgPos2 = $(this).offset().top;
            var scroll2 = $(window).scrollTop();
            var windowHeight2 = $(window).height();
            if(scroll2 > (imgPos2 - windowHeight2) + (windowHeight2 / 5)){
                $('.scroll-section2').fadeIn(3200);
            }
        });
    });
});