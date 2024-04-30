<?php

/**
 * Index Controller for Adminhtml Feedback Section
 *
 * @author Developers-Alliance team
 * @Copyright (c) 2024 Developers-alliance (https:// www. developers-alliance. com)
 * @package Devall_CustomerFeedback
 * @version 1.0.0
 *
 * This class handles the default action for the Feedback section in the admin panel.
 */

namespace Devall\CustomerFeedback\Controller\Adminhtml\Feedback;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Execute the default action.
     *
     * Generates the index (listing) page for the Feedback section in the admin panel.
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Customer Feedback'));
        return $resultPage;
    }
}
