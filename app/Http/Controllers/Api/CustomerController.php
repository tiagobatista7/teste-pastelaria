<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Services\CustomerService;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index()
    {
        return response()->json(Customer::all(), 200);
    }

    public function store(StoreCustomerRequest $request)
    {
        $customer = $this->customerService->store($request->validated());

        return response()->json($customer, Response::HTTP_CREATED);
    }

    public function show(Customer $customer)
    {
        return response()->json($customer, 200);
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $updatedCustomer = $this->customerService->update($customer, $request->validated());
        return response()->json($updatedCustomer, 200);
    }

    public function destroy(Customer $customer)
    {
        $this->customerService->destroy($customer);
        return response()->json(null, 204);
    }
}
