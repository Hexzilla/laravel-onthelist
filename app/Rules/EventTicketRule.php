<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;

class EventTicketRule implements Rule, DataAwareRule
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
        if (isset($this->data['ticket_qty']) && count($value) !== count($this->data['ticket_qty'])) {
            $this->message = 'ticket_qty field length and ticket_type field length must match';
            return false;
        }

        if (isset($this->data['ticket_description']) && count($value) !== count($this->data['ticket_description'])) {
            $this->message = 'ticket_description length and ticket_type field length must match';
            return false;
        }

        if (isset($this->data['ticket_price']) && count($value) !== count($this->data['ticket_price'])) {
            $this->message = 'ticket_price field length and ticket_type field length must match';
            return false;
        }

        if (isset($this->data['ticket_approval']) && count($value) !== count($this->data['ticket_approval'])) {
            $this->message = 'ticket_approval field length and ticket_type field length must match';
            return false;
        }

        if (isset($this->data['ticket_id']) && count($value) !== count($this->data['ticket_id'])) {
            $this->message = 'ticket_id field length and ticket_type field length must match';
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
