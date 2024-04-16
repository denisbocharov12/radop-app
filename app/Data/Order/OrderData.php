<?php

namespace App\Data\Order;

/**
 * @property string $order_number
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $note
 * @property int $user_id
 * @property int $manager_id
 * @property string $payment_method
 * @property string $payment_status
 * @property string $status
 * @property string $subtotal
 * @property string $discount
 * @property string $total
 * @property string $delivery_charge
 */
final class OrderData
{
    public string $order_number;
    public string $first_name;
    public string $last_name;
    public string $email;
    public string $phone;
    public string $address;
    public string $note;
    public ?int $user_id;
    public ?int $manager_id;
    public string $payment_method;
    public string $payment_status;
    public string $status;
    public ?string $subtotal;
    public ?string $discount;
    public ?string $total;
    public ?string $delivery_charge;

    public function __construct(
        string $order_number,
        string $first_name,
        string $last_name,
        string $email,
        string $phone,
        string $address,
        string $note,
        ?int    $user_id,
        ?int    $manager_id,
        string $payment_method,
        string $payment_status,
        string $status,
        ?string $subtotal,
        ?string $discount,
        ?string $total,
        ?string $delivery_charge
    ){
        $this->order_number = $order_number;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
        $this->note = $note;
        $this->user_id = $user_id;
        $this->manager_id = $manager_id;
        $this->payment_method = $payment_method;
        $this->payment_status = $payment_status;
        $this->status = $status;
        $this->subtotal = $subtotal;
        $this->discount = $discount;
        $this->total = $total;
        $this->delivery_charge = $delivery_charge;
    }
}
