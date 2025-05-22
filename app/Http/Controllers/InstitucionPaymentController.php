<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\User;
use App\Models\Institucion;
use App\Models\Pago;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReciboPago;

class InstitucionPaymentController extends Controller
{
    public function createSession(Request $request)
    {
        $institutionId = $request->input('institution_id');
        $institucion = Institucion::findOrFail($institutionId);

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Registro de Institución Educativa',
                    ],
                    'unit_amount' => 30000,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('institucion.payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('institucion.payment.cancel'),
        ]);

        // Crear registro del pago
        Pago::create([
            'institucion_id' => $institutionId,
            'stripe_session_id' => $session->id,
            'monto' => 300.00,
            'estado' => 'pendiente',
            'moneda' => 'EUR'
        ]);

        return redirect($session->url);
    }

    public function handleSuccess(Request $request)
    {
        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'No se pudo verificar el pago. Por favor, inicia sesión de nuevo.');
        }

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        try {
            $session = Session::retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                // Obtener el usuario actual
                $user = Auth::user();

                // Actualizar el estado del usuario a activo usando Query Builder
                DB::table('user')->where('id', $user->id)->update(['activo' => true]);

                // Actualizar el estado del pago
                $pago = Pago::where('stripe_session_id', $sessionId)->first();
                if ($pago) {
                    $pago->update([
                        'estado' => 'completado',
                        'fecha_pago' => now()
                    ]);

                    // Enviar email con el recibo
                    Mail::to($user->email)->send(new ReciboPago($pago));
                }

                Auth::logout();
                return redirect()->route('login')
                    ->with('success', '¡Pago realizado con éxito! Tu cuenta ha sido activada. Por favor, inicia sesión.');
            }

            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'El pago no se ha completado correctamente. Inicia sesión para intentarlo de nuevo.');

        } catch (\Exception $e) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Error al verificar el pago: ' . $e->getMessage());
        }
    }

    public function handleCancel()
    {
        Auth::logout();
        return redirect()->route('login')
            ->with('error', 'El pago ha sido cancelado. Por favor, inicia sesión para intentarlo de nuevo.');
    }
}
