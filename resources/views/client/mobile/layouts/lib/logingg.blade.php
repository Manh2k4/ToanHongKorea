<script src="https://accounts.google.com/gsi/client" async defer></script>

<!-- Cấu hình Google One Tap -->
<div id="g_id_onload" data-client_id="479761304566-lv0pgsc1tfgpfd9u0u34uok23jdo9jcn.apps.googleusercontent.com"
    data-login_uri="https://toanhongkorean.com/auth/google/one-tap" data-auto_prompt="true">
</div>

<script>
    // Tùy chọn: Log để kiểm tra nếu One Tap hiển thị
    window.onload = function() {
        google.accounts.id.initialize({
            client_id: "479761304566-lv0pgsc1tfgpfd9u0u34uok23jdo9jcn.apps.googleusercontent.com",
            callback: handleCredentialResponse // Bạn có thể dùng callback JS hoặc login_uri ở trên
        });
        google.accounts.id.prompt();
    };
</script>
