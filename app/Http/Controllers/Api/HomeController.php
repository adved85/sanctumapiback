<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;

use App\Models\Category;

class HomeController extends BaseController
{
    protected $categories;

    public function __construct()
    {
        $this->categories = new Category();
    }

    public function index()
    {
        $categories = $this->categories->with('children')->where('parent_id',0)->get();//->withChildren()->get();
        $categories = $this->categories->withChildren()->get();
        // return $categories;
        // return $this->sendSuccess('Categories', $categories);
    }
}
