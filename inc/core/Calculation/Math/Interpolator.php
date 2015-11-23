<?php
/**
 * This file contains class::Interpolator
 * @package Runalyze\Calculation\Math
 */
/**
 * Interpolator
 *
 * @author Hannes Christiansen
 * @author Michael Pohl
 * @package Runalyze\Calculation\Math
 */
class Interpolator {
    
    /*
     * Time array for data
     * @var array
     */
    protected $timeArray;
    
    public function __construct(array $timeArray = array()) {
        $this->timeArray = $timeArray;
    }
    
    
    /*
     * Set time array
     * @param array $timeArray
     */
    public function setTimeArray(array $timeArray) {
        $this->timeArray = $timeArray;
    }
    
    /*
     * Interpolate data
     * @param array $data
     * @param int $nullValue
     * @return array
     */
    public function interpolate(array $data, $nullValue = 0) {
        if(count($this->timeArray) == count($data)) {
            foreach($data as $key => $item) {
                if($item == $nullValue) {
                    if(!isset($data[$key+1])) {
                        $value = $data[$key-1];
                    } elseif(!isset($data[$key-1])) {
                        $value = $nullValue;
                    } else {
                        $itemDiff = $data[$key+1] - $data[$key-1];
                        $timeDiff = $this->timeArray[$key+1] - $this->timeArray[$key-1];
                        $timeMultiplicator = $this->timeArray[$key] - $this->timeArray[$key-1];
                        //Todo round - check precision
                        $data[$key] = $itemDiff + (($itemDiff / $timeDiff) * $timeMultiplicator);
                    }
                }
            }
            return $data;
        }
    }
}