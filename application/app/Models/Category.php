<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'title',
        'parent_category_id',
    ];

    public function parent()
    {
        return $this
            ->belongsTo(Category::class, 'parent_category_id')
            ->with('reports')
            ->with('conferences');
    }

    public function child()
    {
        return $this
            ->hasMany(Category::class, 'parent_category_id', 'id')
            ->with('reports')
            ->with('conferences');
    }

    public function parents()
    {
        return $this->parent()->with('parents');
    }

    public function children()
    {
        return $this->child()->with('children');
    }

    public function conferences()
    {
        return $this->hasMany(Conference::class, 'category_id', 'id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'category_id', 'id');
    }

    public static function createTree(Collection $categories = null): array
    {
        $result = [];
        if ($categories === null) {
            $categories = Category::whereNull('parent_category_id')->get();
        }

        foreach ($categories as $category) {
            $data = [
                'id' => $category->id,
                'title' => $category->title,
                'children' => [],
                'count_reports' => $category->reports->count(),
                'count_conferences' => $category->conferences->count(),
            ];
            $category->count_reports = $category->reports->count();
            $category->count_conferences = $category->conferences->count();

            if ($category->child->count()) {
                $data['children'] = Category::createTree($category->child);
            }

            $result[] = $data;
        }

        return $result;
    }

    public static function getAllName()
    {
        $categories = self::all('id', 'title');
        $result = [];

        foreach ($categories as $category) {
            $result[$category['id']] = $category['title'];
        }

        return $result;
    }
}
