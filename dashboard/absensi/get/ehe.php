<script>
document.querySelector('form').addEventListener('submit', function() {
    document.getElementById('nip').disabled = false;
    document.getElementById('jenis_kelamin').disabled = false;
    document.getElementById('nama_jabatan').disabled = false;
});
document.getElementById('nama').addEventListener('change', function() {
    var nama = this.value;
    if (nama) {
        fetch('get_employee.php?nama=' + encodeURIComponent(nama))
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    alert('Error: ' + data.error);
                    return;
                }
                document.getElementById('nip').value = data.nip || '';
                document.getElementById('jenis_kelamin').value = data.jenis_kelamin || '';
                document.getElementById('jabatan').value = data.jabatan || '';  // Assuming 'jabatan' column
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('An error occurred while fetching data. Please try again.');
            });
    } else {
        document.getElementById('nip').value = '';
        document.getElementById('jenis_kelamin').value = '';
        document.getElementById('jabatan').value = '';
    }
});
</script>
<?php include "../inc/footer.php"; ?>
