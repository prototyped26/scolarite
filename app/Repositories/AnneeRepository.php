<?php
namespace App\Repositories;

use Lab2view\RepositoryGenerator\BaseRepository;

use App\Models\Annee;

class AnneeRepository extends BaseRepository
{
    public function __construct(Annee $model)
    {
        parent::__construct($model);
    }
}
