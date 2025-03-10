<?php
if (extension_loaded('pgsql')) {
    echo 'PostgreSQL extension is installed.';
} else {
    echo 'PostgreSQL extension is NOT installed.';
}
?>