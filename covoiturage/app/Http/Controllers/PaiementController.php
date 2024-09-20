<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;

class PaymentController extends Controller
{
    public function payment()
    {
        $client = new Client();
        $url = 'https://api.naboopay.com/api/v1/account/';

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer naboo-e7c1f9e5-cc15-4bbf-ac0b-1fde5c9f5915.c9c82539-fbd5-45e0-b4c0-bcd93998fbb2',
        ];

        try {
            $response = $client->request('GET', $url, [
                'headers' => $headers,
            ]);

            // Récupérer le corps de la réponse
            $responseBody = json_decode($response->getBody()->getContents(), true);

            // Passer les données à la vue
            return view('welcome', compact('responseBody'));

        } catch (RequestException $e) {
            // Gérer l'erreur
            return response()->json([
                'error' => $e->getMessage(),
            ], $e->getCode());
        }
    }
    public function createPayment(Request $request)
    {
        $client = new Client();
        $url = 'https://api.naboopay.com/api/v1/transaction/create-transaction';

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer naboo-e7c1f9e5-cc15-4bbf-ac0b-1fde5c9f5915.c9c82539-fbd5-45e0-b4c0-bcd93998fbb2',
        ];

        // Préparer le corps de la requête
        $body = [
            "method_of_payment" => [$request->input('method_of_payment')], // Forcer à tableau
            "products" => $request->input('products'), // Assurez-vous que ça inclut category
            "is_escrow" => $request->input('is_escrow'),
            "success_url" => $request->input('success_url'),
            "error_url" => $request->input('error_url'),
        ];

        try {
            $response = $client->request('PUT', $url, [
                'headers' => $headers,
                'json' => $body,
            ]);

            return $response->getBody()->getContents();

        } catch (RequestException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}