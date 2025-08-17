<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Mot
 * 
 * @property int $id
 * @property string $name_en
 * @property string $name_fr
 * @property string $name_it
 * @property string $cheminImg
 * @property int $difficulte
 * 
 * @property Collection|Connaissance[] $connaissances
 *
 * @package App\Models
 */
class Mot extends Model
{
	protected $table = 'mot';
	public $timestamps = false;

	protected $casts = [
		'difficulte' => 'int'
	];

	protected $fillable = [
		'name_en',
		'name_fr',
		'name_it',
		'cheminImg',
		'difficulte'
	];

	public function difficulte()
	{
		return $this->belongsTo(Difficulte::class, 'difficulte');
	}

	public function connaissances()
	{
		return $this->hasMany(Connaissance::class, 'idMot');
	}
}
