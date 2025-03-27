<?php

namespace App\Auth\Access;

use Closure;
use Illuminate\Auth\Access\Gate;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Class Gate
 *
 * Base Gate class for application with separate policies for different auth provider models.
 */
class MultiGuardGate extends Gate
{

    /**
     * Function to resolve the gate instance.
     *
     * @return Closure
     */
    public static function containerConcreteResolver(): Closure
    {
        return function (Container $app) {
            return new static($app, fn () => call_user_func($app['auth']->userResolver()));
        };
    }

    /**
     * Define a policy class for a given class type.
     *
     * @param  string $class
     * @param  string $policy
     * @return $this
     */
    public function policy($class, $policy, $userClass = '*'): MultiGuardGate
    {
        Arr::set($this->policies, "$userClass.$class", $policy);

        return $this;
    }

    /**
     * Get a policy instance for a given class.
     *
     * @param  object|string $class
     * @return mixed
     * @throws BindingResolutionException
     */
    public function getPolicyFor($class): mixed
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        if (!is_string($class)) {
            return null;
        }

        $userClass = $this->resolveUser()::class;

        if (Arr::has($this->policies, "$userClass.$class")) {
            return $this->resolvePolicy(Arr::get($this->policies, "$userClass.$class"));
        }

        if (Arr::has($this->policies, "*.$class")) {
            return $this->resolvePolicy(Arr::get($this->policies, "*.$class"));
        }

        foreach ($this->guessPolicyName($class, $userClass) as $guessedPolicy) {
            if (class_exists($guessedPolicy)) {
                return $this->resolvePolicy($guessedPolicy);
            }
        }

        foreach ($this->policies as $expected => $policy) {
            if (is_subclass_of($class, $expected)) {
                return $this->resolvePolicy($policy);
            }
        }

        return null;
    }

    /**
     * Guess the policy name for the given class.
     *
     * @param  string      $class
     * @param  null|string $userClass
     * @return array
     */
    protected function guessPolicyName($class, ?string $userClass = null): array
    {
        if ($this->guessPolicyNamesUsingCallback) {
            return Arr::wrap(call_user_func($this->guessPolicyNamesUsingCallback, $class, $userClass));
        }

        $classDirname = str_replace('/', '\\', dirname(str_replace('\\', '/', $class)));

        $classDirnameSegments = explode('\\', $classDirname);

        $className = Collection::times(count($classDirnameSegments))
            ->map(fn ($index) => implode('\\', [...array_slice($classDirnameSegments, 0, $index), 'Policies', class_basename($class) . 'Policy']))
            ->last(fn ($class) => class_exists($class));

        return [$className ?: ($classDirname . '\\Policies\\' . class_basename($class) . 'Policy')];
    }
}
