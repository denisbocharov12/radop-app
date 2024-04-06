<?php

namespace App\Data\Auth;

final class UserRegistrationData
{
    public string $username;
    public string $email;
    public string $password;
    public string $firstName;
    public string $lastName;
    public string $phone;
    public string $bio;

    public function __construct(
        string $username,
        string $email,
        string $password,
        string $firstName,
        string $lastName,
        string $phone,
        string $bio
    ) {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phone = $phone;
        $this->bio = $bio;
    }
}
