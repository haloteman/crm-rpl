<?php

use App\Models\Role;

$semuaRole = [Role::OWNER, Role::SUPER_ADMIN, Role::ADMIN, Role::KEPALA_STAF_DESIGN, Role::DESAINER];

// role yang boleh buka tiap halaman
return [
    'logout' => $semuaRole,
    'password.edit' => $semuaRole,
    'password.update' => $semuaRole,

    'dashboard' => [Role::OWNER, Role::ADMIN, Role::KEPALA_STAF_DESIGN],
];
