<?php

use App\Models\Category;

function get_breadcrumbs(int|null $id): array
{
    $breadcrumbs = [];

    if ($id) {
        $category = Category::find($id);
        $breadcrumbs['child'] = $category->toArray();

        if ($category->parent_category_id) {
            $breadcrumbs['parents'] = $category->parents->toArray();
        }
    }

    return $breadcrumbs;
}
