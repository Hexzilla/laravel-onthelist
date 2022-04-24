<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;

class VenueOfferRule implements Rule, DataAwareRule
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
        if (isset($this->data['offer_qty']) && count($value) !== count($this->data['offer_qty'])) {
            $this->message = 'offer_qty field length and offer_type field length must match';
            return false;
        }

        if (isset($this->data['offer_description']) && count($value) !== count($this->data['offer_description'])) {
            $this->message = 'offer_description field length and offer_type field length must match';
            return false;
        }

        if (isset($this->data['offer_price']) && count($value) !== count($this->data['offer_price'])) {
            $this->message = 'offer_price field length and offer_type field length must match';
            return false;
        }

        if (isset($this->data['offer_approval']) && count($value) !== count($this->data['offer_approval'])) {
            $this->message = 'offer_approval field length and offer_type field length must match';
            return false;
        }

        if (isset($this->data['offer_id']) && count($value) !== count($this->data['offer_id'])) {
            $this->message = 'offer_id field length and offer_type field length must match';
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
