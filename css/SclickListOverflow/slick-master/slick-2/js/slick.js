$(function() {
    $('.slider-services').slick({
        dots: true,
        appendDots: '.slider-dots',
        arrows: true,
        infinite: false,
        slidesToScroll: 3,
        slidesToShow: 3,
        accessibility: true,
        variableWidth: false,
        focusOnSelect: false,
        centerMode: false,
        responsive: [{
                breakpoint: 992,
                settings: {
                    slidesToScroll: 2,
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToScroll: 1,
                    slidesToShow: 1
                }
            }
        ]
    });
});