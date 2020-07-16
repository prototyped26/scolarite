<?php
namespace App\Repositories;

use Lab2view\RepositoryGenerator\BaseRepository;

use App\Models\Role;

class RoleRepository extends BaseRepository
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }
}
