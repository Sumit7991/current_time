(function($) {
    Drupal.behaviors.updateTime = {
        attach: function (context, settings) {

            // Call function once to update time on page load (doing this makes url cache context useless)
            setTime();
            // and then after every 30 seconds as we are not showing time by second's precision,
            // thus reducing the number of ajax calls.
            // Another approach can be to update time client-side after the first setTime() call,
            // but that would require significant calucations in JS to get time based on timezone.
            setInterval(function() {
                setTime();
            }, 30*1000);
        }
    };

    function setTime() {
        $.ajax({
            url: Drupal.url('/ajax/get-updated-time'),
            dataType: "json",
            success: function(result) {
                $('.time-container #current-time').text(result);
            }
        });
    }
})(jQuery);
