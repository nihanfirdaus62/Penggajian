<script>
document.getElementById('tahun').addEventListener('change', function() {
    var tahun = this.value;
    var bulanSelect = document.getElementById('bulan');

    // Clear existing bulan options except the default
    bulanSelect.innerHTML = '<option value="">-- Bulan --</option>';

    if (tahun) {
        // Fetch bulan options for the selected tahun
        fetch('get_bulan.php?tahun=' + encodeURIComponent(tahun))
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Populate bulan select with fetched options
                data.forEach(function(bulan) {
                    var option = document.createElement('option');
                    option.value = bulan;
                    option.textContent = bulan;
                    bulanSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('Error loading bulan options. Please try again. ');
            });
    }
});
</script>
