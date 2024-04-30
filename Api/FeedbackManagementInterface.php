<?php
declare(strict_types=1);

/**
 * Feedback Management Interface
 *
 * This interface is responsible for managing feedback submissions via API.
 * It defines the method required to submit customer feedback.
 *
 * @author Developers-Alliance team
 * @Copyright (c) 2024 Developers-alliance (https:// www. developers-alliance. com)
 * @website https://developers-alliance.com
 * @package Devall_CustomerFeedback
 * @version 1.0.0
 */
namespace Devall\CustomerFeedback\Api;

interface FeedbackManagementInterface
{
    /**
     * Submit feedback.
     *
     * This method accepts a feedback object which encapsulates all relevant feedback details.
     * It processes the feedback and typically returns a confirmation or result status.
     *
     * @param \Devall\CustomerFeedback\Api\Data\FeedbackInterface $feedback  Feedback object containing the details to be submitted.
     * @return string  Returns a string indicating the result of the feedback submission process.
     */
    public function submitFeedback(\Devall\CustomerFeedback\Api\Data\FeedbackInterface $feedback);
}
