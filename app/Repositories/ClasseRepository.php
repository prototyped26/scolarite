<?php
namespace App\Repositories;

use Lab2view\RepositoryGenerator\BaseRepository;

use App\Models\Classe;

class ClasseRepository extends BaseRepository
{
    public function __construct(Classe $model)
    {
        parent::__construct($model);
    }
}
