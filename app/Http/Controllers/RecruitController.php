<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recruit;
use App\Models\Ninja;

class RecruitController extends Controller
{

    public function show_all() {
        $response = [
            "status" => "",
            "code" => 0,
            "data" => []
        ];

        $recruits = Recruit::all();
        foreach ($recruits as $recruit) {
            array_push($response["data"], $recruit);
            $response["status"] = "Reclutas encontrados";
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
            $new_recruit = new Recruit();
            if(isset($data->name) || !empty($data->name)) {
                $new_recruit->name = $data->name;
            } else {
                $response["status"] = "No hay nombre del recluta";
                $response["code"] = 204;
            }
            if(isset($data->skills) || !empty($data->skills)) {
                $new_recruit->skills = $data->skills;
            } else {
                $response["status"] = "No hay habilidades del recluta";
                $response["code"] = 204;
            }
            if(isset($data->status) || !empty($data->status)) {
                $new_recruit->status = $data->status;
            } else {
                $response["status"] = "No hay estado del recluta";
                $response["code"] = 204;
            }
            try {
                $new_recruit->save();
                $response["status"] = "Recluta guardado correctamente";
                $response["code"] = 201;
                $response["data"] = $new_recruit;
            } catch(\Exception $e) {
                $response["status"] = "Error al guardar al recluta";
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
            $recruit_to_edit = Recruit::find($id);
            if($recruit_to_edit) {
                if(isset($data->name) || !empty($data->name)) {
                    $recruit_to_edit->name = $data->name;
                } else {
                    $response["status"] = "No hay nombre del recluta";
                    $response["code"] = 204;
                }
                if(isset($data->skills) || !empty($data->skills)) {
                    $recruit_to_edit->skills = $data->skills;
                } else {
                    $response["status"] = "No hay habilidades del recluta";
                    $response["code"] = 204;
                }
                if(isset($data->status) || !empty($data->status)) {
                    $recruit_to_edit->status = $data->status;
                } else {
                    $response["status"] = "No hay estado del recluta";
                    $response["code"] = 204;
                }
                try {
                    $recruit_to_edit->save();
                    $response["status"] = "Recluta editado correctamente";
                    $response["code"] = 201;
                    $response["data"] = $recruit_to_edit;
                } catch(\Exception $e) {
                    $response["status"] = "Error al editar el recluta";
                    $response["code"] = 404;
                }
            } else {
                $response["status"] = "Error al encontrar al recluta";
                $response["code"] = 404;
            }
            
        } else {
            $response["status"] = "Json incorrecto";
            $response["code"] = 4;
        }
        return $response;
    }

    public function delete($id) {
        $response = [
            "status" => "",
            "code" => 0,
            "data" => []
        ];

        $recruit_to_delete = Recruit::find($id);
        if($recruit_to_delete) {
            $response["status"] = "Recluta encontrado, se va a proceder a su eliminación";
            $response["code"] = 201;
            $response["data"] = $recruit_to_delete;
            $recruit_to_delete->delete();
        } else {
            $response["status"] = "No hay ningún recluta con ese ID";
            $response["code"] = 404;
        }
        return $response;
    }

    public function promote($id) {
        $response = [
            "status" => "",
            "code" => 0,
            "data" => []
        ];

        $recruit_to_promote = Recruit::find($id);
        $new_ninja = new Ninja();
        if($recruit_to_promote) {
            $new_ninja->name = $recruit_to_promote->name;
            $new_ninja->skills = $recruit_to_promote->skills;
            $new_ninja->status = $recruit_to_promote->status;
            $new_ninja->rank = "Novato";
            try {
                $recruit_to_promote->delete();
                $new_ninja->save();
                $response["status"] = "Recluta promocionado correctamente";
                $response["code"] = 201;
                $response["data"] = $new_ninja;
            } catch (\Exception $e) {
                $response["status"] = $e . "Error al promocionar al recluta";
                $response["code"] = 404;
            }
        } else {
            $response["status"] = "No hay ningún recluta con ese ID";
            $response["code"] = 404;
        }
        return $response;
    }
}
