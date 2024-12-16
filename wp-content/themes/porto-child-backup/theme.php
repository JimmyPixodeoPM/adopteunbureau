<?php
add_action( 'woocommerce_after_save_address_validation', 'strict_validate_email_domain', 10, 3 );
function strict_validate_email_domain( $user_id, $load_address, $address ) {
    // if ( isset( $_POST['billing_email'] ) && !empty($_POST['billing_phone'])) {
    //     $email = $_POST['billing_email'];
    //     if ( ! strict_email_validation( $email) ) {
    //         wc_add_notice( __( 'E-mail n’est pas une e-mail valide.', 'woocommerce' ), 'error' );
    //     }
    // }

    if ( isset( $_POST['billing_phone'] ) && !empty($_POST['billing_phone'])) {
        $phone = sanitize_text_field( $_POST['billing_phone'] ); // Sanitize the phone number input
        if ( ! validate_billing_phone( $phone ) ) {
            wc_add_notice( __( 'Téléphone n’est pas un numéro de téléphone valide.', 'woocommerce' ), 'error' );
        }
    }

    if ( isset( $_POST['shipping_phone'] ) && !empty($_POST['shipping_phone'])) {
        $phone = sanitize_text_field( $_POST['shipping_phone'] ); // Sanitize the phone number input
        if ( ! validate_billing_phone( $phone ) ) {
            wc_add_notice( __( 'Téléphone n’est pas un numéro de téléphone valide.', 'woocommerce' ), 'error' );
        }
    }
}

function strict_email_validation( $email ) {
    $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    if ( !preg_match( $pattern, $email ) ) {
        return false;
    }

    $domain = substr( strrchr( $email, '@' ), 1 );
    return checkdnsrr( $domain, 'MX' );
}

function validate_billing_phone( $phone ) {
    // Check if the phone number is exactly 10 digits and numeric
    return preg_match( '/^\d{10}$/', $phone );
}
?>