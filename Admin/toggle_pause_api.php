<?php
require_once dirname(__DIR__) . "/config.php";
require_once dirname(__DIR__) . "/models/db.php";
require_once dirname(__DIR__) . "/models/Auction.php";

header('Content-Type: application/json');

$auctionId = $_POST['auction_id'] ?? 0;

if ($auctionId > 0) {
    $auctionModel = new Auction();
    if ($auctionModel->togglePause($auctionId)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
