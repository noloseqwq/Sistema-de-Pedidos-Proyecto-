<?php

if ($peticionAjax) {
    require_once "../modelos/bdModelo.php";
} else {
    require_once "./modelos/bdModelo.php";
}

class bdControlador extends bdModelo{

    public function backup_bd_controlador(){
        $day = date("d");
        $mont = date("m");
        $year = date("Y");
        $hora = date("H-i-s");
        $fecha = $day . '_' . $mont . '_' . $year;
        $DataBASE = $fecha . "_(" . $hora . "_hrs).sql";
        $tables = array();
        $error="";
        $result = mainModel::ejecutar_consulta_simple('SHOW TABLES');
        if ($result) { 
            while ($row = $result->fetch()) {
                $tables[] = $row[0];
            }
           //deshabilitar la comprobación de restricciones de clave foránea.
            $sql = 'SET FOREIGN_KEY_CHECKS=0;' . "\n\n";

            $sql .= 'CREATE DATABASE IF NOT EXISTS ' . DB . ";\n\n";
            $sql .= 'USE ' . DB . ";\n\n";;
            
            foreach ($tables as $table) {
                $result = mainModel::ejecutar_consulta_simple('SELECT * FROM ' . $table);

                if ($result) {
                    $numFields = $result->columnCount();
                    $sql .= 'DROP TABLE IF EXISTS ' . $table . ';';
                    $query=mainModel::ejecutar_consulta_simple('SHOW CREATE TABLE ' . $table);
                    $row2 = $query->fetch();
                    $sql .= "\n\n" . $row2[1] . ";\n\n";
                    for ($i = 0; $i < $numFields; $i++) {
                        
                        while ($row = $result->fetch()) {
                            $sql .= 'INSERT INTO ' . $table . ' VALUES(';
                            for ($j = 0; $j < $numFields; $j++) {
                                
                                $row[$j] = addslashes($row[$j]);
                                $row[$j] = str_replace("\n", "\\n", $row[$j]);
                                if (isset($row[$j])) {
                                    $sql .= '"' . $row[$j] . '"';
                                } else {
                                    $sql .= '""';
                                }
                                if ($j < ($numFields - 1)) {
                                    $sql .= ',';
                                }
                            }
                            $sql .= ");\n";
                        }
                    }
                    $sql .= "\n\n\n";
                } else {
                    $error = 1;
                }
            }

            if ($error == 1) {
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ERROR 011",
                    "Texto"=>"No se pudo hacer la copia de seguridad",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            } else {
                chmod(BACKUP_PATH, 0777);
                $sql .= 'SET FOREIGN_KEY_CHECKS=1;';
                $handle = fopen(BACKUP_PATH . $DataBASE, 'w+');
                if (fwrite($handle, $sql)) {
                    fclose($handle);
                    $alerta=[
                        "Alerta"=>"recargar",
                        "Titulo"=>"Operacion exitosa",
                        "Texto"=>"Se a realizado la copia de seguridad corectamente!",
                        "Tipo"=>"success"
                    ];
                    echo json_encode($alerta);
                } else {
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"ERROR 012",
                        "Texto"=>"No se pudo hacer la copia de seguridad",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }
        } else {
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"ERROR 013",
                "Texto"=>"No se pudo hacer la copia de seguridad",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }

    public function restore_bd_controlador(){

        $restorePoint = mainModel::limpiar_cadena($_POST['restore']);
        $restorePoint= SERVER_URL.$restorePoint;
        $sql = explode(";", file_get_contents($restorePoint));
        $totalErrors = 0;
        set_time_limit(60);
        
        $conn = mainModel::conectar();
        $conn->query("SET FOREIGN_KEY_CHECKS=0");
        for ($i = 0; $i < (count($sql) - 1); $i++) {
            if ($conn->query($sql[$i] . ";")) {
            } else {
                $totalErrors++;
            }
        }
        $conn->query("SET FOREIGN_KEY_CHECKS=1");

        if ($totalErrors <= 0) {
            $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Restauracion exitosa",
                    "Texto"=>"Se pudo reaclizar la restauraion de los datos del sistema!",
                    "Tipo"=>"success"
                ];
        } else {
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No se pudo hacer la restauracion de los datos del sistema",
                "Tipo"=>"error"
            ];
    
        }
        echo json_encode($alerta);
    }
}
