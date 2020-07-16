<?php
namespace App\Repositories;

use Lab2view\RepositoryGenerator\BaseRepository;

use App\Models\Paiement;

class PaiementRepository extends BaseRepository
{
    public function __construct(Paiement $model)
    {
        parent::__construct($model);
    }
}
