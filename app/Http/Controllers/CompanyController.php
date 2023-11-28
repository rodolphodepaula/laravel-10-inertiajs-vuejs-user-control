<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Services\Company\CompanyService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function __construct(private CompanyService $srvCompany){}
    /**
     * Display a listing of the resource.
     */
    public function index(CompanyRequest $request)
    {
        $filters = $request->validated();
        $companyQuery  = Company::query();
        $companyQuery  = $this->srvCompany->getBySearch($companyQuery, $filters);
        $companies = $companyQuery->latest()->paginate(10);

        return Inertia::render('Companies/Index',[
            'companies' => $companies,
            'filters' => $filters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
    }
}
