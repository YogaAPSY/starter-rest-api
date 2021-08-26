<?php

namespace App\Transformers;

use Flugg\Responder\Transformers\Transformer;

abstract class AuthTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the data.
     *
     * @param  mixed $data
     * @return array
     */


    public function transform($user): array
    {
        return [
            'id' => (int) $user->id,
            'username' => $user->username,
            'name'  => $user->name
        ];
    }
}
