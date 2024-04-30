<?php

namespace App\Data\Client;

/**
 * @property string $firstName
 * @property string $lastName
 * @property string $email
 * @property string $phone
 * @property string $role
 * @property string $password
 * @property string $status
 * @property string $address
 * @property string $organization_name
 * @property string $cod_fiscal
 * @property string $contact_name
 */

final class ClientData
{
    public ?string $firstName;
    public ?string $lastName;
    public ?string $email;
    public ?string $phone;
    public string $role;
    public string $password;
    public string $status;
    public ?string $address;
    public ?string $organization_name;
    public ?string $cod_fiscal;
    public ?string $contact_name;

    public function __construct(
        ?string $firstName,
        ?string $lastName,
        ?string $email,
        ?string $phone,
        string $role,
        string $password,
        string $status,
        ?string $address,
        ?string $organization_name,
        ?string $cod_fiscal,
        ?string $contact_name,
    )
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = $phone;
        $this->role = $role;
        $this->password = $password;
        $this->status = $status;
        $this->address = $address;
        $this->organization_name = $organization_name;
        $this->cod_fiscal = $cod_fiscal;
        $this->contact_name = $contact_name;
    }
}
