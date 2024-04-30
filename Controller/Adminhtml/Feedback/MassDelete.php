<?php

/**
 * Mass Delete Feedback Controller for adminhtml
 *
 * @author Developers-Alliance team
 * @Copyright (c) 2024 Developers-alliance (https://www.developers-alliance.com)
 * @package Devall_CustomerFeedback
 * @version 1.0.0
 *
 * This class handles the action for mass deleting Feedback entries from the admin panel.
 */

namespace Devall\CustomerFeedback\Controller\Adminhtml\Feedback;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magento\Ui\Component\MassAction\Filter;
use Devall\CustomerFeedback\Model\ResourceModel\Feedback\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;

class MassDelete extends Action
{
    /**
     * Filter component
     *
     * @var Filter
     */
    protected $filter;

    /**
     * Feedback collection factory
     *
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * MassDelete constructor.
     *
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Execute the mass delete action.
     *
     * Deletes multiple feedback entries based on selection.
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $count = 0;

        foreach ($collection as $item) {
            $item->delete();
            $count++;
        }

        $this->messageManager->addSuccessMessage(__('You deleted %1 Feedback(s).', $count));

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/');
    }
}
