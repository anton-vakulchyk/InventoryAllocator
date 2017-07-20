<?php

class Inventory
{
    private $_inventory = array(
        'A' => 150,
        'B' => 150,
        'C' => 100,
        'D' => 100,
        'E' => 200
    );

    public function __construct(array $inventory)
    {
        $this->_inventory = $inventory;
    }

    public function getEmptyInventory()
    {
        return array_fill_keys(array_keys($this->_inventory), 0);
    }

    public function isInventoryEmpty()
    {
        if (!array_filter(array_values($this->_inventory))) {
            return true;
        }
        return false;
    }

    public function isProductValid($productId)
    {
        return array_key_exists($productId, $this->_inventory);
    }

    public function allocate($productId, $productCount)
    {
        $resultCount = $this->_inventory[$productId] - $productCount;
        $allocated = 0;
        $backOrdered = 0;
        if ($resultCount <= 0) {
            $allocated = $this->_inventory[$productId];
            $backOrdered = abs($resultCount);
        }
        $this->_inventory[$productId] = $resultCount > 0 ? $resultCount : 0;

        return array('allocated' => $allocated, 'back_ordered' => $backOrdered);
    }
}
