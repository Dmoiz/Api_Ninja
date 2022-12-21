<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ninja;
use App\Models\Mision;
use App\Models\MisionNinja;

class NinjaController extends Controller
{

    public function show_all() {
        $response = [
            "status" => "",
            "code" => 0,
            "data" => []
        ];

        $ninjas = Ninja::select('name', 'rank', 'status', 'created_at')->get();
        foreach ($ninjas as $ninja) {
            array_push($response["data"], $ninja);
            $response["status"] = "Ninjas encontrados";
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
            $new_ninja = new Ninja();
            if(isset($data->name) || !empty($data->name)) {
                $new_ninja->name = $data->name;
            } else {
                $response["status"] = "No hay nombre del ninja";
                $response["code"] = 204;
            }
            if(isset($data->skills) || !empty($data->skills)) {
                $new_ninja->skills = $data->skills;
            } else {
                $response["status"] = "No hay habilidades del ninja";
                $response["code"] = 204;
            }
            if(isset($data->status) || !empty($data->status)) {
                $new_ninja->status = $data->status;
            } else {
                $response["status"] = "No hay estado del ninja";
                $response["code"] = 204;
            }
            if(isset($data->rank) || !empty($data->rank)) {
                $new_ninja->rank = $data->rank;
            } else {
                $response["status"] = "No hay rango del ninja";
                $response["code"] = 204;
            }
            try {
                $new_ninja->save();
                $response["status"] = "Ninja guardado correctamente";
                $response["code"] = 201;
                $response["data"] = $new_ninja;
            } catch(\Exception $e) {
                $response["status"] = "Error al guardar al ninja";
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
        $ninja_searched = Ninja::find($id);
        if ($ninja_searched) {
            $response["status"] = "Ninja encontrado";
            $response["code"] = 500;
        } else {
            $response["status"] = "Error al encontrar al ninja";
            $response["code"] = 404;
        }
        $mision_id = MisionNinja::select('mision_id')->where('ninja_id', '=', $ninja_searched->id)->get();
        if($mision_id) {
            $response["status"] = "Datos encontrados";
            $response["code"] = 500;
        } else {
            $response["status"] = "Error al encontrar los datos";
            $response["code"] = 404;
        }
        try {
            $missions = array();
            foreach ($mision_id as $id) {
                $mission = Mision::select('id', 'state', 'created_at')
                ->where('id', '=', $id->mision_id)->get();
                array_push($missions, $mission);
            }
            $ninja_searched["misions"] = $missions;
        } catch(\Exception $e) {
            $response["status"] = "Ha ocurrido un error";
            $response["code"] = 500;
        }
        $response ["data"] = $ninja_searched;
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
            $ninja_to_edit = Ninja::find($id);
            if($ninja_to_edit) {
                if(isset($data->name) || !empty($data->name)) {
                    $ninja_to_edit->name = $data->name;
                } else {
                    $response["status"] = "No hay nombre del ninja";
                    $response["code"] = 204;
                }
                if(isset($data->skills) || !empty($data->skills)) {
                    $ninja_to_edit->skills = $data->skills;
                } else {
                    $response["status"] = "No hay habilidades del ninja";
                    $response["code"] = 204;
                }
                if(isset($data->status) || !empty($data->status)) {
                    $ninja_to_edit->status = $data->status;
                } else {
                    $response["status"] = "No hay estado del ninja";
                    $response["code"] = 204;
                }
                if(isset($data->rank) || !empty($data->rank)) {
                    $ninja_to_edit->rank = $data->rank;
                } else {
                    $response["status"] = "No hay rango del ninja";
                    $response["code"] = 204;
                }
                try {
                    $ninja_to_edit->save();
                    $response["status"] = "Ninja editado correctamente";
                    $response["code"] = 201;
                    $response["data"] = $ninja_to_edit;
                } catch(\Exception $e) {
                    $response["status"] = "Error al editar el ninja";
                    $response["code"] = 404;
                }
            } else {
                $response["status"] = "Error al encontrar al ninja";
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
            $ninja_to_edit = Ninja::find($id);
            if($ninja_to_edit) {
                if(isset($ninja_to_edit->status) || !name($ninja_to_edit->status)) {
                    $ninja_to_edit->status = $data->status;
                } else {
                    $response["status"] = "No hay estado del ninja";
                    $response["code"] = 204;
                } 
                try {
                    $ninja_to_edit->save();
                    $response["status"] = "Estado editado correctamente";
                    $response["code"] = 201;
                    $response["data"] = $ninja_to_edit;
                } catch (\Exception $e) {
                    $response["status"] = "Error al guardar al ninja";
                    $response["code"] = 404;
                }
            } else {
                $response["status"] = "Error al encontrar al ninja";
                $response["code"] = 404;
            }
        } else {
            $response["status"] = "Json incorrecto";
            $response["code"] = 4;
        }
        return $response;
    }

    public function show_by_name($name) {
        $response = [
            "status" => "",
            "code" => 0,
            "data" => []
        ];
        $ninjas = Ninja::where('name', $name)->get();

        if($ninjas) {
            $response["status"] = "Ninja encontrado";
            $response["code"] = 201;
            $response["data"] = $ninjas;
        } else {
            $response["status"] = "Ninja no encontrado";
            $response["code"] = 404;
        }
        return $response;
    }

    public function show_by_state($status) {
        $response = [
            "status" => "",
            "code" => 0,
            "data" => []
        ];
        $ninjas = Ninja::where('status', $status)->get();

        if($ninjas) {
            $response["status"] = "Ninja encontrado";
            $response["code"] = 201;
            $response["data"] = $ninjas;
        } else {
            $response["status"] = "Ninja no encontrado";
            $response["code"] = 404;
        }
        return $response;
    }

    public function assign(Request $request) {
        $response = [
            "status" => "",
            "code" => 0,
            "data" => []
        ];

        $json = $request->getContent();
        $data = json_decode($json);

        if($data) {
            $mn = new MisionNinja();
            if(isset($data->ninja_id) || !empty($data->ninja_id) && is_numeric($data->ninja_id)) {
                $ninja = Ninja::find($data->ninja_id);
                if($ninja) {
                    /* $mision->ninjas()->attach($data->ninja_id); */
                    $mn->ninja_id = $data->ninja_id;
                } else {
                    $response["status"] = "No hay ninja";
                }
            } else {
                $response["status"] = "Escribe la ID del ninja";
                $respose["code"] = 404;
            }
            if(isset($data->mision_id) || !empty($data->mision_id) && is_numeric($data->mision_id)) {
                $mision = Mision::find($data->mision_id);
                if($mision) {
                    $mision->state = "en curso";
                    $mn->mision_id = $data->mision_id;
                } else {
                    $response["status"] = "No hay mision";
                }
            } else {
                $response["status"] = "Escribe la ID de la mision";
                $respose["code"] = 404;
            }
            try {
                $mision->save();
                $mn->save();
                $response["status"] = "Datos guardados correctamente";
                $response["code"] = 201;
                $response["data"] = [
                    "ninja_id " . $mn->ninja_id,
                    "mision_id " . $mn->mision_id
                ];
            } catch(\Exception $e) {
                $response["status"] = "Error al guardar los datos";
                $response["code"] = 404;
            }
        } else {
            $response["status"] = "Json incorrecto";
            $response["code"] = 404;
        }
        return $response;
    }

    public function unassign(Request $request) {
        $response = [
            "status" => "",
            "code" => 0,
            "data" => []
        ];

        $json = $request->getContent();
        $data = json_decode($json);

        if($data) {
            if(!isset($data->ninja_id) || empty($data->ninja_id) || !is_numeric($data->ninja_id)) {
                $response["status"] = "ID del ninja inválido";
                $response["code"] = 404;
            }
            if(!isset($data->mision_id) || empty($data->mision_id) || !is_numeric($data->mision_id)) {
                $response["status"] = "ID de la mision invalido";
                $response["code"] = 404;
            }
            //Meto la asignación que quiero borrar en una colección
            $assignments = MisionNinja::where('ninja_id', '=', $data->ninja_id)
            ->where('mision_id', '=', $data->mision_id)
            ->get();
            //Con el foreach me recorro esa colección y borro el contenido
            try {
                foreach($assignments as $unassign) {
                    $unassign->delete();
                    $response["status"] = "Ninja asignado eliminado de la mision";
                    $response["code"] = 201;
                } 
            } catch(\Exception $e) {
                $response["status"] = "Error al eliminar la asignacion";
                $response["code"] = 500;
            }
            return $response;
        }
        
    }
    
}
