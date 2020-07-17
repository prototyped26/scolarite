<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 *
 * @property int $id
 * @property int $role_id
 * @property string|null $nom
 * @property string|null $prenom
 * @property string|null $email
 * @property string|null $login
 * @property string|null $password
 * @property string|null $telephone
 * @property string|null $profession
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Role $role
 * @property Collection|Paiement[] $paiements
 *
 * @package App\Models
 */
class User extends Authenticatable
{
	use SoftDeletes, HasApiTokens;
    use Notifiable;
	protected $table = 'user';

	protected $casts = [
		'role_id' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'role_id',
		'nom',
		'prenom',
		'email',
		'login',
		'password',
		'telephone',
		'profession'
	];

	protected $with = ['role'];

	public function role()
	{
		return $this->belongsTo(Role::class);
	}

	public function paiements()
	{
		return $this->hasMany(Paiement::class);
	}
}
