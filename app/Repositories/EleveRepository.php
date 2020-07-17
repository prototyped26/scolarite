<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Lab2view\RepositoryGenerator\BaseRepository;

use App\Models\Eleve;

class EleveRepository extends BaseRepository
{
    public function __construct(Eleve $model)
    {
        parent::__construct($model);
    }

    public function classe($classe_id, $annee) {
        return DB::table("eleve")->select('eleve.*')
            ->join('parcours', 'parcours.eleve_id', '=', 'eleve.id')
            ->where('parcours.annee_id', $annee->id)
            ->where('parcours.classe_id', $classe_id)
            ->whereNull('eleve.deleted_at')
            ->get();

        return $this->model
            ->select('eleve.*')
            ->join('parcours', 'parcours.id', 'classe', 'classe.id')
            ->join('parcours', 'parcours.id', 'annee', 'annee.id')
            ->join('parcours', 'parcours.id', 'eleve', 'eleve.id')
            ->where('annee.id', $annee->id)
            ->where('classe.id', $classe_id)
            ->get();
    }
}
