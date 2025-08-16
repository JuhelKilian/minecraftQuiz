<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Difficulte
 * 
 * @property int $id
 * @property string $libelle
 * 
 * @property Collection|Mot[] $mots
 *
 * @package App\Models
 */
class Difficulte extends Model
{
	protected $table = 'difficulte';
	public $timestamps = false;

	protected $fillable = [
		'libelle'
	];

	public function mots()
	{
		return $this->hasMany(Mot::class, 'difficulte');
	}
}
