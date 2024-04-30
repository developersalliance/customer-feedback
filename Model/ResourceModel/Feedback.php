<?php
/**
 * Feedback ResourceModel
 *
 * @author Developers-Alliance team
 * @Copyright (c) 2024 Developers-alliance (https:// www. developers-alliance. com)
 * @website https://developers-alliance.com
 * @package Devall_CustomerFeedback
 * @version 1.0.0
 *
 * This class serves as the ResourceModel for the Feedback model.
 */
namespace Devall\CustomerFeedback\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Feedback extends AbstractDb
{
    /**
     * Initialize Feedback ResourceModel
     *
     * The function is responsible for setting the table and primary key information
     * for the Feedback model.
     */
    protected function _construct()
    {
        $this->_init('customer_feedback', 'id');
    }
}
