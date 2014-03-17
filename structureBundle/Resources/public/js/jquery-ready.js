
$(window).ready(function(){
    $('#slider').nivoSlider(
    {
        effect: 'sliceUp',
        animSpeed:650,
        pauseTime:6000,
        directionNavHide: false,
        captionOpacity: 1,
        prevText:'<',
        nextText:'>'
    });


    $('.sectionAdmin').mouseover(function(){
        $(this).css(
            {'-webkit-border-radius': '3px 3px 3px 3px',
            '-moz-border-radius': '3px 3px 3px 3px',   
            'border-radius':'3px 3px 3px 3px',
            'background-color': '#777',
            'background-color': '-webkit-gradient(linear, left top, left bottom, color-stop(0%, #777), color-stop(93%, #b3b3b3))',
            'background-color': '-moz-linear-gradient(top, #777 0%, #b3b3b3 93%)',
            'background-color': '-ms-linear-gradient(top, #777 0%, #b3b3b3 93%)',
            'background-color': 'linear-gradient(to bottom, #777 0%, #b3b3b3 93%)',
            'cursor':'pointer'
            });
    });

    $('.sectionAdmin').mouseleave(function(){
        $(this).css({'background-color' : '#f1ecec'});
    });

    $(window).scroll(function () {
        posScroll = $(document).scrollTop();
        if(posScroll >= 350)
            $('#back-top').fadeIn(600);
        else
            $('#back-top').fadeOut(400);
    }); 

    $('#back-top a').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });

    $('.sectionAdmin').on('click',function(){
        if ($('.barAdmin').children('.admin-content').length > 0 && lien != $(this).attr('id'))
        {
            lien = $(this).attr('id');
            if (close)
            {
                $('.admin-content').remove();
                $('.tool-container').css({'z-index' : '1'});
                $(d).hide().appendTo('.barAdmin');
                getAdminInterface();
                getAdminContent(lien);
                $(d).slideToggle('slow');
            }else
            {
                $('.admin-content').slideToggle('slow').queue(function(){
                    $('.admin-content').remove();
                    $('.tool-container').css({'z-index' : '1'});
                    $(d).hide().appendTo('.barAdmin').slideToggle('slow').queue(function(){
                        getAdminInterface();
                        getAdminContent(lien);
                        $(this).dequeue();
                    });
                    $(this).dequeue();
                });
            }
        }else if ($('.barAdmin').children('.admin-content').length > 0 && lien == $(this).attr('id'))
        {
            $('.admin-content').slideToggle('slow');
            if (close)
            {
                close = false;
            }else
            {
                close = true;
            }
        }else
        {
            close = false;
            lien = $(this).attr('id');
            $('.tool-container').css({'z-index' : '1'});
            $(d).hide().appendTo('.barAdmin').slideToggle('slow').queue(function(){
                getAdminInterface();
                getAdminContent(lien);
                $(this).dequeue();
            });
        }
    });
});

/*
 * Variable pour affichage des pages admin
 */
var close = true;
var lien = null;
var d = '<div class="admin-content small-12 columns tool-container gradient"></div>';
var struct = new Array();
var contentStructure = null;

function getAdminInterface()
{
    sendAjax('ajax/adminInterface', function(data)
    {
        $('.admin-content').append(data);
    },{'lien' : lien });
}

function getAdminContent(lien)
{
    var url = makeUrl();
    var donnee = {'lien' : lien};
    if (lien == 'pagesAdmin')
    {
        sendAjax('ajax/adminContentStructure', function (data){
            $('.contentI').append(data);
        }, { 'lien' : 'GkeywordsAdmin' });
    
    }
    sendAjax('ajax/adminContentStructure', function (data){
        contentStructure = data;
        struct = contentStructure.match(/%[a-zA-Z]*%/g);
        $.getJSON(url[0]+"ajax/adminContent",donnee,function (data){
            $.each(data, function (key,val){
                var article = null;
                var i = 0;
                $.each(struct,function (key,value){
                    var tmp = value.split("%");
                    if (i == 0)
                    {
                        article = contentStructure.replace(value,val[tmp[1]]);
                    }else
                    {
                        article = article.replace(value,val[tmp[1]]);
                    }
                i++;
                });
                $('.contentI').append(article);
                $('.datepickerDebut').datepicker({ maxDate : $('.datepickerFin').val(),
                                                dateFormat : "dd/mm/yy"});
                $('.datepickerFin').datepicker({ minDate : $('.datepickerDebut').val(),
                                                dateFormat : "dd/mm/yy"});
            });
            contentStructure = null;
        });
    },{ 'lien' : lien});
    /*
     * Url pour choisir sur mon site automatiquement vers quel bundle il faut rediriger
     */
}

function scroll(id)
{
    $('html, body').animate({ scrollTop : $(id).offset().top}, 800);
    return false;
}

$(document).on('mouseover','.btn-menuI',function(){
    $(this).css(
        {'-webkit-border-radius': '3px 3px 3px 3px',
        '-moz-border-radius': '3px 3px 3px 3px',   
        'border-radius':'3px 3px 3px 3px',
        'background-color': '#777',
        'background-color': '-webkit-gradient(linear, left top, left bottom, color-stop(0%, #777), color-stop(93%, #b3b3b3))',
        'background-color': '-moz-linear-gradient(top, #777 0%, #b3b3b3 93%)',
        'background-color': '-ms-linear-gradient(top, #777 0%, #b3b3b3 93%)',
        'background-color': 'linear-gradient(to bottom, #777 0%, #b3b3b3 93%)',
        'cursor':'pointer'
        });
});

$(document).on('mouseleave','.btn-menuI',function(){
    $(this).css({'background-color' : '#f1ecec'});
});

$(document).on('mouseleave','.btn-logo',function(){
    $(this).css({'background-color' : '#f1ecec'});
});

$(document).on('mouseover','.btn-logo',function(){
    $(this).css(
        {'-webkit-border-radius': '3px 3px 3px 3px',
        '-moz-border-radius': '3px 3px 3px 3px',   
        'border-radius':'3px 3px 3px 3px',
        'background-color': '#777',
        'background-color': '-webkit-gradient(linear, left top, left bottom, color-stop(0%, #777), color-stop(93%, #b3b3b3))',
        'background-color': '-moz-linear-gradient(top, #777 0%, #b3b3b3 93%)',
        'background-color': '-ms-linear-gradient(top, #777 0%, #b3b3b3 93%)',
        'background-color': 'linear-gradient(to bottom, #777 0%, #b3b3b3 93%)',
        'cursor':'pointer'
        });
});

$(document).on('mouseover','.btn-admin',function(){
    $(this).css(
        {'-webkit-border-radius': '3px 3px 3px 3px',
        '-moz-border-radius': '3px 3px 3px 3px',   
        'border-radius':'3px 3px 3px 3px',
        'background-color': '#777',
        'background-color': '-webkit-gradient(linear, left top, left bottom, color-stop(0%, #777), color-stop(93%, #b3b3b3))',
        'background-color': '-moz-linear-gradient(top, #777 0%, #b3b3b3 93%)',
        'background-color': '-ms-linear-gradient(top, #777 0%, #b3b3b3 93%)',
        'background-color': 'linear-gradient(to bottom, #777 0%, #b3b3b3 93%)',
        'cursor':'pointer'
    });
});

$(document).on('mouseleave','.btn-admin',function(){
    $(this).css({'background-color' : '#f1ecec'});
});
$(document).on('click','.maj-Gkeywords', function (){
    var textarea = $(this).parent().children('textarea');
    sendAjax('ajax/dialog',function(data){
        $(data).dialog({
            modal : true,
            buttons : {
                "Oui" : function(){
                    var t = $(this);
                    sendAjax('ajax/saveElement',(function(data,textStatus,jqXHR){
                        t.dialog('close');
                        var d = '<div>Enregistrement réussi !!</div>';
                        $(d).dialog({
                            modal : true,
                            buttons : {
                                "Close" : function(){
                                    $(this).dialog("close");
                                }
                            }
                        });
                    })(t),{'lien': 'GkeywordsAdmin', 'textarea': textarea.serialize()});
                },
                "Non" : function(){
                    $(this).dialog("close");
                }
            }
        });
    },{ 'element' : 'GkeywordsAdmin'});

});
$(document).on('click','.maj',function(){

    var id = $(this).parent().children('input');
    var input = $(this).parent().children('section').children('article').children('input');
    var textarea = null;
    if ( $(this).parent().children('section').children('article').children('textarea').length > 0)
    {
        textarea = $(this).parent().children('section').children('article').children('textarea');
    }
    sendAjax('ajax/dialog',function(data){
        $(data).dialog({
            modal : true,
            buttons : {
                "Oui" : function(){
                    var t = $(this);
                    if (textarea == null)
                    {
                        var donnee = {'id' : id.val(), 'lien': lien, 'input' : input.serialize(), 'textarea': null}
                    }else
                    {
                        var donnee = {'id' : id.val(), 'lien': lien, 'input' : input.serialize(), 'textarea': textarea.serialize()}
                    }

                    sendAjax('ajax/saveElement',(function(data,textStatus,jqXHR){
                        t.dialog('close');
                        var d = '<div>Enregistrement réussi !!</div>';
                        $(d).dialog({
                            modal : true,
                            buttons : {
                                "Close" : function(){
                                    $(this).dialog("close");
                                }
                            }
                        });
                    }) (t), donnee);
                },
                "Non" : function(){
                    $(this).dialog("close");
                }
            }
        });
    },{ 'dialog' : 'modifElement', 'element' : lien});
});

$(document).on('click','.sup',function(){
    var elem = $(this).parent();
    sendAjax('ajax/dialog', function (data){
        $(data).dialog({
            modal : true,
            buttons : {
                "oui" : function (){
                    var t = $(this);
                    sendAjax('ajax/deleteElement', function (data){
                        t.dialog("close");
                        elem.remove();
                        var d = '<div>Suppression réussi !!</div>';
                        $(d).dialog({
                            modal : true,
                            buttons :{
                                "close" : function (){
                                    $(this).dialog("close");
                                }
                            }
                        });
                    }(t),{ 'id' : elem.children('input').val(), 'lien' : lien});
                },
                "Non" : function(){
                    $(this).dialog("close");
                }
            }
        });
    },{ 'dialog' : 'deleteElement', 'element' : lien});
});
