<?php
/**
 * This file contains class::ActivityPlotPrecision
 * @package Runalyze\System\Configuration\Value
 */
/**
 * Activity plot precision
 * @author Hannes Christiansen
 * @package Runalyze\System\Configuration\Value
 */
class ActivityPlotPrecision extends ConfigurationValueSelect {
	/**
	 * Construct
	 * @param string $Key
	 */
	public function __construct($Key) {
		parent::__construct($Key, array(
			'default'		=> '200points',
			'label'			=> __('Plots: precision'),
			'tooltip'		=> __('How many data points should be plotted?'),
			'options'		=> array( // see GpsData::nextStepForPlotData, GpsData::setStepSizeForPlotData
				'50m'			=> __('every 50m a data point'),
				'100m'			=> __('every 100m a data point'),
				'200m'			=> __('every 200m a data point'),
				'500m'			=> __('every 500m a data point'),
				'50points'		=> __('max. 50 data points'),
				'100points'		=> __('max. 100 data points'),
				'200points'		=> __('max. 200 data points (recommended)'),
				'300points'		=> __('max. 300 data points'),
				'400points'		=> __('max. 400 data points'),
				'500points'		=> __('max. 500 data points'),
				'750points'		=> __('max. 750 data points'),
				'1000points'	=> __('max. 1000 data points')
			),
			'onchange'		=> Ajax::$RELOAD_TRAINING,
			'onchange_eval'	=> 'System::clearTrainingCache();'
		));
	}

	/**
	 * Break by distance?
	 * @return bool
	 */
	public function byDistance() {
		return (substr($this->value(), -1) == 'm');
	}

	/**
	 * Distance in m
	 * @return int
	 */
	public function distanceStep() {
		return (int)substr($this->value(), 0, -1);
	}

	/**
	 * Break by number of points?
	 * @return bool
	 */
	public function byPoints() {
		return (substr($this->value(), -6) == 'points');
	}

	/**
	 * Number of points
	 * @return int
	 */
	public function numberOfPoints() {
		return (int)substr($this->value(), 0, -6);
	}
}