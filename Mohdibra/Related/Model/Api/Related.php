<?php 
namespace Mohdibra\Related\Model\Api;
use Psr\Log\LoggerInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;

class Related {

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepositoryInterface;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        ProductRepositoryInterface $productRepositoryInterface,
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
        $this->productRepositoryInterface = $productRepositoryInterface;
    }

	/**
	 * {@inheritdoc}
	 */
	public function getRelated($sku)
	{
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		
        $relatedProduct = [];
        try {
            $product = $this->productRepositoryInterface->get($sku);
            $related = $product->getRelatedProducts();

            if (count($related)) {
                foreach ($related as $item) {
                    $relatedProduct[] = $objectManager->create('Magento\Catalog\Model\Product')->load($item->getId())->getData();
                }
            }
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
        }

        return [
            [
                'count' => count($relatedProduct),
                "data" => $relatedProduct
            ]
        ]; 

        
	}
}