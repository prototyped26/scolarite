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
 * Class Annee
 * 
 * @property int $id
 * @property string|null $code
 * @property string|null $libelle
 * @property string|null $date_debut
 * @property string|null $dete_fin
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|Parcour[] $parcours
 *
 * @package App\Models
 */
class Annee extends Model
{
	use SoftDeletes;
	protected $table = 'annee';

	protected $fillable = [
		'code',
		'libelle',
		'date_debut',
		'dete_fin'
	];

	public function parcours()
	{
		return $this->hasMany(Parcour::class);
	}
}
