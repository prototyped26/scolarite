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
 * Class Motif
 * 
 * @property int $id
 * @property string|null $code
 * @property string|null $libelle
 * @property Carbon|null $created_at
 * @property string|null $deleted_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Caracteristique[] $caracteristiques
 * @property Collection|Paiement[] $paiements
 *
 * @package App\Models
 */
class Motif extends Model
{
	use SoftDeletes;
	protected $table = 'motif';

	protected $fillable = [
		'code',
		'libelle'
	];

	public function caracteristiques()
	{
		return $this->hasMany(Caracteristique::class);
	}

	public function paiements()
	{
		return $this->hasMany(Paiement::class);
	}
}
