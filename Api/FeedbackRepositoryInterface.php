<?php
declare(strict_types=1);

/**
 * Feedback Repository Interface
 *
 * @author Developers-Alliance team
 * @Copyright (c) 2024 Developers-alliance (https:// www. developers-alliance. com)
 * @website https://developers-alliance.com
 * @package Devall_CustomerFeedback
 * @version 1.0.0
 *
 * This interface defines the repository for managing customer feedback entities.
 */
namespace Devall\CustomerFeedback\Api;

use Devall\CustomerFeedback\Api\Data\FeedbackInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Devall\CustomerFeedback\Api\Data\FeedbackSearchResultsInterface;

interface FeedbackRepositoryInterface
{
    /**
     * Save Feedback data.
     *
     * @param \Devall\CustomerFeedback\Api\Data\FeedbackInterface $feedback
     * @return \Devall\CustomerFeedback\Api\Data\FeedbackInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(FeedbackInterface $feedback): FeedbackInterface;

    /**
     * Retrieve Feedback data by ID.
     *
     * @param int $feedbackId
     * @return \Devall\CustomerFeedback\Api\Data\FeedbackInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $feedbackId): FeedbackInterface;

    /**
     * Retrieve Feedbacks matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Devall\CustomerFeedback\Api\Data\FeedbackSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): FeedbackSearchResultsInterface;

    /**
     * Delete Feedback data.
     *
     * @param \Devall\CustomerFeedback\Api\Data\FeedbackInterface $feedback
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(FeedbackInterface $feedback): bool;

    /**
     * Delete Feedback data by ID.
     *
     * @param int $feedbackId
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById(int $feedbackId): bool;
}
