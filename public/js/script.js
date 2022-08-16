//Scroll down button
$(document).ready(function () {
    $('#anchor').on('click', function () {
        let page = $(this).attr('href');
        let speed = 1400;
        $('html, body').animate({
            scrollTop:
            $(page).offset().top
        }, speed);
        return false;
    });


//Scroll top button
    //Scroll top button appearing after px
    $(function () {
        $(window).scroll(function () {//Au scroll dans la fenêtre, on déclenche la fonction
            if ($(this).scrollTop() > 300) { //si on a défilé de plus de 600px du haut vers le bas
                $('#scroll-top-button').fadeIn().removeClass('hidden');
            } else if ($(this).scrollTop() < 300) {
                $('#scroll-top-button').fadeOut();
            }
        });
    });


    //Scroll top slow
    $('#scroll-top-arrow').on('click', function () {
        var page = $(this).attr('href');
        var speed = 1400;
        $('html, body').animate({
            scrollTop:
            $(page).offset().top
        }, speed);
        return false;
    });


    //Carousel
    $(function () {
        $('.item:first-child').addClass('active');
    });

}); // END DOCUMENT READY