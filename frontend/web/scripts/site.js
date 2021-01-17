;(function($) {

    $(window).on("load", function () {

        $( "#dialog" ).dialog({ autoOpen: false });
        $( "#opener" ).on("click", function() {
            console.log(this);
            $( "#dialog" ).dialog( "open" );
        });

    })

}(jQuery));