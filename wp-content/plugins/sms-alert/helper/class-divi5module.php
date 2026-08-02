<?php
/**
 * This is divi5 Helper
 *
 * PHP version 5
 *
 * @category Handler
 * @package  SMSAlert
 * @author   SMS Alert <support@cozyvision.com>
 * @license  URI: http://www.gnu.org/licenses/gpl-2.0.html
 * @link     https://www.smsalert.co.in/
 */
use ET\Builder\Framework\DependencyManagement\Interfaces\DependencyInterface;
use ET\Builder\Framework\Utility\HTMLUtility;
use ET\Builder\Packages\Module\Module;
use ET\Builder\Packages\ModuleLibrary\ModuleRegistration;
/**
 * This is Class divi 5 helper.
 *
 * PHP version 5
 *
 * @category Handler
 * @package  SMSAlert
 * @author   SMS Alert <support@cozyvision.com>
 * @license  URI: http://www.gnu.org/licenses/gpl-2.0.html
 * @link     https://www.smsalert.co.in/
 * SMSAlertSelectorModern Class.
 */
 
class SMSAlertSelectorModern implements DependencyInterface {

    const MODULE_TYPE = 'smsalert/divi-selector';

    public function load(): void {
        add_action('init', [ $this, 'register_module' ]);
    }

    public static function register_module(): void {
 
        $module_json_folder_path = __DIR__.'divi/';
        ModuleRegistration::register_module(
            $module_json_folder_path,
            [
                'render_callback' => [ __CLASS__, 'render_callback' ],
            ]
        );
    }

    public static function render_callback( array $attrs ): string {

        $new_attrs = $attrs;

        $form_id = $new_attrs['formId']['desktop']['value'] ?? '';

        if ( empty($form_id) ) {
            return '';
        }

        if ($form_id == 1) {
            $shortcode = '[sa_signupwithmobile]';
        } elseif ($form_id == 2) {
            $shortcode = '[sa_loginwithotp]';
        } else {
            $shortcode = '[sa_sharecart]';
        }

        $output = do_shortcode($shortcode);

        return HTMLUtility::render([
            'tag' => 'div',
            'attributes' => [
                'class' => 'et_pb_module_inner'
            ],
            'children' => $output
        ]);
    }
}