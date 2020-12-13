<?php

namespace App\Http\Controllers;

use App\DataTables\PurchasesDataTable;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param PurchasesDataTable $dataTable
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(PurchasesDataTable $dataTable)
    {
        return $dataTable->render('home');
    }
}
