<?php

namespace Modules\Admin\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Admin\Models\Admin;

/**
 * Class AdminTestCase
 *
 * Custom test case class for the Admin module.
 */
class AdminTestCase extends BaseTestCase
{

    /**
     * Create a new Admin.
     *
     * @param  bool $verified
     * @return Admin
     */
    protected function createAdmin(bool $verified = true): Admin
    {
        if ($verified) {
            $factory = Admin::factory();
        } else {
            $factory = Admin::factory()->unverified();
        }

        return $factory->create();
    }
}
