<?php

namespace App\Model;

use App\Exception\NotFoundException;
use Exception;
use Phalcon\Mvc\Model;

class Owner extends Model
{
    public function initialize(): void
    {
        // ignore unknown columns
        Model::setup(['ignoreUnknownColumns' => true]);

        // define the table
        $this->setSource('owners');

        // define the relationships
        $this->hasMany(
            'id',
            Animal::class,
            'owner_id',
            [
                'alias' => 'animals',
            ]
        );
    }

    /**
     * @throws Exception
     */
    public static function findFirstById(int $id): Owner
    {
        /** @var Owner $article */
        $owner = parent::findFirst($id);

        if (!($owner instanceof Owner)) {
            throw new NotFoundException('Owner with id \''.$id.'\' was not found.');
        }

        return $owner;
    }
}
