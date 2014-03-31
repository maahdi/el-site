
$(window).ready(function(){
    $('#slider').nivoSlider(
    {
        effect: 'fade',
        slices : 15,
        animSpeed:550,
        pauseTime:4000,
        directionNav : true,
        pauseOnHover : false,
        directionNavHide: true,
        captionOpacity: 1,
        prevText:'<',
        nextText:'>'
    });


    $('.sectionAdmin').mouseover(function(){
        cssBtnAdmin($(this));
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
    }, {'lien' : lien });
}

function getAdminContent(lien)
{
    var url = makeUrl();
    var donnee = { 'lien' : lien};
    if (lien == 'sliderAdmin')
    {
        sendAjax('ajax/adminContentStructure', function (data){
            $('.contentI').append(data);
            $.getJSON(url[0]+"ajax/adminContent", donnee, function (data){
                var article = null;
                var imgStruct = data.struct;
                if (data.active != null)
                {
                    $.each(data.active, function(key, value){
                        article = imgStruct.replace("%dossier%", "active");
                        article = article.replace("%imgUrl%", value);
                        article = article.replace("%imgUrl%", value);
                        $('.sliderActiveAdmin').append(article);
                    });
                }
                article = null;
                if (data.inactive != null)
                {
                    $.each(data.inactive, function (key,value){
                        article = imgStruct.replace("%dossier%", "inactive");
                        article = article.replace("%imgUrl%", value);
                        article = article.replace("%imgUrl%", value);
                        $('.sliderInactiveAdmin').append(article);
                    });
                
                }
            article = null;
            });
        }, {'lien' : lien });
    }else{
        if (lien == 'pagesAdmin')
        {
            sendAjax('ajax/adminContentStructure', function (data){
                $('.contentI').append(data);
            }, { 'lien' : 'GkeywordsAdmin' });
            setTimeout(500);
        
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
                            article = contentStructure.replace(value, val[tmp[1]]);
                        }else
                        {
                            article = article.replace(value, val[tmp[1]]);
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
    }
}

function scroll(id)
{
    $('html, body').animate({ scrollTop : $(id).offset().top}, 800);
    return false;
}

$(document).on('mouseover','.btn-menuI',function(){
    cssBtnAdmin($(this));
});

$(document).on('mouseleave','.btn-menuI',function(){
    $(this).css({'background-color' : '#f1ecec'});
});

$(document).on('mouseleave','.btn-logo',function(){
    $(this).css({'background-color' : '#f1ecec'});
});
$(document).on('mouseleave','.btn-slider',function(){
    $(this).css({'background-color' : '#f1ecec'});
});

$(document).on('mouseover', '.btn-slider', function(){
    cssBtnAdmin($(this));
})
$(document).on('mouseover','.btn-logo',function(){
    cssBtnAdmin($(this));
});
function cssBtnAdmin(bouton)
{
    bouton.css(
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

}

$(document).on('mouseover','.btn-admin',function(){
    cssBtnAdmin($(this));
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

    var id = $(this).parent().parent().children('input');
    var input = $(this).parent().parent().children('section').children('article').children('input');
    var textarea = null;
    if ( $(this).parent().parent().children('section').children('article').children('textarea').length > 0)
    {
        textarea = $(this).parent().parent().children('section').children('article').children('textarea');
    }
    sendAjax('ajax/dialog',function(data){
        $(data).dialog({
            modal : true,
            buttons : {
                "Oui" : function(){
                    var t = $(this);
                    if (lien == 'sliderAdmin')
                    {
                        var donnee = { 'lien' : lien };
                        var active = new Array;
                        var inactive = new Array;
                        $('.sliderActiveAdmin').children('article').each(function(key){
                            active[key] =  $(this).children('input[type="hidden"]').first().val();
                        });
                        if (active.length == 0)
                        {
                            active = 0;
                        }
                        donnee['active'] = active;
                        active = null;
                        $('.sliderInactiveAdmin').children('article').each(function(key){
                            inactive[key] = $(this).children('input[type="hidden"]').first().val();
                        });
                        donnee['inactive'] = inactive;
                        inactive = null;
                    }else if (textarea == null)
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
    },{ 'dialog' : 'modifElement', 'lien' : lien});
});

function openWindow(button, action, width, height)
{
    var id = $(button).parent().children('input[type="hidden"]').first().val();
    $.ajax({
        type : 'POST',
        url : 'http://localhost/workspace/framework/web/app_dev.php/'+action,
        data : { 'id' : id },
        success : function (data){
            var html = '<div>'+data+'</div>';
            $(html).dialog({
                modal : true,
                buttons :{
                    "Fermer":  function (){
                        $(this).dialog("close");
                    }
                },
                width : width,
                height : height
            });
        }
    });
}
$(document).on('click', '.up', function(){
    var active = $('.sliderActiveAdmin').children();
    var nbToMove = 0;
    var inactive = new Array;
    $('.sliderInactiveAdmin').children().children('input[type="checkbox"]').each(function(){
        if ($(this).attr('checked'))
        {
            inactive[nbToMove] = $(this).parent();
            nbToMove++;
        }
    });
    if ((active.length + nbToMove) > 4)
    {
        var nb = nbToMove - (4 - active.length);
        var div = '<div><p>Vous avez sélectionné '+ nb +' photo(s) de plus qu\'il n\'y a de place disponible pour le slider !!</p>'+
                    '<p>Veuillez désélectionner '+ nb +' photo(s)</p>';
        $(div).dialog({
            modal : true,
            buttons : {
                "Ok": function (){
                    $(this).dialog("close");
                }
            },
            width : "500",
            height : "250"
        });
    }else
    {
        $.each(inactive, function(){
            if ($(this).children('input[type="checkbox"]').attr('checked'))
            {
                $(this).children('input[type="checkbox"]').attr('checked', false);
                var html = '<article class="sliderImage">'+$(this).html()+'</article>';
                $('.sliderActiveAdmin').append(html);
                $(this).remove();
            }
        });
    }
});
$(document).on('click', '.upload', function(){
    sendAjax('ajax/dialog', function (data){
        $(data).dialog({
            modal : true,
            buttons : {
                "Fermer" : function (){
                    $(this).dialog("close");
                }
            },
            width : "500",
            height : "250",
        })
    },{ 'lien' : lien, 'dialog' : 'imagesUpload' });
});

$(document).on('click', '.del', function (){
    sendAjax('ajax/dialog' , function (data){
        $(data).dialog({
            modal : true,
            buttons : {
                "Oui" : function (){
                    var png = new Array;
                    var i = null;
                    $('.sliderActiveAdmin').children().each(function (index){
                        if ($(this).children('input[type="checkbox"]').attr('checked'))
                        {
                            png[index] = $(this).children('input[type="hidden"]').first().val();
                            i = index;
                        }
                    });
                    $('.sliderInactiveAdmin').each(function (index){
                        if ($(this).children('input[type="checkbox"]').attr('checked'))
                        {
                            png[index+i] = $(this).children('input[type="hidden"]').first().val();
                        }
                    });
                    var dialog = $(this);
                    sendAjax('ajax/deleteImage', function (data){
                        dialog.dialog("close");
                        $('<div><p>Suppression réussi</p></div>').dialog({
                            modal : true,
                            buttons : {
                                "Close" : function (){
                                    $(this).dialog("close");
                                }
                            }
                        })
                    }, { 'lien' : lien, 'png' : png });
                },
                "Non" : function (){
                    $(this).dialog("close");
                }
            }
        });
    }, { 'lien' : lien, 'dialog' : 'deleteElement' });
});

$(document).on('click', '.down', function(){
    var nbActive = $('.sliderActiveAdmin').children();
    var nbToMove = 0;
    var active = new Array;
    $('.sliderActiveAdmin').children().children('input[type="checkbox"]').each(function(){
        if ($(this).attr('checked'))
        {
            active[nbToMove] = $(this).parent();
            nbToMove++;
        }
    });
    if((nbActive.length - nbToMove) < 1)
    {
        $('<div><p>Vous allez enlever toutes les images !!</p><p>Continuez ? :</p></div>').dialog({
            modal : true,
            buttons : {
                "oui" : function (){
                    $.each(active, function(){
                        if ($(this).children('input[type="checkbox"]').attr('checked'))
                        {
                            $(this).children('input[type="checkbox"]').attr('checked', false);
                            var html = '<article class="sliderImage">'+$(this).html()+'</article>';
                            $('.sliderInactiveAdmin').append(html);
                            $(this).remove();
                        }
                    });
                    $(this).dialog("close");
                },
                "non" : function (){
                    $(this).dialog("close");
                }
            },
            width : "300",
            height : "260"
        });
    }else
    {
        $.each(active, function(){
            if ($(this).children('input[type="checkbox"]').attr('checked'))
            {
                $(this).children('input[type="checkbox"]').attr('checked', false);
                var html = '<article class="sliderImage">'+$(this).html()+'</article>';
                $('.sliderInactiveAdmin').append(html);
                $(this).remove();
            }
        });
    }
});

$(document).on('click', '.sup', function(){
    var elem = $(this).parent().parent();
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
    },{ 'dialog' : 'deleteElement', 'lien' : lien});
});


$(document).on('click', '.add-btn', function (){
    var url = makeUrl();
    $.getJSON(url[0]+'ajax/addElement', { 'lien' : lien }, function (data){
        var elem = data;
        sendAjax('ajax/adminContentStructure',function (data){
            var structure = data;
            var tmpStruct = structure.match(/%[a-zA-Z]*%/g);
            var article = null;
            var i = 0;
            $.each(tmpStruct, function (key, value){
                var tmp = value.split("%");
                if (i == 0)
                {
                    article = structure.replace(value, elem[tmp[1]]);
                }else
                {
                    article = article.replace(value, elem[tmp[1]]);
                }
                i++;
            });
            $('.contentI').prepend(article);
            $('.datepickerDebut').datepicker({ maxDate : $('.datepickerFin').val(),
                                            dateFormat : "dd/mm/yy"});
            $('.datepickerFin').datepicker({ minDate : $('.datepickerDebut').val(),
                                            dateFormat : "dd/mm/yy"});
        },{'lien' : lien});
    
    });
});
var img = null;
$(document).on('click', '.modif', function(){
    var pngActuel = $(this).parent().children('figure').children('img').attr('src').match(/([a-zA-Z]+\-[a-zA-Z]+|[a-zA-Z]+)\.(png|jpg|jpeg)/);
    img = $(this).parent().children('figure').children('img');
    var id = $(this).parent().parent().parent().children('input');
    sendAjax('ajax/dialog', function (data){
        var galerie = data;
        $(galerie).dialog({
            width : "1000",
            height : "700",
            modal : true,
            buttons : {
                "Appliquer" : function (){
                    $('.imageDisplay').children('.logoGalerie').children('input[type="checkbox"]').each(function () {
                        if ($(this).attr('checked'))
                        {
                            var newPng = $(this).parent().children('input[type="hidden"]').val();
                            if (newPng != pngActuel[0])
                            {
                                sendAjax('ajax/saveImage', function (data){
                                    $('.adminMarqueLogo').children('img').each(function () {
                                        if ($(this).is(img))
                                        {
                                            $(this).attr('src',$(img).attr('src').replace(pngActuel[0], newPng));
                                        }
                                    })
                                }, { 'id' : id.val(), 'lien' : lien, 'newPng' : newPng});
                            }
                        }
                    });
                },
                "Fermer" : function (){
                    $(this).dialog("close");
                },
                "Supprimer" : function (){
                    $('<div><p>Ce bouton supprime l\'image sélectionnée dans la fenêtre précédente !!</p><p>Continuez ? :</p></div>').dialog({
                        buttons : {
                            "Oui" : function (){
                                var dialog = $(this);
                                $('.imageDisplay').children('.logoGalerie').children('input[type="checkbox"]').each(function () {
                                    if ($(this).attr('checked'))
                                    {
                                        var png = $(this).parent();
                                        var pngUrl = png.children('figure').children('img').first().attr('src').match(/([a-zA-Z]+\-([a-zA-Z]+|)|[a-zA-Z]+)\.(png|jpg|jpeg)/);
                                        sendAjax('ajax/deleteImage', function (data){
                                            png.remove();
                                            dialog.dialog("close");
                                        },{ 'lien' : lien, 'png' : pngUrl[0] });
                                    }
                                });
                            },
                            "Non" : function (){
                                $(this).dialog("close");
                            }
                        },
                        modal :  true
                    })
                }
            }
        });
        var url = makeUrl();
        var donnee = { 'lien' : lien };
        sendAjax('ajax/logoAdminStructure', function (data) {
            var structure = data;
            $.getJSON(url[0]+"ajax/imagesSearch", donnee, function (data){
                $.each(data, function (key,val){
                    var tmp = structure;
                    var article = null;
                    article = tmp.replace(/pngUrl/g, val);
                    $('.imageDisplay').append(article);
                    $('.imageDisplay').children('.logoGalerie').last().children('input[type="checkbox"]').attr('checked', (val == pngActuel[0]));
                });
            });
        }, { 'lien' : lien });
    }, { 'dialog' : 'images', 'lien' : lien});
});

$(document).on('click', 'input[type="checkbox"]', function (){
       if (lien == 'sliderAdmin'){
            if ($(this).attr('checked'))
            {
                $(this).removeAttr('checked');
            }else
            {
                $(this).attr('checked', true);
            }
        }else
        {
            if (!$(this).attr('checked'))
            {
                var elem = $(this);
                $('input[type="checkbox"]').each(function (){
                    if (!$(this).is(elem))
                    {
                        $(this).removeAttr('checked');
                    }else
                    {
                        $(this).attr('checked', true);
                    }
                });
            }
        }
});

function $m(theVar){
	return document.getElementById(theVar)
}
function remove(theVar){
	var theParent = theVar.parentNode;
	theParent.removeChild(theVar);
}
function addEvent(obj, evType, fn){
	if(obj.addEventListener)
	    obj.addEventListener(evType, fn, true)
	if(obj.attachEvent)
	    obj.attachEvent("on"+evType, fn)
}
function removeEvent(obj, type, fn){
	if(obj.detachEvent){
		obj.detachEvent('on'+type, fn);
	}else{
		obj.removeEventListener(type, fn, false);
	}
}
function isWebKit(){
	return RegExp(" AppleWebKit/").test(navigator.userAgent);
}
function ajaxUpload(form,url_action,id_element,html_show_loading,html_error_http){
	var detectWebKit = isWebKit();
	form = typeof(form)=="string"?$m(form):form;
	var erro="";
	if(form==null || typeof(form)=="undefined"){
		erro += "The form of 1st parameter does not exists.\n";
	}else if(form.nodeName.toLowerCase()!="form"){
		erro += "The form of 1st parameter its not a form.\n";
	}
	if($m(id_element)==null){
		erro += "The element of 3rd parameter does not exists.\n";
	}
	if(erro.length>0){
		alert("Error in call ajaxUpload:\n" + erro);
		return;
	}
	var iframe = document.createElement("iframe");
	iframe.setAttribute("id","ajax-temp");
	iframe.setAttribute("name","ajax-temp");
	iframe.setAttribute("width","0");
	iframe.setAttribute("height","0");
	iframe.setAttribute("border","0");
	iframe.setAttribute("style","width: 0; height: 0; border: none;");
	form.parentNode.appendChild(iframe);
	window.frames['ajax-temp'].name="ajax-temp";
	var doUpload = function(){
		removeEvent($m('ajax-temp'),"load", doUpload);
		var cross = "javascript: ";
		cross += "window.parent.$m('"+id_element+"').innerHTML = document.body.innerHTML; void(0);";
        $m(id_element).innerHTML = html_error_http;
        $m('ajax-temp').src = cross;
        if (lien == 'marquesAdmin')
        {
            sendAjax('ajax/logoAdminStructure', function (data){
                var src = $('#upload_area').children('img').last().attr('src');
                var pngUrl = src.match(/([a-zA-Z]+\-([a-zA-Z]+|)|[a-zA-Z]+)\.(png|jpg|jpeg)/);
                if (!(pngUrl == null))
                {
                    $('.imageDisplay').append(data);
                    $('.imageDisplay').children('.logoGalerie').last().children('.adminMarqueLogo').first().children('img').first().attr('src', src );
                    $('.imageDisplay').children('.logoGalerie').last().children('input[type="hidden"]').attr('value', pngUrl[0]);
                }
            }, { 'lien' : lien });
        }else if (lien == 'sliderAdmin')
        {
            setTimeout(function (){
                var src = $('#upload_area').children('img').last().attr('src');
                var pngUrl = src.match(/([a-zA-Z]+\-([a-zA-Z]+|)|[a-zA-Z]+)\.(png|jpg|jpeg)/);
                var newImg = $('.sliderImage').first().clone(true);
                newImg.children('figure').children('img').first().attr('src', src);
                newImg.children('input[type="hidden"]').attr('value', pngUrl[0]);
                var html = '<article class="sliderImage">'+newImg.html()+'</article>';
                $('.sliderInactiveAdmin').append(html);
            }, 250);
        }
		if(detectWebKit){
        	remove($m('ajax-temp'));
        }else{
        	setTimeout(function(){ remove($m('ajax-temp'))}, 250);
        }
    }
    var url = makeUrl();
	addEvent($m('ajax-temp'),"load", doUpload);
	form.setAttribute("target","ajax-temp");
	form.setAttribute("action",url[0]+url_action+'?lien='+lien);
	form.setAttribute("method","post");
	form.setAttribute("enctype","multipart/form-data");
	form.setAttribute("encoding","multipart/form-data");
	form.submit();
	if(html_show_loading.length > 0){
		$m(id_element).innerHTML = html_show_loading;
	}
}
