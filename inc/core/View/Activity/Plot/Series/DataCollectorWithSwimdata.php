<?php
/**
 * This file contains class::DataCollector
 * @package Runalyze\View\Activity\Plot\Series
 */

namespace Runalyze\View\Activity\Plot\Series;

use Runalyze\Model\Trackdata\Object as Trackdata;
use Runalyze\Model\Swimdata\Object as Swimdata;
use Runalyze\Model\Swimdata\Loop;
use Runalyze\Configuration;

/**
 * Collect data from trackdata
 * 
 * @author Hannes Christiansen
 * @package Runalyze\View\Activity\Plot\Series
 */
class DataCollectorWithSwimdata extends DataCollector {
	/**
	 * @var \Runalyze\Model\Swimdata\Loop;
	 */
	protected $LoopSwimdata;

	/**
	 * Construct collector
	 * @param \Runalyze\Model\Trackdata\Object $trackdata
	 * @param enum $key
	 * @param \Runalyze\Model\Swimdata\Object $swimdata
	 * @throws \InvalidArgumentException
	 */
	public function __construct(Trackdata $trackdata, $key, Swimdata $swimdata) {
		if (!$swimdata->has($key)) {
			throw new \InvalidArgumentException('Swimdata has no data for "'.$key.'".');
		}

		$this->Key = $key;
		$this->Precision = Configuration::ActivityView()->plotPrecision();
		$this->KnowsDistance = $swimdata->has(Swimdata::SWIMDISTANCE);

		$this->init($trackdata, $swimdata);
		$this->LoopSwimdata = new Loop($swimdata);
		$this->collect();
	}

	/**
	 * Collect data
	 */
	protected function collect() {
		do {
			$this->move();

			$value = $this->LoopSwimdata->average($this->Key);

			if ($this->XAxis == self::X_AXIS_DISTANCE) {
				$this->Data[(string)$this->LoopSwimdata->current(Swimdata::SWIMDISTANCE)] = $value;
			} elseif ($this->XAxis == self::X_AXIS_TIME) {
				$this->Data[(string)$this->LoopSwimdata->current(Swimdata::SWIMTIME).'000'] = $value;
			} else {
				$this->Data[] = $value;
			}
		} while (!$this->Loop->isAtEnd());
	}
        
	/**
	 * Init loop
	 * @param \Runalyze\Model\Trackdata\Object $trackdata
	 */
	protected function init(Trackdata $trackdata, Swimdata $swimdata) {
		$this->Loop = new Loop($swimdata);

		$this->defineStepSize($swimdata);
		$this->defineXAxis($trackdata);
	}
        
	/**
	 * Set step size
	 * @param \Runalyze\Model\Swimdata\Object $swimdata
	 */
	protected function defineStepSize(Swimdata $swimdata) {
		if ($this->Precision->byPoints() && $swimdata->num() > $this->Precision->numberOfPoints()) {
			$this->Loop->setStepSize( round($swimdata->num() / $this->Precision->numberOfPoints ()) );
		} elseif ($this->Precision->byDistance()) {
			$this->StepDistance = $this->Precision->distanceStep() / 1000;
		}
	}
        
	/**
	 * Get next step for plot data
	 * @return bool 
	 */
	protected function move() {
		parent::move();

		$this->LoopSwimdata->goToIndex( $this->Loop->index() );
	}
}