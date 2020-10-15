<?php

namespace App\Model;

use App\Exception\NotFoundException;
use Carbon\Carbon;
use Exception;
use Phalcon\Mvc\Model;

class Article extends Model
{
    /**
     * @return void
     */
    public function initialize(): void
    {
        // ignore unknown columns
        Model::setup(['ignoreUnknownColumns' => true]);

        // define the table
        $this->setSource('articles');

        // define the relationships
        $this->belongsTo(
            'author_id',
            Author::class,
            'id',
            [
                'alias' => 'author'
            ]
        );
        $this->hasMany(
            'id',
            ArticleCategory::class,
            'article_id',
            [
                'alias' => 'articlesCategories'
            ]
        );
        $this->hasManyToMany(
            'id',
            ArticleCategory::class,
            'article_id',
            'category_id',
            Category::class,
            'id',
            [
                'alias' => 'categories'
            ]
        );
    }

    /**
     * @param int $id
     * @return Article
     * @throws Exception
     */
    public static function findFirstById(int $id): Article
    {
        /** @var Article $article */
        $article = parent::findFirst($id);

        if (!($article instanceof Article)) {
            throw new NotFoundException('Article with id \'' . $id . '\' was not found.');
        }

        return $article;
    }

    /**
     * @return void
     */
    public function beforeUpdate(): void
    {
        $this->updated_at = Carbon::now()->format('Y-m-d');
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return array_merge(
            parent::jsonSerialize(),
            [
                'categories' => $this->getRelated('categories')
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
