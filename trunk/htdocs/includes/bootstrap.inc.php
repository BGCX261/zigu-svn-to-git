<?php

class Bootstrap {
    
    private function defineConstant() {
        
    }
    
    private function init() {
        $this->defineConstant();
        $this->loadConfig();
    }
    
    private function loadConfig() {
        
    }
    
    public static function run() {
        $self = new self();
        $self->init();
    }
}