/**
 * Dermatex site scripts (no dependencies).
 * - Hero slider: autoplay, prev/next, pause, dots, swipe, keyboard, reduced-motion aware
 * - Before/after compare: native range input drives a CSS variable
 * - Reveal on scroll: 240ms opacity/12px, skipped when reduced motion is requested
 */
( function () {
	'use strict';

	var reduce = window.matchMedia( '(prefers-reduced-motion: reduce)' );

	/* ---------- Hero slider ---------- */
	function initSlider( root ) {
		var track  = root.querySelector( '.dx-slider__track' );
		var slides = Array.prototype.slice.call( root.querySelectorAll( '.dx-slider__slide' ) );
		if ( ! track || slides.length < 2 ) { return; }

		var prev   = root.querySelector( '.dx-slider__prev' );
		var next   = root.querySelector( '.dx-slider__next' );
		var toggle = root.querySelector( '.dx-slider__toggle' );
		var dotsEl = root.querySelector( '.dx-slider__dots' );
		var live   = root.querySelector( '.dx-slider__live' );
		var delay  = parseInt( root.getAttribute( 'data-interval' ), 10 ) || 6000;
		var index  = 0;
		var timer  = null;
		var playing = root.getAttribute( 'data-autoplay' ) !== 'false' && ! reduce.matches;

		var dots = slides.map( function ( _, i ) {
			var b = document.createElement( 'button' );
			b.type = 'button';
			b.className = 'dx-slider__dot';
			b.setAttribute( 'aria-label', 'Go to slide ' + ( i + 1 ) + ' of ' + slides.length );
			b.addEventListener( 'click', function () { go( i, true ); } );
			dotsEl && dotsEl.appendChild( b );
			return b;
		} );

		function render() {
			slides.forEach( function ( s, i ) {
				var active = i === index;
				s.classList.toggle( 'is-active', active );
				s.setAttribute( 'aria-hidden', active ? 'false' : 'true' );
				s.setAttribute( 'role', 'group' );
				s.setAttribute( 'aria-roledescription', 'slide' );
				s.setAttribute( 'aria-label', ( i + 1 ) + ' of ' + slides.length );
				// Keep focusable controls in inactive slides out of the tab order.
				s.querySelectorAll( 'a, button, input' ).forEach( function ( el ) {
					if ( active ) { el.removeAttribute( 'tabindex' ); } else { el.setAttribute( 'tabindex', '-1' ); }
				} );
			} );
			dots.forEach( function ( d, i ) {
				d.setAttribute( 'aria-current', i === index ? 'true' : 'false' );
			} );
		}

		function go( i, user ) {
			index = ( i + slides.length ) % slides.length;
			render();
			if ( live ) { live.textContent = playing && ! user ? '' : 'Slide ' + ( index + 1 ) + ' of ' + slides.length; }
			if ( user ) { restart(); }
		}

		function tick() { go( index + 1, false ); }
		function stop() { if ( timer ) { clearInterval( timer ); timer = null; } }
		function start() { stop(); if ( playing ) { timer = setInterval( tick, delay ); } }
		function restart() { if ( playing ) { start(); } }

		function setPlaying( value ) {
			playing = value;
			root.classList.toggle( 'is-paused', ! playing );
			if ( toggle ) {
				toggle.setAttribute( 'aria-pressed', playing ? 'false' : 'true' );
				toggle.setAttribute( 'aria-label', playing ? 'Pause slideshow' : 'Play slideshow' );
			}
			if ( track ) { track.setAttribute( 'aria-live', playing ? 'off' : 'polite' ); }
			playing ? start() : stop();
		}

		prev && prev.addEventListener( 'click', function () { go( index - 1, true ); } );
		next && next.addEventListener( 'click', function () { go( index + 1, true ); } );
		toggle && toggle.addEventListener( 'click', function () { setPlaying( ! playing ); } );

		// Pause while hovered or focused inside, resume after (only if the user has not paused).
		var userPaused = false;
		toggle && toggle.addEventListener( 'click', function () { userPaused = ! playing; } );
		function hold() { stop(); }
		function release() { if ( playing && ! userPaused ) { start(); } }
		root.addEventListener( 'mouseenter', hold );
		root.addEventListener( 'mouseleave', release );
		root.addEventListener( 'focusin', hold );
		root.addEventListener( 'focusout', release );

		// Keyboard: arrows on the slider region.
		root.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'ArrowLeft' ) { go( index - 1, true ); }
			if ( e.key === 'ArrowRight' ) { go( index + 1, true ); }
		} );

		// Swipe.
		var x0 = null;
		track.addEventListener( 'touchstart', function ( e ) { x0 = e.touches[ 0 ].clientX; }, { passive: true } );
		track.addEventListener( 'touchend', function ( e ) {
			if ( x0 === null ) { return; }
			var dx = e.changedTouches[ 0 ].clientX - x0;
			if ( Math.abs( dx ) > 48 ) { go( index + ( dx < 0 ? 1 : -1 ), true ); }
			x0 = null;
		}, { passive: true } );

		// Pause when the tab is hidden.
		document.addEventListener( 'visibilitychange', function () { document.hidden ? stop() : release(); } );
		reduce.addEventListener && reduce.addEventListener( 'change', function ( e ) { if ( e.matches ) { setPlaying( false ); } } );

		root.classList.add( 'is-ready' );
		render();
		setPlaying( playing );
	}

	/* ---------- Before / after compare ---------- */
	function initCompare( root ) {
		var range = root.querySelector( '.dx-compare__range' );
		if ( ! range ) { return; }
		function set() { root.style.setProperty( '--dx-pos', range.value + '%' ); range.setAttribute( 'aria-valuetext', range.value + '% before' ); }
		range.addEventListener( 'input', set );
		set();
		root.classList.add( 'is-ready' );
	}

	/* ---------- Reveal on scroll ---------- */
	function initReveal() {
		var items = document.querySelectorAll( '.dx-reveal' );
		if ( ! items.length ) { return; }
		if ( reduce.matches || ! ( 'IntersectionObserver' in window ) ) { return; }
		document.documentElement.classList.add( 'dx-motion' );
		var io = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( en ) {
				if ( en.isIntersecting ) { en.target.classList.add( 'is-visible' ); io.unobserve( en.target ); }
			} );
		}, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 } );
		items.forEach( function ( el ) { io.observe( el ); } );
	}


	/* ---------- Article: table of contents + share ---------- */
	function initArticle() {
		var toc = document.querySelector( '.dx-toc' );
		var body = document.querySelector( '.dx-prose' );
		if ( toc && body ) {
			var heads = body.querySelectorAll( 'h2' );
			if ( heads.length > 1 ) {
				var list = toc.querySelector( 'ol' );
				heads.forEach( function ( h, i ) {
					if ( ! h.id ) { h.id = 'section-' + ( i + 1 ); }
					var li = document.createElement( 'li' );
					var a = document.createElement( 'a' );
					a.href = '#' + h.id;
					a.textContent = h.textContent.replace( /^\s*0?\d+\s*\/\s*/, '' );
					li.appendChild( a );
					list.appendChild( li );
				} );
				toc.hidden = false;
			}
		}
		var copy = document.querySelector( '[data-dx-copy]' );
		if ( copy && navigator.clipboard ) {
			copy.addEventListener( 'click', function () {
				navigator.clipboard.writeText( location.href ).then( function () {
					var t = copy.textContent; copy.textContent = 'Link copied'; setTimeout( function () { copy.textContent = t; }, 2000 );
				} );
			} );
		} else if ( copy ) { copy.hidden = true; }
		var mail = document.querySelector( '[data-dx-mail]' );
		if ( mail ) { mail.href = 'mailto:?subject=' + encodeURIComponent( document.title ) + '&body=' + encodeURIComponent( location.href ); }
	}

	function ready() {
		document.querySelectorAll( '[data-dx-slider], .dx-slider' ).forEach( initSlider );
		document.querySelectorAll( '[data-dx-compare], .dx-compare' ).forEach( initCompare );
		initReveal();
		initArticle();
	}

	if ( document.readyState === 'loading' ) { document.addEventListener( 'DOMContentLoaded', ready ); } else { ready(); }
} )();
