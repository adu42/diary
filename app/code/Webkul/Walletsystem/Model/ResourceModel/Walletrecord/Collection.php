<?php
/**
 * Webkul Software
 *
 * @category Webkul
 * @package Webkul_Walletsystem
 * @author Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license https://store.webkul.com/license.html
 */

namespace Webkul\Walletsystem\Model\ResourceModel\Walletrecord;

use \Webkul\Walletsystem\Model\ResourceModel\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'Webkul\Walletsystem\Model\Walletrecord',
            'Webkul\Walletsystem\Model\ResourceModel\Walletrecord'
        );
        $this->_map['fields']['entity_id'] = 'main_table.entity_id';
        $this->_map['fields']['customer_name'] = 'cgf.name';
    }
    public function addStoreFilter($store, $withAdmin = true)
    {
        if (!$this->getFlag('store_filter_added')) {
            $this->performAddStoreFilter($store, $withAdmin);
        }
        return $this;
    }
}
