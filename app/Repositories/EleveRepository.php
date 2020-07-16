<?php
namespace App\Repositories;

use Lab2view\RepositoryGenerator\BaseRepository;

use App\Models\Eleve;

class EleveRepository extends BaseRepository
{
    public function __construct(Eleve $model)
    {
        parent::__construct($model);
    }
}
