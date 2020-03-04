<?php
/**
 * Position.php - Position Entity
 *
 * Entity Model for Basket Position
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

use Application\Model\CoreEntityModel;

class Position extends CoreEntityModel {
    public $basket_idfs;

    /**
     * Basket constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @since 1.0.0
     */
    public function __construct($oDbAdapter) {
        parent::__construct($oDbAdapter);

        # Set Single Form Name
        $this->sSingleForm = 'basketposition-single';

        # Attach Dynamic Fields to Entity Model
        $this->attachDynamicFields();
    }

    /**
     * Set Entity Data based on Data given
     *
     * @param array $aData
     * @since 1.0.0
     */
    public function exchangeArray(array $aData) {
        $this->id = !empty($aData['Position_ID']) ? $aData['Position_ID'] : 0;
        $this->basket_idfs = !empty($aData['basket_idfs']) ? $aData['basket_idfs'] : 0;

        $this->updateDynamicFields($aData);
    }

    public function getLabel() {
        return $this->article_idfs;
    }
}