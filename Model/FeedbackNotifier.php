<?php

/**
 * Feedback Notifier Model
 *
 * @author Developers-Alliance team
 * @Copyright (c) 2024 Developers-alliance (https:// www. developers-alliance. com)
 * @website https://developers-alliance.com
 * @package Devall_CustomerFeedback
 * @version 1.0.0
 *
 * Handles sending notification emails upon customer feedback submission.
 * This class checks system configuration settings to determine if email notifications
 * are enabled and then crafts and sends the notification email using Magento's
 * email transport builder.
 *
 */
namespace Devall\CustomerFeedback\Model;

use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Model\Session as CustomerSession;

class FeedbackNotifier
{
    /**
     * @var TransportBuilder
     */
    protected $_transportBuilder;

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var CustomerSession
     */
    protected $customerSession;

    /**
     * Constructor
     *
     * @param TransportBuilder $transportBuilder
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param CustomerSession $customerSession
     */
    public function __construct(
        TransportBuilder $transportBuilder,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        CustomerSession $customerSession
    ) {
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_storeManager = $storeManager;
        $this->customerSession = $customerSession;
    }

    /**
     * Sends a notification email about the received feedback.
     *
     * Constructs and sends an email to the configured recipient with details about
     * the feedback. This includes whether the feedback was submitted anonymously,
     * the feedback content, and, if available, customer details.
     *
     * @param mixed $feedback The feedback entity containing all necessary information.
     */
    public function notify($feedback) {

        $isEmailEnabled = $this->_scopeConfig->isSetFlag(
            'devall_feedback/settings/enabled_email',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );


        if (!$isEmailEnabled) {
            return;
        }

        $recipientEmail = $this->_scopeConfig->getValue(
            'devall_feedback/settings/recipient_email',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        if ($recipientEmail) {

            $templateOptions = [
                'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                'store' => $this->_storeManager->getStore()->getId(),
            ];


            $isAnonymous = $feedback->getAnonymous() || !$this->customerSession->isLoggedIn();

            $templateVars = [
                'feedbackTitle' => $feedback->getTitle(),
                'feedbackContent' => $feedback->getFeedback(),
                'isAnonymous' => $isAnonymous ? "Yes" : "No",
                'ProductId' => $feedback->getProductId(),
            ];

            if (!$isAnonymous) {
                $customerData = $this->customerSession->getCustomerData();
                $templateVars += [
                    'customerFirstname' => $customerData->getFirstname(),
                    'customerLastname' => $customerData->getLastname(),
                    'customerEmail' => $customerData->getEmail(),
                ];
            } else {
                $templateVars += [
                    'customerFirstname' => 'Anonymous',
                    'customerLastname' => '',
                    'customerEmail' => 'Anonymous',
                ];
            }

            $transport = $this->_transportBuilder
                ->setTemplateIdentifier('feedback_notification_template')
                ->setTemplateOptions($templateOptions)
                ->setTemplateVars($templateVars)
                ->setFromByScope(['email' => 'noreply@example.com', 'name' => 'Store Name'], $this->_storeManager->getStore()->getId())
                ->addTo($recipientEmail, 'Admin')
                ->getTransport();

            $transport->sendMessage();
        }
    }
}
