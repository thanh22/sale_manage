<?php

namespace App\Interfaces;

/**
 * Interface CriteriaInterface
 * @package App\Interfaces
 */
interface CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository);
}
