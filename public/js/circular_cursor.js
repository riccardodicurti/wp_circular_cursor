// var dimensione_seconda_pallina = ( options.dim_seconda_pallina * options.multi_seconda_pallina ) / 2;
var scale_seconda_pallina = options.multi_seconda_pallina / 100;

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
          left: e.clientX - ( options.dim_seconda_pallina * options.multi_seconda_pallina ) / 2,
          top: e.clientY - ( options.dim_seconda_pallina * options.multi_seconda_pallina ) / 2
        });
    }, options.vel_seconda_pallina);
});

$j(document).ready(function () {
  $j("a, input").addClass( "hover" );
  $j(".hover").mouseenter(function(e) {
      $j('.custom-cursor #cfollow').css({
        transform:       'scale(' + 1 + ')',        
        WebkitTransform: 'scale(' + 1 + ')',
        MozTransform:    'scale(' + 1 + ')',
        OTransform:      'scale(' + 1 + ')',
        msTransform:     'scale(' + 1 + ')'

      });
  });

  $j(".hover").mouseleave(function(){
      $j('.custom-cursor #cfollow').css({
        transform:       'scale(' + scale_seconda_pallina + ')',        
        WebkitTransform: 'scale(' + scale_seconda_pallina + ')',
        MozTransform:    'scale(' + scale_seconda_pallina + ')',
        OTransform:      'scale(' + scale_seconda_pallina + ')',
        msTransform:     'scale(' + scale_seconda_pallina + ')'
      });
  });

  $j('#cmain').css({ 
    backgroundColor: options.col_prima_pallina, 
    width: options.dim_prima_pallina, 
    height: options.dim_prima_pallina, 
    zIndex: options.zindex 
  });

  $j('#cfollow').css({ 
    backgroundColor: options.col_seconda_pallina, 
    width: ( options.dim_seconda_pallina * options.multi_seconda_pallina ), 
    height: ( options.dim_seconda_pallina * options.multi_seconda_pallina ), 
    zIndex: ( options.zindex - 1 ), 
    transform: 'scale(' + scale_seconda_pallina + ')'
  });

  if (options.numero_di_palline == 1) {
    $j('#cfollow').hide();
  }

  if (options.cursore) {
    $j('*').css('cursor', 'none');
  } else {
    $j('*').css('cursor', 'auto');
  }
});
