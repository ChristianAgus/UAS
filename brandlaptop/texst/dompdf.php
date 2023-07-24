// config/dompdf.php
<?php
return [
    'font_dir' => public_path('fonts/'), // Ganti dengan direktori font Anda
    'font_cache' => storage_path('framework/cache/'),
    'temp_dir' => storage_path('framework/cache/'),
    'chroot' => realpath(base_path()),
    'enable_html5_parser' => true,
];