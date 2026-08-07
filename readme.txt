=== AuraChat — Live Chat Widget ===
Contributors: chaudhryyousuf33
Tags: live chat, chatbot, chat widget, customer support, ai assistant
Requires at least: 5.4
Tested up to: 7.0
Stable tag: 1.1.0
Requires PHP: 7.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Lightweight website live chat widget integrated with Google Gemini, OpenAI ChatGPT, and Anthropic Claude AI support.

== Description ==

**AuraChat** is a sleek, ultra-lightweight website live chat widget built specifically for WordPress. It features powerful, direct integrations with the industry's leading AI engines: **Google Gemini**, **OpenAI ChatGPT**, and **Anthropic Claude**. It requires zero heavy third-party dependencies, loads instantly, and provides visitors with an engaging and responsive chat experience.

### ✨ Key Features

* **🧠 Multi-Provider AI Integration:** Seamlessly connect Google Gemini (free-tier friendly), OpenAI (GPT-4o-mini/GPT-4o), or Anthropic (Claude 3.5 Haiku/Sonnet) to handle customer inquiries automatically 24/7.
* **⚡ Ultra-Lightweight & Fast:** Pure JavaScript and CSS. Zero jQuery on the frontend. Loads in milliseconds without dragging down your site performance.
* **🎨 Fully Customizable Branding:** Easily customize the bot's name, role, avatar initials, colors (primary brand color and dark header backgrounds), launcher tooltip, and screen position.
* **💬 Quick Reply Suggestion Chips:** Suggest instant clickable action buttons (e.g., *Pricing*, *Talk to a human*, *FAQ*) above the input box.
* **🤖 Smart Auto-Responder Rules:** Built-in local keyword matching engine for instant canned replies (pricing, human transfer, hello, and customizable keywords) to serve as a fast response layer or fallback.
* **🌐 Webhook / Proxy API Ready:** Connect to Zapier, Make.com, or custom webhook endpoints to proxy requests.
* **🕒 Operating Hours & Online Status:** Toggle online indicator dot or away messages dynamically based on your company's custom working hours.
* **🔔 Web Audio Notification:** Clean synthesized ping sound alert on incoming responses (no heavy audio files downloaded).
* **💾 Persistent History:** Chats stay saved in `localStorage` across page refreshes and navigation.
* **📱 100% Mobile Responsive & Accessible:** Native responsive layout on mobile screens, full keyboard navigability, and compliance with `prefers-reduced-motion`.

== Installation ==

1. Log in to your WordPress Admin dashboard.
2. Go to **Plugins -> Add New -> Upload Plugin**.
3. Choose the plugin ZIP file and click **Install Now**.
4. Click **Activate Plugin**.
5. Go to **Settings -> AuraChat Widget** in your WordPress Admin to choose your AI provider, input your API key, customize widgets, and set canned rules.

== Frequently Asked Questions ==

= Does this plugin slow down my website? =
Not at all. AuraChat is self-contained with no heavy external CSS/JS libraries or web fonts to download. It runs efficiently at under 25KB total asset weight.

= How do I configure Google Gemini AI? =
Under the **AI Configuration** tab, paste your Gemini API key (which you can get for free from Google AI Studio). The plugin uses the optimized and free-tier friendly `gemini-flash-latest` model.

= Can I use OpenAI or Anthropic Claude? =
Yes! The plugin fully integrates with OpenAI (`gpt-4o-mini`, `gpt-4o`) and Anthropic Claude (`claude-3-5-haiku`, `claude-3-5-sonnet`). Simply select your active provider in the settings page and insert your API key.

= Where can I customize the branding colors? =
Go to **Settings -> AuraChat Widget** in your WordPress dashboard and open the **Design & Colors** tab. Use the color pickers to match the launcher button, header backgrounds, and user bubbles to your site's branding.

== Changelog ==

= 1.1.0 =
* Major expansion: Added multi-provider AI support (OpenAI ChatGPT and Anthropic Claude) alongside Google Gemini.
* Enhanced Gemini integration to use `gemini-flash-latest` model for improved compatibility and free-tier stability.
* Refactored settings panel layout with an interactive dropdown selection showing settings dynamically for the active provider.
* General performance enhancements, cleanups, and codebase alignment.

= 1.0.0 =
* Initial release of AuraChat Live Chat Widget for WordPress.
