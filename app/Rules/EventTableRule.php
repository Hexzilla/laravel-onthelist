<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;

class EventTableRule implements Rule, DataAwareRule
{
    /**
     * All of the data under validation.
     *
     * @var array
     */
    protected $data = [];

    protected $message = '';
 
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Set the data under validation.
     *
     * @param  array  $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
 
        return $this;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (isset($this->data['table_qty']) && count($value) !== count($this->data['table_qty'])) {
            $this->message = 'table_qty field length and table_type field length must match';
            return false;
        }

        if (isset($this->data['table_description']) && count($value) !== count($this->data['table_description'])) {
            $this->message = 'table_description field length and table_type field length must match';
            return false;
        }

        if (isset($this->data['table_price']) && count($value) !== count($this->data['table_price'])) {
            $this->message = 'table_price field length and table_type field length must match';
            return false;
        }

        if (isset($this->data['table_approval']) && count($value) !== count($this->data['table_approval'])) {
            $this->message = 'table_approval field length and table_type field length must match';
            return false;
        }

        if (isset($this->data['table_id']) && count($value) !== count($this->data['table_id'])) {
            $this->message = 'table_id field length and table_type field length must match';
            return false;
        }
        
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
