<?php

namespace Modules\Customer\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Customer\Models\Customer;

/**
 * Class CustomerTestCase
 *
 * Custom test case class for the Customer module.
 */
class CustomerTestCase extends BaseTestCase
{

    /**
     * Create a new Customer.
     *
     * @param  bool $verified
     * @return Customer
     */
    protected function createCustomer(bool $verified = true): Customer
    {
        if ($verified) {
            $factory = Customer::factory();
        } else {
            $factory = Customer::factory()->unverified();
        }

        return $factory->create();
    }
}

