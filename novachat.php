<?php
/**
 * Plugin Name:       NovaChat — Live Chat Widget
 * Plugin URI:        https://github.com/novachat/novachat-wp
 * Description:       Lightweight live chat widget with Google Gemini AI integration, bot branding, quick replies, keyword auto-responder, operating hours, and sound effects.
 * Version:           1.1.0
 * Author:            NovaChat Team
 * Author URI:        https://novachat.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       novachat
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) && ! defined( 'ABSPATH' ) ) {
    die;
}

define( 'NOVACHAT_VERSION', '1.1.0' );
define( 'NOVACHAT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'NOVACHAT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'NOVACHAT_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Main NovaChat Plugin Class
 */
class NovaChat_Plugin {

    /**
     * Singleton instance
     */
    private static $instance = null;

    /**
     * Option key name in wp_options
     */
    const OPTION_KEY = 'novachat_settings';

    /**
     * Get single instance
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        // Admin hooks
        if ( is_admin() ) {
            add_action( 'admin_menu', array( $this, 'register_admin_menu' ) );
            add_action( 'admin_init', array( $this, 'register_settings' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
            add_filter( 'plugin_action_links_' . NOVACHAT_PLUGIN_BASENAME, array( $this, 'add_action_links' ) );
        }

        // Frontend hooks
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_widget' ) );

        // REST API for Gemini AI and Webhook proxying
        add_action( 'rest_api_init', array( $this, 'register_rest_routes' ) );
    }

    /**
     * Default plugin options
     */
    public static function get_default_options() {
        return array(
            'enabled'            => 1,
            'bot_name'           => 'Nova',
            'bot_title'          => 'AI Support Assistant',
            'avatar_initial'     => 'N',
            'welcome_message'    => "Hi there 👋 I'm Nova, powered by Gemini AI. Ask me anything, or pick a quick option below!",
            'placeholder'        => 'Type your message…',
            'launcher_label'     => 'Chat with us',
            'primary_color'      => '#5B4FE9',
            'accent_color'       => '#1F2430',
            'position'           => 'right',
            'show_timestamps'    => 1,
            'persist_history'    => 1,
            'sound_enabled'      => 1,
            'storage_key'        => 'novachat_history_v1',
            'quick_replies'      => "What services do you offer?\nPricing details\nTalk to a human",
            'offline_mode'       => 'always_online',
            'offline_start'      => 9,
            'offline_end'        => 18,
            'display_rule'       => 'all',
            // Gemini AI Settings
            'ai_provider'        => 'gemini', // 'gemini', 'rules', or 'webhook'
            'gemini_api_key'     => '',
            'gemini_model'       => 'gemini-1.5-flash',
            'gemini_system_prompt' => "You are Nova, a friendly, concise, and helpful customer support AI assistant for our website. Answer questions accurately, keep replies conversational and short (2-4 sentences max), and offer to connect them to human support if needed.",
            // Fallback & Rules
            'custom_responses'   => array(
                array( 'keyword' => 'pricing', 'reply' => 'We have flexible pricing plans for every need. Would you like our team to provide a custom quote?' ),
                array( 'keyword' => 'human', 'reply' => 'Sure thing! Connecting you with a human teammate. Typical reply time is under 10 minutes.' ),
                array( 'keyword' => 'hours', 'reply' => "Our team is available Monday through Friday, 9 AM to 6 PM. Our AI assistant is here 24/7!" ),
                array( 'keyword' => 'hello', 'reply' => 'Hey there! 👋 How can I help you today?' )
            ),
            'default_reply'      => "Thanks for your message! Our team will get back to you shortly — or feel free to ask another question.",
            'backend_api_url'    => ''
        );
    }

    /**
     * Get sanitized options with fallback to defaults
     */
    public static function get_options() {
        $saved = get_option( self::OPTION_KEY, array() );
        $defaults = self::get_default_options();
        return wp_parse_args( is_array( $saved ) ? $saved : array(), $defaults );
    }

    /**
     * Add settings link to Plugins page
     */
    public function add_action_links( $links ) {
        $settings_link = '<a href="' . esc_url( admin_url( 'options-general.php?page=novachat-settings' ) ) . '">' . __( 'Settings', 'novachat' ) . '</a>';
        array_unshift( $links, $settings_link );
        return $links;
    }

    /**
     * Register Admin Menu item
     */
    public function register_admin_menu() {
        add_options_page(
            __( 'NovaChat Settings', 'novachat' ),
            __( 'NovaChat Widget', 'novachat' ),
            'manage_options',
            'novachat-settings',
            array( $this, 'render_admin_page' )
        );
    }

    /**
     * Register settings and sanitize callback
     */
    public function register_settings() {
        register_setting(
            'novachat_options_group',
            self::OPTION_KEY,
            array( $this, 'sanitize_options' )
        );
    }

    /**
     * Sanitize settings on save
     */
    public function sanitize_options( $input ) {
        $defaults = self::get_default_options();
        $output = array();

        $output['enabled']         = isset( $input['enabled'] ) ? 1 : 0;
        $output['bot_name']        = sanitize_text_field( $input['bot_name'] ?? $defaults['bot_name'] );
        $output['bot_title']       = sanitize_text_field( $input['bot_title'] ?? $defaults['bot_title'] );
        $output['avatar_initial']  = sanitize_text_field( substr( $input['avatar_initial'] ?? $defaults['avatar_initial'], 0, 3 ) );
        $output['welcome_message'] = sanitize_textarea_field( $input['welcome_message'] ?? $defaults['welcome_message'] );
        $output['placeholder']     = sanitize_text_field( $input['placeholder'] ?? $defaults['placeholder'] );
        $output['launcher_label']  = sanitize_text_field( $input['launcher_label'] ?? $defaults['launcher_label'] );

        // Colors
        $output['primary_color']   = sanitize_hex_color( $input['primary_color'] ?? '' ) ?: $defaults['primary_color'];
        $output['accent_color']    = sanitize_hex_color( $input['accent_color'] ?? '' ) ?: $defaults['accent_color'];

        // Position
        $output['position']        = in_array( $input['position'] ?? '', array( 'right', 'left' ), true ) ? $input['position'] : 'right';

        // Toggles
        $output['show_timestamps'] = isset( $input['show_timestamps'] ) ? 1 : 0;
        $output['persist_history'] = isset( $input['persist_history'] ) ? 1 : 0;
        $output['sound_enabled']   = isset( $input['sound_enabled'] ) ? 1 : 0;
        $output['storage_key']     = sanitize_key( $input['storage_key'] ?? $defaults['storage_key'] );

        // Quick replies (multiline text)
        $output['quick_replies']   = sanitize_textarea_field( $input['quick_replies'] ?? $defaults['quick_replies'] );

        // Operating hours
        $output['offline_mode']    = ( isset( $input['offline_mode'] ) && 'custom_hours' === $input['offline_mode'] ) ? 'custom_hours' : 'always_online';
        $output['offline_start']   = absint( $input['offline_start'] ?? 9 );
        $output['offline_end']     = absint( $input['offline_end'] ?? 18 );

        // Display rules
        $output['display_rule']    = sanitize_text_field( $input['display_rule'] ?? 'all' );

        // AI Provider & Gemini Settings
        $output['ai_provider']          = in_array( $input['ai_provider'] ?? '', array( 'gemini', 'rules', 'webhook' ), true ) ? $input['ai_provider'] : 'gemini';
        $output['gemini_api_key']       = sanitize_text_field( trim( $input['gemini_api_key'] ?? '' ) );
        $output['gemini_model']         = sanitize_text_field( $input['gemini_model'] ?? 'gemini-1.5-flash' );
        $output['gemini_system_prompt'] = sanitize_textarea_field( $input['gemini_system_prompt'] ?? $defaults['gemini_system_prompt'] );

        // Webhook / Fallback
        $output['default_reply']   = sanitize_textarea_field( $input['default_reply'] ?? $defaults['default_reply'] );
        $output['backend_api_url'] = esc_url_raw( $input['backend_api_url'] ?? '' );

        // Custom keyword responses
        $clean_responses = array();
        if ( isset( $input['responses_keyword'] ) && is_array( $input['responses_keyword'] ) && isset( $input['responses_reply'] ) && is_array( $input['responses_reply'] ) ) {
            $keywords = array_values( $input['responses_keyword'] );
            $replies  = array_values( $input['responses_reply'] );
            $count    = count( $keywords );

            for ( $i = 0; $i < $count; $i++ ) {
                $kw  = sanitize_text_field( $keywords[ $i ] );
                $rep = sanitize_textarea_field( $replies[ $i ] ?? '' );
                if ( ! empty( $kw ) && ! empty( $rep ) ) {
                    $clean_responses[] = array(
                        'keyword' => $kw,
                        'reply'   => $rep
                    );
                }
            }
        }
        $output['custom_responses'] = ! empty( $clean_responses ) ? $clean_responses : $defaults['custom_responses'];

        return $output;
    }

    /**
     * Enqueue Admin scripts and styles
     */
    public function enqueue_admin_assets( $hook ) {
        if ( 'settings_page_novachat-settings' !== $hook ) {
            return;
        }

        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );

        wp_enqueue_style(
            'novachat-admin-style',
            NOVACHAT_PLUGIN_URL . 'assets/css/admin-style.css',
            array(),
            NOVACHAT_VERSION
        );

        wp_enqueue_script(
            'novachat-admin-script',
            NOVACHAT_PLUGIN_URL . 'assets/js/admin-script.js',
            array( 'jquery', 'wp-color-picker' ),
            NOVACHAT_VERSION,
            true
        );
    }

    /**
     * Register REST API routes for Chat / Gemini
     */
    public function register_rest_routes() {
        register_rest_route( 'novachat/v1', '/chat', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'handle_chat_request' ),
            'permission_callback' => '__return_true', // Public visitors can chat
        ) );
    }

    /**
     * Handle incoming visitor message via WordPress REST API
     */
    public function handle_chat_request( WP_REST_Request $request ) {
        $params = $request->get_json_params();
        $user_message = sanitize_text_field( $params['message'] ?? '' );

        if ( empty( $user_message ) ) {
            return new WP_REST_Response( array( 'reply' => 'Please type a message.' ), 400 );
        }

        $opts = self::get_options();
        $provider = $opts['ai_provider'] ?? 'gemini';

        // 1. If Gemini AI is selected and API key is provided
        if ( 'gemini' === $provider && ! empty( $opts['gemini_api_key'] ) ) {
            $api_key = $opts['gemini_api_key'];
            $model   = ! empty( $opts['gemini_model'] ) ? $opts['gemini_model'] : 'gemini-1.5-flash';
            $system_prompt = ! empty( $opts['gemini_system_prompt'] ) ? $opts['gemini_system_prompt'] : '';

            $gemini_url = 'https://generativelanguage.googleapis.com/v1beta/models/' . urlencode( $model ) . ':generateContent?key=' . urlencode( $api_key );

            $payload = array(
                'contents' => array(
                    array(
                        'role'  => 'user',
                        'parts' => array(
                            array( 'text' => $user_message )
                        )
                    )
                )
            );

            if ( ! empty( $system_prompt ) ) {
                $payload['systemInstruction'] = array(
                    'parts' => array(
                        array( 'text' => $system_prompt )
                    )
                );
            }

            $response = wp_remote_post( $gemini_url, array(
                'headers' => array( 'Content-Type' => 'application/json' ),
                'body'    => wp_json_encode( $payload ),
                'timeout' => 20
            ) );

            if ( ! is_wp_error( $response ) ) {
                $status_code = wp_remote_retrieve_response_code( $response );
                $body = json_decode( wp_remote_retrieve_body( $response ), true );

                if ( 200 === $status_code && isset( $body['candidates'][0]['content']['parts'][0]['text'] ) ) {
                    $reply_text = trim( $body['candidates'][0]['content']['parts'][0]['text'] );
                    return new WP_REST_Response( array(
                        'reply' => $reply_text,
                        'source' => 'gemini'
                    ), 200 );
                } elseif ( isset( $body['error']['message'] ) ) {
                    error_log( 'NovaChat Gemini API Error: ' . $body['error']['message'] );
                }
            }
        }

        // 2. Fallback to Keyword Auto-Responder rules
        $msg_lower = strtolower( $user_message );
        if ( ! empty( $opts['custom_responses'] ) && is_array( $opts['custom_responses'] ) ) {
            foreach ( $opts['custom_responses'] as $pair ) {
                if ( ! empty( $pair['keyword'] ) && false !== strpos( $msg_lower, strtolower( $pair['keyword'] ) ) ) {
                    return new WP_REST_Response( array(
                        'reply'  => $pair['reply'],
                        'source' => 'keyword'
                    ), 200 );
                }
            }
        }

        // 3. Fallback default reply
        $fallback = ! empty( $opts['default_reply'] ) ? $opts['default_reply'] : 'Thanks for reaching out! A teammate will follow up with you shortly.';
        return new WP_REST_Response( array(
            'reply'  => $fallback,
            'source' => 'default'
        ), 200 );
    }

    /**
     * Render the admin settings page
     */
    public function render_admin_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        $opts = self::get_options();
        require_once NOVACHAT_PLUGIN_DIR . 'templates/admin-settings.php';
    }

    /**
     * Enqueue chat widget on frontend
     */
    public function enqueue_frontend_widget() {
        if ( is_admin() || is_feed() || wp_is_json_request() ) {
            return;
        }

        $opts = self::get_options();

        if ( empty( $opts['enabled'] ) ) {
            return;
        }

        if ( 'front_only' === $opts['display_rule'] && ! is_front_page() ) {
            return;
        }
        if ( 'hide_logged_in' === $opts['display_rule'] && is_user_logged_in() ) {
            return;
        }

        // Parse quick replies
        $quick_replies_arr = array();
        if ( ! empty( $opts['quick_replies'] ) ) {
            $lines = explode( "\n", str_replace( "\r", "", $opts['quick_replies'] ) );
            foreach ( $lines as $line ) {
                $trimmed = trim( $line );
                if ( ! empty( $trimmed ) ) {
                    $quick_replies_arr[] = $trimmed;
                }
            }
        }

        // Build keyword response dictionary
        $responses_map = array();
        if ( ! empty( $opts['custom_responses'] ) && is_array( $opts['custom_responses'] ) ) {
            foreach ( $opts['custom_responses'] as $pair ) {
                if ( ! empty( $pair['keyword'] ) && ! empty( $pair['reply'] ) ) {
                    $responses_map[ strtolower( trim( $pair['keyword'] ) ) ] = $pair['reply'];
                }
            }
        }

        // Offline hours object
        $offline_hours = null;
        if ( 'custom_hours' === $opts['offline_mode'] ) {
            $offline_hours = array(
                'start' => intval( $opts['offline_start'] ),
                'end'   => intval( $opts['offline_end'] ),
            );
        }

        // Assemble JavaScript config object
        $js_config = array(
            'botName'        => $opts['bot_name'],
            'botTitle'       => $opts['bot_title'],
            'avatarInitial'  => $opts['avatar_initial'],
            'welcomeMessage' => $opts['welcome_message'],
            'placeholder'    => $opts['placeholder'],
            'primaryColor'   => $opts['primary_color'],
            'accentColor'    => $opts['accent_color'],
            'position'       => $opts['position'],
            'launcherLabel'  => $opts['launcher_label'],
            'quickReplies'   => $quick_replies_arr,
            'showTimestamps' => (bool) $opts['show_timestamps'],
            'persistHistory' => (bool) $opts['persist_history'],
            'soundEnabled'   => (bool) $opts['sound_enabled'],
            'storageKey'     => $opts['storage_key'],
            'offlineHours'   => $offline_hours,
            'responses'      => (object) $responses_map,
            'defaultReply'   => $opts['default_reply'],
            'aiEndpoint'     => esc_url_raw( rest_url( 'novachat/v1/chat' ) ),
            'useServerAi'    => ! empty( $opts['gemini_api_key'] ) || ! empty( $opts['backend_api_url'] )
        );

        if ( ! empty( $opts['backend_api_url'] ) ) {
            $js_config['backendApiUrl'] = $opts['backend_api_url'];
        }

        // Enqueue widget script
        wp_enqueue_script(
            'novachat-widget',
            NOVACHAT_PLUGIN_URL . 'assets/js/chat-widget.js',
            array(),
            NOVACHAT_VERSION,
            true
        );

        // Inject configuration object
        $inline_script = 'window.NovaChatConfig = ' . wp_json_encode( $js_config ) . ';';
        wp_add_inline_script( 'novachat-widget', $inline_script, 'before' );
    }
}

/**
 * Initialize NovaChat plugin
 */
function novachat_init() {
    return NovaChat_Plugin::get_instance();
}
add_action( 'plugins_loaded', 'novachat_init' );
