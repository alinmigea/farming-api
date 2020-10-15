<?php

namespace App\Model;

use App\Exception\NotFoundException;
use Exception;
use Phalcon\Mvc\Model;

class Author extends Model
{
    /**
     * @return void
     */
    public function initialize(): void
    {
        // ignore unknown columns
        Model::setup(['ignoreUnknownColumns' => true]);

        // define the table
        $this->setSource('authors');

        // define the relationships
        $this->hasMany(
            'id',
            Article::class,
            'author_id',
            [
                'alias' => 'articles'
            ]
        );
    }

    /**
     * @param int $id
     * @return Author
     * @throws Exception
     */
    public static function findFirstById(int $id): Author
    {
        /** @var Author $article */
        $author = parent::findFirst($id);

        if (!($author instanceof Author)) {
            throw new NotFoundException('Author with id \'' . $id . '\' was not found.');
        }

        return $author;
    }
}
