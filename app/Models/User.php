<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'users';

    protected $primaryKey = 'ID_USU';

    protected string $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'ID_USU',
        'name',
        'NOM_USU',
        'PAT_USU',
        'MAT_USU',
        'CI_USU',
        'EXP_USU',
        'ID_SUC',
        'EST_USU',
        'email',
        'password',
    ];

    public $timestamps = false;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sucursal()
    {
        return $this->hasMany(Sucursal::class, 'ID_SUC', 'ID_SUC');
    }

    public static function validationStore($request): ?string
    {
        if (self::where('CI_USU', $request->ci_usu)->exists()) {
            return 'Un usuario con el CI '.$request->ci_usu.' ya se encuentra registrado!';
        }

        if (self::where('email', $request->email)->exists()) {
            return 'El correo: "'.$request->email.'" ya se encuentra registrado!';
        }

        return null;
    }
}
