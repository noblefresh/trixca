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

    'accepted' => 'L’ a :attribute must be accepted.',
    'active_url' => 'L’ a :attribute is not a valid URL.',
    'after' => 'L’ a :attribute must be a date after :date.',
    'after_or_equal' => 'L’ a :attribute must be a date after or equal to :date.',
    'alpha' => 'L’ a :attribute may only contain letters.',
    'alpha_dash' => 'L’ a :attribute may only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'L’ a :attribute may only contain letters and numbers.',
    'array' => 'L’ a :attribute must be an array.',
    'before' => 'L’ a :attribute must be a date before :date.',
    'before_or_equal' => 'L’ a :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'L’ a :attribute must be between :min and :max.',
        'file' => 'L’ a :attribute must be between :min and :max kilobytes.',
        'string' => 'L’ a :attribute must be between :min and :max characters.',
        'array' => 'L’ a :attribute must have between :min and :max items.',
    ],
    'boolean' => 'L’ a :attribute field must be true or false.',
    'confirmed' => 'L’ a :attribute confirmation does not match.',
    'date' => 'L’ a :attribute is not a valid date.',
    'date_equals' => 'L’ a :attribute must be a date equal to :date.',
    'date_format' => 'L’ a :attribute does not match the format :format.',
    'different' => 'L’ a :attribute and :other must be different.',
    'digits' => 'L’ a :attribute must be :digits digits.',
    'digits_between' => 'L’ a :attribute must be between :min and :max digits.',
    'dimensions' => 'L’ a :attribute has invalid image dimensions.',
    'distinct' => 'L’ a :attribute field has a duplicate value.',
    'email' => 'L’ a :attribute must be a valid email address.',
    'ends_with' => 'L’ a :attribute must end with one of the following: :values.',
    'exists' => 'Le selected :attribute is invalid.',
    'file' => 'L’ a  :attribute must be a file.',
    'filled' => 'L’ a :attribute field must have a value.',
    'gt' => [
        'numeric' => 'L’ a  :attribute must be greater than :value.',
        'file' => 'L’ a  :attribute must be greater than :value kilobytes.',
        'string' => 'L’ a  :attribute must be greater than :value characters.',
        'array' => 'L’ a :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'L’ a  :attribute must be greater than or equal :value.',
        'file' => 'L’ a :attribute must be greater than or equal :value kilobytes.',
        'string' => 'L’ a  :attribute must be greater than or equal :value characters.',
        'array' => 'L’ a  :attribute must have :value items or more.',
    ],
    'image' => 'L’ a  :attribute must be an image.',
    'in' => 'Le selected :attribute is invalid.',
    'in_array' => 'L’ a :attribute field does not exist in :other.',
    'integer' => 'L’ a  :attribute must be an integer.',
    'ip' => 'L’ a  :attribute must be a valid IP address.',
    'ipv4' => 'L’ a  :attribute must be a valid IPv4 address.',
    'ipv6' => 'L’ a  :attribute must be a valid IPv6 address.',
    'json' => 'L’ a  :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'L’ a  :attribute must be less than :value.',
        'file' => 'L’ a  :attribute must be less than :value kilobytes.',
        'string' => 'L’ a  :attribute must be less than :value characters.',
        'array' => 'L’ a :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'L’ a :attribute must be less than or equal :value.',
        'file' => 'L’ a  :attribute must be less than or equal :value kilobytes.',
        'string' => 'L’ a :attribute must be less than or equal :value characters.',
        'array' => 'L’ a :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'L’ a  :attribute may not be greater than :max.',
        'file' => 'L’ a  :attribute may not be greater than :max kilobytes.',
        'string' => 'L’ a :attribute may not be greater than :max characters.',
        'array' => 'L’ a :attribute may not have more than :max items.',
    ],
    'mimes' => 'L’ a :attribute must be a file of type: :values.',
    'mimetypes' => 'L’ a :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'L’ a  :attribute must be at least :min.',
        'file' => 'L’ a  :attribute must be at least :min kilobytes.',
        'string' => 'L’ a :attribute must be at least :min characters.',
        'array' => 'L’ a :attribute must have at least :min items.',
    ],
    'not_in' => 'Le selected :attribute is invalid.',
    'not_regex' => 'L’ a  :attribute format is invalid.',
    'numeric' => 'L’ a :attribute must be a number.',
    'password' => 'Le mot de passe est incorrect.',
    'present' => 'L’ a  :attribute field must be present.',
    'regex' => 'L’ a :attribute format is invalid.',
    'required' => 'L’ a  :attribute field is required.',
    'required_if' => 'L’ a  :attribute field is required when :other is :value.',
    'required_unless' => 'L’ a  :attribute field is required unless :other is in :values.',
    'required_with' => 'L’ a  :attribute field is required when :values is present.',
    'required_with_all' => 'L’ a :attribute field is required when :values are present.',
    'required_without' => 'L’ a :attribute field is required when :values is not present.',
    'required_without_all' => 'L’ a  :attribute field is required when none of :values are present.',
    'same' => 'L’ a  :attribute and :other must match.',
    'size' => [
        'numeric' => 'L’ a :attribute must be :size.',
        'file' => 'L’ a :attribute must be :size kilobytes.',
        'string' => 'L’ a  :attribute must be :size characters.',
        'array' => 'L’ a  :attribute must contain :size items.',
    ],
    'starts_with' => 'L’ a  :attribute must start with one of the following: :values.',
    'string' => 'L’ a :attribute must be a string.',
    'timezone' => 'L’ a :attribute must be a valid zone.',
    'unique' => 'L’ a :attribute has already been taken.',
    'uploaded' => 'L’ a :attribute failed to upload.',
    'url' => 'L’ a :attribute format is invalid.',
    'uuid' => 'L’ a :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'message_personnalisé',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
