<?php
declare(strict_types=1);

/**
 * Feedback Search Results Interface
 *
 * @author Developers-Alliance team
 * @Copyright (c) 2024 Developers-alliance (https:// www. developers-alliance. com)
 * @website https://developers-alliance.com
 * @package Devall_CustomerFeedback
 * @version 1.0.0
 *
 * This interface defines the search results data structure for customer feedback.
 */
namespace Devall\CustomerFeedback\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface FeedbackSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get an array of Feedback items.
     *
     * @return \Devall\CustomerFeedback\Api\Data\FeedbackInterface[]
     */
    public function getItems(): array;

    /**
     * Set the array of Feedback items.
     *
     * @param \Devall\CustomerFeedback\Api\Data\FeedbackInterface[] $items
     * @return void
     */
    public function setItems(array $items): void;
}
