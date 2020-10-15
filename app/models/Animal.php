<?php

namespace App\Model;

use App\Exception\NotFoundException;
use Carbon\Carbon;
use Exception;
use Phalcon\Mvc\Model;

class Animal extends Model
{
    public function initialize(): void
    {
        // ignore unknown columns
        Model::setup(['ignoreUnknownColumns' => true]);

        // define the table
        $this->setSource('animals');

        // define the relationships
        $this->belongsTo(
            'owner_id',
            Owner::class,
            'id',
            [
                'alias' => 'owner',
            ]
        );
        $this->hasMany(
            'id',
            AnimalCategory::class,
            'animal_id',
            [
                'alias' => 'animalCategories',
            ]
        );
        $this->hasManyToMany(
            'id',
            AnimalCategory::class,
            'animal_id',
            'category_id',
            Category::class,
            'id',
            [
                'alias' => 'categories',
            ]
        );
    }

    /**
     * @throws Exception
     */
    public static function findFirstById(int $id): Animal
    {
        /** @var Animal $article */
        $animal = parent::findFirst($id);

        if (!($animal instanceof Animal)) {
            throw new NotFoundException('Animal with id \''.$id.'\' was not found.');
        }

        return $animal;
    }

    public function beforeUpdate(): void
    {
        $this->updated_at = Carbon::now()->format('Y-m-d');
    }

    public function jsonSerialize(): array
    {
        return array_merge(
            parent::jsonSerialize(),
            [
                'categories' => $this->getRelated('categories'),
            ]
        );
    }

//    /**
//     * @return array
//     */
//    public function columnMap(): array
//    {
//        return [
//            'id' => 'id',
//            'title' => 'title',
//            'description' => 'description',
//            'author_id' => 'authorId',
//            'created_at' => 'createdAt',
//            'updated_at' => 'updatedAt',
//            'categories' => 'categories'
//        ];
//    }
}
