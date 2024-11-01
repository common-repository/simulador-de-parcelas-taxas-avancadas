<?php
/**
 * Plugin Name: Simulador de Parcelas - Taxas avançadas
 * Description: Defina diferentes taxas de juros de acordo com o número de parcelas
 * Author: Fernando Acosta
 * Author URI: https://fernandoacosta.net
 * Plugin URI: https://fernandoacosta.net/produto/simulador-parcelas
 * Version: 1.0.1
 * License: GPLv2 or later
 * WC requires at least: 3.0.0
 * WC tested up to:      3.4.0
 * Domain Path: /languages/
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}
/**
 * WC_Installments_Simulator_Advanced_Fees main class.
 *
 * @package  WC_Installments_Simulator_Advanced_Fees
 * @category Core
 * @author   Fernando Acosta
 */
class WC_Installments_Simulator_Advanced_Fees {
  /**
   * Plugin version.
   *
   * @var string
   */
  const VERSION = '1.0.0';

  /**
   * Instance of this class.
   *
   * @var object
   */
  protected static $instance = null;

  /**
   * Initialize the plugin.
   */
  private function __construct() {
    if ( class_exists( 'WC_Simulador_Parcelas' ) ) {
      $this->includes();
    } else {
      add_action( 'admin_notices', array( $this, 'fallback_notice' ) );
    }
  }

  /**
   * Return an instance of this class.
   *
   * @return object A single instance of this class.
   */
  public static function get_instance() {
    if ( null == self::$instance ) {
      self::$instance = new self;
    }

    return self::$instance;
  }


  private function includes() {
    include_once dirname( __FILE__ ) . '/includes/class-apply-rules.php';
    include_once dirname( __FILE__ ) . '/includes/admin/admin-options.php';
  }


  /**
   * WC Simulador de Parcelas fallback notice.
   *
   * @return string Falback notice.
   */
  public function fallback_notice() {
    echo '<div class="error"><p>' . sprintf( 'Para usar o plugin <strong>%s</strong> você precisa instalar %s.', 'Simulador de Parcelas - Taxas avançadas', '<a href="https://fernandoacosta.net/produto/plugins/simulador-parcelas/">WC Simulador de Parcelas</a>' ) . '</p></div>';
  }
}

/**
 * Init the plugin.
 */
add_action( 'plugins_loaded', array( 'WC_Installments_Simulator_Advanced_Fees', 'get_instance' ), 20 );
