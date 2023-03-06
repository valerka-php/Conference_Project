<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Report;

class ReportCategoryController extends Controller
{
    public function index(Report $report, Category $category)
    {
        return inertia('Report/Categories', [
            'reports' => $report->where('category_id', $category->id)->get()->toArray(),
        ]);
    }
}
