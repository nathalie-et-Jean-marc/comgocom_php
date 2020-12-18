/*
 Fonction d'autocomplétion département _ ville 
*/

/*(function ($) {

    // jQuery autocomplete
    $.fn.autocompleteDpt = function () {
        $('#chercheDepartements').autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url : '../outils/autocomplete.php',
                    dataType: "json",
                        data: {
                            filtreDepartement: request.term,
                            type: 'departements'
                        },
                            success: function( data ) {
                            response( $.map( data, function( item ) {
                                    return {
                                            label: item,
                                            value: item
                                    }
                            }));
                        }
                });
            },
            autoFocus: true,
            minLength: 0         
        });
    };

})(jQuery);


(function ($) {

    // jQuery autocomplete
    $('#chercheVilles').autocomplete({
        source: function( request, response ) {
            $.ajax({
                url : '../../outils/autocomplete.php',
                dataType: "json",
                    data: {
                        filtreVille: request.term,
                        filtreDepartement : $('#chercheDepartements').val(),
                        type: 'villes'
                    },
                        success: function( data ) {
                        response( $.map( data, function( item ) {
                                return {
                                        label: item,
                                        value: item
                                }
                        }));
                    }
            });
        },
        autoFocus: true,
        minLength: 2         
    });

})(jQuery);


    (function ($) {

    // jQuery autoGrowInput plugin by James Padolsey

    $.fn.autoGrowInput = function (o) {


    };

})(jQuery);*/



/*
$(function() {
  $.yourFavoriteFunctionName = function() {
      // the code for the first function
      //   };
      //     $.yourFavoriteFunctionName();
      //     });
      //
 Fonction cacher _ voir div tag 
*/

$(function() {
  $.showHideBeforePost = function(){
        $("#tagCree").hide();
        $("#tagChoisi").show();   

        $("input[name$='creerOuChoisi']").click(function(){
            var radio_value = $(this).val();
            if(radio_value == 'choisi') {
                $("#tagChoisi").show();
                $("#tagCree").hide();
            }
            else if(radio_value == 'cree') {
                $("#tagCree").show();
                    $("#tagChoisi").hide();
            }

        });   
    };
});



$(function() {
  $.showHideAfterPost = function() {

        var radioValue = $('input[name=creerOuChoisi]:checked').val();
        if(radioValue == 'choisi') {

            $("#tagChoisi").show();
            $("#tagCree").hide();
        }
        else if(radioValue == 'cree') {
            $("#tagCree").show();
            $("#tagChoisi").hide();
        }

    };
});




