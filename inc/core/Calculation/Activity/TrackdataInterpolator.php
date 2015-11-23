<?php
/**
 * This file contains class::TrackdataInterpolator
 * @package Runalyze\Calculation\Activity
 */
use Runalyze\Model\Trackdata;
class TrackdataInterpolator extends Interpolator {
    
        public function interpolateTrackdata(Trackdata\Object &$trackdata, array $keysToInterpolate = array()) {
          if (empty($keysToInterpolate)) {
            $keysToInterpolate = $this->defaultKeysToInterpolate($trackdata);
          }
          $this->setTimeArray($trackdata->time());
          foreach ($keysToInterpolate as $key) {
            // + Temperatur beachten für anderen nullValue?
            $trackdata->set($key, $this->interpolate($key));
          }
        } 
        
}