<?php
$plaintext = 'admin';  // Replace with actual password
$hash = password_hash($plaintext, PASSWORD_DEFAULT);
echo 'Generated Hash: ' . $hash . "\n";

// Verify it
if (password_verify($plaintext, $hash)) {
    echo 'Verification: SUCCESS';
} else {
    echo 'Verification: FAILED';
}
?>
