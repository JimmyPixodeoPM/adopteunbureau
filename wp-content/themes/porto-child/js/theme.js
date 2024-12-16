jQuery(document).ready(function ($) {
    //SLICK SLIDER latest blog
    $(document).ready(function () {
        var nameValue = $('.pcf-container .pcf-field-container #name').val();
        $('.comment-form-author #author').val(nameValue);
        var emailValue = $('.pcf-container .pcf-field-container #email').val();
        $('.comment-form-email #email').val(emailValue);
    });
    $('#orderShop select.orderby').on('change', function (e) {
        e.preventDefault();

        var $form = $(this).closest('form');
        var href = '?';

        $form.find('input[type="hidden"], select').each(function () {
            var name = $(this).attr('name');
            var value = $(this).val();
            if (name) {
                href += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
            }
        });

        href = href.slice(0, -1);

        window.location.href = href;
    });
    $('.woocommerce-product-rating .star-rating').each(function () {
        if ($(this).attr('data-bs-original-title') !== '0') {
            $(this).hide();
        }
    });
    $('.tb-woo-rating .star-rating').each(function () {
        if ($(this).attr('data-bs-original-title') !== '0') {
            $(this).hide();
        }
    });
    $('.rating-wrap .star-rating').each(function () {
        if ($(this).attr('data-bs-original-title') !== '0') {
            $(this).hide();
        }
    });
    $('.sticky-detail .star-rating').each(function () {
        if ($(this).attr('data-bs-original-title') !== '0') {
            $(this).hide();
        }
    });
    $('.mini-cart .product-details .quantity').each(function () {
        $(this).html($(this).html().replace('× ', ''));
    });
    $('.mini-cart .product-details .quantity').contents().filter(function () {
        return this.nodeType === 3 && this.nodeValue.includes('×');
    }).each(function () {
        this.nodeValue = this.nodeValue.replace('×', '').trim();
    });

    // $('.spec-infor table tbody').each(function () {
    //     if ($(this).children().length === 0) {
    //         $(this).closest('.spec-infor').hide();
    //     }
    // });
    $(document).ready(function () {
        let allEmpty = true;

        $('.spec-infor table tbody').each(function () {
            if ($(this).children().length > 0) {
                allEmpty = false;
            }
            if ($(this).children().length === 0) {
                $(this).closest('.spec-infor').hide();
            }
        });

        if (allEmpty) {
            $('.specs-title').hide();
        }
    });
    // var CheckoutSteps = {
    //     $sections: $('.wpmc-step-item'),
    //     init: function () {
    //         var self = this;
    //         $('.woocommerce-checkout').on('wpmc_switch_tab', function (event, theIndex) {
    //             self.switch_tab(theIndex);
    //         });

    //         $('.wpmc-step-item:first').addClass('current');

    //         $('#wpmc-next-step, #wpmc-skip-login').on('click', function () {
    //             self.switch_tab(self.current_index() + 1);
    //         });
    //     },
    //     current_index: function () {
    //         return $('.wpmc-step-item.current').index();
    //     },
    //     switch_tab: function (index) {
    //         const steps = $('.wpmc-step-item');
    //         if (index < 0 || index >= steps.length) {
    //             return false;
    //         }
    //         console.log("index", index);
    //         console.log("steps", steps);
    //         steps.removeClass('current');
    //         steps.eq(index).addClass('current');
    //     }
    // };

    // CheckoutSteps.init();
    // console.log(CheckoutSteps, "CheckoutSteps1");
    // console.log(CheckoutSteps.current_index(), "1")
    // $('.wpmc-nav-wrapper #wpmc-next-step').on('click', function (event) {
    //     let isValid = true;
    //     const form = $('form.woocommerce-checkout');

    //     form.find('.woocommerce-billing-fields input[aria-required="true"],.woocommerce-billing-fields select[aria-required="true"]').each(function () {
    //         const $this = $(this);
    //         const errorMessage = 'Ce champ est obligatoire.';
    //         let $errorSpan = $this.next('.error-message');

    //         if (!$this.val()) {
    //             isValid = false;

    //             if ($errorSpan.length === 0) {
    //                 $errorSpan = $('<span class="error-message"></span>').text(errorMessage);
    //                 $this.after($errorSpan);
    //             }
    //             $this.addClass('error');
    //         } else {
    //             $this.removeClass('error');
    //             if ($errorSpan.length > 0) {
    //                 $errorSpan.remove();
    //             }
    //         }
    //     });

    //     console.log(isValid, "baaa");
    //     console.log(CheckoutSteps, "CheckoutSteps2");
    //     console.log(CheckoutSteps.current_index(), "2");
    //     if (isValid) {
    //         event.preventDefault();

    //         const form = $('.woocommerce-checkout');
    //         const steps = form.find('.wpmc-step-item');

    //         steps.each(function (index) {
    //             if ($(this).hasClass('current')) {
    //                 console.log(': ', index + 1);
    //                 const nextStep = $(this).next('.wpmc-step-item');
    //                 if (nextStep.length > 0) {
    //                     console.log(': ', nextStep.index() + 1);
    //                 }
    //             }
    //         });
    //     } else {
    //         event.preventDefault();
    //     }



    // });


    $(".woocommerce-input-wrapper #billing_phone").intlTelInput({
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js",
        initialCountry: "fr",
        separateDialCode: true,
        onlyCountries: ["be", "lu", "fr"],
        countrySearch: false,
        formatOnDisplay: true,
    });
    $(".woocommerce-address-fields #shipping_phone").intlTelInput({
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js",
        initialCountry: "fr",
        separateDialCode: true,
        onlyCountries: ["be", "lu", "fr"],
        countrySearch: false,
        formatOnDisplay: true,
    });
    const input = document.getElementById('billing_address_1');
    const autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.addListener('place_changed', function () {
        var place = autocomplete.getPlace();
        const country = place.address_components.find(c => c.types.includes('country'))?.long_name || '';
        document.getElementById('billing_city').value = country;
        const postalCode = place.address_components.find(c => c.types.includes('postal_code'))?.long_name || '';
        document.getElementById('billing_postcode').value = postalCode;
    });

    const inputShipping = document.getElementById('shipping_address_1');
    const autocompleteShipping = new google.maps.places.Autocomplete(inputShipping);
    autocompleteShipping.addListener('place_changed', function () {
        var placeShipping = autocompleteShipping.getPlace();
        const country = placeShipping.address_components.find(c => c.types.includes('country'))?.long_name || '';
        document.getElementById('shipping_city').value = country;
        const postalCode = placeShipping.address_components.find(c => c.types.includes('postal_code'))?.long_name || '';
        document.getElementById('shipping_postcode').value = postalCode;
    });

    $('.button-modal-sticky-cart').click(function() {
        $('.modal-overlay-sticky-cart').fadeIn();
        $('html').addClass('modal-sticky-cart-open');
    });

    $('.close-modal-sticky-cart').click(function() {
        $('.modal-overlay-sticky-cart').fadeOut();
        $('html').removeClass('modal-sticky-cart-open');
    });
    // $('.wrap-modal-sticky-cart').click(function() {
    //     $('.modal-overlay-sticky-cart').fadeOut();
    //     $('html').removeClass('modal-sticky-cart-open');
    // });
    $('.modal-overlay-sticky-cart').click(function(event) {
        if ($(event.target).is('.modal-overlay-sticky-cart')) {
            $(this).fadeOut();
            $('html').removeClass('modal-sticky-cart-open');
        }
    });

    $('.variations_form').each(function () {
        $(this).wc_variation_form();
    });

    // $('form.variations_form').on('woocommerce_variation_select_change', function() {
    //     var selected_image = $('input.variation_id').val(); 
    //     var image = $('#product-' + selected_image).data('image'); 

    //     $('#main-product-image').attr('src', image);
    // });
});
