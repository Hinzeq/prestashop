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
                    products_info = data.products_info;
                    products_name = data.products_name;
                    
                    if($(".how-many").length < 10) {
                        for(i = 0; i < 10; i++) {
                            $("#load-ten-product").append(
                                '<p class="how-many">' + products_info[i].id_product + ". " +
                                products_name[i].name + "</p>");
                        }
                    }
                }
            }
        })
    });
});
