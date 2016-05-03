(function ($, window) {

    $.fn.contextMenu = function (settings) {

        return this.each(function () {

            // Open context menu
            $(this).on("contextmenu", function (e) {
                $(settings.menuSelector)
                    .data("invokedOn", $(e.target))
                    .show()
                    .css({
                        position: "absolute",
                        left: getLeftLocation(e),
                        top: getTopLocation(e)
                    });

                return false;
            });

            // click handler for context menu
            $(window).scroll(function(event) {
               $(settings.menuSelector).hide();
            });
            $(settings.menuSelector).click(function (e) {
                $(this).hide();

                var $invokedOn = $(this).data("invokedOn");
                var $selectedMenu = $(e.target);

                settings.menuSelected.call($(this), $invokedOn, $selectedMenu);

            });

            //make sure menu closes on any click
            $("#page-content-wrapper").mousedown(function(event) {
                    if(event.which == 1)
                    {                
                        $(settings.menuSelector).hide();                      
                    
                      
                           
                    }
                });

           
        });

        function getLeftLocation(e) {
            var mouseWidth = e.pageX;
            var pageWidth = $(window).width();
            var menuWidth = $(settings.menuSelector).width();
            
            // opening menu would pass the side of the page
            if (mouseWidth + menuWidth > pageWidth &&
                menuWidth < mouseWidth) {
                return mouseWidth - menuWidth;
            } 
            return mouseWidth;
        }        
        
        function getTopLocation(e) {
            var mouseHeight = e.pageY;
            var pageHeight = $(window).height();
            var menuHeight = $(settings.menuSelector).height();

            // opening menu would pass the bottom of the page
            if (mouseHeight + menuHeight > pageHeight &&
                menuHeight < mouseHeight) {
                return mouseHeight - menuHeight;
            } 
            return mouseHeight;
        }

    };
})(jQuery, window);