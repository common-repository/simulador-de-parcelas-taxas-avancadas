<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

/**
*
*/
class WC_Installments_Simulator_Advanced_Fees_Admin {
  function __construct() {
    add_filter( 'wc_simulador_parcelas_settings', array( $this, 'settings' ), 10 );
    add_action( 'woocommerce_admin_field_installments_fee', array( $this, 'installments_fee_field' ) );
  }

  public function settings( $settings ) {
    $new_settings = array(
      array(
        'name' => 'Taxa de juros',
        'type' => 'title',
        'desc' => 'Defina taxas de juros de acordo com o número de parcelas. Os campos não preenchidos irão considerar a taxa de juros padrão.'
      ),
      array(
        'type' => 'installments_fee',
        'id'   => 'wc_simulador_parcelas_installments_list',
        'title' => 'Taxas de juros'
      ),
      array(
        'type' => 'sectionend',
        'id' => 'wc-simulador-parcelas-advanced-fees',
      ),
    );

    $settings = array_merge( $settings, $new_settings );

    return $settings;
  }
  public function installments_fee_field( $value ) {
    $option_value = get_option( $value['id'], $value['default'] );
    ?>
    <tr valign="top">
      <th scope="row" class="titledesc">
        <label for="<?php echo esc_attr( $value['id'] ); ?>"><?php echo esc_html( $value['title'] ); ?></label>
      </th>
      <td class="forminp forminp-text">
        <fieldset>
          <?php
            for ( $i = 1; $i <= 24; $i++ ) :
              $interest = isset( $option_value[ $i ] ) ? $option_value[ $i ] : '';
          ?>
          <p data-installment="<?php echo $i; ?>">
            <input class="small-input" type="text" value="<?php echo $i; ?>"
              <?php disabled( 1, true ); ?> />
            <input class="small-input" type="text"
              placeholder="0,00"
              name="<?php echo esc_attr( $value['id'] ); ?>[<?php echo $i; ?>]"
              id="<?php echo esc_attr( $value['id'] ); ?>" value="<?php echo wc_format_localized_price( $interest ) ?>" />%
          </p>
          <?php endfor; ?>
        </fieldset>
      </td>
    </tr>
    <?php
  }
}

new WC_Installments_Simulator_Advanced_Fees_Admin();
