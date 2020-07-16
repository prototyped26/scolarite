<?php
namespace App\Repositories;

use Lab2view\RepositoryGenerator\BaseRepository;

use App\Models\Parent;

class ParentRepository extends BaseRepository
{
    public function __construct(Parent $model)
    {
        parent::__construct($model);
    }
}
