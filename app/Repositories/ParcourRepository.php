<?php
namespace App\Repositories;

use Lab2view\RepositoryGenerator\BaseRepository;

use App\Models\Parcour;

class ParcourRepository extends BaseRepository
{
    public function __construct(Parcour $model)
    {
        parent::__construct($model);
    }
}
