<?php
/**
 * PositionTable.php - Position Table
 *
 * Table Model for Position Position
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
     * Get Position Entity
     *
     * @param int $id
     * @param string $sKey
     * @return mixed
     * @since 1.0.0
     */
    public function getSingle($id,$sKey = 'Position_ID') {
        # Use core function
        return $this->getSingleEntity($id,$sKey);
    }

    /**
     * Save Position Entity
     *
     * @param Position $oPosition
     * @return int Position ID
     * @since 1.0.0
     */
    public function saveSingle(Position $oPosition) {
        $aDefaultData = [
            'basket_idfs' => $oPosition->basket_idfs,
            'article_type' => $oPosition->article_type,
            'ref_type' => $oPosition->ref_type,
            'ref_idfs' => $oPosition->ref_idfs,
        ];
        unset($oPosition->label);
        unset($oPosition->total);

        return $this->saveSingleEntity($oPosition,'Position_ID',$aDefaultData);
    }

    /**
     * Generate new single Entity
     *
     * @return Position
     * @since 1.0.0
     */
    public function generateNew() {
        return new Position($this->oTableGateway->getAdapter());
    }
}