$(document).on('onlineloaded', function(){
    $('.onlinePanel').each(function(){
        if ($(this).parents('.focus').length > 0){
            $(this).children('.onlineContent').each(function(){
                if ($(this).children('div').first().children('div').first().children('.heure-display').text() == "Fermé"){
                    $(this).children('div').first().children('div').first().children('.desc-title').remove();
                    $(this).children('div').first().children('div').first().addClass('horaire-fermer');
                    $(this).children('div').first().children('.desc-title').remove();
                    $(this).children('div').first().children('div').last().remove();
                    $(this).children('div').last().remove();
                }else{
                    $(this).children('div').each(function(){
                        $(this).children('div').each(function(){
                            $(this).children('.heure-display').each(function(){
                                var heure;
                                var minute;
                                var tmp = $(this).text().split('h');
                                heure = tmp[0];
                                minute = tmp[1];
                                $(this).text('');
                                $(this).append('<div class="heure"><div class="plus">+</div><div class="txt">'+heure+'</div><div class="moins">-</div></div>');
                                $(this).append('<div class="sep">h</div>');
                                $(this).append('<div class="min"><div class="plus">+</div><div class="txt">'+minute+'</div><div class="moins">-</div></div>');
                            });
                        });                    
                    });                
                }
            });
        }
    });
});
