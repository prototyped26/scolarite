<?php
namespace App\Repositories;

use Lab2view\RepositoryGenerator\BaseRepository;

use App\Models\Caracteristique;

class CaracteristiqueRepository extends BaseRepository
{
    public function __construct(Caracteristique $model)
    {
        parent::__construct($model);
    }
}
