<?php
namespace Models;

use Core\Model;

class News extends Model {
    protected $table = 'news';
    protected $fillable = ['title', 'slug', 'content', 'excerpt', 'source', 'external_url', 'published_at'];

    // obtinem cele mai recente stiri (va folosi un feed RSS)
    public function getLatest($limit = 10) {
        return $this->findAll([], 'published_at DESC', $limit);
    }

    // obtine numai stiri interne
    public function getInternal() {
        return $this->findAll(['source' => 'internal'], 'published_at DESC');
    }
}