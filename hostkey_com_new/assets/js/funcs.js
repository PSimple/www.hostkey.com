$(document).ready(function() {   
    $('.combox_block').enscroll();
    //$(".popup_combox").customScrollbar();
    $.extend($.scrollTo.defaults, {
      axis: 'y',
      duration: 1000
    });
    
    var home = 0;
    var why = 582;
    var service = 2555;
    var opportunities = 3040;
    var datacenters = 3524;
    var bothers = 4282;
    var contacts = 4751;
    var end = 5000;
    var clicked = false;

    $('.header_menu .links a').click(function(){
        clicked = true;
        $('.header_menu .links a').removeClass('sel');
        $(this).addClass('sel');
        var href = $(this).attr('href');
        if(href == '#home'){ $.scrollTo(home+'px'); }
        if(href == '#why'){ $.scrollTo(why+'px'); }    
        if(href == '#service'){ $.scrollTo(service+'px'); }    
        if(href == '#opportunities'){ $.scrollTo(opportunities+'px'); }   
        if(href == '#datacenters'){ $.scrollTo(datacenters+'px'); }    
        if(href == '#bothers'){ $.scrollTo(bothers+'px'); }    
        if(href == '#contacts'){ $.scrollTo(contacts+'px'); }
        return false;
    });
    
    $(document).scroll(function(){
        clearTimeout($.data(this, 'scrollTimer'));
        $.data(this, 'scrollTimer', setTimeout(function() {
            clicked = false;
        }, 250));
        
        if(clicked == false){
            var screenHeight = $(window).height();
            var contactsHeightAndFooter = 647;
            var diff = screenHeight-contactsHeightAndFooter;
            var scroll = $(window).scrollTop();
            var target = '#home';
            var contactsFinal = contacts;        
            var endFinal = end;  
                  
            if(diff > 0){ contactsFinal = contacts-diff; endFinal = end-diff; }        
            if(scroll >= home && scroll < why){ target = '#home'; }
            if(scroll >= why && scroll < service){ target = '#why'; }
            if(scroll >= service && scroll < opportunities){ target = '#service'; }
            if(scroll >= opportunities && scroll < datacenters){ target = '#opportunities'; }
            if(scroll >= datacenters && scroll < bothers){ target = '#datacenters'; }
            if(scroll >= bothers && scroll < contactsFinal){ target = '#bothers'; }
            if(scroll >= contactsFinal && scroll < endFinal){ target = '#contacts'; }
            
            $('.header_menu .links a').removeClass('sel');
            $('.header_menu .links a[href='+target+']').addClass('sel');
        }
    });
    $('.header_menu .logo a, #footer > a').click(function(){ $.scrollTo(home); return false; });
    $('#home a.arr_d').click(function(){ $.scrollTo(why); return false; });
    
    $('.callback').click(function(){
        $('#bgJS').show();
        $('.popup_callback').show();
        return false;
    });
    
    $('.datacenters').click(function(){
        $('#bgJS').show();
        $('.popup_datacenters').show();
        return false;
    });
    
    $('.bothers_more').click(function(){
        $('#bgJS').show();
        $('.popup_bothers').show();
        return false;
    });  
      
    $('.popup .close, #bgJS').click(function(){
        $('#bgJS').hide();
        $('.popup').hide();
        return false;
    });
    
    $('.tabs a').click(function(){
        $('.tabs a').removeClass('tab_sel');
        $('.html_tab').hide();
        var tabid = $(this).attr('class');
        $(this).addClass('tab_sel');
        $('.html_'+tabid).show();
        return false;
    });
    
    $('.popup_callback .combox').click(function(){
        if($('.popup_combox').css('display') == 'none'){ $('.popup_combox').show(); }
        else { $('.popup_combox').hide(); }
        return false;
    });
    
    $('.combox_block a').click(function(){
        var code = $(this).data('code');
        $('.div2 input:first-of-type').val(code);
        $('.popup_combox').hide();
        return false;
    });
    
    $('#callback_btn').click(function(){
        var error = false;     
        var name = $('#callback_name').val();
        var code = $('#callback_code').val();
        var phone = $('#callback_nr').val();
        var skype = $('#callback_skype').val();    
        $(".popup_callback .callback_div input").removeClass('error');       
        
        $(".popup_callback .callback_div input").each(function(){
            if($(this).attr('required') == 'required' && ($(this).val() == '' || $(this).text())){
                $(this).addClass('error');
                error = true;
            }
        }); 
        
        if(error == false){
            $('#bgJS').hide(); $('.popup').hide(); $(".popup_callback .callback_div input").val('');
        }
        return false;
    });
    
    $(document).keyup(function(e) { if (e.keyCode == 27) { $('#bgJS').hide(); $('.popup').hide(); } });
});