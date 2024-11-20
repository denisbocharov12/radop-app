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

    'accepted' => ':attribute должен быть принят.',
    'accepted_if' => 'The :attribute должен быть принят когда :other равно :value.',
    'after' => ':attribute должен быть датой после :date.',
    'after_or_equal' => ':attribute должен быть датой после или равным :date.',
    'alpha' => ':attribute должен содержать только буквы.',
    'alpha_dash' => ':attribute должен содержать только буквы, цифры, тире и символы подчеркивания.',
        'alpha_num' => ':attribute должен содержать только буквы и цифры.',
    'array' => ':attribute должен быть массивом.',
    'before' => ':attribute должен быть датой до :date.',
    'between' => [
        'array' => ':attribute должен иметь элементы от :min до :max.',
        'file' => ':attribute должен быть между :min и :max килобайтами.',
        'numeric' => ':attribute должен быть между :min и :max.',
        'string' => ':attribute должен находиться между символами :min и :max.',
    ],
    'boolean' => 'Поле :attribute должно быть истинным или ложным.',
    'confirmed' => 'Подтверждение :attribute не совпадает.',
    'current_password' => 'Неправильный пароль.',
    'date' => ':attribute не является действительной датой.',
    'declined' => ':attribute должен быть отклонен.',
    'digits' => ':attribute должен состоять из :digits цифр.',
    'digits_between' => ':attribute должен быть между цифрами :min и :max.',
    'email' => ':attribute должен быть действительным адресом электронной почты.',
    'enum' => 'Выбранный :attribute недействителен.',
    'exists' => 'Выбранный :attribute не существует.',
    'file' => ':attribute должен быть файлом.',
    'image' => ':attribute должен быть изображением.',
    'in' => 'Выбранный :attribute недействителен.',
    'in_array' => 'Поле :attribute не существует в :other.',
    'integer' => ':attribute должен быть целым числом.',
    'json' => ':attribute олжен быть допустимой строкой JSON.',
    'max' => [
        'array' => ':attribute не должен содержать более :max элементов.',
        'file' => ':attribute не должен превышать :max килобайт.',
        'numeric' => ':attribute не должен быть больше :max.',
        'string' => ':attribute не должен превышать :max символов.',
    ],
    'mimes' => ':attribute должен быть файлом типа: :values.',
    'mimetypes' => ':attribute должен быть файлом типа: :values.',
    'min' => [
        'array' => ':attribute должен иметь как минимум :min элементов.',
        'file' => 'Размер :attribute должен быть не менее :min килобайт.',
        'numeric' => ':attribute должен быть как минимум :min.',
        'string' => ':attribute должен содержать не менее :min символов.',
    ],
    'numeric' => ':attribute должен быть числом.',
    'required' => 'Поле является обязательным.',
    'required_if' => 'Поле является обязательным',
    'required_with' => 'Поле :attribute обязательно, когда присутствует :values.',
    'size' => [
        'array' => ':attribute должен содержать элементы :size.',
        'file' => ':attribute должен быть :size килобайт.',
        'numeric' => ':attribute должен быть размером :size.',
        'string' => ':attribute должен быть :size символов.',
    ],
    'string' => ':attribute должен быть строкой.',
    'unique' => ':attribute уже занят.',
    'uploaded' => 'Не удалось загрузить :attribute.',
    'url' => ':attribute должен быть допустимым URL.',
    'uuid' => ':attribute должен быть допустимым UUID.',
];
