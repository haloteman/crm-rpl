<?php

use App\Models\Role;

$semuaRole = [Role::OWNER, Role::SUPER_ADMIN, Role::ADMIN, Role::KEPALA_STAF_DESIGN, Role::DESAINER];
$pengelolaAkun = [Role::OWNER, Role::SUPER_ADMIN];

// role yang boleh buka tiap halaman
return [
    'beranda' => $semuaRole,
    'logout' => $semuaRole,
    'password.edit' => $semuaRole,
    'password.update' => $semuaRole,

    'dashboard' => [Role::OWNER, Role::ADMIN, Role::KEPALA_STAF_DESIGN],

    'users.index' => $pengelolaAkun,
    'users.store' => $pengelolaAkun,
    'users.reset' => $pengelolaAkun,
    'users.destroy' => $pengelolaAkun,
];
