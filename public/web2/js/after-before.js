var moveSlider = false;
    $(document).ready(function() {
        $(".ba-Slider").each(function(i) {
            var slider = $(this).children(".slider");
            var before = $(this).children("#before");
    
            function startMove() {
                moveSlider = true;
                before.removeClass("ease");
                slider.removeClass("ease");
            }
    
            function stopMove() {
                moveSlider = false;
                before.addClass("ease");
                slider.addClass("ease");
                var minmax = $(this).width() / 8;
                if (before.width() > $(this).width() - minmax) {
                    before.width("100%");
                    var sOffset = $(this).width() - 16.5;
                    slider.css("left", sOffset);
                } else if (before.width() < minmax) {
                    before.width(0);
                    var sOffset = -16.5;
                    slider.css("left", sOffset);
                }
            }
    
            slider.mousedown(startMove);
            $(document).mouseup(stopMove.bind(this));
    
            slider.on('touchstart', startMove);
            $(document).on('touchend', stopMove.bind(this));
    
            $(this).mousemove(function(e) {
                if (moveSlider) {
                    var pOffset = $(this).offset();
                    var mouseX = e.pageX - pOffset.left;
                    before.width(mouseX - 0.5);
                    var sOffset = mouseX - 16.5;
                    slider.css("left", sOffset);
                }
            });
    
            $(this).on('touchmove', function(e) {
                if (moveSlider) {
                    var pOffset = $(this).offset();
                    var touchX = e.originalEvent.touches[0].pageX - pOffset.left;
                    before.width(touchX - 0.5);
                    var sOffset = touchX - 16.5;
                    slider.css("left", sOffset);
                }
            });
        });
    });