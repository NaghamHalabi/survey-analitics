<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function all();
    public function count();
    public function find($code);
}
