<?php

class Venta {
    private $idventa;
    private $fk_idcliente;
    private $fk_idproducto;
    private $fecha;
    private $cantidad;
    private $preciounitario;
    private $total;

    private $nombre_cliente;
    private $nombre_producto;

    public function __construct(){
        $this->cantidad = 0;
        $this->preciounitario = 0.0;
        $this->total = 0.0;
    }

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
        return $this;
    }


    public function insertar(){
       
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        
        $sql = "INSERT INTO ventas (
                    fk_idcliente, 
                    fk_idproducto, 
                    fecha, 
                    cantidad,
                    preciounitario,
                    total
                ) VALUES (
                    $this->fk_idcliente, 
                    $this->fk_idproducto,
                    '$this->fecha', 
                    $this->cantidad,
                    $this->preciounitario,
                    $this->total
                );";
        
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        
        $this->idventa = $mysqli->insert_id;
        
        $mysqli->close();
    }

    public function actualizar(){

        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "UPDATE ventas SET
                    fk_idcliente = $this->fk_idcliente,
                    fk_idproducto = $this->fk_idproducto,
                    fecha = '$this->fecha',
                    cantidad = $this->cantidad,
                    preciounitario = $this->preciounitario,
                    total = $this->total
                WHERE idventa = $this->idventa";

        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }

    public function eliminar(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "DELETE FROM ventas WHERE idventa = " . $this->idventa;
      
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }

    public function obtenerPorId(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "SELECT  idventa, 
                        fk_idcliente, 
                        fk_idproducto, 
                        fecha, 
                        cantidad,
                        preciounitario,
                        total
                FROM ventas 
                WHERE idventa = " . $this->idventa;
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }

      
        if($fila = $resultado->fetch_assoc()){
            $this->idventa = $fila["idventa"];
            $this->fk_idcliente = $fila["fk_idcliente"];
            $this->fk_idproducto = $fila["fk_idproducto"];
            $this->fecha = $fila["fecha"];
            $this->cantidad = $fila["cantidad"];
            $this->preciounitario = $fila["preciounitario"];
            $this->total = $fila["total"];
        }
        $mysqli->close();

    }
    
    public function obtenerTodos(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "SELECT idventa, 
                        fk_idcliente, 
                        fk_idproducto, 
                        fecha, 
                        cantidad,
                        preciounitario,
                        total
                FROM ventas";
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }

        $aResultado = array();
        if($resultado){
    
            while($fila = $resultado->fetch_assoc()){
                $entidadAux = new Venta();
                $entidadAux->idventa = $fila["idventa"];
                $entidadAux->fk_idcliente = $fila["fk_idcliente"];
                $entidadAux->fk_idproducto = $fila["fk_idproducto"];
                $entidadAux->fecha = $fila["fecha"];
                $entidadAux->cantidad = $fila["cantidad"];
                $entidadAux->preciounitario = $fila["preciounitario"];
                $entidadAux->total = $fila["total"];
                $aResultado[] = $entidadAux;
            }
        }
        $mysqli->close();
        return $aResultado;
    }

    public function cargarGrilla(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        
        $sql = "SELECT
                A.idventa,
                A.fecha,
                A.cantidad,
                A.fk_idcliente,
                B.nombre AS nombre_cliente,
                A.fk_idproducto,
                A.total,
                A.preciounitario,
                C.nombre AS nombre_producto
            FROM ventas A
            INNER JOIN clientes B ON A.fk_idcliente = B.idcliente
            INNER JOIN productos C ON A.fk_idproducto = C.idproducto
            ORDER BY A.fecha DESC";
        
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }

        
        $aResultado = array();
        if($resultado){
            while($fila = $resultado->fetch_assoc()){
                $entidadAux = new Venta();
                $entidadAux->idventa = $fila["idventa"];
                $entidadAux->fk_idcliente = $fila["fk_idcliente"];
                $entidadAux->nombre_cliente = $fila["nombre_cliente"];
                $entidadAux->fk_idproducto = $fila["fk_idproducto"];
                $entidadAux->nombre_producto = $fila["nombre_producto"];
                $entidadAux->fecha = $fila["fecha"];
                $entidadAux->cantidad = $fila["cantidad"];
                $entidadAux->preciounitario = $fila["preciounitario"];
                $entidadAux->total = $fila["total"];
                $aResultado[] = $entidadAux;
            }
            $mysqli->close();
            return $aResultado;
        }
    }
}
?>