/**
 * Horizontal Scroller
 * 
 * @package Flexbox Container
 * @since 1.2.0
 */

'use strict';

window.alpusFlexbox = window.alpusFlexbox || {};
window.theme = window.theme || {};

( function( theme, $ ) {
	theme = theme || {};

	var instanceName = '__horizontalscroller';

	var PluginHScroller = function( $el, opts ) {
		return this.initialize( $el, opts );
	}

	PluginHScroller.defaults = {
		lg: 3,
		md: 1,
		init_refresh: false,
	};

	PluginHScroller.prototype = {
		initialize: function( $el, opts ) {
			if ( $el.data( instanceName ) ) {
				return this;
			}
			this.$el = $el;

			this
				.setData( opts )
				.build()
				.event();

			return this;
		},
		setData: function( opts ) {
			this.$el.data( instanceName, this );
			this.options = $.extend( true, {}, PluginHScroller.defaults, opts );
			this.$hScroller = this.$el.find( '.alpus-horizontal-scroller' );
			this.$hScrollerItems = this.$hScroller.find( '.alpus-horizontal-scroller-items' );
			this.$hScrollerItems.find( '>*' ).addClass( 'alpus-horizontal-scroller-item' );
			return this;
		},
		build: function() {
			// Copy Original HTML to clone on Resize.
			this.originalScrollHTML = this.$hScroller.html();
			this.scrollerInitialized = false;

			return this;
		},
		// Generate Scroller
		generateScroller: function() {
			var items = gsap.utils.toArray( this.$hScrollerItems.find( '.alpus-horizontal-scroller-item' ) );
			let windowWidth = $( window ).width();
			let optionsWidth = windowWidth > 991 ? this.options.lg : ( windowWidth > 767 || ! this.options.sm ? this.options.md : this.options.sm );
			gsap.to( items, {
				xPercent: -100 * ( items.length - optionsWidth ),
				ease: 'none',
				scrollTrigger: {
					trigger: '.alpus-horizontal-scroller',
					pin: true,
					scrub: 1,
					snap: 1 / ( items.length - 1 ),
					end: () => '+=' + this.$hScrollerItems.width(),
					el: this.$el,
				}
			} );

			this.scrollerInitialized = true;
		},
		event: function() {
			if ( this.options.init_refresh ) {
				this.generateScroller();
			}
			// Scroll Event to initialize when visible
			this.scrollFunc = this.scroll.bind( this );
			$( window ).on( 'scroll', this.scrollFunc );

			// Resize Event removing and restarting
			this.afterResizeFunc = this.afterResize.bind( this );
			$( window ).on( 'afterResize', this.afterResizeFunc );
		},
		scroll: function() {
			if ( !this.scrollerInitialized ) {

				var position = this.$el[0].getBoundingClientRect();

				if ( position.top >= 0 && position.top < window.innerHeight && position.bottom >= 0 ) {
					this.generateScroller();
				}
			}
		},
		afterResize: function() {

			this.scrollerInitialized = false;
			var Alltrigger = ScrollTrigger.getAll();

			for ( var i = 0; i < Alltrigger.length; i++ ) {
				if ( Alltrigger[i]['vars'] && typeof Alltrigger[i]['vars']['el'] != 'undefined' && Alltrigger[i]['vars']['el'] == this.$el ) {
					Alltrigger[i].kill( true );
					this.$el.empty().html( '<div class="alpus-horizontal-scroller">' + this.originalScrollHTML + '</div>' );
					this.$hScrollerItems = this.$el.find( '.alpus-horizontal-scroller-items' );
					break;
				}
			}
		},
		clearData: function() {
			this.$el.removeData( instanceName );
			$( window ).off( 'scroll', this.scrollFunc );
			$( window ).off( 'afterResize', this.afterResizeFunc );
		}
	};
	// expose to scope
	$.extend( theme, {
		AlpusHScroller: PluginHScroller
	} );
	$.fn.alpusPluginHScroller = function( opt = false ) {
		if ( typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined' ) {
			return this.map( function() {
				var $this = $( this );
				if ( $this.data( instanceName ) ) {
					return $this.data( instanceName );
				} else {
					if ( $this.find( '.alpus-horizontal-scroller-items>*' ).length ) {
						let options = $this.data( 'plugin-hscroll' );
						if ( opt ) {
							options['init_refresh'] = true;
						}
						return new PluginHScroller( $this, options );
					}
				}
			} );
		} else {
			return false;
		}
	}
} ).apply( this, [window.theme, jQuery] );


(function ($) {

    $(window).on('elementor/frontend/init', function () {
        if (elementorFrontend && elementorModules.frontend) {
            class AlpusHscroller extends elementorModules.frontend.handlers.Base {
                onInit() {
                    this.onStart();
                    elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);
                }
                onEditSettingsChange(propertyName, value) {
                    this.onStart();
                }
                onStart() {
                    // Horizontal Scroller
                    if ( $.fn.alpusPluginHScroller ) {
                        // Horizontal Scroller
                        this.$element.find( '.alpus-horizontal-scroller-wrapper' ).each( function() {
                            $( this ).alpusPluginHScroller( true );
                        } );
                    }
                }
            }
            alpusFlexbox.HscrollerHandler = AlpusHscroller;
            elementorFrontend.elementsHandler.attachHandler('alpus-nested-hscroller', AlpusHscroller);
        }
    })
})(jQuery);