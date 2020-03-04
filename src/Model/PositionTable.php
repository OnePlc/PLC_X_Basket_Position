<?php
/**
 * PositionTable.php - Position Table
 *
 * Table Model for Basket Position
 *
 * @category Model
 * @package Basket\Position
 * @author Verein onePlace
 * @copyright (C) 2020 Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Basket\Position\Model;

use Application\Controller\CoreController;
use Application\Model\CoreEntityTable;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Where;
use Laminas\Paginator\Paginator;
use Laminas\Paginator\Adapter\DbSelect;

class PositionTable extends CoreEntityTable {

    /**
     * PositionTable constructor.
     *
     * @param TableGateway $tableGateway
     * @since 1.0.0
     */
    public function __construct(TableGateway $tableGateway) {
        parent::__construct($tableGateway);

        # Set Single Form Name
        $this->sSingleForm = 'basketposition-single';
    }

    /**
     * Get Basket Entity
     *
     * @param int $id
     * @return mixed
     * @since 1.0.0
     */
    public function getSingle($id) {
        # Use core function
        return $this->getSingleEntity($id,'Position_ID');
    }

    /**
     * Save Basket Entity
     *
     * @param Basket $oBasket
     * @return int Basket ID
     * @since 1.0.0
     */
    public function saveSingle(Position $oBasket) {
        $aData = [];

        $aData = $this->attachDynamicFields($aData,$oBasket);

        $id = (int) $oBasket->id;

        if ($id === 0) {
            # Add Metadata
            if(isset($oSession->oUser)) {
                $aData['created_by'] = CoreController::$oSession->oUser->getID();
                $aData['created_date'] = date('Y-m-d H:i:s', time());
                $aData['modified_by'] = CoreController::$oSession->oUser->getID();
                $aData['modified_date'] = date('Y-m-d H:i:s', time());
            } else {
                $aData['created_by'] = 1;
                $aData['created_date'] = date('Y-m-d H:i:s', time());
                $aData['modified_by'] = 1;
                $aData['modified_date'] = date('Y-m-d H:i:s', time());
            }
            # Insert Basket
            $this->oTableGateway->insert($aData);

            # Return ID
            return $this->oTableGateway->lastInsertValue;
        }

        # Check if Basket Entity already exists
        try {
            $this->getSingle($id);
        } catch (\RuntimeException $e) {
            throw new \RuntimeException(sprintf(
                'Cannot update Position with identifier %d; does not exist',
                $id
            ));
        }

        # Update Metadata
        $aData['modified_by'] = (isset(CoreController::$oSession->oUser)) ? CoreController::$oSession->oUser->getID() : 1;
        $aData['modified_date'] = date('Y-m-d H:i:s',time());

        # Update Basket
        $this->oTableGateway->update($aData, ['Position_ID' => $id]);

        return $id;
    }

    /**
     * Generate new single Entity
     *
     * @return Basket
     * @since 1.0.0
     */
    public function generateNew() {
        return new Position($this->oTableGateway->getAdapter());
    }
}