<?php
/**
 * Position.php - Position Entity
 *
 * Entity Model for Position Position
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
    public $article_type;
    public $ref_type;
    public $ref_idfs;

    /**
     * Position constructor.
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
        $this->article_type = !empty($aData['article_type']) ? $aData['article_type'] : 'article';
        $this->ref_type = !empty($aData['ref_type']) ? $aData['ref_type'] : 'none';
        $this->ref_idfs = !empty($aData['ref_idfs']) ? $aData['ref_idfs'] : 0;

        $this->updateDynamicFields($aData);
    }

}