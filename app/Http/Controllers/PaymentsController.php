<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\Auth;

class PaymentsController extends Controller
{

    public function __construct()
    {
      $this->middleware('auth');
    }
    
    public function payment()
    {

      $availablePlans = [
        'matt_id' => 'Mese',
        'matt_id_2'=> 'Anno'
      ];
      $user = Auth::user()->createSetupIntent();
      $data = [
        'intent' => $user,
        'plans' => $availablePlans
      ];
      return view('payment')->with($data);
    }

    public function subscribe(Request $request)
    {
      $user = Auth::user();
      $paymentMethod = $request->payment_method;
      $planId = $request->plan;

      $user->newSubscription('main', $planId)->create($paymentMethod);

      return response(['status'=>'success']);
    }
}
