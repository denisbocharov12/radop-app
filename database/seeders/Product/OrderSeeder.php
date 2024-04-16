<?php

namespace Database\Seeders\Product;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends seeder
{
    public function run() :void
    {
        $order = [
                'order_number' => '123456',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'phone' => '123456789',
                'email' => 'mail@mail.com',
                'address' => '123 Main St',
                'note' => 'This is a note',
//                'user_id' => 1,
//                'manager_id' => 1,
                'payment_method' => 'cash',
                'payment_status' => 'unpaid',
                'status' => 'pending',
                'subtotal' => '100',
                'discount' => '10',
                'total' => '90',
                'delivery_charge' => '10',
        ];

        Order::create($order);
    }
}
