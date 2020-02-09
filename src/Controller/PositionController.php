<?php
/**
 * PositionController.php - Main Controller
 *
 * Main Controller for Basket Position Plugin
 *
 * @category Controller
 * @package Basket\Position
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

declare(strict_types=1);

namespace OnePlace\Basket\Position\Controller;

use Application\Controller\CoreEntityController;
use Application\Model\CoreEntityModel;
use OnePlace\Basket\Model\BasketTable;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\AdapterInterface;
use OnePlace\Position\Model\PositionTable;

class PositionController extends CoreEntityController {
    /**
     * Position Table Object
     *
     * @since 1.0.0
     */
    protected $oTableGateway;

    protected $aPluginTables;

    /**
     * PositionController constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @param PositionTable $oTableGateway
     * @since 1.0.0
     */
    public function __construct(AdapterInterface $oDbAdapter, BasketTable $oTableGateway, $oServiceManager,$aPluginTables = [])
    {
        $this->oTableGateway = $oTableGateway;
        $this->sSingleForm = 'basketposition-single';
        parent::__construct($oDbAdapter, $oTableGateway, $oServiceManager);
        $this->aPluginTables = $aPluginTables;

        if ($oTableGateway) {
            # Attach TableGateway to Entity Models
            if (!isset(CoreEntityModel::$aEntityTables[$this->sSingleForm])) {
                CoreEntityModel::$aEntityTables[$this->sSingleForm] = $oTableGateway;
            }
        }
    }

    public function attachPosition($oBasket) {
        $oPosTbl = $this->aPluginTables['position'];

        $aPositions = [];
        $fSubTotal = 0;
        $oPositionsDB = $oPosTbl->fetchAll(false,['basket_idfs'=>$oBasket->getID()]);
        if(count($oPositionsDB) > 0) {
            foreach($oPositionsDB as $oPos) {
                # Calculate Position Total if property exists
                if(property_exists($oPos,'total')) {
                    $oPos->total = $oPos->amount*$oPos->price;
                    $fSubTotal+=$oPos->total;
                }
                $aPositions[] = $oPos;
            }
        }
        $aFields = [];
        $aUserFields = CoreEntityController::$oSession->oUser->getMyFormFields();
        if(array_key_exists('basketposition-single',$aUserFields)) {
            $aFieldsTmp = $aUserFields['basketposition-single'];
            if(count($aFieldsTmp) > 0) {
                # add all contact-base fields
                foreach($aFieldsTmp as $oField) {
                    if($oField->tab == 'position-base') {
                        $aFields[] = $oField;
                    }
                }
            }
        }
        $aFieldsByTab = ['position-base'=>$aFields];
        # Pass Data to View - which will pass it to our partial
        return [
            # must be named aPartialExtraData
            'aPartialExtraData' => [
                # must be name of your partial
                'basket_position'=> [
                    'aPositions'=>$aPositions,
                    'aFieldsByTab'=>$aFieldsByTab,
                    'fSubTotal'=>$fSubTotal,
                ]
            ]
        ];
    }
}