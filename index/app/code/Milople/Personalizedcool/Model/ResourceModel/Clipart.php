<?php
/**
*
* Do not edit or add to this file if you wish to upgrade the module to newer
* versions in the future. If you wish to customize the module for your
* needs please contact us to https://www.milople.com/contact-us.html
*
* @category    Ecommerce
* @package     Milople_Personlized
* @copyright   Copyright (c) 2016 Milople Technologies Pvt. Ltd. All Rights Reserved.
* @url         https://www.milople.com/magento2-extensions/personalizedcool-products.html
*
**/
namespace Milople\Personalizedcool\Model\ResourceModel;

use  Milople\Personalizedcool\Api\Data\ClipartInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Clipart extends AbstractDb
{
    const TABLE_NAME = 'personalized_clilpart_image';

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(static::TABLE_NAME, ClipartInterface::ID);
    }
}