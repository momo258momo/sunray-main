<?php

namespace App\Http\Controllers;


class ConfirmationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke() 
    {
        
        $orderNumber = session('order_number');

        session()->forget('cart_items');
        session()->forget('order_number');

        return view('confirmation.show', compact('orderNumber'));

    }
}
