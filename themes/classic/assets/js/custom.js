/*
 * Custom code goes here.
 * A template should always ship with an empty custom.js
 */


$(document).ready(function() {
    $("#my-function-button").click(function() {
        $.ajax({url: '/test.txt', // tutaj utworzyłem plik testowy w głównym katalogu
            success: function(x){
                $("#load-ten-product").html(x);
            }
        });
        // $("#load-ten-product").html("tutaj wczytam zawartość");
    });
});