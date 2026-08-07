<?php
/**
 * Admin Settings Template for NovaChat
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$opts = self::get_options();
?>

<div class="wrap novachat-admin-wrap">
    <div class="novachat-header">
        <div class="novachat-logo-area">
            <div class="novachat-brand-badge">
                <span class="novachat-icon-dot"></span>
                <strong>NovaChat</strong>
            </div>
            <h1><?php esc_html_e( 'NovaChat — Live Chat Widget Settings', 'novachat' ); ?></h1>
            <p class="novachat-tagline"><?php esc_html_e( 'Configure your live chat widget branding, Google Gemini AI integration, canned responses, and operating hours.', 'novachat' ); ?></p>
        </div>
        <div class="novachat-status-badge <?php echo ! empty( $opts['enabled'] ) ? 'status-active' : 'status-inactive'; ?>">
            <span class="status-indicator"></span>
            <span><?php echo ! empty( $opts['enabled'] ) ? esc_html__( 'Widget Active', 'novachat' ) : esc_html__( 'Widget Disabled', 'novachat' ); ?></span>
        </div>
    </div>

    <?php settings_errors( 'novachat_options_group' ); ?>

    <form method="post" action="options.php" id="novachat-settings-form">
        <?php
        settings_fields( 'novachat_options_group' );
        ?>

        <div class="novachat-admin-tabs">
            <button type="button" class="nav-tab nav-tab-active" data-tab="tab-gemini">
                <span class="dashicons dashicons-superhero"></span> <?php esc_html_e( 'AI Configuration', 'novachat' ); ?>
            </button>
            <button type="button" class="nav-tab" data-tab="tab-general">
                <span class="dashicons dashicons-admin-generic"></span> <?php esc_html_e( 'General & Identity', 'novachat' ); ?>
            </button>
            <button type="button" class="nav-tab" data-tab="tab-appearance">
                <span class="dashicons dashicons-art"></span> <?php esc_html_e( 'Design & Colors', 'novachat' ); ?>
            </button>
            <button type="button" class="nav-tab" data-tab="tab-responses">
                <span class="dashicons dashicons-format-chat"></span> <?php esc_html_e( 'Auto-Responses', 'novachat' ); ?>
            </button>
            <button type="button" class="nav-tab" data-tab="tab-behavior">
                <span class="dashicons dashicons-clock"></span> <?php esc_html_e( 'Behavior & Hours', 'novachat' ); ?>
            </button>
            <button type="button" class="nav-tab" data-tab="tab-integration">
                <span class="dashicons dashicons-rest-api"></span> <?php esc_html_e( 'Custom Webhooks', 'novachat' ); ?>
            </button>
        </div>

        <div class="novachat-layout-grid">
            <!-- Left Main Settings Column -->
            <div class="novachat-form-col">

                <!-- TAB: AI CONFIGURATION (DEFAULT TAB) -->
                <div class="novachat-tab-panel active" id="tab-gemini">
                    
                    <!-- AI Provider Selector Card -->
                    <div class="novachat-card">
                        <h3><?php esc_html_e( 'Active AI Provider', 'novachat' ); ?></h3>
                        <p class="description"><?php esc_html_e( 'Choose the AI model provider that will power your live chat responses.', 'novachat' ); ?></p>
                        
                        <div class="novachat-field" style="margin-top: 15px;">
                            <select id="novachat_ai_provider" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[ai_provider]" class="regular-text" style="font-size:14px; padding: 6px 10px; width: 100%; max-width: 400px;">
                                <option value="gemini" <?php selected( 'gemini', $opts['ai_provider'] ?? 'gemini' ); ?>><?php esc_html_e( 'Google Gemini AI (Recommended)', 'novachat' ); ?></option>
                                <option value="openai" <?php selected( 'openai', $opts['ai_provider'] ?? '' ); ?>><?php esc_html_e( 'OpenAI (ChatGPT)', 'novachat' ); ?></option>
                                <option value="anthropic" <?php selected( 'anthropic', $opts['ai_provider'] ?? '' ); ?>><?php esc_html_e( 'Anthropic (Claude)', 'novachat' ); ?></option>
                                <option value="rules" <?php selected( 'rules', $opts['ai_provider'] ?? '' ); ?>><?php esc_html_e( 'Keyword Auto-Responder Rules Only', 'novachat' ); ?></option>
                                <option value="webhook" <?php selected( 'webhook', $opts['ai_provider'] ?? '' ); ?>><?php esc_html_e( 'Custom Webhook / External API Proxy', 'novachat' ); ?></option>
                            </select>
                        </div>
                    </div>

                    <!-- PROVIDER CARD: Google Gemini -->
                    <div class="novachat-card ai-provider-settings-card" id="settings-card-gemini">
                        <div class="card-header-badge">
                            <span class="badge-pill" style="background:#EBF5FF; color:#1E40AF;"><?php esc_html_e( 'Google Gemini AI', 'novachat' ); ?></span>
                        </div>
                        <h3><?php esc_html_e( 'Google Gemini Configuration', 'novachat' ); ?></h3>
                        <p class="description" style="font-size: 13.5px; line-height: 1.6;">
                            <?php esc_html_e( 'Answer customer questions automatically 24/7 using Google\'s efficient Gemini model. Your API key is safely stored on your server.', 'novachat' ); ?>
                        </p>

                        <div class="gemini-info-box" style="background:#F3F4F6; padding:12px; border-radius:6px; margin: 15px 0; display:flex; align-items:center; gap:10px;">
                            <div class="gemini-info-icon" style="font-size:20px;">🔑</div>
                            <div class="gemini-info-text">
                                <strong><?php esc_html_e( 'Where to find your Gemini API Key?', 'novachat' ); ?></strong>
                                <p style="margin: 2px 0 0 0; font-size:12px;">
                                    <?php esc_html_e( 'Get your key for free from Google AI Studio: ', 'novachat' ); ?>
                                    <a href="https://aistudio.google.com/app/apikey" target="_blank" rel="noopener noreferrer" style="color: #5B4FE9; font-weight: 600; text-decoration: underline;">
                                        https://aistudio.google.com/app/apikey ↗
                                    </a>
                                </p>
                            </div>
                        </div>

                        <div class="novachat-field">
                            <label for="gemini_api_key"><strong><?php esc_html_e( 'Google Gemini API Key', 'novachat' ); ?></strong></label>
                            <div class="key-input-wrapper" style="display:flex; gap:6px;">
                                <input type="password" id="gemini_api_key" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[gemini_api_key]" value="<?php echo esc_attr( $opts['gemini_api_key'] ?? '' ); ?>" class="large-text code-input" placeholder="AIzaSy..." autocomplete="off" />
                                <button type="button" class="button button-secondary toggle-key-visibility" title="<?php esc_attr_e( 'Show / Hide Key', 'novachat' ); ?>">
                                    <span class="dashicons dashicons-visibility"></span>
                                </button>
                            </div>
                        </div>

                        <div class="novachat-field">
                            <label for="gemini_model"><strong><?php esc_html_e( 'Gemini AI Model', 'novachat' ); ?></strong></label>
                            <select id="gemini_model" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[gemini_model]" class="regular-text">
                                <option value="gemini-flash-latest" <?php selected( 'gemini-flash-latest', $opts['gemini_model'] ?? 'gemini-flash-latest' ); ?>><?php esc_html_e( 'Gemini Flash (Recommended — Fastest & Free Tier Friendly)', 'novachat' ); ?></option>
                                <option value="gemini-2.0-flash" <?php selected( 'gemini-2.0-flash', $opts['gemini_model'] ?? '' ); ?>><?php esc_html_e( 'Gemini 2.0 Flash', 'novachat' ); ?></option>
                                <option value="gemini-2.0-flash-lite" <?php selected( 'gemini-2.0-flash-lite', $opts['gemini_model'] ?? '' ); ?>><?php esc_html_e( 'Gemini 2.0 Flash Lite', 'novachat' ); ?></option>
                                <option value="gemini-2.5-flash" <?php selected( 'gemini-2.5-flash', $opts['gemini_model'] ?? '' ); ?>><?php esc_html_e( 'Gemini 2.5 Flash', 'novachat' ); ?></option>
                                <option value="gemini-2.5-pro" <?php selected( 'gemini-2.5-pro', $opts['gemini_model'] ?? '' ); ?>><?php esc_html_e( 'Gemini 2.5 Pro', 'novachat' ); ?></option>
                                <option value="gemini-3.5-flash" <?php selected( 'gemini-3.5-flash', $opts['gemini_model'] ?? '' ); ?>><?php esc_html_e( 'Gemini 3.5 Flash (Next-Gen)', 'novachat' ); ?></option>
                                <option value="gemini-1.5-pro" <?php selected( 'gemini-1.5-pro', $opts['gemini_model'] ?? '' ); ?>><?php esc_html_e( 'Gemini 1.5 Pro (Advanced reasoning)', 'novachat' ); ?></option>
                            </select>
                        </div>

                        <div class="novachat-field">
                            <label for="gemini_system_prompt"><strong><?php esc_html_e( 'Gemini AI System Instructions (System Prompt)', 'novachat' ); ?></strong></label>
                            <textarea id="gemini_system_prompt" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[gemini_system_prompt]" rows="4" class="large-text" placeholder="You are a helpful customer support bot..."><?php echo esc_textarea( $opts['gemini_system_prompt'] ?? '' ); ?></textarea>
                            <p class="description"><?php esc_html_e( 'Define the personality, tone, and specific knowledge limits of the bot.', 'novachat' ); ?></p>
                        </div>
                    </div>

                    <!-- PROVIDER CARD: OpenAI -->
                    <div class="novachat-card ai-provider-settings-card" id="settings-card-openai">
                        <div class="card-header-badge">
                            <span class="badge-pill" style="background:#ECFDF5; color:#047857;"><?php esc_html_e( 'OpenAI ChatGPT', 'novachat' ); ?></span>
                        </div>
                        <h3><?php esc_html_e( 'OpenAI Configuration', 'novachat' ); ?></h3>
                        <p class="description" style="font-size: 13.5px; line-height: 1.6;">
                            <?php esc_html_e( 'Power your live chat using OpenAI\'s powerful GPT models (e.g. GPT-4o-mini). Requires a paid OpenAI developer account.', 'novachat' ); ?>
                        </p>

                        <div class="gemini-info-box" style="background:#F3F4F6; padding:12px; border-radius:6px; margin: 15px 0; display:flex; align-items:center; gap:10px;">
                            <div class="gemini-info-icon" style="font-size:20px;">🔑</div>
                            <div class="gemini-info-text">
                                <strong><?php esc_html_e( 'Where to find your OpenAI API Key?', 'novachat' ); ?></strong>
                                <p style="margin: 2px 0 0 0; font-size:12px;">
                                    <?php esc_html_e( 'Get your key from your OpenAI Developer Dashboard: ', 'novachat' ); ?>
                                    <a href="https://platform.openai.com/api-keys" target="_blank" rel="noopener noreferrer" style="color: #5B4FE9; font-weight: 600; text-decoration: underline;">
                                        https://platform.openai.com/api-keys ↗
                                    </a>
                                </p>
                            </div>
                        </div>

                        <div class="novachat-field">
                            <label for="openai_api_key"><strong><?php esc_html_e( 'OpenAI API Key', 'novachat' ); ?></strong></label>
                            <div class="key-input-wrapper" style="display:flex; gap:6px;">
                                <input type="password" id="openai_api_key" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[openai_api_key]" value="<?php echo esc_attr( $opts['openai_api_key'] ?? '' ); ?>" class="large-text code-input" placeholder="sk-proj-..." autocomplete="off" />
                                <button type="button" class="button button-secondary toggle-key-visibility" title="<?php esc_attr_e( 'Show / Hide Key', 'novachat' ); ?>">
                                    <span class="dashicons dashicons-visibility"></span>
                                </button>
                            </div>
                        </div>

                        <div class="novachat-field">
                            <label for="openai_model"><strong><?php esc_html_e( 'OpenAI Model', 'novachat' ); ?></strong></label>
                            <select id="openai_model" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[openai_model]" class="regular-text">
                                <option value="gpt-4o-mini" <?php selected( 'gpt-4o-mini', $opts['openai_model'] ?? 'gpt-4o-mini' ); ?>><?php esc_html_e( 'GPT-4o Mini (Recommended — Fast & Low Cost)', 'novachat' ); ?></option>
                                <option value="gpt-4o" <?php selected( 'gpt-4o', $opts['openai_model'] ?? '' ); ?>><?php esc_html_e( 'GPT-4o (Premium Multimodal)', 'novachat' ); ?></option>
                                <option value="o1-mini" <?php selected( 'o1-mini', $opts['openai_model'] ?? '' ); ?>><?php esc_html_e( 'o1-mini (Reasoning Model)', 'novachat' ); ?></option>
                                <option value="o1-preview" <?php selected( 'o1-preview', $opts['openai_model'] ?? '' ); ?>><?php esc_html_e( 'o1-preview (Reasoning Model)', 'novachat' ); ?></option>
                                <option value="gpt-4-turbo" <?php selected( 'gpt-4-turbo', $opts['openai_model'] ?? '' ); ?>><?php esc_html_e( 'GPT-4 Turbo', 'novachat' ); ?></option>
                                <option value="gpt-3.5-turbo" <?php selected( 'gpt-3.5-turbo', $opts['openai_model'] ?? '' ); ?>><?php esc_html_e( 'GPT-3.5 Turbo (Legacy)', 'novachat' ); ?></option>
                            </select>
                        </div>

                        <div class="novachat-field">
                            <label for="openai_system_prompt"><strong><?php esc_html_e( 'OpenAI System Instructions (System Prompt)', 'novachat' ); ?></strong></label>
                            <textarea id="openai_system_prompt" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[openai_system_prompt]" rows="4" class="large-text" placeholder="You are a helpful customer support bot..."><?php echo esc_textarea( $opts['openai_system_prompt'] ?? '' ); ?></textarea>
                            <p class="description"><?php esc_html_e( 'Define the personality, tone, and specific knowledge limits of the bot.', 'novachat' ); ?></p>
                        </div>
                    </div>

                    <!-- PROVIDER CARD: Anthropic -->
                    <div class="novachat-card ai-provider-settings-card" id="settings-card-anthropic">
                        <div class="card-header-badge">
                            <span class="badge-pill" style="background:#FFF7ED; color:#C2410C;"><?php esc_html_e( 'Anthropic Claude', 'novachat' ); ?></span>
                        </div>
                        <h3><?php esc_html_e( 'Anthropic Claude Configuration', 'novachat' ); ?></h3>
                        <p class="description" style="font-size: 13.5px; line-height: 1.6;">
                            <?php esc_html_e( 'Power your live chat using Anthropic\'s high-quality Claude models (e.g. Claude 3.5 Haiku). Requires a paid Anthropic Console account.', 'novachat' ); ?>
                        </p>

                        <div class="gemini-info-box" style="background:#F3F4F6; padding:12px; border-radius:6px; margin: 15px 0; display:flex; align-items:center; gap:10px;">
                            <div class="gemini-info-icon" style="font-size:20px;">🔑</div>
                            <div class="gemini-info-text">
                                <strong><?php esc_html_e( 'Where to find your Anthropic API Key?', 'novachat' ); ?></strong>
                                <p style="margin: 2px 0 0 0; font-size:12px;">
                                    <?php esc_html_e( 'Get your key from your Anthropic Console Dashboard: ', 'novachat' ); ?>
                                    <a href="https://console.anthropic.com/settings/keys" target="_blank" rel="noopener noreferrer" style="color: #5B4FE9; font-weight: 600; text-decoration: underline;">
                                        https://console.anthropic.com/settings/keys ↗
                                    </a>
                                </p>
                            </div>
                        </div>

                        <div class="novachat-field">
                            <label for="anthropic_api_key"><strong><?php esc_html_e( 'Anthropic API Key', 'novachat' ); ?></strong></label>
                            <div class="key-input-wrapper" style="display:flex; gap:6px;">
                                <input type="password" id="anthropic_api_key" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[anthropic_api_key]" value="<?php echo esc_attr( $opts['anthropic_api_key'] ?? '' ); ?>" class="large-text code-input" placeholder="sk-ant-..." autocomplete="off" />
                                <button type="button" class="button button-secondary toggle-key-visibility" title="<?php esc_attr_e( 'Show / Hide Key', 'novachat' ); ?>">
                                    <span class="dashicons dashicons-visibility"></span>
                                </button>
                            </div>
                        </div>

                        <div class="novachat-field">
                            <label for="anthropic_model"><strong><?php esc_html_e( 'Claude Model', 'novachat' ); ?></strong></label>
                            <select id="anthropic_model" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[anthropic_model]" class="regular-text">
                                <option value="claude-3-5-haiku-20241022" <?php selected( 'claude-3-5-haiku-20241022', $opts['anthropic_model'] ?? 'claude-3-5-haiku-20241022' ); ?>><?php esc_html_e( 'Claude 3.5 Haiku (Recommended — Fast & Intelligent)', 'novachat' ); ?></option>
                                <option value="claude-3-5-sonnet-20241022" <?php selected( 'claude-3-5-sonnet-20241022', $opts['anthropic_model'] ?? '' ); ?>><?php esc_html_e( 'Claude 3.5 Sonnet (State-of-the-Art Reasoning)', 'novachat' ); ?></option>
                                <option value="claude-3-opus-20240229" <?php selected( 'claude-3-opus-20240229', $opts['anthropic_model'] ?? '' ); ?>><?php esc_html_e( 'Claude 3 Opus (Premium Creative Reasoning)', 'novachat' ); ?></option>
                                <option value="claude-3-haiku-20240307" <?php selected( 'claude-3-haiku-20240307', $opts['anthropic_model'] ?? '' ); ?>><?php esc_html_e( 'Claude 3 Haiku (Legacy)', 'novachat' ); ?></option>
                            </select>
                        </div>

                        <div class="novachat-field">
                            <label for="anthropic_system_prompt"><strong><?php esc_html_e( 'Claude System Instructions (System Prompt)', 'novachat' ); ?></strong></label>
                            <textarea id="anthropic_system_prompt" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[anthropic_system_prompt]" rows="4" class="large-text" placeholder="You are a helpful customer support bot..."><?php echo esc_textarea( $opts['anthropic_system_prompt'] ?? '' ); ?></textarea>
                            <p class="description"><?php esc_html_e( 'Define the personality, tone, and specific knowledge limits of the bot.', 'novachat' ); ?></p>
                        </div>
                    </div>

                    <!-- PROVIDER CARD: Keyword Rules Info -->
                    <div class="novachat-card ai-provider-settings-card" id="settings-card-rules">
                        <h3><?php esc_html_e( 'Keyword Auto-Responder Rules Active', 'novachat' ); ?></h3>
                        <p class="description">
                            <?php esc_html_e( 'You have selected "Keyword Auto-Responder Rules Only". The widget will bypass AI generation and respond instantly using your custom keywords.', 'novachat' ); ?>
                        </p>
                        <p style="margin-top:15px; font-weight:600;">
                            <?php esc_html_e( 'Configure your triggers and replies in the ', 'novachat' ); ?>
                            <a href="#" class="novachat-go-to-tab" data-target-tab="tab-responses" style="color:#5B4FE9; text-decoration:underline;">
                                <?php esc_html_e( 'Auto-Responses Tab', 'novachat' ); ?>
                            </a>
                        </p>
                    </div>

                    <!-- PROVIDER CARD: Webhook Info -->
                    <div class="novachat-card ai-provider-settings-card" id="settings-card-webhook">
                        <h3><?php esc_html_e( 'Custom Webhook Active', 'novachat' ); ?></h3>
                        <p class="description">
                            <?php esc_html_e( 'You have selected "Custom Webhook / External API Proxy". Messages will be forwarded directly to your custom backend service URL.', 'novachat' ); ?>
                        </p>
                        <p style="margin-top:15px; font-weight:600;">
                            <?php esc_html_e( 'Configure your backend webhook settings in the ', 'novachat' ); ?>
                            <a href="#" class="novachat-go-to-tab" data-target-tab="tab-integration" style="color:#5B4FE9; text-decoration:underline;">
                                <?php esc_html_e( 'Custom Webhooks Tab', 'novachat' ); ?>
                            </a>
                        </p>
                    </div>

                </div>

                <!-- TAB: GENERAL -->
                <div class="novachat-tab-panel" id="tab-general">
                    <div class="novachat-card">
                        <h3><?php esc_html_e( 'Widget Activation', 'novachat' ); ?></h3>
                        <div class="novachat-field toggle-field">
                            <label class="switch-label">
                                <input type="checkbox" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[enabled]" value="1" <?php checked( 1, $opts['enabled'] ); ?> id="novachat-toggle-enabled" />
                                <span class="slider"></span>
                                <span class="label-text"><strong><?php esc_html_e( 'Enable Chat Widget on Website', 'novachat' ); ?></strong></span>
                            </label>
                            <p class="description"><?php esc_html_e( 'Turn this off to temporarily hide the chat widget across your website.', 'novachat' ); ?></p>
                        </div>
                    </div>

                    <div class="novachat-card">
                        <h3><?php esc_html_e( 'Bot Identity & Labels', 'novachat' ); ?></h3>

                        <div class="novachat-grid-2">
                            <div class="novachat-field">
                                <label for="bot_name"><strong><?php esc_html_e( 'Bot / Agent Name', 'novachat' ); ?></strong></label>
                                <input type="text" id="bot_name" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[bot_name]" value="<?php echo esc_attr( $opts['bot_name'] ); ?>" class="regular-text" placeholder="e.g. Nova" required />
                                <p class="description"><?php esc_html_e( 'Name displayed in header and message bubbles.', 'novachat' ); ?></p>
                            </div>

                            <div class="novachat-field">
                                <label for="bot_title"><strong><?php esc_html_e( 'Role / Subtitle', 'novachat' ); ?></strong></label>
                                <input type="text" id="bot_title" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[bot_title]" value="<?php echo esc_attr( $opts['bot_title'] ); ?>" class="regular-text" placeholder="e.g. AI Support Assistant" />
                                <p class="description"><?php esc_html_e( 'Subtitle shown directly beneath the name.', 'novachat' ); ?></p>
                            </div>
                        </div>

                        <div class="novachat-grid-2">
                            <div class="novachat-field">
                                <label for="avatar_initial"><strong><?php esc_html_e( 'Avatar Initial / Icon Letter', 'novachat' ); ?></strong></label>
                                <input type="text" id="avatar_initial" maxlength="3" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[avatar_initial]" value="<?php echo esc_attr( $opts['avatar_initial'] ); ?>" class="small-text" style="text-align:center;font-weight:bold;font-size:16px;" />
                                <p class="description"><?php esc_html_e( '1-2 characters for the avatar circle (e.g. "N" or "🤖").', 'novachat' ); ?></p>
                            </div>

                            <div class="novachat-field">
                                <label for="launcher_label"><strong><?php esc_html_e( 'Launcher Button Tooltip / ARIA Label', 'novachat' ); ?></strong></label>
                                <input type="text" id="launcher_label" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[launcher_label]" value="<?php echo esc_attr( $opts['launcher_label'] ); ?>" class="regular-text" placeholder="Chat with us" />
                            </div>
                        </div>

                        <div class="novachat-field">
                            <label for="welcome_message"><strong><?php esc_html_e( 'Welcome Greeting Message', 'novachat' ); ?></strong></label>
                            <textarea id="welcome_message" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[welcome_message]" rows="3" class="large-text" placeholder="Type your greeting message..."><?php echo esc_textarea( $opts['welcome_message'] ); ?></textarea>
                            <p class="description"><?php esc_html_e( 'The first message the visitor sees when opening the chat widget.', 'novachat' ); ?></p>
                        </div>

                        <div class="novachat-field">
                            <label for="placeholder"><strong><?php esc_html_e( 'Input Placeholder Text', 'novachat' ); ?></strong></label>
                            <input type="text" id="placeholder" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[placeholder]" value="<?php echo esc_attr( $opts['placeholder'] ); ?>" class="large-text" placeholder="Type your message…" />
                        </div>
                    </div>
                </div>

                <!-- TAB: APPEARANCE -->
                <div class="novachat-tab-panel" id="tab-appearance">
                    <div class="novachat-card">
                        <h3><?php esc_html_e( 'Color Palette & Styling', 'novachat' ); ?></h3>

                        <div class="novachat-grid-2">
                            <div class="novachat-field">
                                <label for="primary_color"><strong><?php esc_html_e( 'Primary Brand Accent Color', 'novachat' ); ?></strong></label>
                                <input type="text" id="primary_color" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[primary_color]" value="<?php echo esc_attr( $opts['primary_color'] ); ?>" class="novachat-color-picker" />
                                <p class="description"><?php esc_html_e( 'Used for launcher button, user bubbles, send button, and active chips.', 'novachat' ); ?></p>
                            </div>

                            <div class="novachat-field">
                                <label for="accent_color"><strong><?php esc_html_e( 'Header & Dark Text Color', 'novachat' ); ?></strong></label>
                                <input type="text" id="accent_color" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[accent_color]" value="<?php echo esc_attr( $opts['accent_color'] ); ?>" class="novachat-color-picker" />
                                <p class="description"><?php esc_html_e( 'Background color of the chat widget header and dark text elements.', 'novachat' ); ?></p>
                            </div>
                        </div>

                        <hr class="novachat-divider" />

                        <div class="novachat-field">
                            <label><strong><?php esc_html_e( 'Widget Position on Screen', 'novachat' ); ?></strong></label>
                            <div class="novachat-radio-cards">
                                <label class="radio-card <?php echo 'right' === $opts['position'] ? 'selected' : ''; ?>">
                                    <input type="radio" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[position]" value="right" <?php checked( 'right', $opts['position'] ); ?> />
                                    <div class="radio-card-body">
                                        <span class="dashicons dashicons-align-right"></span>
                                        <strong><?php esc_html_e( 'Bottom Right (Standard)', 'novachat' ); ?></strong>
                                        <p><?php esc_html_e( 'Pinned to bottom-right corner of viewport.', 'novachat' ); ?></p>
                                    </div>
                                </label>
                                <label class="radio-card <?php echo 'left' === $opts['position'] ? 'selected' : ''; ?>">
                                    <input type="radio" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[position]" value="left" <?php checked( 'left', $opts['position'] ); ?> />
                                    <div class="radio-card-body">
                                        <span class="dashicons dashicons-align-left"></span>
                                        <strong><?php esc_html_e( 'Bottom Left', 'novachat' ); ?></strong>
                                        <p><?php esc_html_e( 'Pinned to bottom-left corner of viewport.', 'novachat' ); ?></p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB: AUTO RESPONSES -->
                <div class="novachat-tab-panel" id="tab-responses">
                    <div class="novachat-card">
                        <h3><?php esc_html_e( 'Quick Reply Suggestion Chips', 'novachat' ); ?></h3>
                        <p class="description"><?php esc_html_e( 'Enter suggestion buttons shown above the input box (one per line).', 'novachat' ); ?></p>
                        <div class="novachat-field">
                            <textarea id="quick_replies" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[quick_replies]" rows="4" class="large-text" placeholder="What services do you offer?&#10;Pricing details&#10;Talk to a human"><?php echo esc_textarea( $opts['quick_replies'] ); ?></textarea>
                        </div>
                    </div>

                    <div class="novachat-card">
                        <div class="card-header-flex">
                            <div>
                                <h3><?php esc_html_e( 'Instant Keyword Rules (Fast Matcher)', 'novachat' ); ?></h3>
                                <p class="description"><?php esc_html_e( 'Trigger instant canned replies when Gemini AI is not configured or for specific keywords.', 'novachat' ); ?></p>
                            </div>
                            <button type="button" class="button button-secondary" id="novachat-add-response-btn">
                                <span class="dashicons dashicons-plus-alt2"></span> <?php esc_html_e( 'Add New Rule', 'novachat' ); ?>
                            </button>
                        </div>

                        <div id="novachat-responses-container" class="novachat-rules-table">
                            <div class="rules-header">
                                <div class="col-kw"><?php esc_html_e( 'Keyword Trigger', 'novachat' ); ?></div>
                                <div class="col-reply"><?php esc_html_e( 'Bot Auto-Reply Message', 'novachat' ); ?></div>
                                <div class="col-act"><?php esc_html_e( 'Action', 'novachat' ); ?></div>
                            </div>
                            <?php
                            if ( ! empty( $opts['custom_responses'] ) && is_array( $opts['custom_responses'] ) ) :
                                foreach ( $opts['custom_responses'] as $idx => $item ) :
                            ?>
                                <div class="rule-row">
                                    <div class="col-kw">
                                        <input type="text" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[responses_keyword][]" value="<?php echo esc_attr( $item['keyword'] ?? '' ); ?>" placeholder="e.g. pricing, refund" class="regular-text" required />
                                    </div>
                                    <div class="col-reply">
                                        <textarea name="<?php echo esc_attr( self::OPTION_KEY ); ?>[responses_reply][]" rows="2" class="large-text" placeholder="Bot reply content..." required><?php echo esc_textarea( $item['reply'] ?? '' ); ?></textarea>
                                    </div>
                                    <div class="col-act">
                                        <button type="button" class="button button-link-delete novachat-remove-row" title="<?php esc_attr_e( 'Remove Rule', 'novachat' ); ?>">
                                            <span class="dashicons dashicons-trash"></span>
                                        </button>
                                    </div>
                                </div>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </div>

                        <hr class="novachat-divider" />

                        <div class="novachat-field">
                            <label for="default_reply"><strong><?php esc_html_e( 'Default Fallback Reply', 'novachat' ); ?></strong></label>
                            <textarea id="default_reply" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[default_reply]" rows="3" class="large-text"><?php echo esc_textarea( $opts['default_reply'] ); ?></textarea>
                            <p class="description"><?php esc_html_e( 'Used when Gemini AI or keyword rules do not return a match.', 'novachat' ); ?></p>
                        </div>
                    </div>
                </div>

                <!-- TAB: BEHAVIOR & HOURS -->
                <div class="novachat-tab-panel" id="tab-behavior">
                    <div class="novachat-card">
                        <h3><?php esc_html_e( 'Widget Behavior & Storage', 'novachat' ); ?></h3>

                        <div class="novachat-checkbox-group">
                            <label>
                                <input type="checkbox" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[show_timestamps]" value="1" <?php checked( 1, $opts['show_timestamps'] ); ?> />
                                <strong><?php esc_html_e( 'Show message timestamps (e.g. 10:30 AM)', 'novachat' ); ?></strong>
                            </label>

                            <label>
                                <input type="checkbox" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[persist_history]" value="1" <?php checked( 1, $opts['persist_history'] ); ?> />
                                <strong><?php esc_html_e( 'Save conversation history across page refreshes (localStorage)', 'novachat' ); ?></strong>
                            </label>

                            <label>
                                <input type="checkbox" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[sound_enabled]" value="1" <?php checked( 1, $opts['sound_enabled'] ); ?> />
                                <strong><?php esc_html_e( 'Enable audio ping notification on new bot messages', 'novachat' ); ?></strong>
                            </label>
                        </div>

                        <hr class="novachat-divider" />

                        <div class="novachat-field">
                            <label for="storage_key"><strong><?php esc_html_e( 'LocalStorage Storage Key', 'novachat' ); ?></strong></label>
                            <input type="text" id="storage_key" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[storage_key]" value="<?php echo esc_attr( $opts['storage_key'] ); ?>" class="regular-text" />
                            <p class="description"><?php esc_html_e( 'Change this key if you ever want to force-reset client chat histories site-wide.', 'novachat' ); ?></p>
                        </div>
                    </div>

                    <div class="novachat-card">
                        <h3><?php esc_html_e( 'Operating Hours & Availability Dot', 'novachat' ); ?></h3>

                        <div class="novachat-field">
                            <label>
                                <input type="radio" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[offline_mode]" value="always_online" <?php checked( 'always_online', $opts['offline_mode'] ); ?> class="hours-toggle" />
                                <strong><?php esc_html_e( 'Always Online (24/7 Green Dot)', 'novachat' ); ?></strong>
                            </label>
                        </div>

                        <div class="novachat-field">
                            <label>
                                <input type="radio" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[offline_mode]" value="custom_hours" <?php checked( 'custom_hours', $opts['offline_mode'] ); ?> class="hours-toggle" />
                                <strong><?php esc_html_e( 'Custom Business Hours (Local Visitor Time)', 'novachat' ); ?></strong>
                            </label>
                        </div>

                        <div id="custom-hours-fields" class="novachat-hours-box" style="<?php echo 'custom_hours' === $opts['offline_mode'] ? '' : 'display:none;'; ?>">
                            <div class="novachat-grid-2">
                                <div>
                                    <label for="offline_start"><?php esc_html_e( 'Opening Hour (0-23)', 'novachat' ); ?></label>
                                    <input type="number" min="0" max="23" id="offline_start" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[offline_start]" value="<?php echo esc_attr( $opts['offline_start'] ); ?>" class="small-text" />
                                    <span class="hours-suffix">:00 (e.g. 9 = 9 AM)</span>
                                </div>
                                <div>
                                    <label for="offline_end"><?php esc_html_e( 'Closing Hour (0-23)', 'novachat' ); ?></label>
                                    <input type="number" min="0" max="23" id="offline_end" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[offline_end]" value="<?php echo esc_attr( $opts['offline_end'] ); ?>" class="small-text" />
                                    <span class="hours-suffix">:00 (e.g. 18 = 6 PM)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="novachat-card">
                        <h3><?php esc_html_e( 'Display Visibility Rules', 'novachat' ); ?></h3>
                        <div class="novachat-field">
                            <select name="<?php echo esc_attr( self::OPTION_KEY ); ?>[display_rule]" id="display_rule" class="regular-text">
                                <option value="all" <?php selected( 'all', $opts['display_rule'] ); ?>><?php esc_html_e( 'Show on all public pages (Recommended)', 'novachat' ); ?></option>
                                <option value="front_only" <?php selected( 'front_only', $opts['display_rule'] ); ?>><?php esc_html_e( 'Show only on Homepage / Front Page', 'novachat' ); ?></option>
                                <option value="hide_logged_in" <?php selected( 'hide_logged_in', $opts['display_rule'] ); ?>><?php esc_html_e( 'Hide for logged-in WordPress users', 'novachat' ); ?></option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- TAB: CUSTOM WEBHOOKS -->
                <div class="novachat-tab-panel" id="tab-integration">
                    <div class="novachat-card">
                        <h3><?php esc_html_e( 'External Custom Webhook / API Endpoint', 'novachat' ); ?></h3>
                        <p class="description"><?php esc_html_e( 'Optional: If you prefer using your own custom server, Make.com, or Zapier instead of direct Google Gemini AI, enter your webhook endpoint below.', 'novachat' ); ?></p>
                        
                        <div class="novachat-field">
                            <label for="backend_api_url"><strong><?php esc_html_e( 'POST Webhook / API URL', 'novachat' ); ?></strong></label>
                            <input type="url" id="backend_api_url" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[backend_api_url]" value="<?php echo esc_url( $opts['backend_api_url'] ); ?>" class="large-text" placeholder="https://api.yourdomain.com/v1/chat" />
                        </div>
                    </div>
                </div>

                <div class="novachat-submit-bar">
                    <?php submit_button( __( 'Save All Changes', 'novachat' ), 'primary button-hero', 'submit', false ); ?>
                </div>

            </div>

            <!-- Right Live Preview Column -->
            <div class="novachat-preview-col">
                <div class="novachat-preview-card">
                    <div class="preview-header">
                        <h4><span class="dashicons dashicons-visibility"></span> <?php esc_html_e( 'Interactive Widget Preview', 'novachat' ); ?></h4>
                        <span class="preview-badge"><?php esc_html_e( 'Live', 'novachat' ); ?></span>
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
                                            <div class="mock-bot-msg" id="mock-welcome-msg"><?php echo esc_html( $opts['welcome_message'] ); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="preview-hint"><?php esc_html_e( 'Colors and labels update in real-time as you edit the settings.', 'novachat' ); ?></p>
                </div>
            </div>

        </div>
    </form>
</div>
