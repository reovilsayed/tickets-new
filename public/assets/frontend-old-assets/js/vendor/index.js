/**
    Item Name: Ekka - Ecommerce HTML Template.
    Author: ashishmaraviya
    Copyright 2021-2022
	Author URI: https://themeforest.net/user/ashishmaraviya
**/
(function($) {
    "use strict";

    $(document).ready(function() {

      

        var ecPopNewsLetter = ecAccessCookie("ecPopNewsLetter");
        if (ecPopNewsLetter !== "true")
        {
            setTimeout( function(){ 
                $("#ec-popnews-bg").fadeIn();
                $("#ec-popnews-box").fadeIn();
            }, 5000);

            $("#ec-popnews-close").click(() => {
                $("#ec-popnews-bg").fadeOut();
                $("#ec-popnews-box").fadeOut();

                var dataValue = true;
                ecCreateCookie('ecPopNewsLetter',dataValue,1);
            });

            $("#ec-popnews-bg").click(() => {
                $("#ec-popnews-bg").fadeOut();
                $("#ec-popnews-box").fadeOut();

                var dataValue = true;
                ecCreateCookie('ecPopNewsLetter',dataValue,1);
            });
        }
    });

})(jQuery);




