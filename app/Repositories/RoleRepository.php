<?php
namespace App\Repositories;

use Lab2view\RepositoryGenerator\BaseRepository;

use App\Models\Role;

class RoleRepository extends BaseRepository
{
    /**
     * @var Role
     */
    public static $_ADMIN;

    /**
     * @var Role
     */
    public static $_INTENDANT;

    /**
     * @var Role
     */
    public static $_CAISSIER;

    public function __construct(Role $model)
    {
        parent::__construct($model);
        self::$_ADMIN = $this->model->where('code', 'ADM')->get()->first();
        self::$_INTENDANT = $this->model->where('code', 'INT')->get()->first();
        self::$_CAISSIER = $this->model->where('code', 'CAS')->get()->first();
    }

}
