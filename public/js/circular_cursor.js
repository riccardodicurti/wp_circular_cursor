var dimensione = options.dim_seconda_pallina / 2;
var $j = jQuery;

$j(document).ready(function () {
  $j( "body" ).append('<div class="custom-cursor"><span id="cmain"></span><span id="cfollow"></span></div>');
});

$j(document)
  .mousemove(function(e) {
    $j('#cmain')
      .css({
        left: e.clientX - (options.dim_prima_pallina / 2),
        top: e.clientY - (options.dim_prima_pallina / 2)
      });
    setTimeout(function() {
      $j('#cfollow')
        .css({
          left: e.clientX - dimensione,
          top: e.clientY - dimensione
        });
    }, options.vel_seconda_pallina);
});

$j(document).ready(function () {
  $j("a").addClass( "hover" );

  $j(".hover").mouseenter(function(e) {
      // $j('.custom-cursor').addClass( "hover--reg" );
      $j('.custom-cursor #cfollow').css({'transform': 'scale(' + options.multi_seconda_pallina + ')'});
      dimensione = options.dim_seconda_pallina / 2;
  });

  $j(".hover").mouseleave(function(){
      // $j('.custom-cursor').removeClass( "hover--reg" );
      $j('.custom-cursor #cfollow').css({'transform': 'auto'});      
      dimensione = options.dim_seconda_pallina / 2;
  });

  $j('#cmain').css({ backgroundColor: options.col_prima_pallina, width: options.dim_prima_pallina, height: options.dim_prima_pallina });
  $j('#cfollow').css({ backgroundColor: options.col_seconda_pallina, width: options.dim_seconda_pallina, height: options.dim_seconda_pallina });

  // $j('#cfollow').css({'background-color': 'white !important'});

  // console.log($j('.hover--reg #cfollow').css({'transform': 'scale(12) !important'}));


  if (options.numero_di_palline == 1) {
    $j('#cfollow').hide();
  }

  if (options.cursore) {
    $j('*').css('cursor', 'none');
  } else {
    $j('*').css('cursor', 'auto');
  }
});
