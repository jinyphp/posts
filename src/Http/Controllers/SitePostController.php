<?php
namespace Jiny\Posts\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SitePostController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        return view("jiny-posts::blog.index");
    }

    public function view(Request $request)
    {
        return view("jiny-posts::blog.view", ['id'=> $request->id]);
    }



    public function list()
    {
        return view("jiny-posts::blog.layout");

    }




}
