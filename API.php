<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\OpeniAppTracker;

use Piwik\DataTable;
use Piwik\DataTable\Row;

/**
 * API for plugin OpeniAppTracker
 *
 * @method static \Piwik\Plugins\OpeniAppTracker\API getInstance()
 */
class API extends \Piwik\Plugin\API
{

    /**
     * Another example method that returns a data table.
     * @param int    $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @return DataTable
     */
    public function trackByApp($idSite, $period, $date, $segment = false)
    {
        $data = \Piwik\Plugins\Live\API::getInstance()->getLastVisitsDetails(
          $idSite,
          $period,
          $date,
          $segment,
          $numLastVisitorsToFetch = 100,
          $minTimestamp = false,
          $flat = false,
          $doNotFetchActions = true
        );
        $data->applyQueuedFilters();

        $result = $data->getEmptyClone($keepFilters = false);

        foreach ($data->getRows() as $visitRow) {

          $appName = $visitRow->getColumn('referrerName');
            if(empty($appName)) {
                $appName = 'undefined';
            }
          $appRow = $result->getRowFromLabel($appName);

          if ($appRow === false) {
            $result->addRowFromSimpleArray(array(
              'label' => $appName,
              'nb_visits' => 1
            ));
          } else {
            $counter = $appRow->getColumn('nb_visits');
            $appRow->setColumn('nb_visits', $counter + 1);
          }
        }

        return $result;
    }
}
