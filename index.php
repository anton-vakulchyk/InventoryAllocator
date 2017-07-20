<?php

require 'Inventory.php';
require 'OrderCollection.php';

$inventory = new Inventory(array(
    'A' => 10,
    'B' => 9,
    'C' => 8,
    'D' => 7,
    'E' => 6,
));

$orderStream = array(
    git add README.md'1' => array('A' => 10, 'B' => 10, 'C' => 10, 'D' => 10, 'E' => 10),
    '2' => array('A' => 1, 'B' => 7),
    '3' => array('A' => 1, 'B' => 7),
);

$orderCollection = new OrderCollection($inventory->getEmptyInventory());

foreach ($orderStream as $orderId => $lines) {
    if (empty($lines) || !array_filter(array_values($lines)) || $orderCollection->orderExists($orderId)) {
        continue;
    }
    if ($inventory->isInventoryEmpty()) {
        break;
    }
    foreach ($lines as $productId => $productQty) {
        if (!$inventory->isProductValid($productId)) {
            continue;
        }
        $allocatedOrder = $inventory->allocate($productId, $productQty);
        $orderCollection->push(
            $orderId, $productId, $productQty, $allocatedOrder['allocated'], $allocatedOrder['back_ordered']
        );
    }
}

echo $orderCollection;
