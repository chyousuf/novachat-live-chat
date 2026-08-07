=== NovaChat — Live Chat Widget ===
Contributors: novachat
Tags: live chat, chatbot, chat widget, customer support, messenger, helpdesk, ai chat
Requires at least: 5.4
Tested up to: 6.7
Stable tag: 1.0.0
Requires PHP: 7.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Lightweight, dependency-free live chat widget with customizable bot branding, quick replies, keyword auto-responder, operating hours, sound effects, and zero external build requirements.

== Description ==

**NovaChat** is a sleek, ultra-lightweight website live chat widget built specifically for WordPress. It requires zero third-party dependencies, loads instantly, and provides visitors with an engaging and responsive chat experience.

### ✨ Key Features

* **⚡ Ultra-Lightweight & Fast:** Pure JavaScript and CSS. Zero jQuery on the frontend, zero heavy frameworks. Loads in milliseconds.
* **🎨 Fully Customizable Branding:** Customize bot name, avatar initials, colors (primary accent & dark headers), launcher labels, and screen position (Bottom Right or Bottom Left).
* **💬 Quick Reply Chips:** Suggest instant clickable action buttons (e.g. *Pricing*, *Book a demo*, *Talk to a human*).
* **🤖 Smart Auto-Responder Rules:** Built-in keyword matching rule engine (e.g., instant answers for pricing, hours, refunds, greetings).
* **🌐 Webhook / Backend AI API Ready:** Easily connect to custom AI APIs, OpenAI, Zapier, Make.com, or your helpdesk server via standard REST/JSON.
* **🕒 Operating Hours & Online Status:** Display live green online status dot or away message based on your company's working hours.
* **🔔 Web Audio Notification:** Subtle synthesized ping sound on incoming responses (no heavy audio files downloaded).
* **💾 Persistent History:** Chats stay saved in `localStorage` across page refreshes and navigation.
* **📱 100% Mobile Responsive & Accessible:** Full-screen responsive mode on mobile, keyboard accessible (Enter to send, Esc to close), and `prefers-reduced-motion` compliance.

== Installation ==

1. Log in to your WordPress Admin dashboard.
2. Go to **Plugins -> Add New -> Upload Plugin**.
3. Choose `novachat-live-chat.zip` (or `chatbotplugin.zip`) and click **Install Now**.
4. Click **Activate Plugin**.
5. Go to **Settings -> NovaChat Widget** in your WordPress Admin to customize colors, bot name, welcome greeting, and automated responses.

== Frequently Asked Questions ==

= Does this plugin slow down my website? =
Not at all. NovaChat is self-contained with no external CSS/JS libraries or fonts to download. It runs efficiently at under 25KB total.

= Can I connect it to OpenAI or my own chat API? =
Yes! In the settings under the **API & Integrations** tab, simply enter your POST endpoint URL. The widget will forward messages in JSON format and render your server's reply.

= Where can I customize the colors and position? =
Go to **Settings -> NovaChat Widget** in your WordPress dashboard and open the **Design & Colors** tab. You can use the built-in color picker to match your site's branding.

== Changelog ==

= 1.0.0 =
* Initial release of NovaChat Live Chat Widget for WordPress.
