<script>
    // Auto-fix relative URLs với base URL
    document.addEventListener('DOMContentLoaded', function () {
        const baseUrl = document.querySelector('meta[name="base-url"]')?.content || "";

        if (baseUrl) {
            // Fix tất cả các link relative (không có http/https)
            document.querySelectorAll('a[href^="/"]').forEach(link => {
                const href = link.getAttribute('href');
                // Chỉ fix nếu là relative URL và không phải là base URL
                if (href && !href.startsWith(baseUrl) && !href.startsWith('http')) {
                    link.setAttribute('href', baseUrl + href);
                }
            });

            // Fix form actions nếu cần
            document.querySelectorAll('form[action^="/"]').forEach(form => {
                const action = form.getAttribute('action');
                if (action && !action.startsWith(baseUrl) && !action.startsWith('http')) {
                    form.setAttribute('action', baseUrl + action);
                }
            });
        }
    });
</script>