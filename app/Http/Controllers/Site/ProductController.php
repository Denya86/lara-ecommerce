<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Contracts\ProductContract;
use App\Http\Controllers\Controller;
use App\Contracts\AttributeContract;

class ProductController extends Controller
{
    /**
     * @var ProductContract
     */
    protected $productRepository;

    /**
     * @var AttributeContract
     */
    protected $attributeRepository;

    /**
     * ProductController constructor.
     * @param ProductContract $productRepository
     */
    public function __construct(ProductContract $productRepository, AttributeContract $attributeRepository)
    {
        $this->productRepository = $productRepository;

        $this->attributeRepository = $attributeRepository;
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function show($slug)
    {
        $product = $this->productRepository->findProductBySlug($slug);
        $attributes = $this->attributeRepository->listAttributes();

        return view('site.pages.product', compact('product', 'attributes'));
    }

    /**
     * @param Request $request
     */
    public function addToCart(Request $request){

        dd($request->all());
    }
}
