<?php
/**
 * Plugin Name: Custom Meta boxes by mahmud_remal
 * Plugin URI: https://www.fiverr.com/mahmud_remal
 * Description: Create your own custom Meta boxes seeing it. Here I explain every functions by commenting and if you need any further questions, let me know :-)
 * Version: 1.0.0
 * Author: mahmud_remal
 * Author URI: https://www.fiverr.com/mahmud_remal
 * Text Domain: mahmud_remal
 * Domain Path: /lang/
 * Requires at least: 3.7
 * Tested up to: 6.0
 * Requires PHP: 7.0
 *
 *
 * This program is created for open source purpose to creating a custom posts type on your plugin. Here I described how to create custom posts types and how it will work and tried to describe mostly customizing options on it. Make sure you do not declare directly register_post_type() function on outside of a hook.
 * For any further help, let me know.
 *
 * @package Custom Meta boxes
 */



class CUSTOM_META_BOXES{
  /**
 * yOU CAN GET ALL OF THE DATA STORED ON wp_post_meta table USIONG THIS get_post_meta() function.
 * 
 * Retrieving the values:
 * Checkbox = get_post_meta( get_the_ID(), 'prefix_checkbox', true )
 * WP Color picker = get_post_meta( get_the_ID(), 'prefix_wp-color-picker', true )
 * Custom Color picker = get_post_meta( get_the_ID(), 'prefix_custom-color-picker', true )
 * Date = get_post_meta( get_the_ID(), 'prefix_date', true )
 * Editor = get_post_meta( get_the_ID(), 'prefix_editor', true )
 * Email = get_post_meta( get_the_ID(), 'prefix_email', true )
 * Mediia Url = get_post_meta( get_the_ID(), 'prefix_mediia-url', true )
 * Mediia ID = get_post_meta( get_the_ID(), 'prefix_mediia-id', true )
 * Month = get_post_meta( get_the_ID(), 'prefix_month', true )
 * Number = get_post_meta( get_the_ID(), 'prefix_number', true )
 * Password = get_post_meta( get_the_ID(), 'prefix_password', true )
 * Custom Radio field = get_post_meta( get_the_ID(), 'prefix_custom-radio-field', true )
 * Range = get_post_meta( get_the_ID(), 'prefix_range', true )
 * Custom select = get_post_meta( get_the_ID(), 'prefix_custom-select', true )
 * Telephone = get_post_meta( get_the_ID(), 'prefix_telephone', true )
 * Text field = get_post_meta( get_the_ID(), 'prefix_text-field', true )
 * Text Area = get_post_meta( get_the_ID(), 'prefix_text-area', true )
 * Custom time = get_post_meta( get_the_ID(), 'prefix_custom-time', true )
 * CUstom Url = get_post_meta( get_the_ID(), 'prefix_custom-url', true )
 * Custom Week = get_post_meta( get_the_ID(), 'prefix_custom-week', true )
 */
/**
 * All fields datas are stored on there.
 */
	private $config = '{"title":"Meta box title","description":"Your custom meta box descriptions","prefix":"prefix_","domain":"your-domain","class_name":"your-own-class-name","post-type":["post","page"],"context":"normal","priority":"high","cpt":"post,page","fields":[{"type":"checkbox","label":"Checkbox","description":"Your custom meta box descriptions","id":"prefix_checkbox"},{"type":"color","label":"WP Color picker","default":"#000000","color-picker":"1","id":"prefix_wp-color-picker"},{"type":"color","label":"Custom Color picker","default":"#000000","color-picker":"1","id":"prefix_custom-color-picker"},{"type":"date","label":"Date","max":"2036-10-10","min":"2021-01-07","step":"2","id":"prefix_date"},{"type":"editor","label":"Editor","default":"Editor default texts","wpautop":"1","media-buttons":"1","teeny":"1","id":"prefix_editor"},{"type":"email","label":"Email","id":"prefix_email"},{"type":"media","label":"Mediia Url","button-text":"Upload media for Url","return":"url","modal-title":"Custom model title","modal-button":"Custom button","id":"prefix_mediia-url"},{"type":"media","label":"Mediia ID","button-text":"Upload media for ID","return":"id","modal-title":"Custom model title","modal-button":"Custom button","id":"prefix_mediia-id"},{"type":"month","label":"Month","default":"2022-06","max":"2039-11","min":"2022-01","step":"3","id":"prefix_month"},{"type":"number","label":"Number","default":"25","max":"365","min":"12","step":"2","id":"prefix_number"},{"type":"password","label":"Password","default":"default password","id":"prefix_password"},{"type":"radio","label":"Custom Radio field","default":"option-one","options":"option-one : Option One\r\noption-two : Option Two\r\noption-three : Option Three\r\noption-four : Option Four","id":"prefix_custom-radio-field"},{"type":"range","label":"Range","default":"25","max":"85","min":"5","step":"5","id":"prefix_range"},{"type":"select","label":"Custom select","default":"option-one","options":"option-one : Option One\r\noption-two : Option Two\r\n","id":"prefix_custom-select"},{"type":"tel","label":"Telephone","default":"254856","pattern":"((\\\\(\\\\d{3}\\\\) ?)|(\\\\d{3}-))?\\\\d{3}-\\\\d{4}","id":"prefix_telephone"},{"type":"text","label":"Text field","default":"hola! Are you a American?","id":"prefix_text-field"},{"type":"textarea","label":"Text Area","default":"Default text \r\nfor this text area","rows":"8","id":"prefix_text-area"},{"type":"time","label":"Custom time","default":"10:28","max":"12:40","min":"10:25","step":"5","id":"prefix_custom-time"},{"type":"url","label":"CUstom Url","default":"https:\/\/regexlib.com\/Search.aspx?k=phone&AspxAutoDetectCookieSupport=1","id":"prefix_custom-url"},{"type":"week","label":"Custom Week","default":"2022-W25","max":"2058-W43","min":"2022-W22","step":"3","id":"prefix_custom-week"}]}';

  /**
   * Construct is a function that autometically called by PHP before reading a classes other functions.
   * So you can configure any thing from here before functions execution
   */
  public function __construct() {
    /**
     * Render data from this custom metabox from an array.
     */
		$this->config = json_decode( $this->config, true );
		$this->process_cpts();
    /**
     * add_action() is a function where all plugins and themes functions stored and called according to an order.
     * "add_meta_boxes" is a tag, means this CUSTOM_META_BOXES::add_meta_boxes() function will called when WordPress execute this function on adding metabox tme.
     * "10" means priority or number of order of where this function will called.
     * "0" meant that, this "custom_meta_box()" function accepts no arguments.
     * Here is the function syntex
     * add_action( tag, function_to_add(), priority, accepted_args )
     */
		add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
    /**
     * hook 'admin_enqueue_scripts' called when some scripts needed to run metaboxes operational. This will called WP_MEDIA scripts to enclude.
     */
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
    /**
     * hook 'admin_enqueue_styles' called to include stylesttet and styles on WP meta boxes end.
     */
		add_action( 'admin_enqueue_styles', [ $this, 'admin_enqueue_styles' ] );
    /**
     * 'admin_head' hooks use to insert some script on admin pages <head> tag.
     */
		add_action( 'admin_head', [ $this, 'admin_head' ] );
    /**
     * 'save_post' is called only when user used to save / uppdate a post so save this meta boxes data.
     */
		add_action( 'save_post', [ $this, 'save_post' ] );
  }
  /**
   * Function where custom metabox request function will executed
   */
	public function process_cpts() {
		if ( !empty( $this->config['cpt'] ) ) {
			if ( empty( $this->config['post-type'] ) ) {
				$this->config['post-type'] = [];
			}
			$parts = explode( ',', $this->config['cpt'] );
			$parts = array_map( 'trim', $parts );
			$this->config['post-type'] = array_merge( $this->config['post-type'], $parts );
		}
	}

	public function add_meta_boxes() {
		foreach ( $this->config['post-type'] as $screen ) {
			add_meta_box(
				sanitize_title( $this->config['title'] ),
				$this->config['title'],
				[ $this, 'add_meta_box_callback' ],
				$screen,
				$this->config['context'],
				$this->config['priority']
			);
		}
	}

	public function admin_enqueue_scripts() {
		global $typenow;
		if ( in_array( $typenow, $this->config['post-type'] ) ) {
			wp_enqueue_media();
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_style( 'wp-color-picker' );
		}
	}
	public function admin_enqueue_styles() {
		// Insert your styles Here
		?>
		<style></style>
		<?php
	}

	public function admin_head() {
		global $typenow;
		if ( in_array( $typenow, $this->config['post-type'] ) ) {
			?><script>
				jQuery.noConflict();
				(function($) {
					$(function() {
						$('body').on('click', '.rwp-media-toggle', function(e) {
							e.preventDefault();
							let button = $(this);
							let rwpMediaUploader = null;
							rwpMediaUploader = wp.media({
								title: button.data('modal-title'),
								button: {
									text: button.data('modal-button')
								},
								multiple: true
							}).on('select', function() {
								let attachment = rwpMediaUploader.state().get('selection').first().toJSON();
								button.prev().val(attachment[button.data('return')]);
							}).open();
						});
						$('.rwp-color-picker').wpColorPicker();
					});
				})(jQuery);
			</script><?php
			?><?php
		}
	}

	public function save_post( $post_id ) {
		foreach ( $this->config['fields'] as $field ) {
			switch ( $field['type'] ) {
				case 'checkbox':
					update_post_meta( $post_id, $field['id'], isset( $_POST[ $field['id'] ] ) ? $_POST[ $field['id'] ] : '' );
					break;
				case 'editor':
					if ( isset( $_POST[ $field['id'] ] ) ) {
						$sanitized = wp_filter_post_kses( $_POST[ $field['id'] ] );
						update_post_meta( $post_id, $field['id'], $sanitized );
					}
					break;
				case 'email':
					if ( isset( $_POST[ $field['id'] ] ) ) {
						$sanitized = sanitize_email( $_POST[ $field['id'] ] );
						update_post_meta( $post_id, $field['id'], $sanitized );
					}
					break;
				case 'url':
					if ( isset( $_POST[ $field['id'] ] ) ) {
						$sanitized = esc_url_raw( $_POST[ $field['id'] ] );
						update_post_meta( $post_id, $field['id'], $sanitized );
					}
					break;
				default:
					if ( isset( $_POST[ $field['id'] ] ) ) {
						$sanitized = sanitize_text_field( $_POST[ $field['id'] ] );
						update_post_meta( $post_id, $field['id'], $sanitized );
					}
			}
		}
	}

	public function add_meta_box_callback() {
		echo '<div class="rwp-description">' . $this->config['description'] . '</div>';
		$this->fields_table();
	}

	private function fields_table() {
		?><table class="form-table" role="presentation">
			<tbody><?php
				foreach ( $this->config['fields'] as $field ) {
					?><tr>
						<th scope="row"><?php $this->label( $field ); ?></th>
						<td><?php $this->field( $field ); ?></td>
					</tr><?php
				}
			?></tbody>
		</table><?php
	}

	private function label( $field ) {
		switch ( $field['type'] ) {
			case 'editor':
			case 'radio':
				echo '<div class="">' . $field['label'] . '</div>';
				break;
			case 'media':
				printf(
					'<label class="" for="%s_button">%s</label>',
					$field['id'], $field['label']
				);
				break;
			default:
				printf(
					'<label class="" for="%s">%s</label>',
					$field['id'], $field['label']
				);
		}
	}

	private function field( $field ) {
		switch ( $field['type'] ) {
			case 'checkbox':
				$this->checkbox( $field );
				break;
			case 'date':
			case 'month':
			case 'number':
			case 'range':
			case 'time':
			case 'week':
				$this->input_minmax( $field );
				break;
			case 'editor':
				$this->editor( $field );
				break;
			case 'media':
				$this->input( $field );
				$this->media_button( $field );
				break;
			case 'radio':
				$this->radio( $field );
				break;
			case 'select':
				$this->select( $field );
				break;
			case 'textarea':
				$this->textarea( $field );
				break;
			default:
				$this->input( $field );
		}
	}

	private function checkbox( $field ) {
		printf(
			'<label class="rwp-checkbox-label"><input %s id="%s" name="%s" type="checkbox"> %s</label>',
			$this->checked( $field ),
			$field['id'], $field['id'],
			isset( $field['description'] ) ? $field['description'] : ''
		);
	}

	private function editor( $field ) {
		wp_editor( $this->value( $field ), $field['id'], [
			'wpautop' => isset( $field['wpautop'] ) ? true : false,
			'media_buttons' => isset( $field['media-buttons'] ) ? true : false,
			'textarea_name' => $field['id'],
			'textarea_rows' => isset( $field['rows'] ) ? isset( $field['rows'] ) : 20,
			'teeny' => isset( $field['teeny'] ) ? true : false
		] );
	}

	private function input( $field ) {
		if ( $field['type'] === 'media' ) {
			$field['type'] = 'text';
		}
		if ( isset( $field['color-picker'] ) ) {
			$field['class'] = 'rwp-color-picker';
		}
		printf(
			'<input class="regular-text %s" id="%s" name="%s" %s type="%s" value="%s">',
			isset( $field['class'] ) ? $field['class'] : '',
			$field['id'], $field['id'],
			isset( $field['pattern'] ) ? "pattern='{$field['pattern']}'" : '',
			$field['type'],
			$this->value( $field )
		);
	}

	private function input_minmax( $field ) {
		printf(
			'<input class="regular-text" id="%s" %s %s name="%s" %s type="%s" value="%s">',
			$field['id'],
			isset( $field['max'] ) ? "max='{$field['max']}'" : '',
			isset( $field['min'] ) ? "min='{$field['min']}'" : '',
			$field['id'],
			isset( $field['step'] ) ? "step='{$field['step']}'" : '',
			$field['type'],
			$this->value( $field )
		);
	}

	private function media_button( $field ) {
		printf(
			' <button class="button rwp-media-toggle" data-modal-button="%s" data-modal-title="%s" data-return="%s" id="%s_button" name="%s_button" type="button">%s</button>',
			isset( $field['modal-button'] ) ? $field['modal-button'] : __( 'Select this file', 'your-domain' ),
			isset( $field['modal-title'] ) ? $field['modal-title'] : __( 'Choose a file', 'your-domain' ),
			$field['return'],
			$field['id'], $field['id'],
			isset( $field['button-text'] ) ? $field['button-text'] : __( 'Upload', 'your-domain' )
		);
	}

	private function radio( $field ) {
		printf(
			'<fieldset><legend class="screen-reader-text">%s</legend>%s</fieldset>',
			$field['label'],
			$this->radio_options( $field )
		);
	}

	private function radio_checked( $field, $current ) {
		$value = $this->value( $field );
		if ( $value === $current ) {
			return 'checked';
		}
		return '';
	}

	private function radio_options( $field ) {
		$output = [];
		$options = explode( "\r\n", $field['options'] );
		$i = 0;
		foreach ( $options as $option ) {
			$pair = explode( ':', $option );
			$pair = array_map( 'trim', $pair );
			$output[] = sprintf(
				'<label><input %s id="%s-%d" name="%s" type="radio" value="%s"> %s</label>',
				$this->radio_checked( $field, $pair[0] ),
				$field['id'], $i, $field['id'],
				$pair[0], $pair[1]
			);
			$i++;
		}
		return implode( '<br>', $output );
	}

	private function select( $field ) {
		printf(
			'<select id="%s" name="%s">%s</select>',
			$field['id'], $field['id'],
			$this->select_options( $field )
		);
	}

	private function select_selected( $field, $current ) {
		$value = $this->value( $field );
		if ( $value === $current ) {
			return 'selected';
		}
		return '';
	}

	private function select_options( $field ) {
		$output = [];
		$options = explode( "\r\n", $field['options'] );
		$i = 0;
		foreach ( $options as $option ) {
			$pair = explode( ':', $option );
			$pair = array_map( 'trim', $pair );
			$output[] = sprintf(
				'<option %s value="%s"> %s</option>',
				$this->select_selected( $field, $pair[0] ),
				$pair[0], $pair[1]
			);
			$i++;
		}
		return implode( '<br>', $output );
	}

	private function textarea( $field ) {
		printf(
			'<textarea class="regular-text" id="%s" name="%s" rows="%d">%s</textarea>',
			$field['id'], $field['id'],
			isset( $field['rows'] ) ? $field['rows'] : 5,
			$this->value( $field )
		);
	}

	private function value( $field ) {
		global $post;
		if ( metadata_exists( 'post', $post->ID, $field['id'] ) ) {
			$value = get_post_meta( $post->ID, $field['id'], true );
		} else if ( isset( $field['default'] ) ) {
			$value = $field['default'];
		} else {
			return '';
		}
		return str_replace( '\u0027', "'", $value );
	}

	private function checked( $field ) {
		global $post;
		if ( metadata_exists( 'post', $post->ID, $field['id'] ) ) {
			$value = get_post_meta( $post->ID, $field['id'], true );
			if ( $value === 'on' ) {
				return 'checked';
			}
			return '';
		} else if ( isset( $field['checked'] ) ) {
			return 'checked';
		}
		return '';
	}
};


// Call custm post type functions
new  CUSTOM_META_BOXES();