jQuery(document).ready(function($) {
    $('#wg24themeoptionpanel_body_google_font_prallax_face').change(function(){ 
        var bodygolefont = $("option:selected", this).val();
        var bodygolefontid = bodygolefont.split(':');
        if ($('head').find('link#bodygolefontl').length < 1){
            $('head').append('<link id="bodygolefontl" href="" type="text/css" rel="stylesheet"/>');
        }
        $('link#bodygolefontl').attr({
            href:'http://fonts.googleapis.com/css?family=' + bodygolefontid
            }); 
        $("style#bodygolefontdemo").remove();
        $('head').append('<style id="bodygolefontdemo" type="text/css">#live_show_googl_font h4{ font-family:' + bodygolefont + ' !important; }</style>'); 
    }); 
    $('#wg24themeoptionpanel_body_sy_font_prallax_face').change(function(){ 
        var  bodysystfont = $("option:selected", this).val();
        $("style#bodysystfontdemo").remove();
        $('head').append('<style id="bodysystfontdemo"  type="text/css">#live_show_system_font h4{ font-family:' + bodysystfont + ' !important; }</style>'); 
    });  

    /* heading font */

    $('#wg24themeoptionpanel_heders_gol_font_prallax_face').change(function(){ 
        var headinggolefont = $("option:selected", this).val();
        var idheadinggolefont = headinggolefont.split(':');
        if ($('head').find('link#hedinggolefontdemo').length < 1){
            $('head').append('<link id="hedinggolefontdemo" href="" type="text/css" rel="stylesheet"/>');
        }
        $('link#hedinggolefontdemo').attr({
            href:'http://fonts.googleapis.com/css?family=' + idheadinggolefont
            }); 
        $("style#hedinggolefontdemo2").remove();
        $('head').append('<style id="hedinggolefontdemo2" type="text/css">#live_show_system_font h4{ font-family:' + headinggolefont + ' !important; }</style>'); 
    }); 
    $('#wg24themeoptionpanel_heders_sys_font_prallax_face').change(function(){ 
        var headingsystfont = $("option:selected", this).val();
        $("style#headingsystfontdemo").remove();
        $('head').append('<style id="headingsystfontdemo"  type="text/css">#live_show_system_font h4{ font-family:' + headingsystfont + ' !important; }</style>'); 
    });  
                 

}); 
$(document).ready(function () {

    var bodygolefont = $('#wg24themeoptionpanel_body_google_font_prallax_face').val();
    var bodygolefontid = bodygolefont.split(':');
    if ($('head').find('link#bodygolefontl').length < 1){
        $('head').append('<link id="bodygolefontl" href="" type="text/css" rel="stylesheet"/>');
    }
    $('link#bodygolefontl').attr({
        href:'http://fonts.googleapis.com/css?family=' + bodygolefontid
        }); 
    $("style#bodygolefontdemo").remove();
    $('head').append('<style id="bodygolefontdemo" type="text/css">#live_show_googl_font h4{ font-family:' + bodygolefont + ' !important; }</style>'); 

    var  bodysystfont= $('#wg24themeoptionpanel_body_sy_font_prallax_face').val();    
    $("style#bodysystfontdemo").remove();
    $('head').append('<style id="bodysystfontdemo"  type="text/css">#live_show_system_font h4{ font-family:' + bodysystfont + ' !important; }</style>'); 
         
         
    /* heading font  */
    var headinggolefont = $('#wg24themeoptionpanel_heders_gol_font_prallax_face').val();
    var idheadinggolefont = headinggolefont.split(':');
    if ($('head').find('link#hedinggolefontdemo').length < 1){
        $('head').append('<link id="hedinggolefontdemo" href="" type="text/css" rel="stylesheet"/>');
    }
    $('link#hedinggolefontdemo').attr({
        href:'http://fonts.googleapis.com/css?family=' + idheadinggolefont
        }); 
    $("style#hedinggolefontdemo2").remove();
    $('head').append('<style id="hedinggolefontdemo2" type="text/css">##live_show_system_font h4{ font-family:' + headinggolefont + ' !important; }</style>'); 


    var headingsystfont =$('#wg24themeoptionpanel_heders_sys_font_prallax_face').val();    
    $("style#headingsystfontdemo").remove();
    $('head').append('<style id="headingsystfontdemo"  type="text/css">#live_show_system_font h4{ font-family:' + headingsystfont + ' !important; }</style>');
});
        

        
                
              