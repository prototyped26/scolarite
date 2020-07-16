<?php
namespace App\Repositories;

use Lab2view\RepositoryGenerator\BaseRepository;

use App\Models\Motif;

class MotifRepository extends BaseRepository
{
    public function __construct(Motif $model)
    {
        parent::__construct($model);
    }
}
