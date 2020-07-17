<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Famille
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $parent_id
 * @property int $eleve_id
 *
 * @property ParentEleve $parent
 * @property Eleve $eleve
 *
 * @package App\Models
 */
class Famille extends Model
{
	use SoftDeletes;
	protected $table = 'famille';

	protected $casts = [
		'parent_eleve_id' => 'int',
		'eleve_id' => 'int'
	];

	protected $fillable = [
		'parent_eleve_id',
		'eleve_id'
	];

	protected $with = ['eleve'];

	public function parent()
	{
		return $this->belongsTo(ParentEleve::class);
	}

	public function eleve()
	{
		return $this->belongsTo(Eleve::class);
	}
}
