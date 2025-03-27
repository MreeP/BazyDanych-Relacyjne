<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\FortifyServiceProvider::class,
    App\Providers\JetstreamServiceProvider::class,
    App\Providers\TelescopeServiceProvider::class,
    Modules\Admin\Providers\AdminServiceProvider::class,
    Modules\Customer\Providers\CustomerServiceProvider::class,
];
