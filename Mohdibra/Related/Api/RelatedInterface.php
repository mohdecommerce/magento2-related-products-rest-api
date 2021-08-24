<?php 
namespace Mohdibra\Related\Api;
 
 
interface RelatedInterface {

    /**
     * Provide the list of links for a specific product
     *
     * @param string $sku
     * @return array
     */
    public function getRelated($sku);
}