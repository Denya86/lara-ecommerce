<?php

namespace App\Http\Controllers\Site;


use Illuminate\Http\Request;
use App\Contracts\CategoryContract;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * @var CategoryContract
     */
    protected $categoryRepository;

    /**
     * CategoryController constructor.
     * @param CategoryContract $categoryRepository
     */
    public function __construct(CategoryContract $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function show($slug)
    {
        $category = $this->categoryRepository->findBySlug($slug);

        return view('site.pages.category', compact('category'));
    }
}
