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
 * Class Caracteristique
 *
 * @property int $id
 * @property int $motif_id
 * @property string|null $code
 * @property float|null $montant
 * @property string|null $libelle
 * @property string|null $date_debut
 * @property string|null $date_fin
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Motif $motif
 * @property Collection|Paiement[] $paiements
 *
 * @package App\Models
 */
class Caracteristique extends Model
{
	use SoftDeletes;
	protected $table = 'caracteristique';

	protected $casts = [
		'motif_id' => 'int'
	];

	protected $fillable = [
		'motif_id',
		'code',
		'libelle',
        'montant',
        'date_debut',
        'date_fin'
	];

	public function motif()
	{
		return $this->belongsTo(Motif::class);
	}

	public function paiements()
	{
		return $this->hasMany(Paiement::class);
	}
}
