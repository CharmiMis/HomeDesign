$(document).ready(function () {
    $('.top-menu-bar-second').css('display', 'none');
    $('.searched_product_result').css('display', 'none');
    $('.image-mask-container').css('display', 'none');
    $('.segment-masking-container').css('display', 'none');
    $('.top-menu-bar-third').css('display', 'none');
    $('.image-container').css('display', 'none');
    $('.category-container').css('display', 'none');

    $(".gs-pro-dot-right > img").click(function () {
        $(".gs-pro-dot-right").removeClass("gs-active");
        $(this).parent().toggleClass("gs-active");
    });
    $(".gs-dashboard-wrpper").click(function () {
        $(".gs-pro-dot-right").removeClass("gs-active");
    });
    $('.gs-pro-dot-right').click(function (event) {
        event.stopPropagation();
    });

    // $(".gs-select-automatically-inner li, .interior-list li").click(function () {
    //     $(this).toggleClass("active");
    // });
    // $(".materials-textures-cat li").click(function () {
    //     $(".select-more-details").slideDown();
    // });
    $(".gs-select-category-list-inner").click(function (event) {
        $(this).siblings('.gs-select-category-list-inner').removeClass("active");
        $(this).addClass("active");
    });

    $(".category-tabs").click(function (event) {
        var sec = $(this).data('sec')
        $(".gs-option-flex li").removeClass("active");
        $(".gs-option-flex li").eq(sec).addClass("active");
    });

    // $(".gs-our-preset-color li").click(function () {
    //     $('.gs-our-preset-color li').removeClass("active");
    //     $(this).addClass("active");
    // });

    $(".gs-refine-manually-single a").click(function () {
        $(this).siblings('.gs-refine-manually-single a').removeClass("active");
        $(this).addClass("active");
    });


    $(".gs-select-room-style-single").click(function () {
        $('#view_all_interior_room_type').modal('hide');
        $('#view_all_interior_choose_design').modal('hide');
        $('#view_all_garden_type').modal('hide');
        $('#view_all_garden_style').modal('hide');
        $('#view_all_exterior_choose_design').modal('hide');

        $(this).siblings('.gs-select-room-style-single').removeClass("active");
        $(this).addClass("active");
    });

    $(".menu-icon").click(function () {
        $(".gs-dashboard-leftbar").addClass("active");
    });
    $(".close-icon").click(function () {
        $(".gs-dashboard-leftbar").removeClass("active");
    });

    $(".gs-continue-btn-similar").click(function () {
        $(".gs-simlar-products-list-wrapper").slideToggle();
    });
    $(".gs-dashboard-cross img").click(function () {
        $(this).parents(".gs-dashboard-notice").fadeOut();
    });

    if ($(window).width() < 991) {
        $(".ai-tool-top h3").click(function () {
            $(".ai-tool-list").slideToggle();
        });
    }

    $(".ai-upload-selection input").click(function () {
        if ($('.ai-upload-selection input[type="checkbox"]').is(':checked')) {
            $('.ai-upload-add-project').fadeIn();
        } else {
            $('.ai-upload-add-project').fadeOut();
        }
    });


    $(".gs-modal-feeback-row").click(function () {
        if ($('input[name=feeback]:checked').length > 0) {
            $('.gs-modal-continue-btn').removeClass('gs-modal-continue-disable');
            // do something here
        }
    });


    // $(".gs-continue-btn").click(function () {
    //     setTimeout(function () {
    //         $('.gs-image-editing-slide').slick('refresh');
    //     }, 500);
    // });





    $(function () {
        // $(".gs-select-range").slider({
        //     //   orientation: "vertical",
        //     range: "min",
        //     min: 0,
        //     max: 70,
        //     value: 70,
        //     slide: function (event, ui) {
        //         $("#amount").val(ui.value);
        //         $("#ip-brush-thickness").val(ui.value);
        //     }
        // });
        $("#amount").val($(".gs-select-range").slider("value"));


        $(".our-preset-settings-range").slider({
            range: "max",
            min: 1,
            max: 4,
            value: 1,
            slide: function (event, ui) {
                var sec = $(this).data('sec');
                $('#no_of_des' + sec).val(ui.value);
                $('.our-preset-settings-range[data-sec]').each(function () {
                    var currentSec = $(this).data('sec');
                    if (currentSec === sec) {
                        $(this).slider('value', ui.value);
                    }
                });
            }
        });

        $(".ai-intervention").slider({
            range: "max",
            min: 1,
            max: 4,
            value: 3,
            slide: function (event, ui) {
                var sec = $(this).data('sec');
                var valueText;
                switch (ui.value) {
                    case 1:
                        valueText = 'very_low';
                        break;
                    case 2:
                        valueText = 'low';
                        break;
                    case 3:
                        valueText = 'mid';
                        break;
                    case 4:
                        valueText = 'extreme';
                        break;
                    default:
                        valueText = '';
                        break;
                }
                $('#strength' + sec).val(valueText);
                $('.ai-intervention[data-sec]').each(function () {
                    var currentSec = $(this).data('sec');
                    if (currentSec === sec) {
                        $(this).slider('value', ui.value);
                    }
                });
            }
        });

        $(".ai-intervention-room-composer").slider({
            range: "max",
            min: 1,
            max: 2,
            value: 1,
            slide: function (event, ui) {
                var sec = $(this).data('sec');
                var valueText;
                switch (ui.value) {
                    case 1:
                        valueText = 'mid';
                        break;
                    case 2:
                        valueText = 'extreme';
                        break;
                    default:
                        valueText = '';
                        break;
                }
                $('#strength' + sec).val(valueText);
            }
        });
        // $( "#amount" ).val( $( "#slider-range-max" ).slider( "value" ) );
    });



    const marqueeContainer = $('#marqueeContainer');
    const marqueeWrapper = $('#marqueeWrapper');
    marqueeWrapper.append(marqueeWrapper.html());

    function scrollMarquee() {
        marqueeWrapper.animate({
            top: '-=' + marqueeWrapper.height() / 2 + 'px'
        }, {
            duration: 45000,
            easing: 'linear',
            complete: function () {
                marqueeWrapper.css('top', '0px');
                scrollMarquee();
            }
        });
    }
    scrollMarquee();



    $(".ai-upload-input").on('change', function () {
        if ($('.ai-upload-input').val() != '') {

            // $('#uploading_instruction').modal('show');
        } else {

        }
    });


    $(".gs-image-editing-slide").slick({
        slidesToShow: 1,
        arrows: false,
        draggable:false,
        infinite:true,
        draggable: false,
        swipe: false,
        swipeToSlide: false,
        touchMove: false,
        draggable: false,
        accessibility: false,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 2000
       });


    // $(".gs-modal-best-btns a").click(function () {
    //     setTimeout(function () {
    //         $('.gs-modal-uploading_instruction_slider')[0].slick.refresh();
    //     }, 400);
    //     setTimeout(function () {
    //         $('.top-menu-bar-first').hide();
    //         $('.upload-image-container').hide();
    //         if ($('.top-menu-bar-second').length) {
    //             $('.redesign-designs-tabs').hide();
    //             $('.top-menu-bar-second').show();
    //             $('.image-mask-container').show();
    //             $('.segment-masking-container').show();
    //         }
    //         else{
    //             $('.top-menu-bar-third').show();
    //             $('.image-container').show();
    //             $('.category-container').show();
    //         }
    //         $('.gs-modal-close').trigger('click');
    //     }, 3000)
    // });
    $(".gs-modal-uploading_instruction_slider").slick({
        slidesToShow: 2,
        arrows: false,
        dots: true,
        infinite: true,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        responsive: [{
                breakpoint: 991,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                }
            }
        ]
    });

    // $(".continue-parameter").click(function () {
    //     $('.top-menu-bar-second').hide();
    //     $('.image-mask-container').hide();
    //     $('.segment-masking-container').hide();
    //     $('.top-menu-bar-third').show();
    //     $('.image-container').show();
    //     $('.category-container').show();
    // });

    // $(".previous_page").click(function () {
    //     if ($('.top-menu-bar-third').is(':visible')) {
    //         $('.top-menu-bar-third').hide();
    //         $('.image-container').hide();
    //         $('.category-container').hide();
    //         $('.top-menu-bar-second').show();
    //         $('.image-mask-container').show();
    //         $('.segment-masking-container').show();
    //     }
    //     else if($('.top-menu-bar-second').is(':visible')){
    //         $('.top-menu-bar-second').hide();
    //         $('.image-mask-container').hide();
    //         $('.segment-masking-container').hide();
    //         $('.top-menu-bar-first').show();
    //         $('.upload-image-container').show();
    //     }
    // });
});
