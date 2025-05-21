<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\User;
use App\Models\Institucion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            'success_url' => route('institucion.payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('institucion.payment.cancel'),
        ]);

        return redirect($session->url);
    }

    public function handleSuccess(Request $request)
    {
        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return redirect()->route('institucion.dashboard')
                ->with('error', 'No se pudo verificar el pago.');
        }

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        try {
            $session = Session::retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                // Obtener el usuario actual
                $user = Auth::user();

                // Actualizar el estado del usuario a activo usando Query Builder
                DB::table('user')->where('id', $user->id)->update(['activo' => true]);

                return redirect()->route('institucion.dashboard')
                    ->with('success', '¡Pago realizado con éxito! Tu cuenta ha sido activada.');
            }

            return redirect()->route('institucion.dashboard')
                ->with('error', 'El pago no se ha completado correctamente.');

        } catch (\Exception $e) {
            return redirect()->route('institucion.dashboard')
                ->with('error', 'Error al verificar el pago: ' . $e->getMessage());
        }
    }

    public function handleCancel()
    {
        return redirect()->route('institucion.dashboard')
            ->with('error', 'El pago ha sido cancelado. Por favor, inténtalo de nuevo.');
    }
}
