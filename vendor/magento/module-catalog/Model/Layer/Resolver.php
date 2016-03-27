<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Catalog\Model\Layer;

class Resolver
{
    const CATALOG_LAYER_CATEGORY = 'category';
    const CATALOG_LAYER_SEARCH = 'search';

    /**
     * Catalog view layer models list
     *
     * @var array
     */
    protected $layersPool;

    /**
     * Filter factory
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var \Magento\Catalog\Model\Layer
     */
    protected $layer = null;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param array $layersPool
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        array $layersPool
    ) {
        $this->objectManager = $objectManager;
        $this->layersPool = $layersPool;
    }

    /**
     * Create Catalog Layer by specified type
     *
     * @param string $layerType
     * @return void
     */
    public function create($layerType)
    {
        if (isset($this->layer)) {
            throw new \RuntimeException('Catalog Layer has been already created');
        }
        if (!isset($this->layersPool[$layerType])) {
            throw new \InvalidArgumentException($layerType . ' does not belong to any registered layer');
        }
        $this->layer = $this->objectManager->create($this->layersPool[$layerType]);
    }

    /**
     * Get current Catalog Layer
     *
     * @return \Magento\Catalog\Model\Layer
     */
    public function get()
    {
        if (!isset($this->layer)) {
            $this->layer = $this->objectManager->create($this->layersPool[self::CATALOG_LAYER_CATEGORY]);
        }
        return $this->layer;
    }
}
