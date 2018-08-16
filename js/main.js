jQuery(document).ready(function($) {

	'use strict';

    // Cache selectors
    var lastId,
        topMenu = $(".menu-first"),
        topMenuHeight = 30,
        menuItems = topMenu.find("a"),
        scrollItems = menuItems.map(function(){
          
          if($(this).hasClass('external')) {
            return;
          }
            
          var item = $($(this).attr("href"));
          if (item.length) { return item; }
        });

   
    menuItems.click(function(e){
      var href = $(this).attr("href"),
          offsetTop = href === "#" ? 0 : $(href).offset().top-topMenuHeight;
      $('html, body').stop().animate({ 
          scrollTop: offsetTop
      }, 300);
      e.preventDefault();
    });


    $('.flexslider').flexslider({
      slideshow: true,
      slideshowSpeed: 3000,  
      animation: "fade",
      directionNav: false,
    });


    $('.toggle-menu').click(function(){
        $('.menu-first').toggleClass('show');
        // $('.menu-first').slideToggle();
    });

    $('.menu-first li a').click(function(){
      $('.menu-first').removeClass('show');
    });



});

(function($) {
    //lorsque l'on rempli un des deux champs
    $('.filtre input').keyup(function(event){
        
        // on affiche toutes les annonces
        $('.annonce').show();

        // On cache celles dont le titre ne correspond pas à la recherche
        $('#barreRecherche').each(function(){
            var input = $(this);
            var val = input.val();
            
        // on ne cherche pas seulement les titres qui contiennent exactement la chaine 
        // mais aussi ceux qui contiennent les lettres dans l'ordre de la recherche
        // Par exemple "mdl" trouvera "modal"
            
            // on créer l'expression régulière
            var regexp = '\\b(.*)';
            for(var i in val){
                regexp += '('+val[i]+')(.*)';
            }
            regexp+= '\\b';
            $('.annonce h3 a').each(function(){
                var titre =$(this);
                var resultats = titre.text().match(new RegExp(regexp, 'i'));
                if(resultats){
                }
                else{
                    titre.parent().parent().parent().parent().parent().hide();
                }
            });
        });
        
        // on cache celles dont le prix est inférieur au prix minimum
        $('#barrePrixMin').each(function(){
            var input = $(this);
            var val = input.val();
            var pmin = parseInt(val,10);
            
            if(val != ''){
                $('.annonce p a').each(function(){
                    var prixstring = $(this).text();
                    var prix = parseInt(prixstring,10);
                    if(prix < pmin){
                        $(this).parent().parent().parent().parent().parent().hide();
                    }
                });
            }
           
        });
        
        // on cache celles dont le prix est supérieur au prix maximum 
        $('#barrePrixMax').each(function(){
            var input = $(this);
            var val = input.val();
            var pmax = parseInt(val,10);
        
            if(val != ''){
                $('.annonce p a').each(function(){
                    var prixstring = $(this).text();
                    var prix = parseInt(prixstring,10);
                    if(prix > pmax){
                        $(this).parent().parent().parent().parent().parent().hide();
                    }
                });
            }
            
        });
        
        // on cache celles dont la catégorie ne correspond pas aux catégories cochées
        $('.categories').each(function(){
            var val = $(this).is(':checked');
            if($(this).is(':checked') == false){
                var val = $(this).val();
                $('.annonce span').each(function(){
                    var cat = $(this).text();
                    if(cat == val){
                         $(this).parent().parent().parent().parent().hide();
                    }
                });
            }
        });
        
        // On compte le nombre d'annonces qui ne sont pas cachées et on l'affiche
        $('#nbannonce').each(function(){
            var nb = $('.annonce:visible').size();
            if(nb==0){
                $(this).html("Oups, aucune annonce ne correspond à votre recherche...");
            }
            else{
                if(nb== 1){
                    $(this).html("1 annonce correspond à votre recherche");
                }
                else{
                    $(this).html(nb+" annonces correspondent à votre recherche");
                }
            }
        });
        
    });
    
    
    // si on coche ou décoche une catégorie
    $('.filtre input').click(function(event){
        
        // on affiche toutes les annonces
        $('.annonce').show();

        //On cache celles dont le titre ne correspond pas à la recherche
        $('#barreRecherche').each(function(){
            var input = $(this);
            var val = input.val();
            
            // on ne cherche pas seulement les titres qui contiennent exactement la chaine 
            // mais aussi ceux qui contiennent les lettres dans l'ordre de la recherche
            // Par exemple "mdl" trouvera "modal"
            
            // on créer l'expression régulière
            var regexp = '\\b(.*)';
            for(var i in val){
                regexp += '('+val[i]+')(.*)';
            }
            regexp+= '\\b';
            $('.annonce h3 a').each(function(){
                var titre =$(this);
                var resultats = titre.text().match(new RegExp(regexp, 'i'));
                if(resultats){
                }
                else{
                    titre.parent().parent().parent().parent().parent().hide();
                }
            });
        });
        
        // on cache celles dont le prix est inférieur au prix minimum
        $('#barrePrixMin').each(function(){
            var input = $(this);
            var val = input.val();
            var pmin = parseInt(val,10);
            
            if(val != ''){
                $('.annonce p a').each(function(){
                    var prixstring = $(this).text();
                    var prix = parseInt(prixstring,10);
                    if(prix < pmin){
                        $(this).parent().parent().parent().parent().parent().hide();
                    }
                });
            }
           
        });
        
        // on cache celles dont le prix est supérieur au prix maximum 
        $('#barrePrixMax').each(function(){
            var input = $(this);
            var val = input.val();
            var pmax = parseInt(val,10);
        
            if(val != ''){
                $('.annonce p a').each(function(){
                    var prixstring = $(this).text();
                    var prix = parseInt(prixstring,10);
                    if(prix > pmax){
                        $(this).parent().parent().parent().parent().parent().hide();
                    }
                });
            }
            
        });
        
        // on cache celles dont la catégorie ne correspond pas aux catégories cochées
        $('.categories').each(function(){
            var val = $(this).is(':checked');
            if($(this).is(':checked') == false){
                var val = $(this).val();
                $('.annonce span').each(function(){
                    var cat = $(this).text();
                    if(cat == val){
                         $(this).parent().parent().parent().parent().hide();
                    }
                });
            }
        });
        
        // On compte le nombre d'annonces qui ne sont pas cachées et on l'affiche
        $('#nbannonce').each(function(){
            var nb = $('.annonce:visible').size();
            if(nb==0){
                $(this).html("Oups, aucune annonce ne correspond à votre recherche...");
            }
            else{
                if(nb== 1){
                    $(this).html("1 annonce correspond à votre recherche");
                }
                else{
                    $(this).html(nb+" annonces correspondent à votre recherche");
                }
            }
        });
        
    });
    
    $('#nbannonce').each(function(){
        var nb = $('.annonce:visible').size();
        if(nb==0){
            $(this).html("Oups, aucune annonce ne correspond à votre recherche...");
        }
        else{
            if(nb== 1){
                $(this).html("1 annonce correspond à votre recherche");
            }
            else{
                $(this).html(nb+" annonces correspondent à votre recherche");
            }
        }
    });
})(jQuery);
