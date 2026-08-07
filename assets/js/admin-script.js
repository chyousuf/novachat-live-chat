/**
 * NovaChat Admin Dashboard JavaScript
 */
(function ($) {
    "use strict";

    $(document).ready(function () {
        // 1. Tab Navigation
        $(".novachat-admin-tabs .nav-tab").on("click", function (e) {
            e.preventDefault();
            var targetTab = $(this).data("tab");

            $(".novachat-admin-tabs .nav-tab").removeClass("nav-tab-active");
            $(this).addClass("nav-tab-active");

            $(".novachat-tab-panel").removeClass("active");
            $("#" + targetTab).addClass("active");
        });

        // 2. Toggle API Key Visibility (for any provider key)
        $(".toggle-key-visibility").on("click", function (e) {
            e.preventDefault();
            var $input = $(this).closest(".key-input-wrapper").find("input");
            var currentType = $input.attr("type");
            if (currentType === "password") {
                $input.attr("type", "text");
                $(this).find(".dashicons").removeClass("dashicons-visibility").addClass("dashicons-hidden");
            } else {
                $input.attr("type", "password");
                $(this).find(".dashicons").removeClass("dashicons-hidden").addClass("dashicons-visibility");
            }
        });

        // 2b. AI Provider Card Show/Hide
        function toggleActiveProviderSettings() {
            var selectedProvider = $("#novachat_ai_provider").val() || "gemini";
            $(".ai-provider-settings-card").hide();
            $("#settings-card-" + selectedProvider).show();
        }

        $("#novachat_ai_provider").on("change", function () {
            toggleActiveProviderSettings();
        });

        toggleActiveProviderSettings();

        // 2c. Navigation links inside tabs
        $(document).on("click", ".novachat-go-to-tab", function(e) {
            e.preventDefault();
            var targetTab = $(this).data("target-tab");
            $('.novachat-admin-tabs .nav-tab[data-tab="' + targetTab + '"]').trigger("click");
        });

        // 3. Color Pickers
        if ($.fn.wpColorPicker) {
            $(".novachat-color-picker").wpColorPicker({
                change: function () {
                    updateLivePreview();
                },
                clear: function () {
                    updateLivePreview();
                }
            });
        }

        // 4. Radio Card Position Selector
        $(".novachat-radio-cards .radio-card input").on("change", function () {
            $(".novachat-radio-cards .radio-card").removeClass("selected");
            $(this).closest(".radio-card").addClass("selected");
            updateLivePreview();
        });

        // 5. Hours toggle
        $(".hours-toggle").on("change", function () {
            if ($(this).val() === "custom_hours") {
                $("#custom-hours-fields").slideDown(200);
            } else {
                $("#custom-hours-fields").slideUp(200);
            }
        });

        // 6. Dynamic Keyword Rule Repeater
        $("#novachat-add-response-btn").on("click", function (e) {
            e.preventDefault();
            var rowHtml =
                '<div class="rule-row">' +
                    '<div class="col-kw">' +
                        '<input type="text" name="novachat_settings[responses_keyword][]" placeholder="e.g. discount, return" class="regular-text" required />' +
                    '</div>' +
                    '<div class="col-reply">' +
                        '<textarea name="novachat_settings[responses_reply][]" rows="2" class="large-text" placeholder="Bot reply content..." required></textarea>' +
                    '</div>' +
                    '<div class="col-act">' +
                        '<button type="button" class="button button-link-delete novachat-remove-row" title="Remove Rule">' +
                            '<span class="dashicons dashicons-trash"></span>' +
                        '</button>' +
                    '</div>' +
                '</div>';
            $("#novachat-responses-container").append(rowHtml);
        });

        $(document).on("click", ".novachat-remove-row", function (e) {
            e.preventDefault();
            $(this).closest(".rule-row").remove();
        });

        // 7. Live Interactive Preview Sync
        function updateLivePreview() {
            var botName = $("#bot_name").val() || "Nova";
            var botTitle = $("#bot_title").val() || "AI Support Assistant";
            var avatarInitial = $("#avatar_initial").val() || "N";
            var welcomeMsg = $("#welcome_message").val() || "Hi there! How can I help you today?";
            var primaryColor = $("#primary_color").val() || "#5B4FE9";
            var accentColor = $("#accent_color").val() || "#1F2430";
            var position = $('input[name="novachat_settings[position]"]:checked').val() || "right";

            $("#mock-bot-name").text(botName);
            $("#mock-bot-sub").text(botTitle);
            $("#mock-avatar").text(avatarInitial).css("background-color", primaryColor);
            $("#mock-welcome-msg").text(welcomeMsg);
            $("#mock-launcher-btn").css("background-color", primaryColor);
            $("#mock-header").css("background-color", accentColor);

            if (position === "left") {
                $("#mockup-widget-box").addClass("dock-left");
            } else {
                $("#mockup-widget-box").removeClass("dock-left");
            }
        }

        $("#bot_name, #bot_title, #avatar_initial, #welcome_message, #primary_color, #accent_color").on("input change", function () {
            updateLivePreview();
        });

        updateLivePreview();
    });
})(jQuery);
