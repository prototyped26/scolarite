<?php
namespace App\Repositories;

use Lab2view\RepositoryGenerator\BaseRepository;

use App\Models\Famille;

class FamilleRepository extends BaseRepository
{
    public function __construct(Famille $model)
    {
        parent::__construct($model);
    }
}
