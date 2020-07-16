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
 * Class Classe
 * 
 * @property int $id
 * @property string|null $code
 * @property string|null $libelle
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|Parcour[] $parcours
 *
 * @package App\Models
 */
class Classe extends Model
{
	use SoftDeletes;
	protected $table = 'classe';

	protected $fillable = [
		'code',
		'libelle'
	];

	public function parcours()
	{
		return $this->hasMany(Parcour::class);
	}
}
