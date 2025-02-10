<?php

namespace App\Services;

use App\Models\Customer;

class CustomerService
{
    public function create(array $data)
    {
        return Customer::create($data);
    }

    public function store(array $data)
    {
        return $this->create($data);
    }

    public function update(Customer $customer, array $data)
    {
        $customer->update($data);
        return $customer;
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return $customer;
    }
}
