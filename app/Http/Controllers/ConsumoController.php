<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Mail\EntregableMailable;
use Illuminate\Support\Facades\Mail;


class ConsumoController extends Controller

{

    public function consumo()
    {
        $response = Http::get('https://v6.exchangerate-api.com/v6/617ee60d7da82906cd586141/latest/USD');
    
        if ($response->successful()) {
            $data = $response->json();
            $monedasDeseadas = [
                'USD', // Dólares americanos
                'EUR', // Euros
                'PEN', // Soles
                'CNY', // Yuan
            ];
            
            $monedasFiltradas = array_intersect_key($data['conversion_rates'], array_flip($monedasDeseadas));
    
            return view('mail.entregable', compact('monedasFiltradas'));
        } else {
            return "Error al obtener los datos del API.";
        }
    }
    
 
    public function enviar()
    {
        $response = Http::get('https://v6.exchangerate-api.com/v6/617ee60d7da82906cd586141/latest/USD');
    
        if ($response->successful()) {
            $data = $response->json();
    
            if (isset($data['conversion_rates'])) {
                $monedasDeseadas = [
                    'USD', // Dólares americanos
                    'EUR', // Euros
                    'PEN', // Soles
                    'CNY', // Yuan
                ];
    
                $monedasFiltradas = array_intersect_key($data['conversion_rates'], array_flip($monedasDeseadas));
                
                Mail::to('liannmelanny@gmail.com')->send(new EntregableMailable($monedasFiltradas));
                return "Correo electrónico enviado con éxito.";
            } else {
                return "Los datos del servicio no contienen las tasas de cambio esperadas.";
            }
        } else {
            return "Error al obtener los datos del API.";
        }
    }
    
    }
    
