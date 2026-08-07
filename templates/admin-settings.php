<?php
/**
 * Admin Settings Template for AuraChat
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$aurachat_opts = self::get_options();
?>

<div class="wrap aurachat-admin-wrap">
    <div class="aurachat-header">
        <div class="aurachat-logo-area">
            <div class="aurachat-brand-badge">
                <span class="aurachat-icon-dot"></span>
                <strong>AuraChat</strong>
            </div>
            <h1><?php esc_html_e( 'AuraChat — Live Chat Widget Settings', 'aurachat-live-chat-widget' ); ?></h1>
            <p class="aurachat-tagline"><?php esc_html_e( 'Configure your live chat widget branding, Google Gemini AI integration, canned responses, and operating hours.', 'aurachat-live-chat-widget' ); ?></p>
        </div>
        <div class="aurachat-status-badge <?php echo ! empty( $aurachat_opts['enabled'] ) ? 'status-active' : 'status-inactive'; ?>">
            <span class="status-indicator"></span>
            <span><?php echo ! empty( $aurachat_opts['enabled'] ) ? esc_html__( 'Widget Active', 'aurachat-live-chat-widget' ) : esc_html__( 'Widget Disabled', 'aurachat-live-chat-widget' ); ?></span>
        </div>
    </div>

    <?php settings_errors( 'aurachat_options_group' ); ?>

    <form method="post" action="options.php" id="aurachat-settings-form">
        <?php
        settings_fields( 'aurachat_options_group' );
        ?>

        <div class="aurachat-admin-tabs">
            <button type="button" class="nav-tab nav-tab-active" data-tab="tab-gemini">
                <span class="dashicons dashicons-superhero"></span> <?php esc_html_e( 'AI Configuration', 'aurachat-live-chat-widget' ); ?>
            </button>
            <button type="button" class="nav-tab" data-tab="tab-general">
                <span class="dashicons dashicons-admin-generic"></span> <?php esc_html_e( 'General & Identity', 'aurachat-live-chat-widget' ); ?>
            </button>
            <button type="button" class="nav-tab" data-tab="tab-appearance">
                <span class="dashicons dashicons-art"></span> <?php esc_html_e( 'Design & Colors', 'aurachat-live-chat-widget' ); ?>
            </button>
            <button type="button" class="nav-tab" data-tab="tab-responses">
                <span class="dashicons dashicons-format-chat"></span> <?php esc_html_e( 'Auto-Responses', 'aurachat-live-chat-widget' ); ?>
            </button>
            <button type="button" class="nav-tab" data-tab="tab-behavior">
                <span class="dashicons dashicons-clock"></span> <?php esc_html_e( 'Behavior & Hours', 'aurachat-live-chat-widget' ); ?>
            </button>
            <button type="button" class="nav-tab" data-tab="tab-integration">
                <span class="dashicons dashicons-rest-api"></span> <?php esc_html_e( 'Custom Webhooks', 'aurachat-live-chat-widget' ); ?>
            </button>
        </div>

        <div class="aurachat-layout-grid">
            <!-- Left Main Settings Column -->
            <div class="aurachat-form-col">

                <!-- TAB: AI CONFIGURATION (DEFAULT TAB) -->
                <div class="aurachat-tab-panel active" id="tab-gemini">
                    
                    <!-- AI Provider Selector Card -->
                    <div class="aurachat-card">
                        <h3><?php esc_html_e( 'Active AI Provider', 'aurachat-live-chat-widget' ); ?></h3>
                        <p class="description"><?php esc_html_e( 'Choose the AI model provider that will power your live chat responses.', 'aurachat-live-chat-widget' ); ?></p>
                        
                        <div class="aurachat-field" style="margin-top: 15px;">
                            <select id="aurachat_ai_provider" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[ai_provider]" class="regular-text" style="font-size:14px; padding: 6px 10px; width: 100%; max-width: 400px;">
                                <option value="gemini" <?php selected( 'gemini', $aurachat_opts['ai_provider'] ?? 'gemini' ); ?>><?php esc_html_e( 'Google Gemini AI (Recommended)', 'aurachat-live-chat-widget' ); ?></option>
                                <option value="openai" <?php selected( 'openai', $aurachat_opts['ai_provider'] ?? '' ); ?>><?php esc_html_e( 'OpenAI (ChatGPT)', 'aurachat-live-chat-widget' ); ?></option>
                                <option value="anthropic" <?php selected( 'anthropic', $aurachat_opts['ai_provider'] ?? '' ); ?>><?php esc_html_e( 'Anthropic (Claude)', 'aurachat-live-chat-widget' ); ?></option>
                                <option value="rules" <?php selected( 'rules', $aurachat_opts['ai_provider'] ?? '' ); ?>><?php esc_html_e( 'Keyword Auto-Responder Rules Only', 'aurachat-live-chat-widget' ); ?></option>
                                <option value="webhook" <?php selected( 'webhook', $aurachat_opts['ai_provider'] ?? '' ); ?>><?php esc_html_e( 'Custom Webhook / External API Proxy', 'aurachat-live-chat-widget' ); ?></option>
                            </select>
                        </div>
                    </div>

                    <!-- PROVIDER CARD: Google Gemini -->
                    <div class="aurachat-card ai-provider-settings-card" id="settings-card-gemini">
                        <div class="card-header-badge">
                            <span class="badge-pill" style="background:#EBF5FF; color:#1E40AF;"><?php esc_html_e( 'Google Gemini AI', 'aurachat-live-chat-widget' ); ?></span>
                        </div>
                        <h3><?php esc_html_e( 'Google Gemini Configuration', 'aurachat-live-chat-widget' ); ?></h3>
                        <p class="description" style="font-size: 13.5px; line-height: 1.6;">
                            <?php esc_html_e( 'Answer customer questions automatically 24/7 using Google\'s efficient Gemini model. Your API key is safely stored on your server.', 'aurachat-live-chat-widget' ); ?>
                        </p>

                        <div class="gemini-info-box" style="background:#F3F4F6; padding:12px; border-radius:6px; margin: 15px 0; display:flex; align-items:center; gap:10px;">
                            <div class="gemini-info-icon" style="font-size:20px;">🔑</div>
                            <div class="gemini-info-text">
                                <strong><?php esc_html_e( 'Where to find your Gemini API Key?', 'aurachat-live-chat-widget' ); ?></strong>
                                <p style="margin: 2px 0 0 0; font-size:12px;">
                                    <?php esc_html_e( 'Get your key for free from Google AI Studio: ', 'aurachat-live-chat-widget' ); ?>
                                    <a href="https://aistudio.google.com/app/apikey" target="_blank" rel="noopener noreferrer" style="color: #5B4FE9; font-weight: 600; text-decoration: underline;">
                                        https://aistudio.google.com/app/apikey ↗
                                    </a>
                                </p>
                            </div>
                        </div>

                        <div class="aurachat-field">
                            <label for="gemini_api_key"><strong><?php esc_html_e( 'Google Gemini API Key', 'aurachat-live-chat-widget' ); ?></strong></label>
                            <div class="key-input-wrapper" style="display:flex; gap:6px;">
                                <input type="password" id="gemini_api_key" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[gemini_api_key]" value="<?php echo esc_attr( $aurachat_opts['gemini_api_key'] ?? '' ); ?>" class="large-text code-input" placeholder="AIzaSy..." autocomplete="off" />
                                <button type="button" class="button button-secondary toggle-key-visibility" title="<?php esc_attr_e( 'Show / Hide Key', 'aurachat-live-chat-widget' ); ?>">
                                    <span class="dashicons dashicons-visibility"></span>
                                </button>
                            </div>
                        </div>

                        <div class="aurachat-field">
                            <label for="gemini_model"><strong><?php esc_html_e( 'Gemini AI Model', 'aurachat-live-chat-widget' ); ?></strong></label>
                            <select id="gemini_model" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[gemini_model]" class="regular-text">
                                <option value="gemini-flash-latest" <?php selected( 'gemini-flash-latest', $aurachat_opts['gemini_model'] ?? 'gemini-flash-latest' ); ?>><?php esc_html_e( 'Gemini Flash (Recommended — Fastest & Free Tier Friendly)', 'aurachat-live-chat-widget' ); ?></option>
                                <option value="gemini-2.0-flash" <?php selected( 'gemini-2.0-flash', $aurachat_opts['gemini_model'] ?? '' ); ?>><?php esc_html_e( 'Gemini 2.0 Flash', 'aurachat-live-chat-widget' ); ?></option>
                                <option value="gemini-2.0-flash-lite" <?php selected( 'gemini-2.0-flash-lite', $aurachat_opts['gemini_model'] ?? '' ); ?>><?php esc_html_e( 'Gemini 2.0 Flash Lite', 'aurachat-live-chat-widget' ); ?></option>
                                <option value="gemini-2.5-flash" <?php selected( 'gemini-2.5-flash', $aurachat_opts['gemini_model'] ?? '' ); ?>><?php esc_html_e( 'Gemini 2.5 Flash', 'aurachat-live-chat-widget' ); ?></option>
                                <option value="gemini-2.5-pro" <?php selected( 'gemini-2.5-pro', $aurachat_opts['gemini_model'] ?? '' ); ?>><?php esc_html_e( 'Gemini 2.5 Pro', 'aurachat-live-chat-widget' ); ?></option>
                                <option value="gemini-3.5-flash" <?php selected( 'gemini-3.5-flash', $aurachat_opts['gemini_model'] ?? '' ); ?>><?php esc_html_e( 'Gemini 3.5 Flash (Next-Gen)', 'aurachat-live-chat-widget' ); ?></option>
                                <option value="gemini-1.5-pro" <?php selected( 'gemini-1.5-pro', $aurachat_opts['gemini_model'] ?? '' ); ?>><?php esc_html_e( 'Gemini 1.5 Pro (Advanced reasoning)', 'aurachat-live-chat-widget' ); ?></option>
                            </select>
                        </div>

                        <div class="aurachat-field">
                            <label for="gemini_system_prompt"><strong><?php esc_html_e( 'Gemini AI System Instructions (System Prompt)', 'aurachat-live-chat-widget' ); ?></strong></label>
                            <textarea id="gemini_system_prompt" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[gemini_system_prompt]" rows="4" class="large-text" placeholder="You are a helpful customer support bot..."><?php echo esc_textarea( $aurachat_opts['gemini_system_prompt'] ?? '' ); ?></textarea>
                            <p class="description"><?php esc_html_e( 'Define the personality, tone, and specific knowledge limits of the bot.', 'aurachat-live-chat-widget' ); ?></p>
                        </div>
                    </div>

                    <!-- PROVIDER CARD: OpenAI -->
                    <div class="aurachat-card ai-provider-settings-card" id="settings-card-openai">
                        <div class="card-header-badge">
                            <span class="badge-pill" style="background:#ECFDF5; color:#047857;"><?php esc_html_e( 'OpenAI ChatGPT', 'aurachat-live-chat-widget' ); ?></span>
                        </div>
                        <h3><?php esc_html_e( 'OpenAI Configuration', 'aurachat-live-chat-widget' ); ?></h3>
                        <p class="description" style="font-size: 13.5px; line-height: 1.6;">
                            <?php esc_html_e( 'Power your live chat using OpenAI\'s powerful GPT models (e.g. GPT-4o-mini). Requires a paid OpenAI developer account.', 'aurachat-live-chat-widget' ); ?>
                        </p>

                        <div class="gemini-info-box" style="background:#F3F4F6; padding:12px; border-radius:6px; margin: 15px 0; display:flex; align-items:center; gap:10px;">
                            <div class="gemini-info-icon" style="font-size:20px;">🔑</div>
                            <div class="gemini-info-text">
                                <strong><?php esc_html_e( 'Where to find your OpenAI API Key?', 'aurachat-live-chat-widget' ); ?></strong>
                                <p style="margin: 2px 0 0 0; font-size:12px;">
                                    <?php esc_html_e( 'Get your key from your OpenAI Developer Dashboard: ', 'aurachat-live-chat-widget' ); ?>
                                    <a href="https://platform.openai.com/api-keys" target="_blank" rel="noopener noreferrer" style="color: #5B4FE9; font-weight: 600; text-decoration: underline;">
                                        https://platform.openai.com/api-keys ↗
                                    </a>
                                </p>
                            </div>
                        </div>

                        <div class="aurachat-field">
                            <label for="openai_api_key"><strong><?php esc_html_e( 'OpenAI API Key', 'aurachat-live-chat-widget' ); ?></strong></label>
                            <div class="key-input-wrapper" style="display:flex; gap:6px;">
                                <input type="password" id="openai_api_key" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[openai_api_key]" value="<?php echo esc_attr( $aurachat_opts['openai_api_key'] ?? '' ); ?>" class="large-text code-input" placeholder="sk-proj-..." autocomplete="off" />
                                <button type="button" class="button button-secondary toggle-key-visibility" title="<?php esc_attr_e( 'Show / Hide Key', 'aurachat-live-chat-widget' ); ?>">
                                    <span class="dashicons dashicons-visibility"></span>
                                </button>
                            </div>
                        </div>

                        <div class="aurachat-field">
                            <label for="openai_model"><strong><?php esc_html_e( 'OpenAI Model', 'aurachat-live-chat-widget' ); ?></strong></label>
                            <select id="openai_model" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[openai_model]" class="regular-text">
                                <option value="gpt-4o-mini" <?php selected( 'gpt-4o-mini', $aurachat_opts['openai_model'] ?? 'gpt-4o-mini' ); ?>><?php esc_html_e( 'GPT-4o Mini (Recommended — Fast & Low Cost)', 'aurachat-live-chat-widget' ); ?></option>
                                <option value="gpt-4o" <?php selected( 'gpt-4o', $aurachat_opts['openai_model'] ?? '' ); ?>><?php esc_html_e( 'GPT-4o (Premium Multimodal)', 'aurachat-live-chat-widget' ); ?></option>
                                <option value="o1-mini" <?php selected( 'o1-mini', $aurachat_opts['openai_model'] ?? '' ); ?>><?php esc_html_e( 'o1-mini (Reasoning Model)', 'aurachat-live-chat-widget' ); ?></option>
                                <option value="o1-preview" <?php selected( 'o1-preview', $aurachat_opts['openai_model'] ?? '' ); ?>><?php esc_html_e( 'o1-preview (Reasoning Model)', 'aurachat-live-chat-widget' ); ?></option>
                                <option value="gpt-4-turbo" <?php selected( 'gpt-4-turbo', $aurachat_opts['openai_model'] ?? '' ); ?>><?php esc_html_e( 'GPT-4 Turbo', 'aurachat-live-chat-widget' ); ?></option>
                                <option value="gpt-3.5-turbo" <?php selected( 'gpt-3.5-turbo', $aurachat_opts['openai_model'] ?? '' ); ?>><?php esc_html_e( 'GPT-3.5 Turbo (Legacy)', 'aurachat-live-chat-widget' ); ?></option>
                            </select>
                        </div>

                        <div class="aurachat-field">
                            <label for="openai_system_prompt"><strong><?php esc_html_e( 'OpenAI System Instructions (System Prompt)', 'aurachat-live-chat-widget' ); ?></strong></label>
                            <textarea id="openai_system_prompt" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[openai_system_prompt]" rows="4" class="large-text" placeholder="You are a helpful customer support bot..."><?php echo esc_textarea( $aurachat_opts['openai_system_prompt'] ?? '' ); ?></textarea>
                            <p class="description"><?php esc_html_e( 'Define the personality, tone, and specific knowledge limits of the bot.', 'aurachat-live-chat-widget' ); ?></p>
                        </div>
                    </div>

                    <!-- PROVIDER CARD: Anthropic -->
                    <div class="aurachat-card ai-provider-settings-card" id="settings-card-anthropic">
                        <div class="card-header-badge">
                            <span class="badge-pill" style="background:#FFF7ED; color:#C2410C;"><?php esc_html_e( 'Anthropic Claude', 'aurachat-live-chat-widget' ); ?></span>
                        </div>
                        <h3><?php esc_html_e( 'Anthropic Claude Configuration', 'aurachat-live-chat-widget' ); ?></h3>
                        <p class="description" style="font-size: 13.5px; line-height: 1.6;">
                            <?php esc_html_e( 'Power your live chat using Anthropic\'s high-quality Claude models (e.g. Claude 3.5 Haiku). Requires a paid Anthropic Console account.', 'aurachat-live-chat-widget' ); ?>
                        </p>

                        <div class="gemini-info-box" style="background:#F3F4F6; padding:12px; border-radius:6px; margin: 15px 0; display:flex; align-items:center; gap:10px;">
                            <div class="gemini-info-icon" style="font-size:20px;">🔑</div>
                            <div class="gemini-info-text">
                                <strong><?php esc_html_e( 'Where to find your Anthropic API Key?', 'aurachat-live-chat-widget' ); ?></strong>
                                <p style="margin: 2px 0 0 0; font-size:12px;">
                                    <?php esc_html_e( 'Get your key from your Anthropic Console Dashboard: ', 'aurachat-live-chat-widget' ); ?>
                                    <a href="https://console.anthropic.com/settings/keys" target="_blank" rel="noopener noreferrer" style="color: #5B4FE9; font-weight: 600; text-decoration: underline;">
                                        https://console.anthropic.com/settings/keys ↗
                                    </a>
                                </p>
                            </div>
                        </div>

                        <div class="aurachat-field">
                            <label for="anthropic_api_key"><strong><?php esc_html_e( 'Anthropic API Key', 'aurachat-live-chat-widget' ); ?></strong></label>
                            <div class="key-input-wrapper" style="display:flex; gap:6px;">
                                <input type="password" id="anthropic_api_key" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[anthropic_api_key]" value="<?php echo esc_attr( $aurachat_opts['anthropic_api_key'] ?? '' ); ?>" class="large-text code-input" placeholder="sk-ant-..." autocomplete="off" />
                                <button type="button" class="button button-secondary toggle-key-visibility" title="<?php esc_attr_e( 'Show / Hide Key', 'aurachat-live-chat-widget' ); ?>">
                                    <span class="dashicons dashicons-visibility"></span>
                                </button>
                            </div>
                        </div>

                        <div class="aurachat-field">
                            <label for="anthropic_model"><strong><?php esc_html_e( 'Claude Model', 'aurachat-live-chat-widget' ); ?></strong></label>
                            <select id="anthropic_model" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[anthropic_model]" class="regular-text">
                                <option value="claude-3-5-haiku-20241022" <?php selected( 'claude-3-5-haiku-20241022', $aurachat_opts['anthropic_model'] ?? 'claude-3-5-haiku-20241022' ); ?>><?php esc_html_e( 'Claude 3.5 Haiku (Recommended — Fast & Intelligent)', 'aurachat-live-chat-widget' ); ?></option>
                                <option value="claude-3-5-sonnet-20241022" <?php selected( 'claude-3-5-sonnet-20241022', $aurachat_opts['anthropic_model'] ?? '' ); ?>><?php esc_html_e( 'Claude 3.5 Sonnet (State-of-the-Art Reasoning)', 'aurachat-live-chat-widget' ); ?></option>
                                <option value="claude-3-opus-20240229" <?php selected( 'claude-3-opus-20240229', $aurachat_opts['anthropic_model'] ?? '' ); ?>><?php esc_html_e( 'Claude 3 Opus (Premium Creative Reasoning)', 'aurachat-live-chat-widget' ); ?></option>
                                <option value="claude-3-haiku-20240307" <?php selected( 'claude-3-haiku-20240307', $aurachat_opts['anthropic_model'] ?? '' ); ?>><?php esc_html_e( 'Claude 3 Haiku (Legacy)', 'aurachat-live-chat-widget' ); ?></option>
                            </select>
                        </div>

                        <div class="aurachat-field">
                            <label for="anthropic_system_prompt"><strong><?php esc_html_e( 'Claude System Instructions (System Prompt)', 'aurachat-live-chat-widget' ); ?></strong></label>
                            <textarea id="anthropic_system_prompt" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[anthropic_system_prompt]" rows="4" class="large-text" placeholder="You are a helpful customer support bot..."><?php echo esc_textarea( $aurachat_opts['anthropic_system_prompt'] ?? '' ); ?></textarea>
                            <p class="description"><?php esc_html_e( 'Define the personality, tone, and specific knowledge limits of the bot.', 'aurachat-live-chat-widget' ); ?></p>
                        </div>
                    </div>

                    <!-- PROVIDER CARD: Keyword Rules Info -->
                    <div class="aurachat-card ai-provider-settings-card" id="settings-card-rules">
                        <h3><?php esc_html_e( 'Keyword Auto-Responder Rules Active', 'aurachat-live-chat-widget' ); ?></h3>
                        <p class="description">
                            <?php esc_html_e( 'You have selected "Keyword Auto-Responder Rules Only". The widget will bypass AI generation and respond instantly using your custom keywords.', 'aurachat-live-chat-widget' ); ?>
                        </p>
                        <p style="margin-top:15px; font-weight:600;">
                            <?php esc_html_e( 'Configure your triggers and replies in the ', 'aurachat-live-chat-widget' ); ?>
                            <a href="#" class="aurachat-go-to-tab" data-target-tab="tab-responses" style="color:#5B4FE9; text-decoration:underline;">
                                <?php esc_html_e( 'Auto-Responses Tab', 'aurachat-live-chat-widget' ); ?>
                            </a>
                        </p>
                    </div>

                    <!-- PROVIDER CARD: Webhook Info -->
                    <div class="aurachat-card ai-provider-settings-card" id="settings-card-webhook">
                        <h3><?php esc_html_e( 'Custom Webhook Active', 'aurachat-live-chat-widget' ); ?></h3>
                        <p class="description">
                            <?php esc_html_e( 'You have selected "Custom Webhook / External API Proxy". Messages will be forwarded directly to your custom backend service URL.', 'aurachat-live-chat-widget' ); ?>
                        </p>
                        <p style="margin-top:15px; font-weight:600;">
                            <?php esc_html_e( 'Configure your backend webhook settings in the ', 'aurachat-live-chat-widget' ); ?>
                            <a href="#" class="aurachat-go-to-tab" data-target-tab="tab-integration" style="color:#5B4FE9; text-decoration:underline;">
                                <?php esc_html_e( 'Custom Webhooks Tab', 'aurachat-live-chat-widget' ); ?>
                            </a>
                        </p>
                    </div>

                </div>

                <!-- TAB: GENERAL -->
                <div class="aurachat-tab-panel" id="tab-general">
                    <div class="aurachat-card">
                        <h3><?php esc_html_e( 'Widget Activation', 'aurachat-live-chat-widget' ); ?></h3>
                        <div class="aurachat-field toggle-field">
                            <label class="switch-label">
                                <input type="checkbox" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[enabled]" value="1" <?php checked( 1, $aurachat_opts['enabled'] ); ?> id="aurachat-toggle-enabled" />
                                <span class="slider"></span>
                                <span class="label-text"><strong><?php esc_html_e( 'Enable Chat Widget on Website', 'aurachat-live-chat-widget' ); ?></strong></span>
                            </label>
                            <p class="description"><?php esc_html_e( 'Turn this off to temporarily hide the chat widget across your website.', 'aurachat-live-chat-widget' ); ?></p>
                        </div>
                    </div>

                    <div class="aurachat-card">
                        <h3><?php esc_html_e( 'Bot Identity & Labels', 'aurachat-live-chat-widget' ); ?></h3>

                        <div class="aurachat-grid-2">
                            <div class="aurachat-field">
                                <label for="bot_name"><strong><?php esc_html_e( 'Bot / Agent Name', 'aurachat-live-chat-widget' ); ?></strong></label>
                                <input type="text" id="bot_name" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[bot_name]" value="<?php echo esc_attr( $aurachat_opts['bot_name'] ); ?>" class="regular-text" placeholder="e.g. Nova" required />
                                <p class="description"><?php esc_html_e( 'Name displayed in header and message bubbles.', 'aurachat-live-chat-widget' ); ?></p>
                            </div>

                            <div class="aurachat-field">
                                <label for="bot_title"><strong><?php esc_html_e( 'Role / Subtitle', 'aurachat-live-chat-widget' ); ?></strong></label>
                                <input type="text" id="bot_title" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[bot_title]" value="<?php echo esc_attr( $aurachat_opts['bot_title'] ); ?>" class="regular-text" placeholder="e.g. AI Support Assistant" />
                                <p class="description"><?php esc_html_e( 'Subtitle shown directly beneath the name.', 'aurachat-live-chat-widget' ); ?></p>
                            </div>
                        </div>

                        <div class="aurachat-grid-2">
                            <div class="aurachat-field">
                                <label for="avatar_initial"><strong><?php esc_html_e( 'Avatar Initial / Icon Letter', 'aurachat-live-chat-widget' ); ?></strong></label>
                                <input type="text" id="avatar_initial" maxlength="3" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[avatar_initial]" value="<?php echo esc_attr( $aurachat_opts['avatar_initial'] ); ?>" class="small-text" style="text-align:center;font-weight:bold;font-size:16px;" />
                                <p class="description"><?php esc_html_e( '1-2 characters for the avatar circle (e.g. "N" or "🤖").', 'aurachat-live-chat-widget' ); ?></p>
                            </div>

                            <div class="aurachat-field">
                                <label for="launcher_label"><strong><?php esc_html_e( 'Launcher Button Tooltip / ARIA Label', 'aurachat-live-chat-widget' ); ?></strong></label>
                                <input type="text" id="launcher_label" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[launcher_label]" value="<?php echo esc_attr( $aurachat_opts['launcher_label'] ); ?>" class="regular-text" placeholder="Chat with us" />
                            </div>
                        </div>

                        <div class="aurachat-field">
                            <label for="welcome_message"><strong><?php esc_html_e( 'Welcome Greeting Message', 'aurachat-live-chat-widget' ); ?></strong></label>
                            <textarea id="welcome_message" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[welcome_message]" rows="3" class="large-text" placeholder="Type your greeting message..."><?php echo esc_textarea( $aurachat_opts['welcome_message'] ); ?></textarea>
                            <p class="description"><?php esc_html_e( 'The first message the visitor sees when opening the chat widget.', 'aurachat-live-chat-widget' ); ?></p>
                        </div>

                        <div class="aurachat-field">
                            <label for="placeholder"><strong><?php esc_html_e( 'Input Placeholder Text', 'aurachat-live-chat-widget' ); ?></strong></label>
                            <input type="text" id="placeholder" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[placeholder]" value="<?php echo esc_attr( $aurachat_opts['placeholder'] ); ?>" class="large-text" placeholder="Type your message…" />
                        </div>
                    </div>
                </div>

                <!-- TAB: APPEARANCE -->
                <div class="aurachat-tab-panel" id="tab-appearance">
                    <div class="aurachat-card">
                        <h3><?php esc_html_e( 'Color Palette & Styling', 'aurachat-live-chat-widget' ); ?></h3>

                        <div class="aurachat-grid-2">
                            <div class="aurachat-field">
                                <label for="primary_color"><strong><?php esc_html_e( 'Primary Brand Accent Color', 'aurachat-live-chat-widget' ); ?></strong></label>
                                <input type="text" id="primary_color" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[primary_color]" value="<?php echo esc_attr( $aurachat_opts['primary_color'] ); ?>" class="aurachat-color-picker" />
                                <p class="description"><?php esc_html_e( 'Used for launcher button, user bubbles, send button, and active chips.', 'aurachat-live-chat-widget' ); ?></p>
                            </div>

                            <div class="aurachat-field">
                                <label for="accent_color"><strong><?php esc_html_e( 'Header & Dark Text Color', 'aurachat-live-chat-widget' ); ?></strong></label>
                                <input type="text" id="accent_color" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[accent_color]" value="<?php echo esc_attr( $aurachat_opts['accent_color'] ); ?>" class="aurachat-color-picker" />
                                <p class="description"><?php esc_html_e( 'Background color of the chat widget header and dark text elements.', 'aurachat-live-chat-widget' ); ?></p>
                            </div>
                        </div>

                        <hr class="aurachat-divider" />

                        <div class="aurachat-field">
                            <label><strong><?php esc_html_e( 'Widget Position on Screen', 'aurachat-live-chat-widget' ); ?></strong></label>
                            <div class="aurachat-radio-cards">
                                <label class="radio-card <?php echo 'right' === $aurachat_opts['position'] ? 'selected' : ''; ?>">
                                    <input type="radio" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[position]" value="right" <?php checked( 'right', $aurachat_opts['position'] ); ?> />
                                    <div class="radio-card-body">
                                        <span class="dashicons dashicons-align-right"></span>
                                        <strong><?php esc_html_e( 'Bottom Right (Standard)', 'aurachat-live-chat-widget' ); ?></strong>
                                        <p><?php esc_html_e( 'Pinned to bottom-right corner of viewport.', 'aurachat-live-chat-widget' ); ?></p>
                                    </div>
                                </label>
                                <label class="radio-card <?php echo 'left' === $aurachat_opts['position'] ? 'selected' : ''; ?>">
                                    <input type="radio" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[position]" value="left" <?php checked( 'left', $aurachat_opts['position'] ); ?> />
                                    <div class="radio-card-body">
                                        <span class="dashicons dashicons-align-left"></span>
                                        <strong><?php esc_html_e( 'Bottom Left', 'aurachat-live-chat-widget' ); ?></strong>
                                        <p><?php esc_html_e( 'Pinned to bottom-left corner of viewport.', 'aurachat-live-chat-widget' ); ?></p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB: AUTO RESPONSES -->
                <div class="aurachat-tab-panel" id="tab-responses">
                    <div class="aurachat-card">
                        <h3><?php esc_html_e( 'Quick Reply Suggestion Chips', 'aurachat-live-chat-widget' ); ?></h3>
                        <p class="description"><?php esc_html_e( 'Enter suggestion buttons shown above the input box (one per line).', 'aurachat-live-chat-widget' ); ?></p>
                        <div class="aurachat-field">
                            <textarea id="quick_replies" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[quick_replies]" rows="4" class="large-text" placeholder="What services do you offer?&#10;Pricing details&#10;Talk to a human"><?php echo esc_textarea( $aurachat_opts['quick_replies'] ); ?></textarea>
                        </div>
                    </div>

                    <div class="aurachat-card">
                        <div class="card-header-flex">
                            <div>
                                <h3><?php esc_html_e( 'Instant Keyword Rules (Fast Matcher)', 'aurachat-live-chat-widget' ); ?></h3>
                                <p class="description"><?php esc_html_e( 'Trigger instant canned replies when Gemini AI is not configured or for specific keywords.', 'aurachat-live-chat-widget' ); ?></p>
                            </div>
                            <button type="button" class="button button-secondary" id="aurachat-add-response-btn">
                                <span class="dashicons dashicons-plus-alt2"></span> <?php esc_html_e( 'Add New Rule', 'aurachat-live-chat-widget' ); ?>
                            </button>
                        </div>

                        <div id="aurachat-responses-container" class="aurachat-rules-table">
                            <div class="rules-header">
                                <div class="col-kw"><?php esc_html_e( 'Keyword Trigger', 'aurachat-live-chat-widget' ); ?></div>
                                <div class="col-reply"><?php esc_html_e( 'Bot Auto-Reply Message', 'aurachat-live-chat-widget' ); ?></div>
                                <div class="col-act"><?php esc_html_e( 'Action', 'aurachat-live-chat-widget' ); ?></div>
                            </div>
                            <?php
                            if ( ! empty( $aurachat_opts['custom_responses'] ) && is_array( $aurachat_opts['custom_responses'] ) ) :
                                foreach ( $aurachat_opts['custom_responses'] as $aurachat_idx => $aurachat_item ) :
                            ?>
                                <div class="rule-row">
                                    <div class="col-kw">
                                        <input type="text" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[responses_keyword][]" value="<?php echo esc_attr( $aurachat_item['keyword'] ?? '' ); ?>" placeholder="e.g. pricing, refund" class="regular-text" required />
                                    </div>
                                    <div class="col-reply">
                                        <textarea name="<?php echo esc_attr( self::OPTION_KEY ); ?>[responses_reply][]" rows="2" class="large-text" placeholder="Bot reply content..." required><?php echo esc_textarea( $aurachat_item['reply'] ?? '' ); ?></textarea>
                                    </div>
                                    <div class="col-act">
                                        <button type="button" class="button button-link-delete aurachat-remove-row" title="<?php esc_attr_e( 'Remove Rule', 'aurachat-live-chat-widget' ); ?>">
                                            <span class="dashicons dashicons-trash"></span>
                                        </button>
                                    </div>
                                </div>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </div>

                        <hr class="aurachat-divider" />

                        <div class="aurachat-field">
                            <label for="default_reply"><strong><?php esc_html_e( 'Default Fallback Reply', 'aurachat-live-chat-widget' ); ?></strong></label>
                            <textarea id="default_reply" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[default_reply]" rows="3" class="large-text"><?php echo esc_textarea( $aurachat_opts['default_reply'] ); ?></textarea>
                            <p class="description"><?php esc_html_e( 'Used when Gemini AI or keyword rules do not return a match.', 'aurachat-live-chat-widget' ); ?></p>
                        </div>
                    </div>
                </div>

                <!-- TAB: BEHAVIOR & HOURS -->
                <div class="aurachat-tab-panel" id="tab-behavior">
                    <div class="aurachat-card">
                        <h3><?php esc_html_e( 'Widget Behavior & Storage', 'aurachat-live-chat-widget' ); ?></h3>

                        <div class="aurachat-checkbox-group">
                            <label>
                                <input type="checkbox" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[show_timestamps]" value="1" <?php checked( 1, $aurachat_opts['show_timestamps'] ); ?> />
                                <strong><?php esc_html_e( 'Show message timestamps (e.g. 10:30 AM)', 'aurachat-live-chat-widget' ); ?></strong>
                            </label>

                            <label>
                                <input type="checkbox" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[persist_history]" value="1" <?php checked( 1, $aurachat_opts['persist_history'] ); ?> />
                                <strong><?php esc_html_e( 'Save conversation history across page refreshes (localStorage)', 'aurachat-live-chat-widget' ); ?></strong>
                            </label>

                            <label>
                                <input type="checkbox" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[sound_enabled]" value="1" <?php checked( 1, $aurachat_opts['sound_enabled'] ); ?> />
                                <strong><?php esc_html_e( 'Enable audio ping notification on new bot messages', 'aurachat-live-chat-widget' ); ?></strong>
                            </label>
                        </div>

                        <hr class="aurachat-divider" />

                        <div class="aurachat-field">
                            <label for="storage_key"><strong><?php esc_html_e( 'LocalStorage Storage Key', 'aurachat-live-chat-widget' ); ?></strong></label>
                            <input type="text" id="storage_key" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[storage_key]" value="<?php echo esc_attr( $aurachat_opts['storage_key'] ); ?>" class="regular-text" />
                            <p class="description"><?php esc_html_e( 'Change this key if you ever want to force-reset client chat histories site-wide.', 'aurachat-live-chat-widget' ); ?></p>
                        </div>
                    </div>

                    <div class="aurachat-card">
                        <h3><?php esc_html_e( 'Operating Hours & Availability Dot', 'aurachat-live-chat-widget' ); ?></h3>

                        <div class="aurachat-field">
                            <label>
                                <input type="radio" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[offline_mode]" value="always_online" <?php checked( 'always_online', $aurachat_opts['offline_mode'] ); ?> class="hours-toggle" />
                                <strong><?php esc_html_e( 'Always Online (24/7 Green Dot)', 'aurachat-live-chat-widget' ); ?></strong>
                            </label>
                        </div>

                        <div class="aurachat-field">
                            <label>
                                <input type="radio" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[offline_mode]" value="custom_hours" <?php checked( 'custom_hours', $aurachat_opts['offline_mode'] ); ?> class="hours-toggle" />
                                <strong><?php esc_html_e( 'Custom Business Hours (Local Visitor Time)', 'aurachat-live-chat-widget' ); ?></strong>
                            </label>
                        </div>

                        <div id="custom-hours-fields" class="aurachat-hours-box" style="<?php echo 'custom_hours' === $aurachat_opts['offline_mode'] ? '' : 'display:none;'; ?>">
                            <div class="aurachat-grid-2">
                                <div>
                                    <label for="offline_start"><?php esc_html_e( 'Opening Hour (0-23)', 'aurachat-live-chat-widget' ); ?></label>
                                    <input type="number" min="0" max="23" id="offline_start" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[offline_start]" value="<?php echo esc_attr( $aurachat_opts['offline_start'] ); ?>" class="small-text" />
                                    <span class="hours-suffix">:00 (e.g. 9 = 9 AM)</span>
                                </div>
                                <div>
                                    <label for="offline_end"><?php esc_html_e( 'Closing Hour (0-23)', 'aurachat-live-chat-widget' ); ?></label>
                                    <input type="number" min="0" max="23" id="offline_end" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[offline_end]" value="<?php echo esc_attr( $aurachat_opts['offline_end'] ); ?>" class="small-text" />
                                    <span class="hours-suffix">:00 (e.g. 18 = 6 PM)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="aurachat-card">
                        <h3><?php esc_html_e( 'Display Visibility Rules', 'aurachat-live-chat-widget' ); ?></h3>
                        <div class="aurachat-field">
                            <select name="<?php echo esc_attr( self::OPTION_KEY ); ?>[display_rule]" id="display_rule" class="regular-text">
                                <option value="all" <?php selected( 'all', $aurachat_opts['display_rule'] ); ?>><?php esc_html_e( 'Show on all public pages (Recommended)', 'aurachat-live-chat-widget' ); ?></option>
                                <option value="front_only" <?php selected( 'front_only', $aurachat_opts['display_rule'] ); ?>><?php esc_html_e( 'Show only on Homepage / Front Page', 'aurachat-live-chat-widget' ); ?></option>
                                <option value="hide_logged_in" <?php selected( 'hide_logged_in', $aurachat_opts['display_rule'] ); ?>><?php esc_html_e( 'Hide for logged-in WordPress users', 'aurachat-live-chat-widget' ); ?></option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- TAB: CUSTOM WEBHOOKS -->
                <div class="aurachat-tab-panel" id="tab-integration">
                    <div class="aurachat-card">
                        <h3><?php esc_html_e( 'External Custom Webhook / API Endpoint', 'aurachat-live-chat-widget' ); ?></h3>
                        <p class="description"><?php esc_html_e( 'Optional: If you prefer using your own custom server, Make.com, or Zapier instead of direct Google Gemini AI, enter your webhook endpoint below.', 'aurachat-live-chat-widget' ); ?></p>
                        
                        <div class="aurachat-field">
                            <label for="backend_api_url"><strong><?php esc_html_e( 'POST Webhook / API URL', 'aurachat-live-chat-widget' ); ?></strong></label>
                            <input type="url" id="backend_api_url" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[backend_api_url]" value="<?php echo esc_url( $aurachat_opts['backend_api_url'] ); ?>" class="large-text" placeholder="https://api.yourdomain.com/v1/chat" />
                        </div>
                    </div>
                </div>

                <div class="aurachat-submit-bar">
                    <?php submit_button( __( 'Save All Changes', 'aurachat-live-chat-widget' ), 'primary button-hero', 'submit', false ); ?>
                </div>

            </div>

            <!-- Right Live Preview Column -->
            <div class="aurachat-preview-col">
                <div class="aurachat-preview-card">
                    <div class="preview-header">
                        <h4><span class="dashicons dashicons-visibility"></span> <?php esc_html_e( 'Interactive Widget Preview', 'aurachat-live-chat-widget' ); ?></h4>
                        <span class="preview-badge"><?php esc_html_e( 'Live', 'aurachat-live-chat-widget' ); ?></span>
                    </div>
                    <div class="preview-screen-wrapper">
                        <div class="mockup-browser">
                            <div class="mockup-bar">
                                <span class="mock-dot red"></span>
                                <span class="mock-dot yellow"></span>
                                <span class="mock-dot green"></span>
                                <span class="mock-url"><?php echo esc_html( home_url() ); ?></span>
                            </div>
                            <div class="mockup-content">
                                <div class="mock-text-line short"></div>
                                <div class="mock-text-line"></div>
                                <div class="mock-text-line half"></div>
                                
                                <!-- Mockup widget -->
                                <div class="mock-widget-preview" id="mockup-widget-box">
                                    <div class="mock-chat-bubble" id="mock-launcher-btn">
                                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="#fff" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                                    </div>
                                    <div class="mock-window" id="mock-chat-window">
                                        <div class="mock-win-header" id="mock-header">
                                            <div class="mock-avatar" id="mock-avatar">N</div>
                                            <div class="mock-win-info">
                                                <div class="mock-bot-name" id="mock-bot-name">Nova</div>
                                                <div class="mock-bot-sub" id="mock-bot-sub">AI Support Assistant</div>
                                            </div>
                                        </div>
                                        <div class="mock-win-body">
                                            <div class="mock-bot-msg" id="mock-welcome-msg"><?php echo esc_html( $aurachat_opts['welcome_message'] ); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="preview-hint"><?php esc_html_e( 'Colors and labels update in real-time as you edit the settings.', 'aurachat-live-chat-widget' ); ?></p>
                </div>
            </div>

        </div>
    </form>
</div>
