<?php
namespace App\Repositories;

use Lab2view\RepositoryGenerator\BaseRepository;

use App\Models\ParentEleve;

class ParentEleveRepository extends BaseRepository
{
    public function __construct(ParentEleve $model)
    {
        parent::__construct($model);
    }
}
