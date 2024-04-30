<?php

/**
 * Delete Feedback Controller for adminhtml
 *
 * @author Developers-Alliance team
 * @Copyright (c) 2024 Developers-alliance (https:// www. developers-alliance. com)
 * @package Devall_CustomerFeedback
 * @version 1.0.0
 *
 * This class handles the action for deleting a Feedback entry from the admin panel.
 */

namespace Devall\CustomerFeedback\Controller\adminhtml\Feedback;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Devall\CustomerFeedback\Api\FeedbackRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;

class Delete extends Action
{
    /**
     * Feedback repository
     *
     * @var FeedbackRepositoryInterface
     */
    protected $feedbackRepository;

    /**
     * Delete constructor.
     *
     * @param Action\Context $context
     * @param FeedbackRepositoryInterface $feedbackRepository
     */
    public function __construct(
        Action\Context $context,
        FeedbackRepositoryInterface $feedbackRepository
    ) {
        parent::__construct($context);
        $this->feedbackRepository = $feedbackRepository;
    }

    /**
     * Execute the delete action.
     *
     * Deletes a feedback entry if an ID is provided.
     *
     * @return Redirect
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id) {
            try {
                $this->feedbackRepository->deleteById((int) $id);
                $this->messageManager->addSuccessMessage(__('Feedback entry has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        } else {
            $this->messageManager->addErrorMessage(__('We can\'t find a feedback entry to delete.'));
        }

        return $resultRedirect->setPath('*/*/');
    }
}
