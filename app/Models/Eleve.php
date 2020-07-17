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
 * Class Eleve
 *
 * @property int $id
 * @property string|null $nom
 * @property string|null $prenom
 * @property string|null $genre
 * @property string|null $photo
 * @property string|null $date_naissance
 * @property string|null $matricule
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Collection|Famille[] $familles
 * @property Collection|Parcour[] $parcours
 *
 * @package App\Models
 */
class Eleve extends Model
{
	use SoftDeletes;
	protected $table = 'eleve';

	protected $fillable = [
		'nom',
		'prenom',
		'genre',
		'photo',
		'date_naissance',
		'matricule'
	];

	// protected $with = ['parcours'];

	public function familles()
	{
		return $this->hasMany(Famille::class);
	}

	public function parcours()
	{
		return $this->hasMany(Parcour::class);
	}
}
