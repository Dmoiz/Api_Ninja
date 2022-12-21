<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{

    public function show_all() {
        $response = [
            "status" => "",
            "code" => 0,
            "data" => []
        ];

        $clients = Client::select('code', 'vip', 'created_at')->get();
        foreach ($clients as $client) {
            array_push($response["data"], $client);
            $response["status"] = "Clientes encontrados";
            $response["code"] = 500;
        }
        return $response;
    }

    public function create(Request $request) {
        $response = [
            "status" => "",
            "code" => 0,
            "data" => []
        ];

        $json = $request->getContent();
        $data = json_decode($json);

        if($data) {
            $new_client = new Client();
            if(isset($data->code) || !empty($data->code)) {
                $new_client->code = $data->code;
            } else {
                $response["status"] = "No hay código de cliente";
                $response["code"] = 204;
            }
            if(isset($data->vip) || !empty($data->vip)) {
                $new_client->vip = $data->vip;
            } else {
                $response["status"] = "No hay tipo de cliente";
                $response["code"] = 204;
            }
            try {
                $new_client->save();
                $response["status"] = "Cliente guardado correctamente";
                $response["code"] = 200;
                $response["data"] = $new_client;
            } catch(\Exception $e) {
                $response["status"] = "Error al guardar al cliente";
                $response["code"] = 404;
            }
        } else {
            $response["status"] = "Json incorrecto";
            $response["code"] = 4;
        }
        return $response;
    }

    public function edit(Request $request, $id) {
        $response = [
            "status" => "",
            "code" => 0,
            "data" => []
        ];

        $json = $request->getContent();
        $data = json_decode($json);

        if($data) {
            $client_to_edit = Client::find($id);
            if($client_to_edit) {
                if(isset($data->code) || !empty($data->code)) {
                    $client_to_edit->code = $data->code;
                } else {
                    $response["status"] = "No hay código de cliente";
                    $response["code"] = 204;
                }
                if(isset($data->vip) || !empty($data->vip)) {
                    $client_to_edit->vip = $data->vip;
                } else {
                    $response["status"] = "No has especificado la preferencia";
                    $response["code"] = 204;
                }
                try {
                    $client_to_edit->save();
                    $response["status"] = "Cliente editado correctamente";
                    $response["code"] = 201;
                    $response["data"] = $client_to_edit;
                } catch(\Exception $e) {
                    $response["status"] = "Error al guardar el cliente";
                    $response["code"] = 404;
                }
            } else {
                $response["status"] = "Error al encontrar al cliente";
                $response["code"] = 404;
            }
            
        } else {
            $response["status"] = "Json incorrecto";
            $response["code"] = 4;
        }
        return $response;
    }

    

}
