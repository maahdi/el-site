
var mobile=false;
var dev=false;

function setMobile(mo, de)
{
    if (mo == true)
    {
        mobile = true;
    }else
    {
        mobile = false;
    }
    if (de == true)
    {
        dev = true;
    }else
    {
        dev = false;
    }
}

function swipeDown()
{
     $('#imobile').animate({
        'left':'-100%',
     },800);
    // $('.bodyl').css({'position': 'absolute'})
     $('.bodyl').animate({
        'left':'0'
     },800);
    //$('.bodyl').css({'position':'relative'});
    if ($('#slider').length)
    {
        $('#slider').data('nivoslider').start();
    }
}

function swipeUp()
{
    if ($('#slider').length)
    {
        $('#slider').data('nivoslider').stop();
    }
    $('.bodyl').css({'position':'absolute'});
    $('#imobile').css({'z-index':'1000'});
    $('#imobile').animate({
        'left':'0',
    },800);
    $('.bodyl').css({'position':'relative'});
    $('.bodyl').animate({
        'left':'100%'
    },800);
}

function changeUrl(balise,mob){
    mob = mob || false;
    var loc = $(location).attr("href");
    var page = loc.substr(loc.lastIndexOf('/'));
    if (page.search('#') > -1){
        page = page.substring(0,page.search('#'));
    }
    balise.each(function(){
        var h = $(this).attr("href");
        var i = h.search('#');
        if (i > -1)
        {
            var diez = h.indexOf('#');
            var hpage = h.substring(h.lastIndexOf('/'), diez);
            if (hpage == page){
                var text = h.substr(diez);
                $(this).attr('href', text);
                if (mob)
                {
                    $(this).addClass('samePage');
                }
            }
        }
    });
}
