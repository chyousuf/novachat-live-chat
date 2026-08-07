/*!
 * NovaChat — Embeddable Website Chat Widget
 * -------------------------------------------------------------
 * Drop-in, dependency-free chat plugin for WordPress with Google Gemini AI.
 * -------------------------------------------------------------
 */
(function () {
  "use strict";

  if (window.__novaChatInitialized) return;
  window.__novaChatInitialized = true;

  var userConfig = window.NovaChatConfig || {};

  var CFG = Object.assign(
    {
      botName: "Nova",
      botTitle: "AI Support Assistant",
      avatarInitial: "N",
      welcomeMessage: "Hi there \uD83D\uDC4B I'm Nova, powered by Gemini AI. Ask me anything, or pick a quick option below!",
      placeholder: "Type your message\u2026",
      primaryColor: "#5B4FE9",
      accentColor: "#1F2430",
      position: "right",
      launcherLabel: "Chat with us",
      quickReplies: ["What services do you offer?", "Pricing details", "Talk to a human"],
      showTimestamps: true,
      persistHistory: true,
      soundEnabled: true,
      storageKey: "novachat_history_v1",
      offlineHours: null,
      aiEndpoint: "",
      useServerAi: false,
      backendApiUrl: "",
      responses: {
        "pricing": "We have flexible pricing plans for every need. Would you like our team to provide a custom quote?",
        "human": "Sure thing! Connecting you with a human teammate. Typical reply time is under 10 minutes.",
        "hours": "Our team is available Monday through Friday, 9 AM to 6 PM. Our AI assistant is here 24/7!",
        "hello": "Hey there! \uD83D\uDC4B How can I help you today?",
        "hi": "Hello! How can I assist you today?"
      },
      defaultReply: "Thanks for your message! Our team will get back to you shortly."
    },
    userConfig
  );

  var isRight = CFG.position !== "left";

  var css =
    "#novachat-root{--nc-primary:" + CFG.primaryColor + ";--nc-ink:" + CFG.accentColor + ";" +
    "font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Inter,Roboto,Helvetica,Arial,sans-serif;" +
    "position:fixed;bottom:20px;" + (isRight ? "right" : "left") + ":20px;z-index:999999;}" +
    "#novachat-root *{box-sizing:border-box;}" +
    "#nc-launcher{width:60px;height:60px;border-radius:50%;background:var(--nc-primary);" +
    "box-shadow:0 8px 24px rgba(0,0,0,.2);border:none;cursor:pointer;display:flex;" +
    "align-items:center;justify-content:center;transition:transform .18s ease, box-shadow .18s ease;" +
    "position:relative;outline:none;padding:0;}" +
    "#nc-launcher:hover{transform:scale(1.06);box-shadow:0 10px 28px rgba(0,0,0,.28);}" +
    "#nc-launcher svg{width:26px;height:26px;transition:opacity .15s ease, transform .15s ease;}" +
    "#nc-launcher .nc-icon-close{position:absolute;opacity:0;transform:rotate(-45deg) scale(.5);}" +
    "#novachat-root.nc-open #nc-launcher .nc-icon-chat{opacity:0;transform:rotate(45deg) scale(.5);}" +
    "#novachat-root.nc-open #nc-launcher .nc-icon-close{opacity:1;transform:rotate(0) scale(1);}" +
    "#nc-badge{position:absolute;top:-4px;" + (isRight ? "right" : "left") + ":-4px;background:#FF4757;" +
    "color:#fff;font-size:11px;font-weight:700;min-width:20px;height:20px;border-radius:10px;" +
    "display:flex;align-items:center;justify-content:center;padding:0 5px;box-shadow:0 0 0 2px #fff;}" +
    "#nc-badge.nc-hidden{display:none;}" +
    "#nc-panel{position:absolute;bottom:74px;" + (isRight ? "right" : "left") + ":0;width:360px;" +
    "max-width:calc(100vw - 40px);height:520px;max-height:calc(100vh - 140px);background:#fff;" +
    "border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,.25);display:flex;flex-direction:column;" +
    "overflow:hidden;opacity:0;transform:translateY(16px) scale(.98);pointer-events:none;" +
    "transition:opacity .2s ease, transform .2s ease;border:1px solid rgba(0,0,0,0.06);}" +
    "#novachat-root.nc-open #nc-panel{opacity:1;transform:translateY(0) scale(1);pointer-events:auto;}" +
    "#nc-header{background:var(--nc-ink);color:#fff;padding:14px 16px;display:flex;align-items:center;gap:10px;flex-shrink:0;}" +
    "#nc-avatar{width:36px;height:36px;border-radius:50%;background:var(--nc-primary);display:flex;" +
    "align-items:center;justify-content:center;font-weight:700;font-size:15px;flex-shrink:0;color:#fff;}" +
    "#nc-header-text{flex:1;min-width:0;}" +
    "#nc-header-text .nc-name{font-size:14px;font-weight:600;display:flex;align-items:center;gap:6px;color:#fff;}" +
    "#nc-header-text .nc-sub{font-size:12px;opacity:.75;margin-top:1px;color:#eee;}" +
    ".nc-dot{width:7px;height:7px;border-radius:50%;background:#3DDC84;display:inline-block;flex-shrink:0;}" +
    ".nc-dot.nc-offline{background:#9AA0AC;}" +
    "#nc-header button{background:transparent;border:none;color:#fff;opacity:.8;cursor:pointer;padding:6px;" +
    "border-radius:8px;line-height:0;}" +
    "#nc-header button:hover{opacity:1;background:rgba(255,255,255,.12);}" +
    "#nc-messages{flex:1;overflow-y:auto;padding:16px;display:flex;flex-direction:column;gap:10px;background:#F6F7FB;}" +
    "#nc-messages::-webkit-scrollbar{width:6px;}" +
    "#nc-messages::-webkit-scrollbar-thumb{background:#D8DAE3;border-radius:3px;}" +
    ".nc-row{display:flex;flex-direction:column;max-width:82%;}" +
    ".nc-row.nc-bot{align-self:flex-start;align-items:flex-start;}" +
    ".nc-row.nc-user{align-self:flex-end;align-items:flex-end;}" +
    ".nc-bubble{padding:9px 13px;border-radius:14px;font-size:13.5px;line-height:1.45;white-space:pre-wrap;word-wrap:break-word;}" +
    ".nc-bot .nc-bubble{background:#fff;color:var(--nc-ink);border-bottom-left-radius:4px;box-shadow:0 1px 2px rgba(0,0,0,.06);}" +
    ".nc-user .nc-bubble{background:var(--nc-primary);color:#fff;border-bottom-right-radius:4px;}" +
    ".nc-time{font-size:10px;color:#9AA0AC;margin-top:3px;padding:0 4px;}" +
    ".nc-typing{display:flex;gap:4px;padding:11px 13px;background:#fff;border-radius:14px;" +
    "border-bottom-left-radius:4px;width:fit-content;box-shadow:0 1px 2px rgba(0,0,0,.06);}" +
    ".nc-typing span{width:6px;height:6px;border-radius:50%;background:#B7BBC7;animation:nc-bounce 1.2s infinite ease-in-out;}" +
    ".nc-typing span:nth-child(2){animation-delay:.15s;}.nc-typing span:nth-child(3){animation-delay:.3s;}" +
    "@keyframes nc-bounce{0%,60%,100%{transform:translateY(0);opacity:.5;}30%{transform:translateY(-4px);opacity:1;}}" +
    "#nc-quick{display:flex;flex-wrap:wrap;gap:6px;padding:0 16px 12px;background:#F6F7FB;flex-shrink:0;}" +
    ".nc-chip{border:1px solid #D8DAE3;background:#fff;color:var(--nc-ink);font-size:12.5px;padding:6px 12px;" +
    "border-radius:999px;cursor:pointer;transition:background .15s ease, border-color .15s ease;outline:none;}" +
    ".nc-chip:hover{background:var(--nc-primary);border-color:var(--nc-primary);color:#fff;}" +
    "#nc-inputbar{display:flex;align-items:flex-end;gap:8px;padding:10px 12px;border-top:1px solid #ECEDF2;" +
    "background:#fff;flex-shrink:0;}" +
    "#nc-input{flex:1;resize:none;border:1px solid #DEE0E7;border-radius:12px;padding:9px 12px;font-size:13.5px;" +
    "font-family:inherit;max-height:90px;outline:none;transition:border-color .15s ease;background:#fff;color:#1F2430;}" +
    "#nc-input:focus{border-color:var(--nc-primary);}" +
    "#nc-send{width:38px;height:38px;border-radius:10px;border:none;background:var(--nc-primary);color:#fff;" +
    "cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:opacity .15s ease;outline:none;}" +
    "#nc-send:disabled{opacity:.4;cursor:not-allowed;}" +
    "#nc-send:not(:disabled):hover{opacity:.88;}" +
    "#nc-footer{text-align:center;font-size:10.5px;color:#B7BBC7;padding:6px 0 10px;flex-shrink:0;background:#fff;}" +
    "@media (max-width:480px){#nc-panel{position:fixed;inset:0;width:100vw;max-width:100vw;height:100vh;" +
    "max-height:100vh;border-radius:0;bottom:0;right:0;left:0;}" +
    "#novachat-root{bottom:16px;" + (isRight ? "right" : "left") + ":16px;}}" +
    "@media (prefers-reduced-motion:reduce){#nc-launcher,#nc-panel,#nc-launcher svg,.nc-typing span{transition:none;animation:none;}}";

  var styleTag = document.createElement("style");
  styleTag.id = "novachat-styles";
  styleTag.textContent = css;
  document.head.appendChild(styleTag);

  var root = document.createElement("div");
  root.id = "novachat-root";
  root.innerHTML =
    '<div id="nc-panel" role="dialog" aria-label="' + escapeAttr(CFG.botName) + ' chat window" aria-hidden="true">' +
      '<div id="nc-header">' +
        '<div id="nc-avatar">' + escapeHtml(CFG.avatarInitial) + "</div>" +
        '<div id="nc-header-text">' +
          '<div class="nc-name"><span class="nc-dot" id="nc-status-dot"></span>' + escapeHtml(CFG.botName) + "</div>" +
          '<div class="nc-sub" id="nc-status-text">' + escapeHtml(CFG.botTitle) + "</div>" +
        "</div>" +
        '<button id="nc-sound-toggle" aria-label="Toggle notification sound" title="Toggle sound">' + soundIcon(CFG.soundEnabled) + "</button>" +
        '<button id="nc-minimize" aria-label="Minimize chat" title="Minimize">' + minimizeIcon() + "</button>" +
      "</div>" +
      '<div id="nc-messages" aria-live="polite"></div>' +
      '<div id="nc-quick"></div>' +
      '<div id="nc-inputbar">' +
        '<textarea id="nc-input" rows="1" placeholder="' + escapeAttr(CFG.placeholder) + '" aria-label="Message"></textarea>' +
        '<button id="nc-send" aria-label="Send message" disabled>' + sendIcon() + "</button>" +
      "</div>" +
      '<div id="nc-footer">Powered by NovaChat & Gemini AI</div>' +
    "</div>" +
    '<button id="nc-launcher" aria-label="' + escapeAttr(CFG.launcherLabel) + '" aria-expanded="false">' +
      '<span id="nc-badge" class="nc-hidden">0</span>' +
      chatIcon() +
      closeIcon() +
    "</button>";

  document.body.appendChild(root);

  function chatIcon() {
    return '<svg class="nc-icon-chat" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" ' +
      'stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>';
  }
  function closeIcon() {
    return '<svg class="nc-icon-close" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" ' +
      'stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
  }
  function minimizeIcon() {
    return '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#fff" stroke-width="2" ' +
      'stroke-linecap="round"><line x1="5" y1="12" x2="19" y2="12"/></svg>';
  }
  function sendIcon() {
    return '<svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="#fff" stroke-width="2" ' +
      'stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>';
  }
  function soundIcon(on) {
    return on
      ? '<svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.5 8.5a5 5 0 0 1 0 7"/></svg>'
      : '<svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><line x1="23" y1="9" x2="17" y2="15"/><line x1="17" y1="9" x2="23" y2="15"/></svg>';
  }
  function escapeAttr(s) {
    return String(s || "").replace(/"/g, "&quot;");
  }
  function escapeHtml(s) {
    var div = document.createElement("div");
    div.textContent = s || "";
    return div.innerHTML;
  }

  var els = {
    panel: root.querySelector("#nc-panel"),
    launcher: root.querySelector("#nc-launcher"),
    badge: root.querySelector("#nc-badge"),
    messages: root.querySelector("#nc-messages"),
    quick: root.querySelector("#nc-quick"),
    input: root.querySelector("#nc-input"),
    send: root.querySelector("#nc-send"),
    minimize: root.querySelector("#nc-minimize"),
    soundToggle: root.querySelector("#nc-sound-toggle"),
    statusDot: root.querySelector("#nc-status-dot"),
    statusText: root.querySelector("#nc-status-text")
  };

  var state = {
    open: false,
    unread: 0,
    soundEnabled: CFG.soundEnabled,
    history: []
  };

  function loadHistory() {
    if (!CFG.persistHistory) return [];
    try {
      var raw = localStorage.getItem(CFG.storageKey);
      return raw ? JSON.parse(raw) : [];
    } catch (e) {
      return [];
    }
  }
  function saveHistory() {
    if (!CFG.persistHistory) return;
    try {
      localStorage.setItem(CFG.storageKey, JSON.stringify(state.history));
    } catch (e) {
      /* storage unavailable */
    }
  }

  function refreshStatus() {
    var online = true;
    if (CFG.offlineHours && typeof CFG.offlineHours.start === "number" && typeof CFG.offlineHours.end === "number") {
      var h = new Date().getHours();
      online = h >= CFG.offlineHours.start && h < CFG.offlineHours.end;
    }
    els.statusDot.classList.toggle("nc-offline", !online);
    els.statusText.textContent = online ? "Online now" : "Away \u2014 leave a message";
    return online;
  }

  function formatTime(ts) {
    var d = new Date(ts);
    var h = d.getHours(),
      m = d.getMinutes();
    var ampm = h >= 12 ? "PM" : "AM";
    h = h % 12 || 12;
    return h + ":" + (m < 10 ? "0" : "") + m + " " + ampm;
  }

  function renderMessage(msg) {
    var row = document.createElement("div");
    row.className = "nc-row " + (msg.from === "user" ? "nc-user" : "nc-bot");

    var bubble = document.createElement("div");
    bubble.className = "nc-bubble";
    bubble.textContent = msg.text;
    row.appendChild(bubble);

    if (CFG.showTimestamps) {
      var time = document.createElement("div");
      time.className = "nc-time";
      time.textContent = formatTime(msg.ts);
      row.appendChild(time);
    }
    els.messages.appendChild(row);
    scrollToBottom();
  }

  function scrollToBottom() {
    els.messages.scrollTop = els.messages.scrollHeight;
  }

  function renderQuickReplies() {
    els.quick.innerHTML = "";
    if (!CFG.quickReplies || !CFG.quickReplies.length) return;
    CFG.quickReplies.forEach(function (label) {
      var chip = document.createElement("button");
      chip.className = "nc-chip";
      chip.type = "button";
      chip.textContent = label;
      chip.addEventListener("click", function () {
        handleUserMessage(label);
      });
      els.quick.appendChild(chip);
    });
  }

  function addMessage(from, text) {
    var msg = { from: from, text: text, ts: Date.now() };
    state.history.push(msg);
    renderMessage(msg);
    saveHistory();
    if (from === "bot" && !state.open) {
      state.unread++;
      updateBadge();
      playPing();
    }
  }

  function updateBadge() {
    if (state.unread > 0) {
      els.badge.textContent = state.unread > 9 ? "9+" : String(state.unread);
      els.badge.classList.remove("nc-hidden");
    } else {
      els.badge.classList.add("nc-hidden");
    }
  }

  function showTyping() {
    var row = document.createElement("div");
    row.className = "nc-row nc-bot";
    row.id = "nc-typing-row";
    row.innerHTML = '<div class="nc-typing"><span></span><span></span><span></span></div>';
    els.messages.appendChild(row);
    scrollToBottom();
  }
  function hideTyping() {
    var row = document.getElementById("nc-typing-row");
    if (row) row.remove();
  }

  function getBotReply(userText) {
    var text = userText.toLowerCase();
    var responses = CFG.responses || {};
    var keys = Object.keys(responses);
    for (var i = 0; i < keys.length; i++) {
      if (text.indexOf(keys[i]) !== -1) return responses[keys[i]];
    }
    return CFG.defaultReply;
  }

  function sendToBackend(userText, resolve) {
    // 1. If Server AI (Google Gemini via WordPress REST API) or Webhook is active
    var targetUrl = (CFG.backendApiUrl && CFG.backendApiUrl.trim().length > 0) ? CFG.backendApiUrl : CFG.aiEndpoint;

    if (targetUrl && (CFG.useServerAi || (CFG.backendApiUrl && CFG.backendApiUrl.trim().length > 0))) {
      fetch(targetUrl, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ message: userText })
      })
        .then(function (res) { return res.json(); })
        .then(function (data) {
          resolve(data.reply || data.message || data.response || CFG.defaultReply);
        })
        .catch(function () {
          // Fallback to local keyword matcher on network error
          resolve(getBotReply(userText));
        });
      return;
    }

    // 2. Local fast rule matcher
    var delay = 400 + Math.min(userText.length * 15, 900);
    setTimeout(function () {
      resolve(getBotReply(userText));
    }, delay);
  }

  function handleUserMessage(text) {
    text = (text || "").trim();
    if (!text) return;
    addMessage("user", text);
    els.input.value = "";
    autoGrow();
    updateSendState();
    showTyping();
    sendToBackend(text, function (reply) {
      hideTyping();
      addMessage("bot", reply);
    });
  }

  var audioCtx = null;
  function playPing() {
    if (!state.soundEnabled) return;
    try {
      audioCtx = audioCtx || new (window.AudioContext || window.webkitAudioContext)();
      var osc = audioCtx.createOscillator();
      var gain = audioCtx.createGain();
      osc.type = "sine";
      osc.frequency.value = 880;
      gain.gain.setValueAtTime(0.001, audioCtx.currentTime);
      gain.gain.exponentialRampToValueAtTime(0.12, audioCtx.currentTime + 0.02);
      gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 0.25);
      osc.connect(gain).connect(audioCtx.destination);
      osc.start();
      osc.stop(audioCtx.currentTime + 0.26);
    } catch (e) {
      /* AudioContext blocked */
    }
  }

  function openPanel() {
    state.open = true;
    root.classList.add("nc-open");
    els.launcher.setAttribute("aria-expanded", "true");
    els.panel.setAttribute("aria-hidden", "false");
    state.unread = 0;
    updateBadge();
    setTimeout(function () {
      els.input.focus();
    }, 200);
    scrollToBottom();
  }
  function closePanel() {
    state.open = false;
    root.classList.remove("nc-open");
    els.launcher.setAttribute("aria-expanded", "false");
    els.panel.setAttribute("aria-hidden", "true");
  }
  function togglePanel() {
    state.open ? closePanel() : openPanel();
  }

  function autoGrow() {
    els.input.style.height = "auto";
    els.input.style.height = Math.min(els.input.scrollHeight, 90) + "px";
  }
  function updateSendState() {
    els.send.disabled = els.input.value.trim().length === 0;
  }

  els.launcher.addEventListener("click", togglePanel);
  els.minimize.addEventListener("click", closePanel);

  els.soundToggle.addEventListener("click", function () {
    state.soundEnabled = !state.soundEnabled;
    els.soundToggle.innerHTML = soundIcon(state.soundEnabled);
  });

  els.input.addEventListener("input", function () {
    autoGrow();
    updateSendState();
  });
  els.input.addEventListener("keydown", function (e) {
    if (e.key === "Enter" && !e.shiftKey) {
      e.preventDefault();
      if (!els.send.disabled) handleUserMessage(els.input.value);
    }
  });
  els.send.addEventListener("click", function () {
    handleUserMessage(els.input.value);
  });

  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape" && state.open) closePanel();
  });

  function boot() {
    refreshStatus();
    renderQuickReplies();
    updateSendState();

    state.history = loadHistory();
    if (state.history.length) {
      state.history.forEach(renderMessage);
    } else {
      addMessage("bot", CFG.welcomeMessage);
    }
    state.unread = 0;
    updateBadge();
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", boot);
  } else {
    boot();
  }

  window.NovaChat = {
    open: openPanel,
    close: closePanel,
    toggle: togglePanel,
    sendMessage: handleUserMessage,
    clearHistory: function () {
      state.history = [];
      saveHistory();
      els.messages.innerHTML = "";
      addMessage("bot", CFG.welcomeMessage);
    }
  };
})();
