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
 * Class ParentEleve
 *
 * @property int $id
 * @property string|null $nom
 * @property string|null $prenom
 * @property string|null $telephone
 * @property string|null $adresse
 * @property string|null $ville
 * @property string|null $email
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Collection|Famille[] $familles
 * @property Collection|Paiement[] $paiements
 *
 * @package App\Models
 */
class ParentEleve extends Model
{
	use SoftDeletes;
	protected $table = 'parent';

	protected $fillable = [
		'nom',
		'prenom',
		'telephone',
		'adresse',
		'ville',
		'email'
	];

	public function familles()
	{
		return $this->hasMany(Famille::class);
	}

	public function paiements()
	{
		return $this->hasMany(Paiement::class);
	}
}
