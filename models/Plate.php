<?php
class Plate extends Db {
    public function get() {
        // 1. Lấy danh sách Ô tô
        $sqlCar = "SELECT * FROM plates WHERE vehicle_type = 'Car' ORDER BY current_price DESC";
        $resCar = self::$connection->query($sqlCar);
        $cars = $resCar->fetch_all(MYSQLI_ASSOC);

        // 2. Lấy danh sách Xe máy
        $sqlMoto = "SELECT * FROM plates WHERE vehicle_type = 'Motorbike' ORDER BY current_price DESC";
        $resMoto = self::$connection->query($sqlMoto);
        $motorbikes = $resMoto->fetch_all(MYSQLI_ASSOC);

        // Trả về kết quả gộp
        return [
            'cars' => $cars,
            'motorbikes' => $motorbikes
        ];
    }
}