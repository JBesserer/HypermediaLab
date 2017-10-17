$(document).ready(function(){
    $('.facture').css('color', '#FF4A07');
    $(".detail").click(function(){
        var value = $(this).text();

        if(value === 'Détails'){
            $(this).html('Réduire');
            $(this).parents('div').find('.divItems').show();
        }
        else{
            $(this).html('Détails');
            $(this).parents('div').find('.divItems').hide();
        }
    });
});


