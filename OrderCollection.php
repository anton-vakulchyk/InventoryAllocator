<?php

class OrderCollection
{
    private $_orders = array();
    private $_emptyInventory = null;


    public function __construct(array $emptyInventory)
    {
        $this->_emptyInventory = $emptyInventory;
    }

    public function orderExists($orderId)
    {
        return array_key_exists($orderId, $this->_orders);
    }

    private function _getOrderPrototype()
    {
        return array(
            'quoted' => $this->_emptyInventory,
            'allocated' => $this->_emptyInventory,
            'back_ordered' => $this->_emptyInventory
        );
    }

    public function getCollection()
    {
        return $this->_orders;
    }

    public function __toString()
    {
        $result = '';
        foreach ($this->getCollection() as $orderId => $lines) {
            $result .= $orderId . ': ';
            $typeList = array();
            foreach ($lines as $type => $products) {
                $qtyList = array();
                foreach ($products as $product => $qty) {
                    $qtyList[] = $qty;
                }
                $typeList[] = implode(',', $qtyList);
            }
            $result .= implode('::', $typeList) . "\n";
        }

        return $result;
    }

    public function push($orderId, $productId, $quoted, $allocated, $backOrdered)
    {
        if (!$this->orderExists($orderId)) {
            $this->_orders[$orderId] = $this->_getOrderPrototype();
        }
        $this->_orders[$orderId]['quoted'][$productId] = $quoted;
        $this->_orders[$orderId]['allocated'][$productId] = $allocated;
        $this->_orders[$orderId]['back_ordered'][$productId] = $backOrdered;
    }
}
