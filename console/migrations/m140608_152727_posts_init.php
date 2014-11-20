<?php

use yii\db\Schema;

use common\models\Category;
use common\models\CategoryTranslate;
use common\models\Post;
use common\models\PostTranslate;

class m140608_152727_posts_init extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable(Category::tableName(), [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(32) NOT NULL',
        ], $tableOptions);

        $this->createTable(CategoryTranslate::tableName(), [
            'id' => Schema::TYPE_PK,
            'cid' => Schema::TYPE_INTEGER,
            'language' => Schema::TYPE_STRING . '(2)',
            'title' => Schema::TYPE_STRING . '(32) NOT NULL',
            'meta_title' => Schema::TYPE_TEXT,
            'meta_keywords' => Schema::TYPE_TEXT,
            'meta_descriptions' => Schema::TYPE_TEXT,
        ], $tableOptions);

        $this->createTable(Post::tableName(), [
            'id' => Schema::TYPE_PK,
            'cid' => Schema::TYPE_INTEGER . '(10) NOT NULL',
            'views' => Schema::TYPE_INTEGER,
            'preview_img' => Schema::TYPE_STRING . '(32)',
            'status' => Schema::TYPE_INTEGER . '(10) NOT NULL',
            'author_id' => Schema::TYPE_INTEGER . '(10) NOT NULL',
            'slug' => Schema::TYPE_STRING . '(64) NOT NULL',
            'published_date' => Schema::TYPE_INTEGER . ' NOT NULL',
            'add_preview_to_full' => Schema::TYPE_BOOLEAN,
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        $this->createIndex('slug', Post::tableName(), 'slug', true);

        $this->createTable(PostTranslate::tableName(), [
            'id' => Schema::TYPE_PK,
            'post_id' => Schema::TYPE_INTEGER . '(10) NOT NULL',
            'language' => Schema::TYPE_STRING . '(2)',
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'full_text' => Schema::TYPE_TEXT . ' NOT NULL',
            'preview_text' => Schema::TYPE_TEXT,
            'meta_title' => Schema::TYPE_TEXT,
            'meta_keywords' => Schema::TYPE_TEXT,
            'meta_descriptions' => Schema::TYPE_TEXT,
        ], $tableOptions);

        $this->initTables();
    }

    public function down()
    {

        $this->dropTable(Category::tableName());
        $this->dropTable(CategoryTranslate::tableName());

        $this->dropTable(Post::tableName());
        $this->dropTable(PostTranslate::tableName());
    }

    private function initTables()
    {
        $cate = new Category();
        $cate->name = 'blog';
        if($cate->save()) {
            $cate_tr = new CategoryTranslate();
            $cate_tr->cid = $cate->id;
            $cate_tr->language = Yii::$app->language;
            $cate_tr->title = 'Blog';
            $cate_tr->save();
        }
    }
}
