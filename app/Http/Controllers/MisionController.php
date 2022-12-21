<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mision;
use App\Models\Ninja;

class MisionController extends Controller
{
    public function show_all() {
        $response = [
            "status" => "",
            "code" => 0,
            "data" => []
        ];

        $missions = Mision::all();
        foreach ($missions as $mission) {
            array_push($response["data"], $mission);
            $response["status"] = "Misiones encontradass";
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
            $new_mission = new Mision();
            if(isset($data->client_id) || !empty($data->client_id)) {
                try {
                    $new_mission->client_id = $data->client_id;
                } catch (\Exception $e) {
                    $response["status"] = "No existe el ID del cliente";
                    $response["code"] = 404;
                }
            } else {
                $response["status"] = "Falta el ID del cliente";
                $response["code"] = 204;
            }
            if(isset($data->description) || !empty($data->description)) {
                $new_mission->description = $data->description;
            } else {
                $response["status"] = "Falta la descripcion de la mision";
                $response["code"] = 204;
            }
            if(isset($data->number_of_ninjas) || !empty($data->number_of_ninjas)) {
                if($data->number_of_ninjas < 10 && $data->number_of_ninjas > 0) {
                    $new_mission->number_of_ninjas = $data->number_of_ninjas;
                } else {
                    $response["status"] = "El numero disponible de ninjas va de 1 a 10";
                    $response["code"] = 90;
                }
            } else {
                $response["status"] = "Falta especificar el numero de ninjas";
                $response["code"] = 204;
            }
            if(isset($data->priority) || !empty($data->priority)) {
                $new_mission->priority = $data->priority; 
            } else{
                $response["status"] = "Selecciona la prioridad de la mision";
                $response["code"] = 204;
            }
            if(isset($data->payment) || !empty($data->payment)) {
                $new_mission->payment = $data->payment;
            } else {
                $respose["status"] = "Pon el pago que vas a realizar";
                $response["code"] = 204;
            }
            $new_mission->state = "pendiente";
            $new_mission->finish_time = "";
            try {
                $new_mission->save();
                $response["status"] = "Mision guardada correctamente";
                $response["code"] = 201;
                $response["data"] = $new_mission;
            } catch(\Exception $e) {
                $response["status"] = $e."Error al crear la mision";
                $response["code"] = 404;
            }
        } else {
            $response["status"] = "Json incorrecto";
            $response["code"] = 4;
        }
        return $response;
    }

    public function show_by_id($id) {
        $response = [
            "status" => "",
            "code" => 0,
            "data" => []
        ];
        $mission_searched = Mision::find($id);
        if ($mission_searched) {
            $response["status"] = "Mision encontrada";
            $response["code"] = 500;
            $response["data"] = $mission_searched;
        } else {
            $response["status"] = "Error al encontrar la mision";
            $response["code"] = 404;
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
            $mission_to_edit = Mision::find($id);
            if($mission_to_edit) {
                if(isset($data->client_id) || !empty($data->client_id)) {
                    try {
                        $mission_to_edit->client_id = $data->client_id;
                    } catch (\Exception $e) {
                        $response["status"] = "No existe el ID del cliente";
                        $response["code"] = 404;
                    }
                } else {
                    $response["status"] = "Falta el ID del cliente";
                    $response["code"] = 204;
                }
                if(isset($data->description) || !empty($data->description)) {
                    $mission_to_edit->description = $data->description;
                } else {
                    $response["status"] = "Falta la descripcion de la mision";
                    $response["code"] = 204;
                }
                if(isset($data->number_of_ninjas) || !empty($data->number_of_ninjas)) {
                    if($data->number_of_ninjas < 10 && $data->number_of_ninjas > 0) {
                        $mission_to_edit->number_of_ninjas = $data->number_of_ninjas;
                    } else {
                        $response["status"] = "El numero disponible de ninjas va de 1 a 10";
                        $response["code"] = 90;
                    }
                } else {
                    $response["status"] = "Falta especificar el numero de ninjas";
                    $response["code"] = 204;
                }
                if(isset($data->priority) || !empty($data->priority)) {
                    $mission_to_edit->priority = $data->priority; 
                } else{
                    $response["status"] = "Selecciona la prioridad de la mision";
                    $response["code"] = 204;
                }
                if(isset($data->payment) || !empty($data->payment)) {
                    $mission_to_edit->payment = $data->payment;
                } else {
                    $respose["status"] = "Pon el pago que vas a realizar";
                    $response["code"] = 204;
                }
                //$mission_to_edit->state = $data->state;
                try {
                    $mission_to_edit->save();
                    $response["status"] = "Mision guardada correctamente";
                    $response["code"] = 201;
                    $response["data"] = $mission_to_edit;
                } catch(\Exception $e) {
                    $response["status"] = "Error al crear la mision";
                    $response["code"] = 404;
                }
            } else {
                $response["status"] = "Error al encontrar la mision";
                $response["code"] = 404;
            }
            
        } else {
            $response["status"] = "Json incorrecto";
            $response["code"] = 4;
        }
        return $response;
    }

    public function change_state(Request $request, $id) {
        $response = [
            "status" => "",
            "code" => 0,
            "data" => []
        ];

        $json = $request->getContent();
        $data = json_decode($json);

        if($data) {
            $mission_to_edit = Mision::find($id);
            if($mission_to_edit) {
                if(isset($mission_to_edit->state) || !name($mission_to_edit->state)) {
                    $mission_to_edit->state = $data->state;
                } else {
                    $response["status"] = "No hay estado de la mision";
                    $response["code"] = 204;
                } 
                if(isset($data->finish_time) || !empty($data->finish_time)) {
                    $mission_to_edit->finish_time = $data->finish_time;
                } else {
                    $response["status"] = "No hay fecha de finalizacion";
                    $response["code"] = 204;
                }
                try {
                    $mission_to_edit->save();
                    if($data->state == "fallida" || $data->state == "completada") {
                        $response["status"] = "Estado editado correctamente";
                        $response["code"] = 201;
                        $response["data"] = [
                            "Estado de la mision: " . $mission_to_edit->state,
                            "Hora de completacion " . $mission_to_edit->finish_time
                        ];
                    }
                } catch (\Exception $e) {
                    $response["status"] = $e."Error al guardar la mision";
                    $response["code"] = 404;
                }
            } else {
                $response["status"] = "Error al encontrar la mision";
                $response["code"] = 404;
            }
        } else {
            $response["status"] = "Json incorrecto";
            $response["code"] = 4;
        }
        return $response;
    }

}
