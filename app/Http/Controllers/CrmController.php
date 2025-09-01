<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CrmController extends Controller
{
    public function index()
    {
        $customers = Customer::all();

        return Inertia::render('Crm/Index', [
            'customers' => $customers,
        ]);
    }
    public function create()
    {

        return Inertia::render('Crm/Create');
    }
    public function store(Request $request)
    {
        // dd($request->all());
          $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'businessId' => 'nullable|string|max:100',
            'phone' => 'required|string|max:20',
            'country' => 'required|string|max:100',
        ]);

        $validated['user_id'] = 1;
        Customer::create($validated);

        return to_route('customers.index');
    }
    public function update(Request $request, $id)
    {
        //dd($id);
        $customer = Customer::findOrFail($id);
        //dd($request->all());
          $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'businessId' => 'nullable|string|max:100',
            'phone' => 'required|string|max:20',
            'country' => 'required|string|max:100',
        ]);

        if($customer){
            $customer->update($validated);
        };

        return to_route('customers.index');
    }
    public function destroy($id)
    {
        // dd($id);
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return to_route('customers.index');
        // return redirect('/customers');
    }
}
