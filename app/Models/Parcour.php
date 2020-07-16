<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Parcour
 * 
 * @property int $id
 * @property int $classe_id
 * @property int $eleve_id
 * @property int $annee_id
 * @property bool $redouble
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Classe $classe
 * @property Eleve $eleve
 * @property Annee $annee
 * @property Collection|Paiement[] $paiements
 *
 * @package App\Models
 */
class Parcour extends Model
{
	use SoftDeletes;
	protected $table = 'parcours';

	protected $casts = [
		'classe_id' => 'int',
		'eleve_id' => 'int',
		'annee_id' => 'int',
		'redouble' => 'bool'
	];

	protected $fillable = [
		'classe_id',
		'eleve_id',
		'annee_id',
		'redouble'
	];

	public function classe()
	{
		return $this->belongsTo(Classe::class);
	}

	public function eleve()
	{
		return $this->belongsTo(Eleve::class);
	}

	public function annee()
	{
		return $this->belongsTo(Annee::class);
	}

	public function paiements()
	{
		return $this->hasMany(Paiement::class, 'parcours_id');
	}
}
