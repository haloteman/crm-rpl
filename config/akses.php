<?php

use App\Models\Role;

// role yang boleh buka tiap halaman
return [
    'logout' => [Role::OWNER, Role::SUPER_ADMIN, Role::ADMIN, Role::KEPALA_STAF_DESIGN, Role::DESAINER],

    'dashboard' => [Role::OWNER, Role::ADMIN, Role::KEPALA_STAF_DESIGN],
];
