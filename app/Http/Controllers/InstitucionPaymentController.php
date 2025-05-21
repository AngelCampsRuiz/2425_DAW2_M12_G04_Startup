<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class InstitucionPaymentController extends Controller
{
    public function createSession(Request $request)
    {
        $institutionId = $request->input('institution_id');
        // Aquí puedes guardar en la sesión el ID de la institución, si lo necesitas

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Registro de Institución Educativa',
                    ],
                    'unit_amount' => 30000, // 300€ en céntimos
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('institucion.dashboard') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('institucion.payment.cancel'),
        ]);

        return redirect($session->url);
    }
}
