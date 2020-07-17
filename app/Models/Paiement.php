<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Paiement
 *
 * @property int $id
 * @property int $caracteristique_id
 * @property int|null $user_id
 * @property int $parent_id
 * @property int $motif_id
 * @property int $parcours_id
 * @property Carbon|null $date
 * @property float $montant
 * @property string|null $raison
 * @property string|null $libelle
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property ParentEleve $parent
 * @property Parcour $parcour
 * @property Motif $motif
 * @property Caracteristique $caracteristique
 * @property User $user
 *
 * @package App\Models
 */
class Paiement extends Model
{
	use SoftDeletes;
	protected $table = 'paiement';

	protected $casts = [
		'caracteristique_id' => 'int',
		'user_id' => 'int',
		'parent_eleve_id' => 'int',
		'motif_id' => 'int',
		'parcours_id' => 'int',
		'montant' => 'float'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'caracteristique_id',
		'user_id',
		'parent_eleve_id',
		'motif_id',
		'parcours_id',
		'date',
		'montant',
		'raison',
		'libelle'
	];

	protected $with = ['parent', 'parcour', 'motif', 'caracteristique', 'user'];

	public function parent()
	{
		return $this->belongsTo(ParentEleve::class);
	}

	public function parcour()
	{
		return $this->belongsTo(Parcour::class, 'parcours_id');
	}

	public function motif()
	{
		return $this->belongsTo(Motif::class);
	}

	public function caracteristique()
	{
		return $this->belongsTo(Caracteristique::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
