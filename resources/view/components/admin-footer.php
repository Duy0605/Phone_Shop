<script>
    const baseUrl = document.querySelector('meta[name="base-url"]')?.content || '';

    function confirmDelete(message) {
        return confirm(message || 'Bạn có chắc chắn muốn xóa?');
    }
</script>
</body>

</html>