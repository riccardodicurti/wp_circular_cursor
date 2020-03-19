var $j = jQuery;

$j(document).ready(function () {
    $j( "body" ).append('<div class="custom-cursor"><span id="cmain"></span><span id="cfollow"></span></div>');
    $j("a, button").addClass( "browser-window__link" );

    $j('#cmain').css({ 
      backgroundColor: options.col_prima_pallina, 
      width: ( options.dim_prima_pallina ), 
      height: ( options.dim_prima_pallina ), 
      zIndex: ( options.zindex ),
      top: (( options.dim_seconda_pallina / 2 ) - ( options.dim_prima_pallina / 2)),
      left: (( options.dim_seconda_pallina / 2 ) - ( options.dim_prima_pallina / 2))
    });

    $j('#cfollow').css({ 
      borderColor: options.col_seconda_pallina, 
      width: ( options.dim_seconda_pallina ), 
      height: ( options.dim_seconda_pallina ), 
      zIndex: ( options.zindex - 1 ),
      // top: ( options.dim_seconda_pallina / 4 ),
      // left: ( options.dim_seconda_pallina / 4 )
    });

    const demo3 = new Demo3();

    console.log(demo3);
});

/**
 * demo.js
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright 2019, Codrops
 * http://www.codrops.com
 */

class Demo3 {
  constructor() {
    this.initCursor();
    this.initHovers();
  }

  initCursor() {
    const { Back } = window;
    this.outerCursor = document.querySelector("#cfollow");
    this.innerCursor = document.querySelector("#cmain");
    this.outerCursorBox = this.outerCursor.getBoundingClientRect();
    this.outerCursorSpeed = 0;
    this.easing = Back.easeOut.config(1.7);
    this.clientX = -100;
    this.clientY = -100;
    this.showCursor = false;

    const unveilCursor = () => {
      TweenMax.set(this.innerCursor, {
        x: this.clientX,
        y: this.clientY 
      });
      TweenMax.set(this.outerCursor, {
        x: this.clientX,
        y: this.clientY
      });
      setTimeout(() => {
        this.outerCursorSpeed = options.vel_seconda_pallina / 1000;
      }, 100);
      this.showCursor = true;
    };
    document.addEventListener("mousemove", unveilCursor);

    document.addEventListener("mousemove", e => {
      this.clientX = e.clientX - ( options.dim_prima_pallina / 2 );
      this.clientY = e.clientY - ( options.dim_prima_pallina / 2 );
    });

    const render = () => {
      TweenMax.set(this.innerCursor, {
        x: this.clientX,
        y: this.clientY
      });
      if (!this.isStuck) {
        TweenMax.to(this.outerCursor, this.outerCursorSpeed, {
          x: this.clientX,
          y: this.clientY
        });
      }
      if (this.showCursor) {
        document.removeEventListener("mousemove", unveilCursor);
      }
      requestAnimationFrame(render);
    };
    requestAnimationFrame(render);
  }

  initHovers() {
    const handleMouseEnter = e => {
      this.isStuck = true;
      const target = e.currentTarget;
      const box = target.getBoundingClientRect();
      this.outerCursorOriginals = {
        width: this.outerCursorBox.width,
        height: this.outerCursorBox.height
      };
      TweenMax.to(this.outerCursor, 0.2, {
        x: box.left + ( ( box.width / 2 ) - ( options.dim_seconda_pallina * options.multi_seconda_pallina / 2 )),
        y: box.top + (( box.height / 2 ) - ( options.dim_seconda_pallina * options.multi_seconda_pallina / 2 )),
        width: ( options.dim_seconda_pallina * options.multi_seconda_pallina ),
        height: ( options.dim_seconda_pallina * options.multi_seconda_pallina ),
        opacity: 0.6,
        borderColor: options.col_seconda_pallina
      });
    };

    const handleMouseLeave = () => {
      this.isStuck = false;
      TweenMax.to(this.outerCursor, 0.2, {
        width: this.outerCursorOriginals.width,
        height: this.outerCursorOriginals.width,
        opacity: 0.4,
        borderColor: options.col_seconda_pallina
      });
    };

    const linkItems = document.querySelectorAll(".browser-window__link");

    linkItems.forEach(item => {
      item.addEventListener("mouseenter", handleMouseEnter);
      item.addEventListener("mouseleave", handleMouseLeave);
    });
  }
}