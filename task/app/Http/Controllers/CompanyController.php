<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Exception;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;



class CompanyController extends Controller
{
    public function index()
    {
        $company = Company::all();

        return $company;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $company_info = request()->all();
        $logo = request()->logo;
        $company = new Company();
        $company->name = $company_info['name'];

        if ($logo) {
            $logo_name = time() . '.' . $logo->extension();
            $logo->move(public_path('images/companies'), $logo_name);
            $company->logo = $logo_name;
        }

        $company->save();

        return response()->json([
            'data' => [
                'company' => $company,
            ],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $company = Company::findOrFail($id);

        return  response()->json(['company' => $company]);
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
    public function update($id)
    {

        try {
            $company = Company::findorfails($id);

            if (request()->hasFile('logo')) {

                $this->delete_image($company->logo);

                $imagePath = request()->file('logo')->store('public/images/companies');

                $company->logo = $imagePath;
            }

            $company->name = request()->input('name');

            $company->save();

            return response()->json([
                'data' => [
                    'company' => $company,
                ],
            ]);
        } catch (Exception $e) {

            return $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $company = Company::findOrFail($id);
            // $this->delete_image($company->logo);
            $company->delete();
            return Company::all();
        } catch (Exception $e) {
            return $e;
        }
    }

    private  function  delete_image($logo)
    {
        if ($logo != 'company.png' and !str_contains($logo, '/tmp/')) {

            try {

                unlink(public_path('images/companies/' . $logo));
            } catch (Exception $e) {

                echo $e;
            }
        }
    }
}
