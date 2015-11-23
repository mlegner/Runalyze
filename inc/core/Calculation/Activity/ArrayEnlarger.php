<?php
/**
 * This file contains class::ArrayEnlarger
 * @package Runalyze\Calculation\Activity
 */
/**
 * Array Enlarger
 *
 * @author Hannes Christiansen
 * @author Michael Pohl
 * @package Runalyze\Calculation\Math
 */
class ArrayEnlarger {
    
    protected $EnlargedTimeArray;
    protected $OldTimeArray;
    protected $NewTimeArray;
    protected $newKeys;
    
    
    public function __construct($LargerTimeArray, $oldTimeArray) {
        $this->NewTimeArray = $LargerTimeArray;
        $this->OldTimeArray = $oldTimeArray;
    }
    
    public function setNewTimeArray($newTimeArray) {
        $this->NewTimeArray = $newTimeArray;
    }
    
    public function setoldTimeArray($oldTimeArray) {
        $this->OldTimeArray = $oldTimeArray;
    }
    
    private function createEnlargedTimeArray() {
        $EnlargedArray = array_unique(array_merge($this->OldTimeArray, $this->NewTimeArray));
        sort($EnlargedArray);
        $this->EnlargedTimeArray = $EnlargedArray;
    }
    
    private function getNewKeys() {
	$EnlargedArray = array_flip($this->EnlargedTimeArray);
	foreach($this->OldTimeArray as $key => $old) {
	    if(isset($EnlargedArray[$old]))
		$this->newKeys[$key] =  $EnlargedArray[$old];
	}
    }
    
    public function getEnlargedTimeArray() {
        if(is_array($this->EnlargedTimeArray)) {
            return $this->EnlargedTimeArray;
        } 
        return false;
    }
    
    public function enlarge($dataArray) {
        foreach($dataArray as $key => $data) {
	    //TODO if $this->newKeys[$key] - build new array
	}
    }
}