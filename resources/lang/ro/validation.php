<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute trebuie acceptat.',
    'accepted_if' => ':attribute trebuie acceptat când :other este :value.',
    'after' => ':attribute trebuie să fie o dată după :date.',
    'after_or_equal' => ':attribute trebuie să fie o dată ulterioară sau egală cu :date.',
    'alpha' => ':attribute trebuie să conțină numai litere.',
    'alpha_dash' => ':attribute trebuie să conțină numai litere, cifre, liniuțe și litere de subliniere.',
    'alpha_num' => ':attribute trebuie să conțină numai litere și cifre.',
    'array' => ':attribute trebuie să fie o matrice.',
    'before' => ':attribute trebuie să fie o dată înainte de :date.',
    'between' => [
        'array' => ':attribute trebuie să aibă între elemente :min și :max.',
        'file' => ':attribute trebuie să fie între :min și :max kilobytes.',
        'numeric' => ':attribute trebuie să fie între :min și :max.',
        'string' => ':attribute trebuie să aibă între caractere :min și :max.',
    ],
    'boolean' => 'Câmpul :attribute trebuie să fie adevărat sau fals.',
    'confirmed' => 'Confirmarea :attribute nu se potrivește.',
    'current_password' => 'Parola este incorecta.',
    'date' => ':attribute nu este o dată validă.',
    'declined' => ':attribute trebuie refuzat.',
    'digits' => ':attribute trebuie să fie :digits cifre.',
    'digits_between' => ':attribute trebuie să fie între cifrele :min și :max.',
    'email' => ':attribute trebuie să fie o adresă de e-mail validă.',
    'enum' => ':attribute selectat este nevalid.',
    'exists' => ':attribute selectat este nevalid.',
    'file' => ':attribute trebuie să fie un fișier.',
    'image' => ':attribute trebuie să fie o imagine.',
    'in' => ':attribute selectat este nevalid.',
    'in_array' => 'Câmpul :attribute nu există în :other.',
    'integer' => ':attribute trebuie să fie un număr întreg.',
    'json' => ':attribute trebuie să fie un șir JSON valid.',
    'max' => [
        'array' => ':attribute nu trebuie să aibă mai mult de :max elemente.',
        'file' => ':attribute nu trebuie să fie mai mare de :max kilobytes.',
        'numeric' => ':attribute The :attribute must not be greater than :max.',
        'string' => ':attribute nu trebuie să fie mai mare decât :max caractere.',
    ],
    'mimes' => ':attribute trebuie să fie un fișier de tip: :values.',
    'mimetypes' => ':attribute trebuie să fie un fișier de tip:: :values.',
    'min' => [
        'array' => ':attribute trebuie să aibă cel puțin elemente :min.',
        'file' => ':attribute trebuie să fie de cel puțin :min kilobytes.',
        'numeric' => ':attribute trebuie să fie cel puțin :min.',
        'string' => ':attribute trebuie să conțină cel puțin caractere :min.',
    ],
    'numeric' => ':attribute trebuie să fie un număr.',
    'required' => 'Câmpul este obligatoriu.',
    'required_if' => 'Câmpul este obligatoriu.',
    'required_with' => 'Câmpul :attribute este obligatoriu când :values este prezent.',
    'size' => [
        'array' => ':attribute trebuie să conţină elemente :size.',
        'file' => ':attribute trebuie să fie :size kilobytes.',
        'numeric' => ':attribute trebuie să fie :size.',
        'string' => ':attribute trebuie să fie caractere :size.',
    ],
    'string' => ':attribute trebuie să fie un șir.',
    'unique' => ':attribute a fost deja luat.',
    'uploaded' => ':attribute nu a putut fi încărcat.',
    'url' => ':attribute trebuie să fie o adresă URL validă.',
    'uuid' => ':attribute trebuie să fie un UUID valid.',
    'regex' => 'Câmpul trebuie să includă litere de la A-Z',

    'checkout' => [
        'city_or_filial_required' => 'Trebuie să selectați orașul sau filiala de livrare.',
    ],
    'required_without' => 'Indicați telefonul sau e-mailul.',
];
