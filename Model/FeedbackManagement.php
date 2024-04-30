<?php
declare(strict_types=1);

/**
 * Feedback Management Model
 *
 * @author Developers-Alliance team
 * @Copyright (c) 2024 Developers-alliance (https:// www. developers-alliance. com)
 * @website https://developers-alliance.com
 * @package Devall_CustomerFeedback
 * @version 1.0.0
 *
 * Manages the handling and processing of customer feedback. This includes validation,
 * saving feedback to the repository, and notifying administrative users upon submission.
 * Requires user to be logged in for feedback submission.
 *
 */

namespace Devall\CustomerFeedback\Model;

use Devall\CustomerFeedback\Api\FeedbackManagementInterface;
use Devall\CustomerFeedback\Api\Data\FeedbackInterface;
use Devall\CustomerFeedback\Api\FeedbackRepositoryInterface;
use Devall\CustomerFeedback\Model\FeedbackNotifier;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Escaper;
use Magento\Customer\Model\Session as CustomerSession;

class FeedbackManagement implements FeedbackManagementInterface
{
    /**
     * @var FeedbackRepositoryInterface
     */
    protected $feedbackRepository;

    /**
     * @var CustomerSession
     */
    protected $customerSession;

    /**
     * @var Escaper
     */
    protected $escaper;

    /**
     * @var FeedbackNotifier
     */
    protected $feedbackNotifier;

    /**
     * Constructor
     *
     * @param FeedbackRepositoryInterface $feedbackRepository
     * @param CustomerSession $customerSession
     * @param Escaper $escaper
     * @param FeedbackNotifier $feedbackNotifier
     */
    public function __construct(
        FeedbackRepositoryInterface $feedbackRepository,
        CustomerSession $customerSession,
        Escaper $escaper,
        FeedbackNotifier $feedbackNotifier
    ) {
        $this->feedbackRepository = $feedbackRepository;
        $this->customerSession = $customerSession;
        $this->escaper = $escaper;
        $this->feedbackNotifier = $feedbackNotifier;
    }

    /**
     * Submits a feedback
     *
     * Validates and submits customer feedback. If user is not logged in, an exception is thrown.
     * Escapes HTML entities in title and content to prevent XSS attacks. Processes feedback
     * for anonymity based on user choice. Notifies the appropriate parties upon successful submission.
     *
     * @param FeedbackInterface $feedback The feedback entity containing all necessary information.
     * @return string JSON encoded success or failure message.
     */
    public function submitFeedback(FeedbackInterface $feedback)
    {
        try {
            if (!$this->customerSession->isLoggedIn()) {
                throw new CouldNotSaveException(__('You need to be logged in to submit feedback.'));
            }

            $title = $this->escaper->escapeHtml($feedback->getTitle());
            $feedbackContent = $this->escaper->escapeHtml($feedback->getFeedback());
            $productId = filter_var($feedback->getProductId(), FILTER_VALIDATE_INT);
            $submitAnonymously = filter_var($feedback->getAnonymous(), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

            $feedback->setTitle($title);
            $feedback->setFeedback($feedbackContent);
            $feedback->setProductId($productId);
            $feedback->setAnonymous($submitAnonymously);

            if (!$submitAnonymously && $this->customerSession->isLoggedIn()) {
                $customer = $this->customerSession->getCustomer();
                $feedback->setFirstname($customer->getFirstname());
                $feedback->setLastname($customer->getLastname());
                $feedback->setEmail($customer->getEmail());
            } else {
                $feedback->setFirstname(null);
                $feedback->setLastname(null);
                $feedback->setEmail(null);
            }

            $this->feedbackRepository->save($feedback);
            $this->feedbackNotifier->notify($feedback);
            return json_encode(['success' => true, 'message' => 'Feedback submitted successfully']);
        } catch (LocalizedException $e) {
            return json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}


