    <!DOCTYPE html>
    <html lang="en">
    <?php
    session_start();

    // Mảng các ID được phép vào vùng Admin
    $admin_roles = [1, 2, 3, 4, 5];

    if (!isset($_SESSION['role_id']) || !in_array($_SESSION['role_id'], $admin_roles)) {
        // Nếu không có quyền, đuổi về trang login hoặc báo lỗi
        header("Location: login.php?error=access_denied");
        exit();
    }
    // Sử dụng đường dẫn tương đối để tránh lỗi trên Linux Server của InfinityFree
    require_once dirname(__DIR__) . "/config.php";

    // 2. Nạp db.php (Cùng nằm trong thư mục Models với file này)
    require_once dirname(__DIR__) . "/models/db.php";
    require_once dirname(__DIR__) . "/models/Auction.php";
    require_once dirname(__DIR__) . "/models/Plate.php";
    $plateModel = new Plate();

    // Ở đầu file VaultManager.php, đoạn xử lý POST
    if (isset($_POST['save_plate'])) {
        $id = !empty($_POST['plate_id']) ? intval($_POST['plate_id']) : 0;

        $data = [
            'plate_number'   => trim($_POST['plate_number']),
            'starting_price' => $_POST['starting_price'],
            'current_price'  => $_POST['starting_price'],
            'category'       => $_POST['category'],
            'vehicle_type'   => $_POST['vehicle_type'],
            'address'        => $_POST['address'],
            'status'         => 'Available'
        ];

        try {
            if ($id > 0) {
                $plateModel->update($id, $data);
                $msg = "updated";
            } else {
                // Kiểm tra xem biển số đã tồn tại chưa trước khi thêm (Cách an toàn nhất)
                $plateModel->create($data);
                $msg = "success";
            }
            header("Location: VaultManager.php?status=$msg");
            exit();
        } catch (Exception $e) {
            // Kiểm tra nếu lỗi là trùng khóa (Duplicate entry)
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                header("Location: VaultManager.php?error=duplicate&plate=" . $data['plate_number']);
            } else {
                header("Location: VaultManager.php?error=system");
            }
            exit();
        }
    }
    ?>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>he Vault Inventory Interface</title>
        <script src="https://cdn.tailwindcss.com"></script>

        <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/Draggable.min.js"></script>

        <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Inter:wght@400;700&display=swap" rel="stylesheet">

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <style>
            :root {
                --obsidian: #050505;
                --sapphire-glow: rgba(30, 64, 175, 0.4);
                --neon-cyan: #00f2ff;
                --electric-red: #ff003c;
                --dark-sapphire: #001220;
                --emerald-verify: #10b981;
                --amber-pending: #f59e0b;
                --crimson-error: #ef4444;
            }

            body {
                background-color: #000814;
                color: white;
                font-family: 'Inter', sans-serif;
                overflow-x: hidden;
                user-select: none;
            }

            /* ----------------------------- section 1 -----------------------------  */

            .space-mono {
                font-family: 'Space Mono', monospace;
            }

            /* Hiệu ứng Sapphire Blur mặc định */
            .glass-vault {
                background: linear-gradient(135deg, rgba(5, 5, 5, 0.9) 0%, rgba(10, 25, 47, 0.8) 100%);
                border: 1px solid var(--sapphire-glow);
                transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                overflow: hidden;
            }

            /* Laser Scan Effect */
            .laser-scan {
                position: absolute;
                top: -100%;
                left: 0;
                width: 100%;
                height: 4px;
                background: linear-gradient(90deg, transparent, var(--neon-cyan), transparent);
                box-shadow: 0 0 15px var(--neon-cyan);
                z-index: 20;
                opacity: 0;
            }

            .glass-vault:hover .laser-scan {
                animation: scan 2s infinite;
                opacity: 1;
            }

            @keyframes scan {
                0% {
                    top: -10%;
                }

                100% {
                    top: 110%;
                }
            }

            /* Status Breathing */
            .breathe-cyan {
                animation: breathe 2s infinite ease-in-out;
                box-shadow: 0 0 5px var(--neon-cyan);
            }

            @keyframes breathe {

                0%,
                100% {
                    opacity: 1;
                    transform: scale(1);
                }

                50% {
                    opacity: 0.6;
                    transform: scale(0.95);
                }
            }

            /* Perspective 3D */
            .vault-card-container {
                perspective: 1000px;
            }

            /* Responsive Grid Customization */
            .inventory-grid {
                display: grid;
                gap: 1.5rem;
                grid-template-columns: repeat(1, minmax(0, 1fr));
                /* Mobile */
            }

            @media (min-width: 768px) {
                .inventory-grid {
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                }

                .tops {
                    margin-top: 50px !important;
                }

            }

            /* Tablet */
            @media (min-width: 1440px) {
                .inventory-grid {
                    grid-template-columns: repeat(5, minmax(0, 1fr));
                }

            }

            @media (min-width: 1028px) {}

            /* Desktop Ultra-Wide */

            /* Floating Button Mobile */
            .fab-scan {
                position: fixed;
                bottom: 2rem;
                right: 2rem;
                width: 60px;
                height: 60px;
                background: var(--neon-cyan);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: black;
                font-size: 1.5rem;
                box-shadow: 0 0 20px rgba(0, 242, 255, 0.5);
                z-index: 100;
            }

            /* ----------------------------- section 2 -----------------------------  */
            /* --- CSS Bổ sung cho Section 2 --- */
            /* Sidebar Glassmorphism */
            .sidebar-glass {
                background: rgba(0, 26, 51, 0.5);
                backdrop-filter: blur(20px);
                border-right: 1px solid rgba(255, 255, 255, 0.05);
            }

            #document-vault {
                position: relative;
                z-index: 10;
                /* Đảm bảo nội dung không bị Sidebar đè */
                margin-left: 0;
                transition: margin-left 0.3s ease;
            }

            .sapphire-satin {
                background: radial-gradient(circle at top left, #001a33, #000814);
                box-shadow: inset 0 0 100px rgba(0, 0, 0, 0.5);
            }

            .mono {
                font-family: 'JetBrains Mono', monospace;
            }

            .doc-stack {
                perspective: 1500px;
                height: 400px;
            }

            .doc-item {
                position: absolute;
                width: 100%;
                transition: transform 0.6s cubic-bezier(0.23, 1, 0.32, 1), opacity 0.6s;
                transform-style: preserve-3d;
                cursor: pointer;
            }

            .zoom-container {
                position: relative;
                cursor: none;
                overflow: hidden;
                border-radius: 1rem;
            }

            .magnifier {
                position: absolute;
                width: 160px;
                height: 160px;
                border-radius: 50%;
                pointer-events: none;
                display: none;
                z-index: 100;
                background-repeat: no-repeat;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.5), inset 0 0 15px rgba(0, 242, 255, 0.2);
            }

            .doc-item {
                transition: transform 0.6s cubic-bezier(0.23, 1, 0.32, 1), opacity 0.6s;
                transform-style: preserve-3d;
                cursor: pointer;
            }

            .bc-verify-active {
                animation: bc-glow 1.5s infinite;
                border-color: #10b981 !important;
            }

            /* Custom Scrollbar */
            ::-webkit-scrollbar {
                width: 4px;
            }

            ::-webkit-scrollbar-track {
                background: transparent;
            }

            ::-webkit-scrollbar-thumb {
                background: var(--sapphire);
                border-radius: 10px;
            }

            @keyframes bc-glow {

                0%,
                100% {
                    box-shadow: 0 0 5px rgba(16, 185, 129, 0.2);
                }

                50% {
                    box-shadow: 0 0 20px rgba(16, 185, 129, 0.5);
                }
            }

            /* Tab Transition for Tablet */
            .tab-content {
                display: none;
            }

            .tab-content.active {
                display: block;
            }

            .watermark-layer {
                position: absolute;
                inset: 0;
                pointer-events: none;
                background-image: url("data:image/svg+xml,%3Csvg width='200' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Ctext x='50%25' y='50%25' font-size='10' fill='rgba(255,255,255,0.03)' text-anchor='middle' transform='rotate(-30, 100, 100)'%3EADMIN_CONFIDENTIAL%3C/text%3E%3C/svg%3E");
                z-index: 10;
            }

            /* Responsive: Trên Desktop đẩy lùi vào để nhường chỗ cho Sidebar */
            @media (min-width: 768px) {
                #document-vault {
                    margin-left: 17%;
                    /* Độ rộng mặc định của sidebar thu gọn */
                    /* width: 120% !important; */
                }
            }

            @media (max-width: 1024px) {
                #document-vault {
                    /* margin-left: 17%; */
                    /* Độ rộng mặc định của sidebar thu gọn */
                    width: 100% !important;
                }
            }

            /* ----------------------------- section 3 -----------------------------  */
            /* Section 3 Custom Styles */
            #logistics-vault::-webkit-scrollbar {
                display: none;
            }

            .timeline-step-active::before {
                content: '';
                position: absolute;
                left: -10px;
                top: 0;
                width: 50px;
                height: 50px;
                background: var(--neon-cyan);
                opacity: 0.1;
                filter: blur(20px);
                border-radius: 50%;
            }

            @media (max-width: 768px) {
                .xl\:flex-row {
                    flex-direction: column !important;
                }

                #logistics-vault {
                    margin-left: 17% !important;
                    width: 100%;
                }
            }

            @media (max-width: 1024px) {
                #logistics-vault {
                    margin-left: 0% !important;
                    /* Độ rộng mặc định của sidebar thu gọn */
                    width: 100% !important;

                }
            }

            /* ----------------------------- section 4 -----------------------------  */
            /* Animation for Emergency Pulse */
            .emergency-alert {
                border-color: #fb923c !important;
                background: rgba(251, 146, 60, 0.05) !important;
                animation: pulse-orange 1.5s infinite;
            }

            @keyframes pulse-orange {
                0% {
                    box-shadow: 0 0 0 0 rgba(251, 146, 60, 0.4);
                }

                70% {
                    box-shadow: 0 0 0 20px rgba(251, 146, 60, 0);
                }

                100% {
                    box-shadow: 0 0 0 0 rgba(251, 146, 60, 0);
                }
            }

            @media (max-width: 1024px) {
                #sentinel-audit {
                    margin-left: 0% !important;
                    width: 100% !important
                }
            }

            /* ----------------------------- section 5 -----------------------------  */
            @keyframes elastic-slide {
                0% {
                    transform: translateX(100%);
                }

                100% {
                    transform: translateX(0);
                }
            }

            .side-panel-open {
                animation: elastic-slide 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
            }

            .overlay-active {
                background: rgba(0, 0, 0, 0.6);
                backdrop-filter: blur(8px);
                z-index: 40;
            }

            .plate-morph {
                transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .car-plate {
                width: 180px;
                height: 40px;
            }

            .moto-plate {
                width: 100px;
                height: 80px;
            }

            /* Skeleton Loading */
            .skeleton {
                background: linear-gradient(90deg, #111 25%, #222 50%, #111 75%);
                background-size: 200% 100%;
                animation: loading 1.5s infinite;
            }

            @keyframes loading {
                0% {
                    background-position: 200% 0;
                }

                100% {
                    background-position: -200% 0;
                }
            }


            /* ----------------------------- section 6 -----------------------------  */
        </style>
    </head>

    <body oncontextmenu="return false;">
        <!-- ----------------------------- sidebar -----------------------------  -->
        <?php include "Sidebar.php" ?>
        <!-- ----------------------------- section 1 -----------------------------  -->
        <div class="flex min-h-screen">
            <aside id="sidebar" class="hidden lg:flex w-64 bg-[#020c1b] border-r border-white/5 p-6 flex-col gap-6">
                <h2 class="text-xs font-bold text-white/30 tracking-[3px] uppercase">Security Level</h2>
                <nav class="flex flex-col gap-2">
                    <div class="p-3 rounded-lg bg-white/5 border border-white/10 text-sm opacity-50 cursor-grab active:cursor-grabbing">
                        <i class="ri-drag-move-2-line mr-2"></i> Northern Vault
                    </div>
                    <div class="p-3 rounded-lg bg-white/5 border border-white/10 text-sm opacity-50">
                        <i class="ri-drag-move-2-line mr-2"></i> Central Vault
                    </div>
                    <div class="p-3 rounded-lg bg-white/5 border border-white/10 text-sm opacity-50">
                        <i class="ri-drag-move-2-line mr-2"></i> Southern Vault
                    </div>
                </nav>
            </aside>

            <main class="flex-1 p-4 md:p-8 lg:p-12" style="width: 100%;">
                <?php if (isset($_GET['error']) && $_GET['error'] === 'duplicate'): ?>
                    <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 rounded-2xl flex items-center gap-3 text-red-400 animate-pulse">
                        <i class="ri-error-warning-line text-xl"></i>
                        <span>Lỗi: Biển số <b><?php echo htmlspecialchars($_GET['plate']); ?></b> đã tồn tại trong hệ thống!</span>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
                    <div class="mb-6 p-4 bg-green-500/10 border border-green-500/50 rounded-2xl flex items-center gap-3 text-green-400">
                        <i class="ri-checkbox-circle-line text-xl"></i>
                        <span>Đã thêm tài sản mới thành công!</span>
                    </div>
                <?php endif; ?>

                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10 bg-[#0a192f]/50 p-4 rounded-2xl border border-white/5 tops">
                    <form method="GET" action="" class="flex items-center gap-4 w-full md:w-auto">
                        <div class="relative w-full md:w-80">
                            <i class="ri-search-line absolute left-4 top-1/2 -translate-y-1/2 text-cyan-400"></i>

                            <input type="text"
                                name="search"
                                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                                placeholder="Scan Barcode or Search Plate..."
                                class="w-full bg-black/40 border border-white/10 rounded-xl py-3 pl-12 pr-4 text-sm text-white focus:outline-none focus:border-cyan-400 transition-all">
                        </div>

                        <button type="submit" class="bg-white/5 p-3 rounded-xl hover:bg-white/10 transition-all text-white">
                            <i class="ri-mic-line"></i>
                        </button>

                        <?php if (isset($_GET['category'])): ?>
                            <input type="hidden" name="category" value="<?php echo htmlspecialchars($_GET['category']); ?>">
                        <?php endif; ?>
                    </form>
                    <div class="flex gap-3 overflow-x-auto w-full md:w-auto pb-2 md:pb-0">
                        <!-- <button onclick="filterVault('all', this)" class="filter-btn px-4 py-2 rounded-full bg-cyan-500/20 text-cyan-400 text-xs font-bold border border-cyan-500/30 whitespace-nowrap active-filter">TẤT CẢ</button>
                        <button onclick="filterVault('bac', this)" class="filter-btn px-4 py-2 rounded-full bg-white/5 text-white/40 text-xs font-bold border border-white/10 whitespace-nowrap">KHO BẮC</button>
                        <button onclick="filterVault('trung', this)" class="filter-btn px-4 py-2 rounded-full bg-white/5 text-white/40 text-xs font-bold border border-white/10 whitespace-nowrap">KHO TRUNG</button>
                        <button onclick="filterVault('nam', this)" class="filter-btn px-4 py-2 rounded-full bg-white/5 text-white/40 text-xs font-bold border border-white/10 whitespace-nowrap">KHO NAM</button> -->

                    </div>

                    <button onclick="openVaultPanel()" class="flex items-center gap-3 bg-cyan-600 hover:bg-cyan-500 text-white px-6 py-3 rounded-2xl transition-all shadow-[0_0_20px_rgba(8,145,178,0.3)] group">
                        <span class="text-xs font-bold uppercase tracking-widest">Add New Asset</span>
                        <div class="w-6 h-6 bg-white/20 rounded-lg flex items-center justify-center group-hover:rotate-90 transition-transform">
                            <i class="ri-add-line"></i>
                        </div>
                    </button>
                </div>

                <div class="inventory-grid" id="inventory-container">
                    <!-- <div class="group relative bg-[#0a192f] border border-white/5 p-6 rounded-[2rem] hover:border-cyan-500/50 transition-all duration-500" onclick="openVaultPanel('51K-888.88')">
                        <div class="flex justify-between items-start mb-4">
                            <i class="ri-car-fill text-white/20 group-hover:text-cyan-400 transition-colors"></i>
                            <span class="text-[10px] font-bold text-emerald-400 bg-emerald-400/10 px-2 py-1 rounded">LIVE</span>
                        </div>

                        <div class="flex justify-center py-6">
                            <div class="bg-white border-2 border-gray-300 rounded px-4 py-1 shadow-lg transform group-hover:scale-110 transition-transform duration-500">
                                <span class="text-black font-bold text-xl tracking-tighter">51K-888.88</span>
                            </div>
                        </div>

                        <div class="mt-4 flex justify-between items-end">
                            <div>
                                <p class="text-[9px] text-white/30 uppercase">Current Bid</p>
                                <p class="text-white font-bold">450.000.000đ</p>
                            </div>
                            <button class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center hover:bg-cyan-500 transition-all">
                                <i class="ri-pencil-line text-xs"></i>
                            </button>
                        </div>
                    </div>
                    <div class="group relative bg-[#0a192f] border border-white/5 p-6 rounded-[2rem] hover:border-cyan-500/50 transition-all duration-500" onclick="openVaultPanel('59-AA 888.88')">
                        <div class="flex justify-between items-start mb-4">
                            <i class="ri-motorbike-fill text-white/20 group-hover:text-cyan-400 transition-colors text-xl"></i>
                            <span class="text-[10px] font-bold text-emerald-400 bg-emerald-400/10 px-2 py-1 rounded">LIVE</span>
                        </div>

                        <div class="flex justify-center py-4">
                            <div class="bg-white border-2 border-gray-300 rounded-lg px-4 py-2 shadow-lg transform group-hover:scale-110 transition-transform duration-500 flex flex-col items-center justify-center leading-none min-w-[100px]">
                                <span class="text-black font-bold text-lg tracking-widest border-b border-gray-200 w-full text-center pb-1 mb-1">59-AA</span>
                                <span class="text-black font-bold text-xl tracking-tighter">888.88</span>
                            </div>
                        </div>

                        <div class="mt-4 flex justify-between items-end">
                            <div>
                                <p class="text-[9px] text-white/30 uppercase">Current Bid</p>
                                <p class="text-white font-bold">85.000.000đ</p>
                            </div>
                            <button class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center hover:bg-cyan-500 transition-all" onclick="event.stopPropagation(); openVaultPanel('59-AA 888.88')">
                                <i class="ri-pencil-line text-xs"></i>
                            </button>
                        </div>
                    </div> -->
                    <?php
                    $plateModel = new Plate();

                    // 1. Cấu hình phân trang
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    if ($page < 1) $page = 1;
                    $perPage = 10; // Số lượng bản ghi mỗi trang

                    // 2. Lấy dữ liệu ĐÃ PHÂN TRANG (Truyền các tham số lọc nếu có)
                    // Giả sử các tham số filter lấy từ GET hoặc để trống
                    $keyword = isset($_GET['search']) ? $_GET['search'] : '';
                    $category = isset($_GET['category']) ? $_GET['category'] : '';

                    $plates = $plateModel->getWithPagination($keyword, $category, null, $page, $perPage);

                    // 3. Tính toán tổng số trang
                    $totalRecords = $plateModel->getTotalPlates($keyword, $category);
                    $totalPages = ceil($totalRecords / $perPage);

                    // 4. Hiển thị danh sách biển số
                    if (count($plates) > 0) {
                        foreach ($plates as $plate) {
                            echo $plateModel->renderPlateCard($plate);
                        }
                    } else {
                        echo "<p class='text-white/50 col-span-full text-center py-10'>Không tìm thấy dữ liệu.</p>";
                    }
                    ?>

                    <?php if ($totalPages > 1): ?>
                        <div class="mt-12 flex justify-center items-center gap-4 col-span-full">
                            <?php if ($page > 1): ?>
                                <a href="?page=<?php echo $page - 1; ?>&search=<?php echo $keyword; ?>&category=<?php echo $category; ?>"
                                    class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-white hover:bg-cyan-500/20 transition-all">
                                    <i class="ri-arrow-left-s-line"></i>
                                </a>
                            <?php endif; ?>

                            <div class="flex gap-2">
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <a href="?page=<?php echo $i; ?>&search=<?php echo $keyword; ?>&category=<?php echo $category; ?>"
                                        class="w-10 h-10 flex items-center justify-center rounded-xl border <?php echo ($i == $page) ? 'bg-cyan-500 border-cyan-500 text-white' : 'bg-white/5 border-white/10 text-white/50'; ?> hover:border-cyan-500 transition-all">
                                        <?php echo $i; ?>
                                    </a>
                                <?php endfor; ?>
                            </div>

                            <?php if ($page < $totalPages): ?>
                                <a href="?page=<?php echo $page + 1; ?>&search=<?php echo $keyword; ?>&category=<?php echo $category; ?>"
                                    class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-white hover:bg-cyan-500/20 transition-all">
                                    <i class="ri-arrow-right-s-line"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                </div>
            </main>
        </div>

        <div class="fab-scan lg:hidden">
            <i class="ri-qr-code-line"></i>
        </div>






        <div id="vault-overlay" class="fixed inset-0 hidden transition-opacity duration-500" onclick="closeVaultPanel()"></div>

        <!-- <div id="vault-panel" class="fixed top-0 right-0 h-full w-full md:w-[450px] bg-[#020c1b] border-l border-white/10 z-50 transform translate-x-full transition-transform duration-500 ease-out shadow-[-20px_0_50px_rgba(0,0,0,0.5)] flex flex-col">

            <div class="p-8 border-b border-white/5 flex justify-between items-center">
                <div>
                    <h3 id="panel-title" class="text-xl font-bold text-white tracking-wide">Add Asset</h3>
                    <p id="panel-subtitle" class="text-[10px] text-white/30 uppercase">Vault Registration</p>
                </div>
                <button onclick="closeVaultPanel()" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center hover:bg-red-500/20 hover:text-red-500 transition-all">
                    <i class="ri-close-line text-xl"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-8 space-y-8">
                <div class="flex flex-col items-center gap-4 py-6 bg-black/40 rounded-[2rem] border border-white/5">
                    <span class="text-[9px] text-white/20 uppercase tracking-[3px]">Visual Preview</span>
                    <div id="plate-preview" class="plate-morph bg-white border-2 border-gray-300 rounded flex items-center justify-center car-plate">
                        <span id="preview-text" class="text-black font-bold tracking-tighter">XX-XXX.XX</span>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-[10px] text-white/40 uppercase ml-2">Plate Number</label>
                        <input type="text" id="input-plate" oninput="updatePreview()" placeholder="e.g. 51K-999.99" class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-white focus:border-cyan-500 outline-none transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <button onclick="switchType('car')" id="btn-car" class="py-4 rounded-2xl border border-cyan-500 bg-cyan-500/10 text-cyan-400 text-xs font-bold uppercase">Automobile</button>
                        <button onclick="switchType('moto')" id="btn-moto" class="py-4 rounded-2xl border border-white/10 bg-white/5 text-white/40 text-xs font-bold uppercase">Motorcycle</button>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] text-white/40 uppercase ml-2">Starting Price (VND)</label>
                        <input type="number" placeholder="40,000,000" class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-white focus:border-cyan-500 outline-none transition-all">
                    </div>
                </div>
            </div>

            <div class="p-8 border-t border-white/5 bg-[#020c1b]">
                <button id="save-btn" class="w-full py-4 bg-cyan-600 hover:bg-cyan-500 text-white rounded-2xl font-bold uppercase tracking-widest transition-all shadow-[0_10px_30px_rgba(8,145,178,0.3)]">
                    Confirm Changes
                </button>
            </div>
        </div> -->
        <div id="vault-panel" class="fixed top-0 right-0 h-full w-full md:w-[450px] bg-[#020c1b] border-l border-white/10 z-50 transform translate-x-full transition-transform duration-500 ease-out shadow-[-20px_0_50px_rgba(0,0,0,0.5)] flex flex-col">
            <form method="POST" action="" class="flex flex-col h-full overflow-hidden">

                <input type="hidden" name="plate_id" id="input-plate-id">

                <div class="p-8 border-b border-white/5 flex justify-between items-center">
                    <div>
                        <h3 id="panel-title" class="text-xl font-bold text-white tracking-wide">Add Asset</h3>
                        <p id="panel-subtitle" class="text-[10px] text-white/30 uppercase">Vault Registration</p>
                    </div>
                    <button type="button" onclick="closeVaultPanel()" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center hover:bg-red-500/20 hover:text-red-500 transition-all">
                        <i class="ri-close-line text-xl"></i>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto  p-8 space-y-8 custom-scrollbar">
                    <div class="flex flex-col items-center gap-4 py-6 bg-black/40 rounded-[2rem] border border-white/5">
                        <span class="text-[9px] text-white/20 uppercase tracking-[3px]">Visual Preview</span>
                        <div id="plate-preview" class="plate-morph bg-white border-2 border-gray-300 rounded flex items-center justify-center car-plate shadow-lg transition-all duration-300">
                            <span id="preview-text" class="text-black font-bold tracking-tighter text-2xl">XX-XXX.XX</span>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-[10px] text-white/40 uppercase ml-2">Plate Number</label>
                            <input type="text" name="plate_number" id="input-plate" oninput="updatePreview()" placeholder="e.g. 51K-999.99" class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-white focus:border-cyan-500 outline-none transition-all" required>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] text-white/40 uppercase ml-2">Vehicle Type</label>
                            <div class="grid grid-cols-2 gap-4">
                                <button type="button" onclick="switchType('Car')" id="btn-car" class="py-4 rounded-2xl border border-cyan-500 bg-cyan-500/10 text-cyan-400 text-xs font-bold uppercase transition-all">Automobile</button>
                                <button type="button" onclick="switchType('Motorbike')" id="btn-moto" class="py-4 rounded-2xl border border-white/10 bg-white/5 text-white/40 text-xs font-bold uppercase transition-all">Motorcycle</button>
                            </div>
                            <input type="hidden" name="vehicle_type" id="input-vehicle-type" value="Car">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] text-white/40 uppercase ml-2">Category</label>
                            <select name="category" id="input-category" class="w-full bg-[#0a192f] border border-white/10 rounded-2xl py-4 px-6 text-white focus:border-cyan-500 outline-none transition-all appearance-none">
                                <option value="Ngũ quý">Ngũ quý</option>
                                <option value="Tứ quý">Tứ quý</option>
                                <option value="Lộc phát">Lộc phát</option>
                                <option value="Số tiến">Số tiến</option>
                                <option value="Thần tài">Thần tài</option>
                                <option value="Sảnh tiến">Sảnh tiến</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] text-white/40 uppercase ml-2">Location</label>
                            <input type="text" name="address" id="input-address" placeholder="e.g. TP. Hồ Chí Minh" class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-white focus:border-cyan-500 outline-none transition-all">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] text-white/40 uppercase ml-2">Starting Price</label>
                            <input type="number" name="starting_price" id="input-price" placeholder="40000000" class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-white focus:border-cyan-500 outline-none transition-all" required>
                        </div>
                    </div>
                </div>

                <div class="p-8 border-t border-white/5 bg-[#020c1b]">
                    <button type="submit" name="save_plate" id="save-btn" class="w-full py-4 bg-cyan-600 hover:bg-cyan-500 text-white rounded-2xl font-bold uppercase tracking-widest transition-all shadow-[0_10px_30px_rgba(8,145,178,0.3)] flex items-center justify-center gap-2">
                        <span>Confirm Changes</span>
                        <i class="ri-check-double-line"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- ----------------------------- section 2 -----------------------------  -->
        <section id="document-vault" class="min-h-screen sapphire-satin p-4 md:p-8 lg:p-12 relative overflow-hidden border-t border-white/5">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 border-b border-white/10 pb-8 space-y-4 md:space-y-0">
                <div class="animate-on-scroll">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="w-8 h-[1px] bg-blue-500"></span>
                        <span class="text-blue-500 text-[10px] font-bold tracking-[4px] uppercase">Forensic Module</span>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-light tracking-tight text-white">
                        Digital Twin <span class="text-blue-400 font-bold">&</span> Document Vault
                    </h2>
                    <p class="text-white/40 text-sm mt-3 max-w-xl">
                        Xác thực hồ sơ pháp lý thông qua công nghệ quét lớp vân giấy kỹ thuật số và đối chiếu mã băm Blockchain.
                    </p>
                </div>

                <div class="flex items-center gap-6">
                    <div class="hidden xl:block text-right">
                        <p class="text-[10px] text-white/30 uppercase mono mb-1">Security Protocol</p>
                        <p class="text-emerald-400 text-xs font-bold">ENCRYPTED END-TO-END</p>
                    </div>
                    <div class="h-10 w-[1px] bg-white/10 hidden xl:block"></div>
                    <div class="flex flex-col items-start md:items-end">
                        <span class="text-[10px] text-white/30 uppercase mono mb-1">Version Control</span>
                        <select class="bg-white/5 border border-white/10 text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500 transition-all text-white/80">
                            <option class="bg-[#000814]">v2.4 - Current (Jan 2024)</option>
                            <option class="bg-[#000814]">v2.0 - Archived (Aug 2023)</option>
                            <option class="bg-[#000814]">v1.5 - Legacy (May 2023)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex flex-col xl:flex-row gap-10">

                <div id="visual-twin" class="w-full xl:w-3/5 space-y-6">
                    <div class="zoom-container group relative rounded-[2rem] border border-white/10 bg-black" id="main-inspector">
                        <div class="watermark-layer"></div>

                        <div id="lens" class="magnifier border-2 border-cyan-500/50 shadow-[0_0_30px_rgba(0,242,255,0.3)]"></div>

                        <img id="target-image"
                            src="https://images.unsplash.com/photo-1621360841013-c7683c659ec6?q=80&w=2000"
                            alt="Document Scan"
                            class="w-full h-[550px] object-cover opacity-70 group-hover:opacity-100 transition-opacity duration-1000">

                        <div class="absolute top-6 right-6 flex flex-col gap-2">
                            <div class="bg-black/60 backdrop-blur-md px-4 py-2 rounded-full border border-white/10 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span class="text-[10px] mono text-white/80 uppercase tracking-widest">Live Integrity Check</span>
                            </div>
                        </div>

                        <div class="absolute bottom-6 left-6 flex gap-3">
                            <button class="bg-blue-600 text-white px-5 py-2 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-blue-500 transition-all">
                                <i class="ri-focus-3-line mr-2"></i> Auto Focus
                            </button>
                            <button class="bg-white/10 backdrop-blur-md text-white px-5 py-2 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-white/20 transition-all">
                                <i class="ri-contrast-drop-2-line mr-2"></i> Invert Colors
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-4 sm:grid-cols-6 gap-4">
                        <div onclick="changeInspectorImage(this)" class="aspect-square border-2 border-blue-500 overflow-hidden rounded-2xl cursor-pointer group relative">
                            <img src="https://images.unsplash.com/photo-1621360841013-c7683c659ec6?q=80&w=200" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-blue-500/20"></div>
                        </div>

                        <div onclick="changeInspectorImage(this)" class="aspect-square border border-white/10 opacity-50 hover:opacity-100 hover:border-white/30 overflow-hidden rounded-2xl cursor-pointer transition-all">
                            <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?q=80&w=200" class="w-full h-full object-cover">
                        </div>

                    </div>
                </div>

                <div id="metadata-panel" class="w-full xl:w-2/5 space-y-8">
                    <div class="relative h-[300px] mb-12" id="stack-container">
                        <p class="text-[10px] text-white/20 uppercase tracking-[3px] mb-4 mono">Folder Stack (Scroll to flip)</p>

                        <div class="doc-item absolute inset-0 z-30 transform transition-all duration-700">
                            <div class="bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-2xl border border-emerald-500/30 p-8 rounded-[2.5rem] h-64 flex flex-col justify-between shadow-2xl">
                                <div class="flex justify-between items-start">
                                    <div class="w-14 h-14 bg-emerald-500/10 rounded-2xl flex items-center justify-center border border-emerald-500/20">
                                        <i class="ri-file-shield-2-line text-3xl text-emerald-400"></i>
                                    </div>
                                    <button onclick="verifyBlockchain(this)" class="group flex items-center gap-3 bg-emerald-500/10 hover:bg-emerald-500 px-4 py-2 rounded-full border border-emerald-500/30 transition-all">
                                        <span class="text-[9px] font-bold text-emerald-400 group-hover:text-black">VERIFY HASH</span>
                                        <i class="ri-lock-2-line text-emerald-400 group-hover:text-black"></i>
                                    </button>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-white tracking-wide">Giấy thu hồi gốc</h4>
                                    <p class="text-xs text-white/40 mt-1 mono tracking-tighter">BLOCKCHAIN ID: 0x88F9...42E1</p>
                                </div>
                                <div class="flex justify-between items-center pt-4 border-t border-white/5">
                                    <span class="text-[10px] text-white/30 mono uppercase">Timestamp: 12/01/2024</span>
                                    <span class="text-emerald-400 text-[10px] font-bold bg-emerald-400/10 px-2 py-1 rounded">MATCHED</span>
                                </div>
                            </div>
                        </div>

                        <div class="doc-item absolute inset-0 z-20 translate-y-4 translate-z-[-50px] opacity-40">
                            <div class="bg-white/5 border border-white/10 p-8 rounded-[2.5rem] h-64 flex flex-col grayscale">
                                <i class="ri-file-list-3-line text-3xl text-white/20 mb-auto"></i>
                                <h4 class="text-xl font-bold text-white/20 uppercase">Hợp đồng mua bán</h4>
                            </div>
                        </div>
                    </div>

                    <div class="bg-[#050505] rounded-[2.5rem] p-8 border border-white/5 shadow-inner">
                        <h5 class="text-[10px] font-bold text-blue-400 uppercase tracking-[4px] mb-6 flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-blue-400 rounded-full animate-ping"></span>
                            AI Metadata Extraction
                        </h5>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5 hover:bg-white/10 transition-all">
                                <div class="flex items-center gap-4">
                                    <i class="ri-fingerprint-line text-blue-400 text-lg"></i>
                                    <span class="text-xs text-white/40 uppercase">Số Khung (VIN)</span>
                                </div>
                                <span class="text-sm mono font-bold text-white">RLH-7728X-291</span>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5 hover:bg-white/10 transition-all">
                                <div class="flex items-center gap-4">
                                    <i class="ri-engine-line text-blue-400 text-lg"></i>
                                    <span class="text-xs text-white/40 uppercase">Số Máy</span>
                                </div>
                                <span class="text-sm mono font-bold text-white">BE-1928374</span>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5 hover:bg-white/10 transition-all">
                                <div class="flex items-center gap-4">
                                    <i class="ri-user-star-line text-blue-400 text-lg"></i>
                                    <span class="text-xs text-white/40 uppercase">Chủ sở hữu gốc</span>
                                </div>
                                <span class="text-sm font-bold text-white italic underline decoration-blue-500/30">Lê Văn Quý ***</span>
                            </div>
                        </div>

                        <button class="w-full mt-8 py-4 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-2xl text-[10px] font-bold uppercase tracking-[2px] hover:shadow-[0_0_30px_rgba(37,99,235,0.4)] transition-all">
                            Xuất Báo Cáo Thẩm Định (PDF)
                        </button>
                    </div>

                </div>
            </div>
        </section>


        <!-- ----------------------------- section 3 -----------------------------  -->
        <section id="logistics-vault" class="min-h-screen bg-[#000814] p-4 md:p-8 lg:p-12 relative overflow-hidden border-t border-white/5" style="margin-left: 17%;">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 border-b border-white/10 pb-8">
                <div class="animate-on-scroll">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="w-8 h-[1px] bg-cyan-500"></span>
                        <span class="text-cyan-500 text-[10px] font-bold tracking-[4px] uppercase">Asset Path Protocol</span>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-light tracking-tight text-white">
                        Logistics <span class="text-cyan-400 font-bold">&</span> Transfer Chain
                    </h2>
                </div>
                <div class="flex gap-4 mt-4 md:mt-0">
                    <div class="bg-red-500/10 border border-red-500/20 px-4 py-2 rounded-xl flex items-center gap-3 group cursor-pointer hover:bg-red-500 transition-all">
                        <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
                        <span class="text-[10px] font-bold text-red-500 group-hover:text-white uppercase tracking-widest">Emergency SOS</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col xl:flex-row gap-8">

                <div class="w-full xl:w-3/5 relative">
                    <div class="relative h-[400px] md:h-[600px] bg-[#001220] rounded-[2.5rem] border border-white/10 overflow-hidden group shadow-2xl">
                        <div class="absolute inset-0 opacity-30 grayscale invert pointer-events-none"
                            style="background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');"></div>

                        <div class="absolute top-1/4 left-1/4 w-4 h-4 bg-cyan-500 rounded-full blur-[2px] shadow-[0_0_15px_#00f2ff]">
                            <span class="absolute -top-6 -left-4 text-[9px] mono text-cyan-400 uppercase">Northern_Hub</span>
                        </div>
                        <div class="absolute bottom-1/3 right-1/4 w-4 h-4 bg-blue-600 rounded-full blur-[2px] shadow-[0_0_15px_#1e40af]">
                            <span class="absolute -bottom-6 -left-4 text-[9px] mono text-blue-400 uppercase">Southern_Hub</span>
                        </div>

                        <svg class="absolute inset-0 w-full h-full pointer-events-none">
                            <path id="transport-path" d="M 250 150 Q 400 300 650 450" fill="none" stroke="rgba(0, 242, 255, 0.2)" stroke-width="2" stroke-dasharray="8 4" />
                            <circle id="transport-pulse" r="5" fill="#00f2ff" style="filter: drop-shadow(0 0 8px #00f2ff)">
                                <animateMotion dur="4s" repeatCount="indefinite" path="M 250 150 Q 400 300 650 450" />
                            </circle>
                        </svg>

                        <div class="absolute top-6 left-6 bg-black/60 backdrop-blur-md p-4 rounded-2xl border border-white/10">
                            <p class="text-[10px] text-white/40 uppercase mono">Current Transport</p>
                            <h4 class="text-white font-bold text-sm">SECURE_VAN: #TX-992</h4>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-emerald-400 text-[10px] mono">GPS: 10.7626, 106.6601</span>
                            </div>
                        </div>

                        <div class="absolute bottom-6 left-6 flex gap-3">
                            <button id="dispatch-btn" class="bg-cyan-600 hover:bg-cyan-500 text-white px-6 py-3 rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all shadow-lg shadow-cyan-500/20">
                                <i class="ri-rocket-2-line mr-2"></i> Dispatch Signal
                            </button>
                        </div>
                    </div>
                </div>

                <div class="w-full xl:w-2/5 space-y-6">
                    <div class="bg-[#050505] rounded-[2.5rem] p-8 border border-white/5 h-full relative overflow-y-auto">
                        <h5 class="text-[10px] font-bold text-blue-400 uppercase tracking-[4px] mb-10 flex items-center gap-2">
                            <i class="ri-history-line"></i> Chain of Custody
                        </h5>

                        <div class="relative space-y-12">
                            <div class="absolute left-[15px] top-2 bottom-2 w-[1px] bg-gradient-to-b from-cyan-500/50 via-white/10 to-transparent"></div>

                            <div class="relative pl-12 group">
                                <div class="absolute left-0 top-1 w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center border-4 border-[#050505] z-10">
                                    <i class="ri-check-line text-black text-sm font-bold"></i>
                                </div>
                                <div>
                                    <span class="text-[9px] mono text-emerald-400 bg-emerald-400/10 px-2 py-0.5 rounded">COMPLETED</span>
                                    <h4 class="text-white text-sm font-bold mt-1">Vault Departure</h4>
                                    <p class="text-white/40 text-xs mt-1">Agent: <strong>Quoc_Le_01</strong> • <span class="italic">Digital Sig: 0x92...F1</span></p>
                                </div>
                            </div>

                            <div class="relative pl-12 group timeline-step-active">
                                <div class="absolute left-0 top-1 w-8 h-8 rounded-full bg-cyan-500 flex items-center justify-center border-4 border-[#050505] z-10 shadow-[0_0_15px_#00f2ff] animate-pulse">
                                    <i class="ri-truck-line text-black text-sm"></i>
                                </div>
                                <div class="bg-white/5 p-4 rounded-2xl border border-cyan-500/30">
                                    <span class="text-[9px] mono text-cyan-400 bg-cyan-400/10 px-2 py-0.5 rounded">IN TRANSIT</span>
                                    <h4 class="text-white text-sm font-bold mt-1">In Transit - Station Alpha</h4>
                                    <p class="text-white/40 text-xs mt-1">ETA: 14:30 (12 mins remaining)</p>
                                    <div class="mt-3 hidden group-hover:block transition-all duration-500">
                                        <img src="https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?q=80&w=400" class="w-full h-24 object-cover rounded-lg border border-white/10">
                                    </div>
                                </div>
                            </div>

                            <div class="relative pl-12 group opacity-30">
                                <div class="absolute left-0 top-1 w-8 h-8 rounded-full bg-white/10 flex items-center justify-center border-4 border-[#050505] z-10">
                                    <i class="ri-user-received-2-line text-white/40 text-sm"></i>
                                </div>
                                <div>
                                    <span class="text-[9px] mono text-white/40">PENDING</span>
                                    <h4 class="text-white text-sm font-bold mt-1">Customer Handover</h4>
                                    <div class="mt-4 flex gap-2">
                                        <input type="text" placeholder="Enter OTP" class="bg-black border border-white/10 rounded-lg px-3 py-2 text-xs w-24 focus:border-cyan-500 outline-none">
                                        <button class="bg-white/10 px-4 py-2 rounded-lg text-[9px] font-bold uppercase hover:bg-white/20 transition-all">Verify</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-12 pt-8 border-t border-white/5">
                            <p class="text-[10px] text-white/20 uppercase tracking-[3px] mb-4 mono">Proof of Delivery (AI Scan)</p>
                            <div class="relative rounded-2xl overflow-hidden group">
                                <div class="absolute inset-0 bg-blue-500/20 mix-blend-overlay group-hover:opacity-0 transition-all"></div>
                                <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?q=80&w=600" class="w-full h-32 object-cover blur-[2px] group-hover:blur-0 transition-all duration-700">
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="bg-black/80 px-4 py-1 rounded-full text-[9px] font-bold border border-white/10">AI OBFUSCATED</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ----------------------------- section 4 -----------------------------  -->
        <section id="sentinel-audit" class="min-h-screen bg-[#000814] text-white p-4 md:p-8 border-t border-cyan-900/30 relative overflow-hidden transition-all duration-300 ml-0 md:ml-20 lg:ml-24" style="margin-left: 17%;">

            <div class="absolute inset-0 opacity-5 pointer-events-none"
                style="background-image: radial-gradient(#00f2ff 0.5px, transparent 0.5px); background-size: 30px 30px;"></div>

            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-12 relative z-10 animate-on-scroll">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <i class="ri-shield-keyhole-line text-cyan-400"></i>
                        <span class="text-cyan-400 text-[10px] font-bold tracking-[5px] uppercase">Protocol: Sentinel Audit</span>
                    </div>
                    <h2 class="text-3xl font-light tracking-tighter">The <span class="text-white font-bold">Integrity Dashboard</span></h2>
                </div>

                <div class="mt-6 lg:mt-0 flex items-center gap-6 bg-white/5 border border-white/10 p-4 rounded-3xl backdrop-blur-xl">
                    <div class="relative w-20 h-20">
                        <svg class="w-full h-full" viewBox="0 0 36 36">
                            <circle cx="18" cy="18" r="16" fill="none" class="stroke-white/10" stroke-width="2"></circle>
                            <circle cx="18" cy="18" r="16" fill="none" class="stroke-cyan-500" stroke-width="2"
                                stroke-dasharray="100" stroke-dashoffset="15" stroke-linecap="round"></circle>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-xl font-bold text-white leading-none">94</span>
                            <span class="text-[8px] text-cyan-400 font-bold uppercase">Safe</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-[10px] text-white/40 uppercase tracking-widest">Vault Trust Score</p>
                        <p class="text-xs text-emerald-400 font-mono">STATUS: HIGH INTEGRITY</p>
                        <div class="flex gap-1 mt-1">
                            <span class="w-8 h-1 bg-emerald-500 rounded-full"></span>
                            <span class="w-8 h-1 bg-emerald-500 rounded-full"></span>
                            <span class="w-8 h-1 bg-emerald-500 rounded-full"></span>
                            <span class="w-8 h-1 bg-white/10 rounded-full"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 relative z-10">

                <div class="bg-black/40 border border-white/5 p-6 rounded-[2rem] hover:border-cyan-500/30 transition-all group">
                    <h4 class="text-[11px] font-bold text-white/60 mb-6 uppercase tracking-widest flex items-center gap-2">
                        <span class="w-2 h-2 bg-cyan-500 rounded-full"></span> Digital-Physical Sync
                    </h4>
                    <div class="space-y-4 font-mono">
                        <div class="text-[10px]">
                            <div class="flex justify-between mb-1">
                                <span class="text-white/40">VAULT_NORTH</span>
                                <span class="text-cyan-400">SYNCED</span>
                            </div>
                            <div class="h-1.5 w-full bg-white/5 rounded-full overflow-hidden">
                                <div class="h-full bg-cyan-500 w-[92%]"></div>
                            </div>
                        </div>
                        <div class="text-[10px]">
                            <div class="flex justify-between mb-1">
                                <span class="text-white/40">VAULT_CENTRAL</span>
                                <span class="text-rose-500">DEVIATION_DETECTION</span>
                            </div>
                            <div class="h-1.5 w-full bg-white/5 rounded-full overflow-hidden">
                                <div class="h-full bg-rose-500 w-[65%] animate-pulse"></div>
                            </div>
                        </div>
                        <div class="text-[10px]">
                            <div class="flex justify-between mb-1">
                                <span class="text-white/40">VAULT_SOUTH</span>
                                <span class="text-cyan-400">SYNCED</span>
                            </div>
                            <div class="h-1.5 w-full bg-white/5 rounded-full overflow-hidden">
                                <div class="h-full bg-cyan-500 w-[100%]"></div>
                            </div>
                        </div>
                    </div>
                    <button onclick="startDeepScan()" class="w-full mt-6 py-3 border border-cyan-500/20 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-cyan-500 hover:text-black transition-all">
                        Full System Audit
                    </button>
                </div>

                <div class="bg-black/40 border border-white/5 p-6 rounded-[2rem] flex flex-col items-center justify-center relative overflow-hidden">
                    <div id="blockchain-seal-target" class="text-center">
                        <div class="text-[60px] text-white/5 mb-2"><i class="ri-lock-password-line"></i></div>
                        <h4 class="text-2xl font-bold text-white mb-1">88.5%</h4>
                        <p class="text-[10px] text-white/40 uppercase tracking-widest">Blockchain Verified</p>
                        <div class="mt-4 flex -space-x-2">
                            <img src="https://i.pravatar.cc/100?u=1" class="w-8 h-8 rounded-full border-2 border-black">
                            <img src="https://i.pravatar.cc/100?u=2" class="w-8 h-8 rounded-full border-2 border-black">
                            <img src="https://i.pravatar.cc/100?u=3" class="w-8 h-8 rounded-full border-2 border-black">
                            <div class="w-8 h-8 rounded-full bg-white/5 border-2 border-black flex items-center justify-center text-[8px] font-bold">+12</div>
                        </div>
                    </div>
                    <div id="wax-seal" class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-0 scale-150">
                        <div class="w-32 h-32 bg-rose-900/80 rounded-full border-4 border-rose-600 flex items-center justify-center shadow-[0_0_50px_rgba(225,29,72,0.5)]">
                            <i class="ri-shield-check-fill text-rose-200 text-5xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-black/40 border border-white/5 p-6 rounded-[2rem]">
                    <h4 class="text-[11px] font-bold text-white/60 mb-6 uppercase tracking-widest">Environmental Sensors</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="env-card p-3 bg-white/5 rounded-2xl border border-white/10 transition-all">
                            <span class="text-[10px] text-white/40 block mb-1">Temperature</span>
                            <span class="text-xl font-mono">22.4°C</span>
                        </div>
                        <div id="humidity-sensor" class="env-card p-3 bg-white/5 rounded-2xl border border-white/10 transition-all">
                            <span class="text-[10px] text-white/40 block mb-1">Humidity</span>
                            <span class="text-xl font-mono">45%</span>
                        </div>
                        <div class="env-card p-3 bg-white/5 rounded-2xl border border-white/10 transition-all">
                            <span class="text-[10px] text-white/40 block mb-1">Pressure</span>
                            <span class="text-xl font-mono">1012 hPa</span>
                        </div>
                        <div class="env-card p-3 bg-white/5 rounded-2xl border border-white/10 transition-all">
                            <span class="text-[10px] text-white/40 block mb-1">Light O2</span>
                            <span class="text-xl font-mono text-emerald-400">OPTIMAL</span>
                        </div>
                    </div>
                    <div class="mt-4 p-3 bg-cyan-500/5 rounded-xl border border-cyan-500/10">
                        <p class="text-[9px] text-cyan-400 font-mono leading-tight uppercase italic">
                            AI Smoothing: Active <br> Filtering sensor noise...
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-8 relative z-10 animate-on-scroll">
                <div class="flex items-center gap-3 bg-white/5 p-4 rounded-2xl border border-white/5 hover:bg-white/10 transition-all">
                    <i class="ri-user-follow-line text-cyan-400"></i>
                    <div>
                        <p class="text-[8px] text-white/40 uppercase">KYC Linkage</p>
                        <p class="text-xs font-bold">100% Match</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 bg-white/5 p-4 rounded-2xl border border-white/5 hover:bg-white/10 transition-all">
                    <i class="ri-qr-scan-2-line text-cyan-400"></i>
                    <div>
                        <p class="text-[8px] text-white/40 uppercase">Seal Integrity</p>
                        <p class="text-xs font-bold text-emerald-400">Intact</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 bg-white/5 p-4 rounded-2xl border border-white/5 hover:bg-white/10 transition-all">
                    <i class="ri-terminal-window-line text-cyan-400"></i>
                    <div>
                        <p class="text-[8px] text-white/40 uppercase">Encryption</p>
                        <p class="text-xs font-bold">AES-256 GCM</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 bg-white/5 p-4 rounded-2xl border border-white/5 hover:bg-white/10 transition-all">
                    <i class="ri-rfid-line text-cyan-400"></i>
                    <div>
                        <p class="text-[8px] text-white/40 uppercase">RFID Auto-Scan</p>
                        <p class="text-xs font-bold text-cyan-400">Ready</p>
                    </div>
                </div>
            </div>

            <div id="laser-scanner" class="fixed left-0 w-full h-1 bg-gradient-to-r from-transparent via-emerald-400 to-transparent shadow-[0_0_20px_#10b981] z-[100] hidden"></div>
        </section>


        <!-- ----------------------------- section 5 -----------------------------  -->

        <!-- ----------------------------- section 6 -----------------------------  -->

    </body>
    <script>
        // ----------------------------- section 1 ----------------------------- //
        function filterVault(vaultType, btn) {
            const cards = document.querySelectorAll('.vault-card-container');
            const buttons = document.querySelectorAll('.filter-btn');

            // 1. Cập nhật UI cho nút bấm
            buttons.forEach(b => {
                b.classList.remove('bg-cyan-500/20', 'text-cyan-400', 'border-cyan-500/30');
                b.classList.add('bg-white/5', 'text-white/40', 'border-white/10');
            });
            btn.classList.add('bg-cyan-500/20', 'text-cyan-400', 'border-cyan-500/30');
            btn.classList.remove('bg-white/5', 'text-white/40', 'border-white/10');

            // 2. Logic lọc thẻ với hiệu ứng GSAP
            cards.forEach(card => {
                const cardType = card.getAttribute('data-type');

                if (vaultType === 'all' || cardType === vaultType) {
                    // Hiện thẻ
                    card.style.display = 'block';
                    gsap.to(card, {
                        opacity: 1,
                        scale: 1,
                        duration: 0.4,
                        ease: "power2.out",
                        clearProps: "all" // Đảm bảo không lỗi layout grid
                    });
                } else {
                    // Ẩn thẻ
                    gsap.to(card, {
                        opacity: 0,
                        scale: 0.8,
                        duration: 0.3,
                        ease: "power2.in",
                        onComplete: () => {
                            card.style.display = 'none';
                        }
                    });
                }
            });
        }
        // Hiệu ứng Depth Perception (Tilt Shift)
        function handleTilt(e, card) {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            const rotateX = (y - centerY) / 10;
            const rotateY = (centerX - x) / 10;

            gsap.to(card, {
                rotateX: rotateX,
                rotateY: rotateY,
                duration: 0.5,
                ease: "power2.out",
                transformPerspective: 1000
            });
        }

        function resetTilt(card) {
            gsap.to(card, {
                rotateX: 0,
                rotateY: 0,
                duration: 0.8,
                ease: "elastic.out(1, 0.3)"
            });
        }

        // Tích hợp Swipe Actions cho Mobile
        let touchstartX = 0;
        let touchendX = 0;

        const cards = document.querySelectorAll('.glass-vault');
        cards.forEach(card => {
            card.addEventListener('touchstart', e => {
                touchstartX = e.changedTouches[0].screenX;
            });

            card.addEventListener('touchend', e => {
                touchendX = e.changedTouches[0].screenX;
                handleSwipe(card);
            });
        });

        function handleSwipe(card) {
            if (window.innerWidth < 1024) {
                if (touchendX < touchstartX - 100) { // Swipe Left
                    gsap.to(card, {
                        x: -100,
                        opacity: 0,
                        duration: 0.3,
                        onComplete: () => {
                            alert("Báo cáo sự cố đã được gửi!");
                            gsap.set(card, {
                                x: 0,
                                opacity: 1
                            });
                        }
                    });
                }
                if (touchendX > touchstartX + 100) { // Swipe Right
                    card.style.borderColor = "#00f2ff";
                    alert("Xác nhận kiểm kê thành công!");
                }
            }
        }

        // ----------------------------- section 2 ----------------------------- //
        // --- Logic Section 2 --- //

        // 1. Forensic Magnifier Logic
        const container = document.getElementById('main-inspector');
        const lens = document.getElementById('lens');
        const img = document.getElementById('target-image');

        container.addEventListener('mousemove', (e) => {
            lens.style.display = 'block';
            const rect = container.getBoundingClientRect();
            let x = e.clientX - rect.left;
            let y = e.clientY - rect.top;

            // Di chuyển lens
            gsap.to(lens, {
                left: x - 75,
                top: y - 75,
                duration: 0.1
            });

            // Tính toán vị trí background cho lens (Phóng đại 2x)
            const xPercent = (x / rect.width) * 100;
            const yPercent = (y / rect.height) * 100;

            lens.style.backgroundImage = `url('${img.src}')`;
            lens.style.backgroundSize = `${rect.width * 2}px ${rect.height * 2}px`;
            lens.style.backgroundPosition = `${xPercent}% ${yPercent}%`;
        });

        container.addEventListener('mouseleave', () => {
            lens.style.display = 'none';
        });

        // 2. Document Stack Flip (Mouse Wheel)
        let currentDoc = 0;
        const docs = document.querySelectorAll('.doc-item');

        document.getElementById('stack-container').addEventListener('wheel', (e) => {
            e.preventDefault();
            if (e.deltaY > 0 && currentDoc < docs.length - 1) {
                gsap.to(docs[currentDoc], {
                    rotateX: 90,
                    y: -100,
                    opacity: 0,
                    duration: 0.6
                });
                currentDoc++;
            } else if (e.deltaY < 0 && currentDoc > 0) {
                currentDoc--;
                gsap.to(docs[currentDoc], {
                    rotateX: 0,
                    y: 0,
                    opacity: 1,
                    duration: 0.6
                });
            }
        });

        // 3. Blockchain Verification Animation
        function verifyBlockchain(btn) {
            const card = btn.closest('.doc-item');
            const icon = btn.querySelector('i');

            // Chạy hiệu ứng luồng sáng
            card.classList.add('bc-verify-active');
            icon.classList.replace('ri-lock-2-line', 'ri-loader-4-line');
            icon.classList.add('animate-spin');

            setTimeout(() => {
                icon.classList.replace('ri-loader-4-line', 'ri-shield-check-line');
                icon.classList.remove('animate-spin');
                card.style.borderColor = '#10b981';
                alert("Blockchain Hash Verified: 0x88F9...42E1\nData Integrity: 100%");
            }, 2000);
        }

        // 4. Disable PrintScreen & Shortcuts
        window.addEventListener('keyup', (e) => {
            if (e.key === 'PrintScreen') {
                document.body.style.display = 'none';
                alert("Hành động chụp màn hình bị cấm. Hệ thống đã ghi nhật ký!");
            }
        });
        // Hàm thay đổi ảnh trong khu vực soi tài liệu (Section 2)
        function changeInspectorImage(element) {
            const mainImg = document.getElementById('target-image');
            const lens = document.getElementById('lens');
            const newSrc = element.querySelector('img').src.replace('&w=200', '&w=2000'); // Lấy ảnh chất lượng cao hơn

            // 1. Hiệu ứng chuyển cảnh mượt bằng GSAP
            gsap.to(mainImg, {
                opacity: 0,
                scale: 0.95,
                duration: 0.3,
                onComplete: () => {
                    mainImg.src = newSrc;
                    // Cập nhật background cho kính lúp ngay lập tức để tránh lệch ảnh cũ
                    lens.style.backgroundImage = `url('${newSrc}')`;

                    gsap.to(mainImg, {
                        opacity: 1,
                        scale: 1,
                        duration: 0.5,
                        ease: "power2.out"
                    });
                }
            });

            // 2. Cập nhật UI cho thumbnails (Border highlight)
            const allThumbs = element.parentElement.children;
            for (let thumb of allThumbs) {
                thumb.classList.remove('border-blue-500', 'opacity-100');
                thumb.classList.add('border-white/10', 'opacity-50');
                const overlay = thumb.querySelector('.bg-blue-500/20');
                if (overlay) overlay.remove();
            }

            element.classList.add('border-blue-500', 'opacity-100');
            element.classList.remove('border-white/10', 'opacity-50');

            // Thêm lớp phủ xanh cho ảnh đang chọn
            const highlight = document.createElement('div');
            highlight.className = "absolute inset-0 bg-blue-500/20";
            element.appendChild(highlight);
        }
        // ----------------------------- section 3 ----------------------------- //
        // 1. Hiệu ứng "The Flowing Pulse" - Chuyển sang màu Amber khi dừng lại
        const pulseCircle = document.getElementById('transport-pulse');
        const pathLine = document.getElementById('transport-path');

        function triggerWarning() {
            gsap.to(pulseCircle, {
                fill: '#f59e0b',
                duration: 0.5
            });
            gsap.to(pathLine, {
                stroke: 'rgba(245, 158, 11, 0.4)',
                duration: 0.5
            });
            console.log("ALERT: Transport delay detected!");
        }

        // 2. Dispatch Signal & Mechanical Sound Effect
        document.getElementById('dispatch-btn').addEventListener('click', function() {
            const btn = this;
            // Giả lập âm thanh cơ khí
            const audio = new Audio('https://www.soundjay.com/mechanical/mechanical-clonk-1.mp3');
            audio.volume = 0.3;
            audio.play().catch(() => {});

            gsap.to(btn, {
                scale: 1.05,
                backgroundColor: '#10b981',
                duration: 0.2,
                yoyo: true,
                repeat: 1,
                onComplete: () => {
                    btn.innerHTML = '<i class="ri-checkbox-circle-line mr-2"></i> IN TRANSIT';
                }
            });
        });

        // 3. Handover OTP Logic Mockup
        function verifyOTP(input) {
            if (input.value === "1234") {
                gsap.to(input.parentElement.parentElement, {
                    opacity: 1,
                    duration: 0.5
                });
                alert("Handover Verified via Blockchain.");
            }
        }

        // 4. GPS Auto-fetch (Dành cho Mobile View)
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    console.log(`LAT: ${position.coords.latitude}, LNG: ${position.coords.longitude}`);
                });
            }
        }

        // Scroll Trigger cho Section 3
        gsap.from("#logistics-vault .animate-on-scroll", {
            scrollTrigger: {
                trigger: "#logistics-vault",
                start: "top 80%",
            },
            y: 50,
            opacity: 0,
            duration: 1,
            stagger: 0.2
        });

        // ----------------------------- section 4 ----------------------------- //
        // 1. Hiệu ứng "The Deep Scan"
        function startDeepScan() {
            const laser = document.getElementById('laser-scanner');
            laser.classList.remove('hidden');

            // Laser quét từ trên xuống
            gsap.fromTo(laser, {
                top: '0%'
            }, {
                top: '100%',
                duration: 3,
                ease: "power1.inOut",
                onComplete: () => {
                    laser.classList.add('hidden');
                    triggerBlockchainSeal(); // Sau khi quét xong thì đóng dấu
                }
            });

            // Hiệu ứng các hàng dữ liệu rung nhẹ (giả lập audit)
            gsap.to('.env-card', {
                x: 2,
                duration: 0.1,
                repeat: 10,
                yoyo: true,
                ease: "none"
            });
        }

        // 2. Hiệu ứng "Blockchain Seal" (Digital Wax Seal)
        function triggerBlockchainSeal() {
            const seal = document.getElementById('wax-seal');

            gsap.to(seal, {
                opacity: 1,
                scale: 1,
                duration: 0.8,
                ease: "back.out(1.7)",
                onComplete: () => {
                    // Hiệu ứng "tan chảy" nhẹ vào nền
                    gsap.to(seal, {
                        opacity: 0.2,
                        duration: 2,
                        delay: 1,
                        filter: "blur(5px)"
                    });
                    alert("INTEGRITY SEALED: All assets verified on Blockchain.");
                }
            });
        }

        // 3. Hiệu ứng "Alert Cascading" (Giả lập sự cố môi trường)
        function simulateEnvironmentalAlert() {
            const humidityCard = document.getElementById('humidity-sensor');
            humidityCard.classList.add('emergency-alert');

            // Thông báo cho Admin
            console.warn("ALERT: Humidity level deviation detected in Central Vault!");
        }

        // Kích hoạt alert sau 10 giây để demo
        setTimeout(simulateEnvironmentalAlert, 10000);

        // 4. Scroll Reveal cho Section 4
        gsap.from("#sentinel-audit .animate-on-scroll", {
            scrollTrigger: {
                trigger: "#sentinel-audit",
                start: "top 80%",
            },
            y: 30,
            opacity: 0,
            duration: 0.8,
            stagger: 0.2
        });

        // ----------------------------- section 5 ----------------------------- //
        // Đảm bảo biến này nằm ngoài cùng
        let isDirty = false;

        function openVaultPanel(plateData = null) {
            const panel = document.getElementById('vault-panel');
            const overlay = document.getElementById('vault-overlay');
            const mainGrid = document.getElementById('inventory-container');
            const title = document.getElementById('panel-title');
            const formElement = document.querySelector('#vault-panel form');

            // Các ô nhập liệu
            const inputId = document.getElementById('input-plate-id');
            const inputPlate = document.getElementById('input-plate');
            const inputPrice = document.getElementById('input-price');
            const inputAddress = document.getElementById('input-address');
            const selectCategory = document.getElementById('input-category');
            const selectType = document.getElementById('input-vehicle-type');

            // 1. KHÓA CUỘN TRANG CHÍNH
            document.body.style.overflow = 'hidden';

            // 2. HIỆU ỨNG MỞ PANEL
            overlay.classList.remove('hidden');
            overlay.style.opacity = "1";
            setTimeout(() => {
                panel.style.transform = "translateX(0)";
            }, 10);

            // 3. HIỆU ỨNG LÀM MỜ NỀN
            if (mainGrid) {
                mainGrid.style.pointerEvents = "none";
                mainGrid.style.transform = "scale(0.98)";
                mainGrid.style.filter = "blur(4px)";
                mainGrid.style.transition = "all 0.5s ease";
            }

            // 4. LOGIC ĐỔ DỮ LIỆU
            if (plateData && typeof plateData === 'object') {
                // --- CHẾ ĐỘ SỬA (EDIT) ---
                title.innerText = "Edit Asset: " + plateData.plate_number;

                // Gán ID vào input ẩn (BẮT BUỘC để PHP không tạo mới)
                if (inputId) inputId.value = plateData.id;

                // Gán giá trị vào các ô input
                if (inputPlate) inputPlate.value = plateData.plate_number;
                if (inputPrice) inputPrice.value = Math.floor(plateData.starting_price);
                if (inputAddress) inputAddress.value = plateData.address || '';
                if (selectCategory) selectCategory.value = plateData.category || 'Ngũ quý';

                if (selectType) {
                    selectType.value = plateData.vehicle_type;
                    // Cập nhật giao diện nút bấm Car/Moto
                    if (typeof switchType === "function") switchType(plateData.vehicle_type);
                }

                simulateSkeletonLoad();
            } else {
                // --- CHẾ ĐỘ THÊM MỚI (ADD) ---
                title.innerText = "Add New Asset";

                // Reset toàn bộ form
                if (formElement) formElement.reset();

                // XÓA TRẮNG ID (Để PHP hiểu là Insert)
                if (inputId) inputId.value = "";

                // Reset preview biển số về mặc định
                document.getElementById('preview-text').innerText = "XX-XXX.XX";

                // Mặc định chọn Car
                if (typeof switchType === "function") switchType('Car');
            }

            // 5. CẬP NHẬT PREVIEW BIỂN SỐ
            if (typeof updatePreview === "function") updatePreview();
        }



        function closeVaultPanel() {
            // Nếu đang nhập dở thì hỏi, nếu không thì đóng luôn
            if (isDirty) {
                if (!confirm("Dữ liệu chưa được lưu, bạn có chắc muốn thoát?")) return;
            }

            const panel = document.getElementById('vault-panel');
            const overlay = document.getElementById('vault-overlay');
            const mainGrid = document.getElementById('inventory-container');

            // 1. Đẩy panel ra ngoài
            panel.style.transform = "translateX(100%)";

            // 2. Đợi animation chạy xong rồi mới ẩn overlay (khoảng 500ms)
            setTimeout(() => {
                overlay.classList.add('hidden');

                // 3. QUAN TRỌNG: Trả lại quyền bấm (pointer-events) cho grid
                if (mainGrid) {
                    mainGrid.style.pointerEvents = "auto";
                    mainGrid.style.transform = "scale(1)";
                    mainGrid.style.filter = "none";
                }
            }, 500);

            isDirty = false;
        }

        function switchType(type) {
            const preview = document.getElementById('plate-preview');
            const btnCar = document.getElementById('btn-car');
            const btnMoto = document.getElementById('btn-moto');
            const typeHidden = document.getElementById('input-vehicle-type');

            typeHidden.value = type;

            if (type === 'Car') {
                // Style cho ô tô (ngang)
                preview.className = "plate-morph bg-white border-2 border-gray-300 rounded flex items-center justify-center car-plate shadow-lg w-[200px] h-[45px]";
                btnCar.className = "py-4 rounded-2xl border border-cyan-500 bg-cyan-500/10 text-cyan-400 text-xs font-bold uppercase";
                btnMoto.className = "py-4 rounded-2xl border border-white/10 bg-white/5 text-white/40 text-xs font-bold uppercase";
            } else {
                // Style cho xe máy (vuông)
                preview.className = "plate-morph bg-white border-2 border-gray-300 rounded flex items-center justify-center moto-plate shadow-lg w-[120px] h-[80px] text-center";
                btnMoto.className = "py-4 rounded-2xl border border-cyan-500 bg-cyan-500/10 text-cyan-400 text-xs font-bold uppercase";
                btnCar.className = "py-4 rounded-2xl border border-white/10 bg-white/5 text-white/40 text-xs font-bold uppercase";
            }
        }

        function updatePreview() {
            const val = document.getElementById('input-plate').value;
            const previewText = document.getElementById('preview-text');
            const type = document.getElementById('input-vehicle-type').value;

            if (val) {
                if (type === 'Motorbike' && val.includes('-')) {
                    // Hiển thị kiểu 2 dòng cho xe máy nếu có dấu gạch ngang
                    const parts = val.split('-');
                    previewText.innerHTML = `<div class='flex flex-col'><span class='text-sm border-b'>${parts[0]}</span><span>${parts[1]}</span></div>`;
                } else {
                    previewText.innerText = val;
                }
            } else {
                previewText.innerText = "XX-XXX.XX";
            }
            isDirty = true;
        }

        function simulateSkeletonLoad() {
            // Hiển thị khung xương trong 1s trước khi hiện dữ liệu thực
            const form = document.querySelector('.space-y-6');
            form.classList.add('opacity-20');
            setTimeout(() => form.classList.remove('opacity-20'), 800);
        }

        // ----------------------------- section 6 ----------------------------- //
    </script>

    </html>