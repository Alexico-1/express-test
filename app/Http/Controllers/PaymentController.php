<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Stripe\OAuth;
use Stripe\Stripe;
use Stripe\StripeClient;

class PaymentController extends Controller
{
    private $stripe;
    public function __construct()
    {
        $this->stripe = new StripeClient(config('pk_test_51LYTZDKEd5aVpg7azV9MmEoOuwbgEQDWAG4wyP4bgEfP1gFku09beuaENxK4B1tBrkGkGK7iISlM6O2XZYkQtCkU00lKzaoX6f'));
        Stripe::setApiKey(config('sk_test_51LYTZDKEd5aVpg7arLXqZotAn1pFN6lgnRcaBnSj1eta3p1k1qiJynlYPWehChgTwJrcZw4w09yMppFY1TJBjRE700Y4Z3F9Hc'));
    }

    public function index()
    {
        $queryData = [
            'response_type' => 'code',
            'client_id' => config('ca_NbaAObHXNzJHA2vUxj0SDgoIknRiJUrG'),
            'scope' => 'read_write',
            'redirect_uri' => config('https://kayndrexsphere_payouts.test')
        ];
        $connectUri = config('https://kayndrexsphere_payouts.test').'?'.http_build_query($queryData);
        return view('index', compact('https://kayndrexsphere_payouts.test'));
    }

    public function redirect(Request $request)
    {
        $token = $this->getToken($request->code);
        if(!empty($token['error'])) {
            $request->session()->flash('danger', $token['error']);
            return response()->redirectTo('/');
        }
        $connectedAccountId = $token->stripe_user_id;
        $account = $this->getAccount($connectedAccountId);
        if(!empty($account['error'])) {
            $request->session()->flash('danger', $account['error']);
            return response()->redirectTo('/');
        }
        return view('account', compact('account'));
    }

    private function getToken($code)
    {
        $token = null;
        try {
            $token = OAuth::token([
                'grant_type' => 'authorization_code',
                'code' => $code
            ]);
        } catch (Exception $e) {
            $token['error'] = $e->getMessage();
        }
        return $token;
    }

    private function getAccount($connectedAccountId)
    {
        $account = null;
        try {
            $account = $this->stripe->accounts->retrieve(
                $connectedAccountId,
                []
            );
        } catch (Exception $e) {
            $account['error'] = $e->getMessage();
        }
        return $account;
    }
}