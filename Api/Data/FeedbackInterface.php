<?php
declare(strict_types=1);

/**
 * Feedback Interface
 *
 * @author Developers-Alliance team
 * @Copyright (c) 2024 Developers-alliance (https:// www. developers-alliance. com)
 * @website https://developers-alliance.com
 * @package Devall_CustomerFeedback
 * @version 1.0.0
 *
 * This interface defines the data structure for customer feedback.
 */
namespace Devall\CustomerFeedback\Api\Data;

interface FeedbackInterface
{
    /**
     * Get the ID of the feedback entry.
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Get the Product ID associated with the feedback.
     *
     * @return int|null
     */
    public function getProductId(): ?int;

    /**
     * Set the Product ID.
     *
     * @param int $productId
     * @return FeedbackInterface
     */
    public function setProductId(int $productId): FeedbackInterface;

    /**
     * Get the title of the feedback.
     *
     * @return string
     */
    public function getTitle(): string;

    /**
     * Set the title of the feedback.
     *
     * @param string $title
     * @return FeedbackInterface
     */
    public function setTitle(string $title): FeedbackInterface;

    /**
     * Get the feedback content.
     *
     * @return string
     */
    public function getFeedback(): string;

    /**
     * Set the feedback content.
     *
     * @param string $feedback
     * @return FeedbackInterface
     */
    public function setFeedback(string $feedback): FeedbackInterface;

    /**
     * Get the date the feedback was created.
     *
     * @return \DateTime|null
     */
    public function getDateCreated(): ?\DateTime;

    /**
     * Set the date the feedback was created.
     *
     * @param \DateTime $dateCreated
     * @return FeedbackInterface
     */
    public function setDateCreated(\DateTime $dateCreated): FeedbackInterface;

    /**
     * Check if the feedback is anonymous.
     *
     * @return bool
     */
    public function getAnonymous(): bool;

    /**
     * Set whether the feedback is anonymous or not.
     *
     * @param bool $anonymous
     * @return FeedbackInterface
     */
    public function setAnonymous(bool $anonymous): FeedbackInterface;
}
