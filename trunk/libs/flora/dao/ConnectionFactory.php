<?php

class ConnectionFactory {
    const CONNECTION_READ = 'read';
    const CONNECTION_WRITE = 'write';
    private $connectionMap = array ();
    private $configuration;
    private static $instance = null;

    /**
     * @return ConnectionFactory
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self ( );
        }
        return self::$instance;
    }

    public function __clone() {
        throw new Exception ( 'ConnectionFactory not allowed clone.' );
    }

    public function getConnction($name = null, $mode = self::CONNECTION_WRITE) {
        if ($mode != self::CONNECTION_WRITE) {
            throw new Exception ( 'Now only support write connection mode.' );
        }
        
        if (! isset ( $this->connectionMap [$name] )) {
            $conparams = isset ( $this->configuration [$name] ) ? $this->configuration [$name] : null;
            if (empty ( $conparams )) {
                throw new Exception ( 'error' );
            }
            $con = $this->initConnection ( $conparams, $name );
            $this->connectionMap [$name] = $con;
        }
        return $this->connectionMap [$name];
    }

    private function initConnection($conparams, $name) {
        $dsn = $conparams ['dsn'];
        if ($dsn === null) {
            throw new PropelException ( 'No dsn specified in your connection parameters for datasource [' . $name . ']' );
        }
        
        $user = isset ( $conparams ['user'] ) ? $conparams ['user'] : null;
        $password = isset ( $conparams ['password'] ) ? $conparams ['password'] : null;
        
        $con = new PDO ( $dsn, $user, $password );
        $con->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        return $con;
    }

    public function setConfiguration($c) {
        $this->configuration = $c;
//        return $this;
    }

    public function getConfiguration() {
        return $this->configuration;
    }

    public function init($c) {
        self::configure ( $c );
        self::$connectionMap = array ();
    }
}