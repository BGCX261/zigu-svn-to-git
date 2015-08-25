<?php

require_once 'flora/dao/ConnectionFactory.php';
require_once 'flora/config/RunlevelConfig.php';

class PollConnectionFactory {
    /**
     * @var ConnectionFactory
     */
    private $factory = null;
    private static $_instance = null;

    private function __construct() {
        $this->factory = ConnectionFactory::getInstance();
        $config = RunlevelConfig::load(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . DIRECTORY_SEPARATOR . 'config', 'database');
        $this->factory->setConfiguration($config);
    }
    
    /**
     * @return PDO
     */
    public function getConnection() {
        return $this->factory->getConnction('poll');
    }
    
    /**
     * @return PollConnectionFactory
     */
    public static function getInstance() {
        if (empty(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}