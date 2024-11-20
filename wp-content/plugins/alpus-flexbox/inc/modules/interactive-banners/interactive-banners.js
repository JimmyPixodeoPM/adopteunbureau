/**
 * Flexbox Container
 * Nested Interactive Banners
 * 
 * @package Flexbox Container
 * @since 1.2.0
 */

'use strict';

window.alpusFlexbox = window.alpusFlexbox || {};
window.theme = window.theme || {};

// Mouse Hover Split
(function ($) {

    var instanceName = '__mousehoversplit';

    var PluginHoverSplit = function ($el) {
        return this.initialize($el);
    }

    PluginHoverSplit.prototype = {
        initialize: function ($el) {
            if ($el.data(instanceName)) {
                return this;
            }
            this.$el = $el;

            this
                .setData()
                .event();

            return this;
        },

        setData: function () {
            this.$el.data(instanceName, this);
            this.$el.addClass('initialized');
            var $ibanners = this.$el.find('>.ibanner-item');

            this.direction = this.$el.attr('data-direction');

            for (var index = 0; index < $ibanners.length; index++) {
                var ibanner = $ibanners[index];
                if (index == 0) {
                    ibanner.classList.add('ibanner-left');
                    this.left = ibanner;
                } else if (index == 1) {
                    ibanner.classList.add('ibanner-right');
                    this.right = ibanner;
                    break;
                }
            }

            return this;
        },

        event: function () {
            // Refresh
            this.refresh();
            this.onRefresh = this.refresh.bind(this);
            $(window).on('resize', this.onRefresh);

            // Hover
            this.onHandleMove = this.handleMove.bind(this);
            this.$el.on('mousemove', this.onHandleMove);
        },
        handleMove: function (e) {
            if (this.direction == 'horizontal') {
                if (e.clientX < this.$el.offset().left) {
                    this.right.style.width = '0';
                } else {
                    this.right.style.width = e.clientX - this.$el.offset().left + 'px';
                    // this.right.style.width = `calc( ${(e.clientX - this.$el.offset().left) / (this.$el.innerWidth()) * 100}% - 3px ) `;
                }
            } else {
                if (e.clientY < this.$el.get(0).getBoundingClientRect().top) {
                    this.right.style.height = '0';
                } else {
                    this.right.style.height = e.clientY - this.$el.get(0).getBoundingClientRect().top + 'px';
                    // this.right.style.width = `calc( ${(e.clientX - this.$el.offset().left) / (this.$el.innerWidth()) * 100}% - 3px ) `;
                }
            }
        },
        refresh: function (e) {
            if (this.direction == 'horizontal') {
                let _wd = this.$el.innerWidth();
                if ( _wd ) {
                    this.$el.find('>.ibanner-item>*').css('width', _wd);
                }
            } else {
                let _ht = this.$el.innerHeight();
                if ( _ht ) {
                    this.$el.find('>.ibanner-item>*').css('height', _ht);
                }
            }
        },
    }

    // expose to scope
    $.extend(theme, {
        AlpusPluginHoverSplit: PluginHoverSplit
    });

    $.fn.nestedInteractiveBanners = function () {
        return this.map(function () {
            var $this = $(this),
                $ibanners = $this.find('>.ibanner-item');
            if ($ibanners.length >= 2) {
                if ($this.data(instanceName)) {
                    return $this.data(instanceName);
                } else {
                    return new PluginHoverSplit($this);
                }
            }
        });
    }
})(jQuery);

(function ($) {

    $(window).on('elementor/frontend/init', function () {
        if (elementorFrontend && elementorModules.frontend) {
            class AlpusInteractiveBanners extends elementorModules.frontend.handlers.Base {
                onInit() {
                    elementorFrontend.isEditMode() && this.findElement(".e-con").each((function () {
                        if (!jQuery(this).parent().hasClass('ibanner-item')) {
                            jQuery(this).wrap('<div class="ibanner-item"></div>')
                        }
                    }));
                    this.onStart();
                    elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);
                }
                onEditSettingsChange(propertyName, value) {
                    this.onStart();
                }
                onStart() {
                    if ($.fn.nestedInteractiveBanners) {
                        this.$element.find('.alpus-nested-interactive-banners').each(function () {
                            var $this = $(this),
                                $ibanners = $this.find('>.ibanner-item');

                            if ($ibanners.length >= 2) {
                                $this.nestedInteractiveBanners();
                            }
                        });
                    }
                }
            }
            alpusFlexbox.InteractiveBannersHandler = AlpusInteractiveBanners;
            elementorFrontend.elementsHandler.attachHandler('alpus-nested-interactive-banners', AlpusInteractiveBanners);
        }
    })
})(jQuery);