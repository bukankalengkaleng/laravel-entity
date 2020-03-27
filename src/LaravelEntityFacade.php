<?php

namespace BukanKalengKaleng\LaravelEntity;

use Illuminate\Support\Facades\Facade;

/**
 * @see \BukanKalengKaleng\LaravelEntity\Skeleton\SkeletonClass
 */
class LaravelEntityFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'entity';
    }
}
