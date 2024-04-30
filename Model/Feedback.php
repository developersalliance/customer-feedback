<?php
declare(strict_types=1);

/**
 * Feedback Model
 *
 * @author Developers-Alliance team
 * @Copyright (c) 2024 Developers-alliance (https:// www. developers-alliance. com)
 * @website https://developers-alliance.com
 * @package Devall_CustomerFeedback
 * @version 1.0.0
 *
 * This class is the model for handling customer feedback.
 */
namespace Devall\CustomerFeedback\Model;

use Magento\Framework\Model\AbstractModel;
use Devall\CustomerFeedback\Api\Data\FeedbackInterface;

class Feedback extends AbstractModel implements FeedbackInterface
{
    /**
     * Initialize Feedback model
     */
    protected function _construct()
    {
        $this->_init(\Devall\CustomerFeedback\Model\ResourceModel\Feedback::class);
    }

    /**
     * Get the ID of the feedback.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return ($this->hasData('id')) ? (int) $this->getData('id') : null;
    }

    /**
     * Get the product ID related to the feedback.
     *
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return ($this->hasData('product_id')) ? (int) $this->getData('product_id') : null;
    }

    /**
     * Set the product ID related to the feedback.
     *
     * @param int $productId
     * @return FeedbackInterface
     */
    public function setProductId(int $productId): FeedbackInterface
    {
        return $this->setData('product_id', $productId);
    }

    /**
     * Get the title of the feedback.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return (string) $this->getData('title');
    }

    /**
     * Set the title of the feedback.
     *
     * @param string $title
     * @return FeedbackInterface
     */
    public function setTitle(string $title): FeedbackInterface
    {
        return $this->setData('title', $title);
    }

    /**
     * Get the content of the feedback.
     *
     * @return string
     */
    public function getFeedback(): string
    {
        return (string) $this->getData('feedback');
    }

    /**
     * Set the content of the feedback.
     *
     * @param string $feedback
     * @return FeedbackInterface
     */
    public function setFeedback(string $feedback): FeedbackInterface
    {
        return $this->setData('feedback', $feedback);
    }

    /**
     * Get the date when the feedback was created.
     *
     * @return \DateTime|null
     */
    public function getDateCreated(): ?\DateTime
    {
        $dateStr = $this->getData('date_created');
        return ($dateStr) ? new \DateTime($dateStr) : null;
    }

    /**
     * Set the date when the feedback was created.
     *
     * @param \DateTime $dateCreated
     * @return FeedbackInterface
     */
    public function setDateCreated(\DateTime $dateCreated): FeedbackInterface
    {
        return $this->setData('date_created', $dateCreated->format('Y-m-d H:i:s'));
    }

    /**
     * Check if the feedback is anonymous.
     *
     * @return bool
     */
    public function getAnonymous(): bool
    {
        return (bool) $this->getData('anonymous');
    }

    /**
     * Set if the feedback should be anonymous or not.
     *
     * @param bool $anonymous
     * @return FeedbackInterface
     */
    public function setAnonymous(bool $anonymous): FeedbackInterface
    {
        return $this->setData('anonymous', $anonymous);
    }
}
