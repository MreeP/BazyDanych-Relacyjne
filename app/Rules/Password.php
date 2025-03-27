<?php

namespace App\Rules;

use Illuminate\Validation\Rules\Password as BasePasswordValidationRule;

/**
 * Class Password
 *
 * Custom validation rule for passwords.
 */
class Password extends BasePasswordValidationRule
{

    /**
     * Create a new rule instance.
     *
     * @param  string $guard
     * @return void
     */
    public function __construct(
        private readonly string $guard = 'customer',
    )
    {
        parent::__construct($this->getRequirementFromConfig('min', 12));

        if ($this->getRequirementFromConfig('digit', false)) {
            $this->numbers();
        }

        if ($this->getRequirementFromConfig('letter', false)) {
            $this->letters();
        }

        if ($this->getRequirementFromConfig('mixed_case', false)) {
            $this->mixedCase();
        }

        if ($this->getRequirementFromConfig('special', false)) {
            $this->symbols();
        }

        if ($this->getRequirementFromConfig('uncompromised', false)) {
            $this->uncompromised();
        }
    }

    /**
     * Get the password requirements from the configuration.
     *
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    private function getRequirementFromConfig(string $key, mixed $default = null): mixed
    {
        return config(
            sprintf('auth.password_requirements.%s.%s', $this->guard, $key),
            $default,
        );
    }
}
