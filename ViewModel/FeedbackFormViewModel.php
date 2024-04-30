<?php

namespace Devall\CustomerFeedback\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * ViewModel for the Feedback Form.
 *
 * Provides necessary methods to interact with the feedback form elements such as retrieving form keys
 * and checking if the feedback functionality is enabled in the store configuration.
 */
class FeedbackFormViewModel implements ArgumentInterface
{
    /**
     * @var ScopeConfigInterface Interface for configuration access, used here to check module settings
     */
    private $scopeConfig;

    /**
     * Constructor for FeedbackFormViewModel.
     *
     * Initializes the registry, form key generator, and scope configuration interface to be used
     * in other methods.
     * @param ScopeConfigInterface $scopeConfig Config access for checking module settings
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Determines whether the feedback functionality is enabled in the store configuration.
     *
     * This method checks the configuration under the specified path to see if the feedback module
     * is enabled for the store view.
     *
     * @return bool True if feedback is enabled, otherwise false
     */
    public function isFeedbackEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(
            'devall_feedback/settings/enabled',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
