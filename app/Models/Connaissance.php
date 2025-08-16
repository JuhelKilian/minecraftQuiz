<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Connaissance
 * 
 * @property int $idCompte
 * @property int $idMot
 * @property int $nbRepetition
 * @property int $nbPoint
 * @property Carbon $dateRevision
 * 
 * @property Mot $mot
 * @property User $user
 *
 * @package App\Models
 */
class Connaissance extends Model
{
	protected $table = 'connaissance';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'idCompte' => 'int',
		'idMot' => 'int',
		'nbRepetition' => 'int',
		'nbPoint' => 'int',
		'dateRevision' => 'datetime'
	];

	protected $fillable = [
		'nbRepetition',
		'nbPoint'
	];

	public function mot()
	{
		return $this->belongsTo(Mot::class, 'idMot');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'idCompte');
	}
}
