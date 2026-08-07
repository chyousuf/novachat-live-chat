# 💬 AuraChat — WordPress Live Chat Widget Plugin

A drop-in, zero-dependency WordPress live chat plugin with customizable bot branding, quick-reply chips, keyword auto-responder, operating hours indicator, and optional AI / Webhook backend connection.

---

## 📦 What's Included in This Plugin Folder

```
aurachat-live-chat/
├── aurachat.php              # Main WordPress Plugin file & Settings API
├── readme.txt                # WordPress.org standard metadata & documentation
├── README.md                 # Full documentation & configuration guide
├── index.php                 # Direct access security protection
├── assets/
│   ├── index.php
│   ├── js/
│   │   ├── chat-widget.js    # Front-end pure JS chat widget
│   │   └── admin-script.js   # Admin dashboard settings & live preview logic
│   └── css/
│       └── admin-style.css   # Admin dashboard styling with tabs & color picker
└── templates/
    └── admin-settings.php    # Admin settings UI with live preview and rule builder
```

---

## 🚀 How to Install in WordPress

### Method 1: Upload via WordPress Admin (Easiest)
1. In your WordPress Admin sidebar, navigate to **Plugins → Add New Plugin**.
2. Click the **Upload Plugin** button at the top.
3. Choose **`aurachat-live-chat.zip`** (or **`chatbotplugin.zip`**) from your Downloads folder.
4. Click **Install Now**, then click **Activate Plugin**.
5. Go to **Settings → AuraChat Widget** in your WordPress Admin sidebar to configure your branding and responses.

### Method 2: Manual Folder Upload (FTP / cPanel / Localhost)
1. Copy or extract this **`aurachat-live-chat`** directory into your WordPress plugins directory:
   ```
   wp-content/plugins/aurachat-live-chat/
   ```
2. In WordPress Admin, go to **Plugins → Installed Plugins**.
3. Find **AuraChat — Live Chat Widget** and click **Activate**.

---

## ⚙️ Configuration & Features

Go to **WordPress Admin → Settings → AuraChat Widget**:

### 1. General & Identity
- **Enable / Disable Widget**: Easily toggle the widget on or off site-wide.
- **Bot Name & Subtitle**: Set your assistant's display name (e.g. `Nova`) and subtitle (e.g. `Support Assistant`).
- **Avatar Initial**: Customize the letter or emoji in the avatar circle (e.g. `N` or `🤖`).
- **Welcome Message**: Set the initial greeting shown when visitors open the chat.
- **Input Placeholder**: Customize the textarea placeholder text.

### 2. Design & Colors
- **Primary Accent Color**: Integrated WordPress color picker for the launcher button, user message bubbles, and action buttons.
- **Header & Dark Color**: Set the header bar and text accent colors.
- **Position**: Choose **Bottom-Right** (default) or **Bottom-Left** corner dock.

### 3. Quick Replies & Auto-Responder
- **Quick Reply Chips**: Add instant clickable pill buttons (e.g., *Pricing*, *Book a demo*, *Talk to a human*).
- **Keyword Response Rules**: Add custom keyword triggers (e.g. *hours*, *pricing*, *refund*, *hello*) with dedicated bot responses.
- **Default Fallback**: Message returned when no keyword matches.

### 4. Operating Hours & Behavior
- **Operating Hours**: Set your local business hours (e.g. 9 AM - 6 PM) to show a live green online dot or away message.
- **Message Timestamps**: Show or hide 12-hour formatted timestamps (`10:45 AM`).
- **LocalStorage Persistence**: Saves conversation history across page navigation and refresh.
- **Audio Ping**: Subtle Web Audio chime on incoming bot messages.
- **Display Rules**: Show on all pages, homepage only, or hide for logged-in admin users.

### 5. AI / Custom Webhook API Integration (Optional)
Connect your chat widget directly to an external API (e.g., OpenAI Assistant, Zapier, Make.com, or Node/Python backend).
Simply enter your endpoint URL in **Settings → AuraChat Widget → API & Integrations**:
- **Outgoing Payload**: `{"message": "User text"}`
- **Expected Return JSON**: `{"reply": "Bot answer"}`

---

## 🛠️ Programmatic JavaScript API

The widget automatically registers `window.AuraChat` on the frontend for custom JavaScript interactions:

```javascript
AuraChat.open();                    // Open the chat panel
AuraChat.close();                   // Close the chat panel
AuraChat.toggle();                  // Toggle open / closed
AuraChat.sendMessage("Hello!");     // Trigger a message programmatically
AuraChat.clearHistory();            // Reset chat history and restart
```

---

## 🔒 Security & Performance
- Zero frontend dependencies (No jQuery, React, or heavy fonts required on frontend).
- Secure WordPress Settings API with capability checks (`manage_options`) and nonce validation.
- All options sanitized via `sanitize_text_field`, `sanitize_hex_color`, and `esc_url_raw`.
- Safe DOM rendering to prevent XSS.
