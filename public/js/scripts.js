var $j = jQuery;

$j(document).ready(function () {
    $j( "body" ).append('<div class="custom-cursor"><span id="cmain"></span><span id="cfollow"></span></div>');
    $j("a, button").addClass( "browser-window__link" );

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
        x: this.clientX - this.outerCursorBox.width / 2,
        y: this.clientY - this.outerCursorBox.height / 2
      });
      setTimeout(() => {
        this.outerCursorSpeed = 0.2;
      }, 100);
      this.showCursor = true;
    };
    document.addEventListener("mousemove", unveilCursor);

    document.addEventListener("mousemove", e => {
      this.clientX = e.clientX;
      this.clientY = e.clientY;
    });

    const render = () => {
      TweenMax.set(this.innerCursor, {
        x: this.clientX,
        y: this.clientY
      });
      if (!this.isStuck) {
        TweenMax.to(this.outerCursor, this.outerCursorSpeed, {
          x: this.clientX - this.outerCursorBox.width / 2,
          y: this.clientY - this.outerCursorBox.height / 2
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
        x: box.left + ( ( box.width / 2 ) - 50 ),
        y: box.top + (( box.height / 2 ) - 50),
        width: 100,
        height: 100,
        opacity: 0.6,
        borderColor: "#cd2653"
      });
    };

    const handleMouseLeave = () => {
      this.isStuck = false;
      TweenMax.to(this.outerCursor, 0.2, {
        width: this.outerCursorOriginals.width,
        height: this.outerCursorOriginals.width,
        opacity: 0.4,
        borderColor: "#cd2653"
      });
    };

    const linkItems = document.querySelectorAll(".browser-window__link");

    linkItems.forEach(item => {
      item.addEventListener("mouseenter", handleMouseEnter);
      item.addEventListener("mouseleave", handleMouseLeave);
    });

    const mainNavHoverTween = TweenMax.to(this.outerCursor, 0.3, {
      backgroundColor: "#ffffff",
      ease: this.easing,
      paused: true
    });

    const mainNavMouseEnter = () => {
      this.outerCursorSpeed = 0;
      TweenMax.set(this.innerCursor, { opacity: 0 });
      mainNavHoverTween.play();
    };

    const mainNavMouseLeave = () => {
      this.outerCursorSpeed = 0.2;
      TweenMax.set(this.innerCursor, { opacity: 1 });
      mainNavHoverTween.reverse();
    };

    const mainNavLinks = document.querySelectorAll(".content--fixed a");
    mainNavLinks.forEach(item => {
      item.addEventListener("mouseenter", mainNavMouseEnter);
      item.addEventListener("mouseleave", mainNavMouseLeave);
    });
  }
}