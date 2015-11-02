<?php

class cols {
    
    private $cols;
    
    public function __construct() {
        for($i='a'; $i<='z' ; $i++) {
            $this->cols[] = $i;
        }
    }
    
    /**
     * Start with 1.
     * 
     * @param type $number
     */
    public function getColNameByNumber($number) {
        return $this->cols[$number - 1];
    }
    
}