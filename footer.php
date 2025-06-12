</div> <!-- End container -->

<!-- Common JavaScript functions -->
<script>
    function showAlert(message, type = 'success') {
        const alert = document.getElementById('alert');
        alert.className = `alert alert-${type}`;
        alert.textContent = message;
        alert.style.display = 'block';
        setTimeout(() => {
            alert.style.display = 'none';
        }, 3000);
    }

    // Format currency for display
    function formatCurrency(amount) {
        return '€' + amount.toLocaleString('en-IE', {minimumFractionDigits: 2});
    }

    // Format currency for input (removes formatting)
    function parseCurrency(value) {
        return parseFloat(value.toString().replace(/[€,]/g, '')) || 0;
    }
</script>
</body>
</html>