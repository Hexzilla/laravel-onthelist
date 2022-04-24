<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;

class EventGuestRule implements Rule, DataAwareRule
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
        if (isset($this->data['guestlist_qty']) && count($value) !== count($this->data['guestlist_qty'])) {
            $this->message = 'guestlist_qty field length and guestlist_type field length must match';
            return false;
        }

        if (isset($this->data['guestlist_description']) && count($value) !== count($this->data['guestlist_description'])) {
            $this->message = 'guestlist_description field length and guestlist_type field length must match';
            return false;
        }

        if (isset($this->data['guestlist_price']) && count($value) !== count($this->data['guestlist_price'])) {
            $this->message = 'guestlist_price field length and guestlist_type field length must match';
            return false;
        }

        if (isset($this->data['guestlist_approval']) && count($value) !== count($this->data['guestlist_approval'])) {
            $this->message = 'guestlist_approval field length and guestlist_type field length must match';
            return false;
        }

        if (isset($this->data['guestlist_id']) && count($value) !== count($this->data['guestlist_id'])) {
            $this->message = 'guestlist_id field length and guestlist_type field length must match';
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
