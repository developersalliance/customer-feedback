<?php
declare(strict_types=1);

/**
 * Class FeedbackRepository
 * Repository for Feedback data
 *
 * @author Developers-Alliance team
 * @Copyright (c) 2024 Developers-alliance (https:// www. developers-alliance. com)
 * @website https://developers-alliance.com
 * @package Devall_CustomerFeedback
 * @version 1.0.0
 */

namespace Devall\CustomerFeedback\Model;

use Devall\CustomerFeedback\Api\Data\FeedbackInterface;
use Devall\CustomerFeedback\Api\Data\FeedbackSearchResultsInterface;
use Devall\CustomerFeedback\Api\FeedbackRepositoryInterface;
use Devall\CustomerFeedback\Model\ResourceModel\Feedback\CollectionFactory as FeedbackCollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;


class FeedbackRepository implements FeedbackRepositoryInterface
{
    /**
     * @var FeedbackFactory
     */
    private $feedbackFactory;

    /**
     * @var FeedbackCollectionFactory
     */
    private $feedbackCollectionFactory;

    /**
     * @var SearchResultsFactory
     */
    private $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;


    /**
     * FeedbackRepository constructor.
     * @param FeedbackFactory $feedbackFactory
     * @param FeedbackCollectionFactory $feedbackCollectionFactory
     * @param SearchResultsFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        FeedbackFactory $feedbackFactory,
        FeedbackCollectionFactory $feedbackCollectionFactory,
        SearchResultsFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->feedbackFactory = $feedbackFactory;
        $this->feedbackCollectionFactory = $feedbackCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Save Feedback data
     * @param FeedbackInterface $feedback
     * @return FeedbackInterface
     * @throws CouldNotSaveException
     */
    public function save(FeedbackInterface $feedback): FeedbackInterface
    {
        try {
            $feedback->save();
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $feedback;
    }

    /**
     * Get Feedback by ID
     * @param int $feedbackId
     * @return FeedbackInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $feedbackId): FeedbackInterface
    {
        $feedback = $this->feedbackFactory->create();
        $feedback->load($feedbackId);
        if (!$feedback->getId()) {
            throw new NoSuchEntityException(__('Feedback with id "%1" does not exist.', $feedbackId));
        }
        return $feedback;
    }

    /**
     * Get Feedback list based on search criteria
     * @param SearchCriteriaInterface $searchCriteria
     * @return FeedbackSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): FeedbackSearchResultsInterface
    {
        $collection = $this->feedbackCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * Delete Feedback
     * @param FeedbackInterface $feedback
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(FeedbackInterface $feedback): bool
    {
        try {
            $feedback->delete();
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete Feedback by ID
     * @param int $feedbackId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $feedbackId): bool
    {
        return $this->delete($this->getById($feedbackId));
    }
}
