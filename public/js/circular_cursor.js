var dimensione = 6;
var $j = jQuery;

$j(document).ready(function () {
  $j( "body" ).append('<div class="custom-cursor"><span id="cmain"></span><span id="cfollow"></span></div>');
});

$j(document)
  .mousemove(function(e) {
    $j('#cmain')
      .css({
        left: e.clientX - 6,
        top: e.clientY - 6
      });
    setTimeout(function() {
      $j('#cfollow')
        .css({
          left: e.clientX - dimensione,
          top: e.clientY - dimensione
        });
    }, 100);
});

$j(document).ready(function () {
  $j("a").addClass( "hover" );

  $j(".hover").mouseenter(function(e) {
      $j('.custom-cursor').addClass( "hover--reg" );
      dimensione = 6;
  });

  $j(".hover").mouseleave(function(){
      $j('.custom-cursor').removeClass( "hover--reg" );
      dimensione = 6;
  });
});
