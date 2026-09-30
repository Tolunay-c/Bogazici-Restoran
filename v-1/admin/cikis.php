<?php
declare(strict_types=1);
require_once __DIR__ . '/ortak.php';

admin_cikis_yap();

header('Location: /admin/giris.php');
exit;
