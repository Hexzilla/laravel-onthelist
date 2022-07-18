<?php

namespace App\Traits;

use Stripe\Customer;
use Stripe\Account;
use Stripe\Stripe;
use Stripe\AccountLink;
use Stripe\StripeClient;
use Stripe\OAuth;

class StripeConnect
{
    public static function prepare()
    {
      Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public static function getOrCreateAccount($user, $params = [], $config = [])
    {
        self::prepare();

        $params = array_merge([
          'type' => $config['account_type'] 
        ], $params);

        return self::create($user, 'account_id', function () use ($params) {
          return Account::create($params);
        });
    }

    public static function getOrCreateCustomer($token, $user, $params = [])
    {
        self::prepare();
        $params = array_merge([
            "email" => $user->email,
            'source' => $token,
        ], $params);
        return self::create($user, 'customer_id', function () use ($params) {
            return Customer::create($params);
        });
    }

    public static function deleteAccount( String $account_id) {
        try {
            $stripe = new StripeClient( env("STRIPE_SECRET") );
            $stripe->accounts->delete($account_id, [] );
            return true;
        } catch (\Throwable $th) {
            throw $th;
            return false;
        }
    }
}