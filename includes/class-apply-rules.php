<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

/**
*
*/
class WC_Installments_Simulator_Advanced_Fees_Rules {
  function __construct() {
    add_filter( 'wcsp_fee', array( $this, 'custom_fees' ), 10, 3 );
    add_filter( 'wcsp_installment_with_fee', array( $this, 'calculated_price' ), 10, 4 );
  }

  public function custom_fees( $fee, $product, $installments ) {
    $custom_fees = get_option( 'wc_simulador_parcelas_installments_list', array() );
    $fee         = isset( $custom_fees[ $installments ] ) && ! empty( $custom_fees[ $installments ] ) ? $custom_fees[ $installments ] : $fee;

    return $fee;
  }

  public function calculated_price( $installment_price, $price, $fee, $installments ) {
    $custom_fees = get_option( 'wc_simulador_parcelas_installments_list', array() );

    if ( isset( $custom_fees[ $installments ] ) ) {
      $price            += $price * ( floatval( wc_format_decimal( $fee ) ) / 100 );
      $installment_price = $price / $installments;
    }

    return $installment_price;
  }
}

new WC_Installments_Simulator_Advanced_Fees_Rules();
