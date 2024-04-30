<?php declare(strict_types=1);

/**
 * Actions Column for Customer Feedback UI Listing
 *
 * @author Developers-Alliance team
 * @Copyright (c) 2024 Developers-alliance (https:// www. developers-alliance. com)
 * @website https://developers-alliance.com
 * @package Devall_CustomerFeedback
 * @version 1.0.0
 *
 * This class is responsible for creating actions in the Customer Feedback listing.
 */

namespace Devall\CustomerFeedback\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Actions extends Column
{
    /**
     * @var UrlInterface URL Builder Interface
     */
    private $urlBuilder;

    /**
     * Constructor to initialize object variables.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare data source for UI listing
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if(!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as & $item) {
            if(!isset($item['id'])) {
                continue;
            }

            $item[$this->getData('name')] = [
                'delete' => [
                    'href' => $this->urlBuilder->getUrl('customerfeedback/feedback/delete', [
                        'id' => $item['id']
                    ]),
                    'label' => __('Delete'),
                    'confirm' => [
                        'title' => __('Delete %1', $item['title']),
                        'message' => __('Are you sure you want to delete a record with ID %1?', $item['id'])
                    ]
                ]
            ];
        }

        return $dataSource;
    }
}
