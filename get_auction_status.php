<?php
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/models/db.php";
require_once __DIR__ . "/models/Auction.php";

$id = $_GET['id'] ?? 0;
$auctionModel = new Auction();
$data = $auctionModel->getAuctionDetail($id);

$remaining = strtotime($data['end_time']) - time();

echo json_encode([
    'is_paused' => $data['is_paused'],
    'remaining_seconds' => max(0, $remaining)
]);
