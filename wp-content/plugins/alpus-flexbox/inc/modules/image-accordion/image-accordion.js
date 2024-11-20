/**
 * Flexbox Container
 * Nested Image Accordion
 * 
 * @package Flexbox Container
 * @since 1.2.0
 */

'use strict';

window.alpusFlexbox = window.alpusFlexbox || {};

(function ($) {

    $(window).on('elementor/frontend/init', function () {
        if (elementorFrontend && elementorModules.frontend) {
            class AlpusImageAccordion extends elementorModules.frontend.handlers.Base {
                onInit() {
                    if (elementorFrontend.isEditMode()) {
                        this.findElement(".e-con").each((function () {
                            if (!jQuery(this).parent().hasClass('ia-item')) {
                                jQuery(this).wrap('<div class="ia-item"></div>')
                            }
                        }));

                        var activeItems = this.findElement('.alpus-nested-ia-wrapper').attr('data-active').split(',');

                        for (let index = 0; index < activeItems.length; index++) {
                            $(this.findElement('.ia-item')[activeItems[index]]).addClass('active');
                        }
                    }

                    $(document.body).on('click', '.alpus-nested-ia-wrapper.active-on-click .ia-item', function () {
                        $(this).addClass('active').siblings().removeClass('active');
                    })

                    elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);
                }
            }
            alpusFlexbox.ImageAccordionHandler = AlpusImageAccordion;
            elementorFrontend.elementsHandler.attachHandler('alpus-nested-image-accordion', AlpusImageAccordion);
        }
    })
})(jQuery);