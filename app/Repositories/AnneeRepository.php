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

    public function active()
    {
        return $this->model->where('is_active', true)->get()->first();
    }
}
