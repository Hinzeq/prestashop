/*
 * Custom code goes here.
 * A template should always ship with an empty custom.js
 */




$(document).ready(function(){
    $("#my-function-button").click(function(){
        $.ajax({
            url: "http://localhost/prestashop/index.php?controller=testsite",
            cache: false,
            type: 'POST',
            data: {
                ajax: true,
                action: "getProducts"
            },
            success: function(data) {
                if(data) {
                    data = $.parseJSON(data);
                    products = data.products;
                    console.log(products);
                    $("#load-ten-product").html(data.data.dane);
                }
            }
        })
    });
});
