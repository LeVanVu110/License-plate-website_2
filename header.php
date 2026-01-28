<!DOCTYPE html>
<html lang="vi">
<?php
session_start();
require_once "config.php";
require_once "Models/db.php";
require_once "Models/Plate.php";
require_once 'Models/News.php';

$plateModel = new Plate();
$data = $plateModel->get(); // Lấy mảng ['cars' => [...], 'motorbikes' => [...]]

$currentUser = null;
if (isset($_SESSION['user_id'])) {
    $userId = intval($_SESSION['user_id']);
    // Truy vấn thông tin từ bảng customers
    $sql = "SELECT * FROM customers WHERE id = $userId";
    $result = Db::$connection->query($sql);

    if ($result && $result->num_rows > 0) {
        $currentUser = $result->fetch_assoc();
    }
}
// PHẦN THÔNG BÁO - ĐÃ SỬA LỖI DẤU CHẤM THÀNH MŨI TÊN
$user_id = $_SESSION['user_id'] ?? 0;
$notifications_dropdown = [];

if ($user_id > 0) {
    $sql_nav = "SELECT * FROM notifications WHERE receiver_id = ? ORDER BY created_at DESC LIMIT 5";
    // Thay dấu . bằng ->
    $stmt_nav = Db::$connection->prepare($sql_nav);
    $stmt_nav->bind_param("i", $user_id);
    $stmt_nav->execute();
    $notifications_dropdown = $stmt_nav->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biển Số Đẹp - Glassmorphism Interface</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/MotionPathPlugin.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,300&family=Space+Mono:wght@400;700&family=Inter:wght@300;400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy-dark: #001A33;
            --electric-blue: #007FFF;
            --glass-bg: rgba(255, 255, 255, 0.7);
        }

        body {
            background: linear-gradient(135deg, #f0f4f8 0%, #d7e2eb 100%);
            min-height: 200vh;
            /* Để test hiệu ứng scroll */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .glass-header {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(192, 192, 192, 0.3);
        }

        .chrome-text {
            background: linear-gradient(180deg, #ffffff 0%, #a0a0a0 50%, #ffffff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 2px 2px rgba(0, 0, 0, 0.1));
            font-weight: 800;
        }

        .glow-hover {
            position: relative;
            overflow: hidden;
        }

        .glow-effect {
            position: absolute;
            width: 50px;
            height: 50px;
            background: var(--electric-blue);
            filter: blur(30px);
            border-radius: 50%;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
        }

        /* Mobile Bottom Bar */
        .bottom-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 24px 24px 0 0;
        }

        .status-pulse {
            box-shadow: 0 0 0 0 rgba(0, 242, 255, 0.7);
            animation: pulse-neon 2s infinite;
        }

        @keyframes pulse-neon {
            0% {
                box-shadow: 0 0 0 0 rgba(0, 242, 255, 0.5);
            }

            70% {
                box-shadow: 0 0 0 8px rgba(0, 242, 255, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(0, 242, 255, 0);
            }
        }


        #account-menu {
            display: block !important;
            /* Luôn cho phép block để GSAP điều khiển opacity */
            pointer-events: none;
            /* Mặc định không cho bấm khi đang ẩn */
        }

        #account-menu.is-visible {
            pointer-events: auto;
            /* Cho phép bấm khi đang hiện */
        }

        @media (max-width: 768px) {
            #search-input {
                width: 131px;
            }

            /* Đảm bảo menu thông báo không bị văng ra khỏi màn hình mobile */
            #notification-menu {
                right: -50px;
                /* Điều chỉnh lại vị trí để vừa màn hình điện thoại */
                width: 90vw;
                /* Cho chiều ngang rộng ra dễ nhìn trên mobile */
                max-width: 320px;
            }

            /* Đảm bảo vùng bấm đủ lớn */
            #notification-btn {
                min-width: 40px;
                min-height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    <div id="top-bar" class="w-full bg-[#001A33] text-white py-1 px-6 flex justify-between items-center text-xs z-[100] relative">
        <span><i class="ri-notification-3-line mr-2"></i>Đang có 1,250 biển số mới lên sàn</span>
        <span>Hotline: 1900 8888</span>
    </div>

    <header id="main-header" class="glass-header sticky top-0 w-full z-[100] transition-all duration-300 h-20 flex flex-col justify-center">
        <div class="container mx-auto px-4 md:px-6 flex items-center justify-between">

            <div class="logo flex items-center">
                <a href="index.php"><span class="chrome-text text-xl md:text-2xl tracking-tighter uppercase">Biển Số Đẹp</span></a>
            </div>

            <nav class="hidden md:flex items-center space-x-8 text-[#001A33] font-medium">
                <a href="Digital_Vault.php" class="nav-item relative py-2">Kho Số</a>
                <a href="dau_gia.php" class="nav-item relative py-2">Đấu Giá</a>
                <a href="dinh_gia_AI.php" class="nav-item relative py-2">Định Giá AI</a>
                <a href="tin_tuc.php" class="nav-item relative py-2">Tin Tức</a>
            </nav>

            <div class="flex items-center space-x-4">
                <div class="relative">
                    <button id="notification-btn" class="p-2 text-[#001A33]/70 hover:text-[#007FFF] transition-all duration-300 relative bg-white/50 rounded-full hover:bg-white shadow-sm border border-transparent hover:border-[#007FFF]/20">
                        <i class="ri-notification-3-line text-xl"></i>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 border border-white rounded-full"></span>
                    </button>

                    <div id="notification-menu" class="absolute top-full right-0 w-80 pt-4 opacity-0 invisible translate-y-2 transition-all duration-300 z-[120]">
                        <div class="bg-white/95 backdrop-blur-2xl border border-white/40 rounded-2xl shadow-2xl overflow-hidden">
                            <div class="p-4 border-b border-[#001A33]/5 flex justify-between items-center">
                                <h3 class="text-[11px] font-bold tracking-widest text-[#001A33]">THÔNG BÁO</h3>
                                <?php
                                $unread_count = count(array_filter($notifications_dropdown, function ($n) {
                                    return !$n['is_read'];
                                }));
                                if ($unread_count > 0):
                                ?>
                                    <span class="text-[9px] bg-[#007FFF]/10 text-[#007FFF] px-2 py-0.5 rounded-full font-bold"><?= $unread_count ?> MỚI</span>
                                <?php endif; ?>
                            </div>

                            <div class="max-h-[300px] overflow-y-auto">
                                <?php if (empty($notifications_dropdown)): ?>
                                    <div class="p-6 text-center text-[10px] text-slate-400 uppercase tracking-widest">
                                        Không có thông báo mới
                                    </div>
                                <?php else: ?>
                                    <?php foreach ($notifications_dropdown as $noti): ?>
                                        <div class="p-4 hover:bg-[#007FFF]/5 transition-colors cursor-pointer border-b border-[#001A33]/5 relative <?= !$noti['is_read'] ? 'bg-blue-50/30' : '' ?>">
                                            <?php if (!$noti['is_read']): ?>
                                                <div class="absolute left-2 top-1/2 -translate-y-1/2 w-1 h-1 bg-[#007FFF] rounded-full"></div>
                                            <?php endif; ?>

                                            <p class="text-[11px] text-[#001A33] font-medium leading-snug">
                                                <span class="font-bold text-[#007FFF]"><?= htmlspecialchars($noti['title']) ?>:</span>
                                                <?= htmlspecialchars($noti['content']) ?>
                                            </p>
                                            <p class="text-[9px] text-[#001A33]/40 mt-1">
                                                <?php
                                                // Hiển thị thời gian tương đối đơn giản
                                                echo date('H:i d/m', strtotime($noti['created_at']));
                                                ?>
                                            </p>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <a href="account_notifications.php" class="block w-full py-3 text-center text-[10px] font-bold text-[#007FFF] hover:bg-gray-50 transition-all uppercase tracking-tighter border-t border-[#001A33]/5">
                                Xem tất cả thông báo
                            </a>
                        </div>
                    </div>
                </div>

                <?php if ($currentUser): ?>
                    <div class="relative" id="account-dropdown-trigger">
                        <div class="flex items-center gap-3 cursor-pointer p-1 rounded-full hover:bg-white/20 transition-all duration-500 relative z-20">
                            <div class="hidden sm:block text-right pointer-events-none">
                                <p class="text-[8px] text-[#001A33]/50 tracking-[1px] uppercase font-bold">
                                    Thành viên <?= htmlspecialchars($currentUser['rank']) ?>
                                </p>
                                <p class="text-[11px] text-[#001A33] font-semibold leading-tight">
                                    <?= htmlspecialchars($currentUser['full_name']) ?>
                                </p>
                            </div>
                            <div class="relative pointer-events-none">
                                <div class="w-10 h-10 rounded-full border-2 border-[#007FFF]/30 p-0.5 overflow-hidden shadow-lg bg-white">
                                    <img src="<?= htmlspecialchars($currentUser['avatar']) ?>" alt="Avatar" class="w-full h-full rounded-full object-cover">
                                </div>
                                <div class="absolute bottom-0 right-0 w-3 h-3 bg-[#00f2ff] border-2 border-white rounded-full status-pulse"></div>
                            </div>
                        </div>

                        <div id="account-menu" class="absolute top-full right-0 w-64 pt-4 opacity-0 invisible group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition-all duration-300 z-[120]">
                            <div class="bg-white/95 backdrop-blur-2xl border border-white/40 rounded-2xl shadow-2xl p-5 space-y-3">

                                <?php
                                $adminRoles = [1, 2, 3, 4, 5];
                                if (isset($currentUser['role_id']) && in_array($currentUser['role_id'], $adminRoles)):
                                ?>
                                    <a href="Admin/Dashboard.php" class="flex items-center justify-between text-[11px] font-bold tracking-wider text-blue-600 hover:text-[#007FFF] transition-all transform hover:translate-x-2">
                                        QUẢN TRỊ VIÊN <i class="ri-admin-line"></i>
                                    </a>
                                    <div class="h-[1px] bg-[#001A33]/5 my-2"></div>
                                <?php endif; ?>

                                <a href="account_kho_bau.php" class="flex items-center justify-between text-[11px] font-bold tracking-wider text-[#001A33]/70 hover:text-[#007FFF] transition-all transform hover:translate-x-2">
                                    KHO BÁU CỦA TÔI <i class="ri-gem-line"></i>
                                </a>

                                <a href="account_lich_su_dau_gia.php" class="flex items-center justify-between text-[11px] font-bold tracking-wider text-[#001A33]/70 hover:text-[#007FFF] transition-all transform hover:translate-x-2">
                                    LỊCH SỬ ĐẤU GIÁ <i class="ri-history-line"></i>
                                </a>

                                <div class="h-[1px] bg-[#001A33]/5 my-2"></div>

                                <a href="Admin/logout.php" class="flex items-center justify-between text-[11px] font-bold tracking-wider text-red-500 hover:scale-105 transition-all">
                                    ĐĂNG XUẤT <i class="ri-logout-box-r-line"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="relative" id="guest-trigger">
                        <div class="flex items-center gap-3 cursor-pointer p-1 pr-4 rounded-full bg-[#007FFF]/10 hover:bg-[#007FFF]/20 border border-[#007FFF]/20 transition-all duration-500 relative z-20">
                            <div class="relative pointer-events-none">
                                <div class="w-10 h-10 rounded-full border-2 border-dashed border-[#007FFF]/30 p-0.5 overflow-hidden shadow-md bg-white/50 flex items-center justify-center">
                                    <i class="ri-user-3-line text-[#007FFF] text-xl"></i>
                                </div>
                            </div>
                            <div class="hidden sm:block text-left pointer-events-none">
                                <p class="text-[8px] text-[#001A33]/50 tracking-[1px] uppercase font-bold">Chào mừng bạn</p>
                                <p class="text-[11px] text-[#007FFF] font-bold leading-tight">ĐĂNG NHẬP NGAY</p>
                            </div>
                        </div>

                        <div id="guest-menu" class="absolute top-full right-0 w-56 pt-4 opacity-0 invisible translate-y-2  transition-all duration-300 z-[120]">
                            <div class="bg-white/95 backdrop-blur-2xl border border-white/40 rounded-2xl shadow-2xl p-5 space-y-4">
                                <p class="text-[10px] text-[#001A33]/60 leading-relaxed text-center italic">
                                    Đăng nhập để tham gia đấu giá và nhận ưu đãi VIP.
                                </p>
                                <div class="space-y-2">
                                    <a href="Admin/login.php" class="flex items-center justify-center gap-2 w-full py-2.5 bg-[#007FFF] text-white rounded-xl text-[11px] font-bold tracking-widest hover:bg-[#005bb3] hover:shadow-lg hover:shadow-[#007FFF]/30 transition-all active:scale-95">
                                        ĐĂNG NHẬP <i class="ri-login-box-line"></i>
                                    </a>
                                    <a href="register.php" class="flex items-center justify-center gap-2 w-full py-2.5 bg-white border border-[#007FFF]/30 text-[#007FFF] rounded-xl text-[11px] font-bold tracking-widest hover:bg-gray-50 transition-all">
                                        TẠO TÀI KHOẢN
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <button class="md:hidden text-2xl" id="menu-toggle">
                    <i class="ri-menu-4-line"></i>
                </button>
            </div>
        </div>
    </header>

    <div id="mobile-menu" class="fixed inset-0 bg-[#001A33]/95 backdrop-blur-xl z-[150] flex flex-col items-center justify-center space-y-8 text-white translate-y-[-100%] hidden">
        <button id="close-menu" class="absolute top-6 right-6 text-3xl text-white/50">&times;</button>
        <a href="Digital_Vault.php" class="menu-link text-3xl font-bold">Kho Số</a>
        <a href="dau_gia.php" class="menu-link text-3xl font-bold">Đấu Giá</a>
        <a href="dinh_gia_AI.php" class="menu-link text-3xl font-bold">Định Giá AI</a>
        <a href="tin_tuc.php" class="menu-link text-3xl font-bold">Tin Tức</a>
        <button class="bg-[#007FFF] px-10 py-4 rounded-full text-xl">KÝ GỬI NGAY</button>
    </div>

    <!-- <div class="md:hidden fixed bottom-0 left-0 w-full px-4 pb-4 z-50">
        <div class="bottom-nav flex justify-around items-center py-4 shadow-2xl">
            <a href="#" class="flex flex-col items-center text-[#001A33]"><i class="ri-home-5-line text-xl"></i></a>
            <a href="#" class="flex flex-col items-center text-[#001A33]"><i class="ri-search-2-line text-xl"></i></a>
            <a href="#" class="flex flex-col items-center text-[#001A33]"><i class="ri-phone-line text-xl"></i></a>
            <a href="#" class="flex flex-col items-center text-blue-500"><i class="ri-messenger-line text-xl"></i></a>
        </div>
    </div> -->



    <script>
        // 1. Khởi tạo hiệu ứng GSAP
        gsap.from("#main-header", {
            y: -100,
            opacity: 0,
            duration: 1.2,
            ease: "power4.out"
        });
        gsap.from(".nav-item", {
            opacity: 0,
            y: 20,
            stagger: 0.1,
            duration: 0.8,
            delay: 0.5,
            ease: "back.out(1.7)"
        });

        // 2. Xử lý Header khi Scroll
        window.addEventListener('scroll', () => {
            const header = document.getElementById('main-header');
            const topBar = document.getElementById('top-bar');
            if (window.scrollY > 50) {
                header.style.height = '60px';
                header.style.backgroundColor = 'rgba(255, 255, 255, 0.9)';
                gsap.to(topBar, {
                    y: -50,
                    duration: 0.3
                });
            } else {
                header.style.height = '80px';
                header.style.backgroundColor = 'rgba(255, 255, 255, 0.7)';
                gsap.to(topBar, {
                    y: 0,
                    duration: 0.3
                });
            }
        });

        // 3. Mobile Side Menu (Kho số, Đấu giá...)
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const closeMenu = document.getElementById('close-menu');

        menuToggle?.addEventListener('click', () => {
            mobileMenu.classList.remove('hidden');
            gsap.to(mobileMenu, {
                y: 0,
                duration: 0.8,
                ease: "power4.inOut"
            });
        });

        closeMenu?.addEventListener('click', () => {
            gsap.to(mobileMenu, {
                y: "-100%",
                duration: 0.6,
                ease: "power4.in",
                onComplete: () => mobileMenu.classList.add('hidden')
            });
        });

        // 4. Hàm điều khiển Dropdown (Account/Notification)
        // 4. Hàm điều khiển Dropdown (Account/Notification)
        function toggleDropdown(menuId, forceClose = false) {
            const menu = document.getElementById(menuId);
            if (!menu) return;

            if (forceClose) {
                gsap.to(menu, {
                    autoAlpha: 0,
                    y: 10,
                    duration: 0.2,
                    overwrite: true
                });
                menu.classList.remove('is-open', 'is-visible');
                menu.style.visibility = 'hidden';
            } else {
                const isOpen = menu.classList.contains('is-open');

                // Đóng các cái khác trước khi mở cái mới
                document.querySelectorAll('[id$="-menu"]').forEach(m => {
                    if (m.id !== menuId && m.classList.contains('is-open')) {
                        toggleDropdown(m.id, true);
                    }
                });

                if (!isOpen) {
                    menu.style.visibility = 'visible';
                    menu.classList.add('is-open', 'is-visible');
                    gsap.to(menu, {
                        autoAlpha: 1,
                        y: 0,
                        duration: 0.4,
                        ease: "power2.out"
                    });
                } else {
                    toggleDropdown(menuId, true);
                }
            }
        }

        // 5. Gán sự kiện Click cho các vùng Trigger
        const accountTrigger = document.getElementById('account-dropdown-trigger');
        const guestTrigger = document.getElementById('guest-trigger');
        const notifyBtn = document.getElementById('notification-btn');

        // Xử lý Account/Guest
        [accountTrigger, guestTrigger].forEach(trigger => {
            trigger?.addEventListener('click', (e) => {
                // Nếu bấm vào link thực sự bên trong menu thì cho đi tiếp
                if (e.target.closest('a')) return;

                e.preventDefault();
                e.stopPropagation();
                const menuId = trigger.id === 'account-dropdown-trigger' ? 'account-menu' : 'guest-menu';
                toggleDropdown(menuId);
            });
        });
        // Xử lý Thông báo - Sửa lỗi Mobile
        notifyBtn?.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            toggleDropdown('notification-menu');
        });

        // 6. FIX LỖI "ĐÈ": Đóng dropdown khi bấm ra ngoài nhưng trừ Menu điều hướng
        // 6. Đóng dropdown khi bấm ra ngoài (Fix lỗi đơ Menu Mobile)
        document.addEventListener('click', (e) => {
            // Nếu click vào các link điều hướng chính -> Cho phép nhảy trang
            if (e.target.closest('.nav-item') || e.target.closest('.logo') || e.target.closest('.menu-link')) {
                return;
            }

            const isDropdown = e.target.closest('[id$="-menu"]');
            const isTrigger = e.target.closest('#notification-btn') ||
                e.target.closest('#account-dropdown-trigger') ||
                e.target.closest('#guest-trigger');
            // Nếu click RA NGOÀI cả nút bấm và menu -> Đóng tất cả
            if (!isDropdown && !isTrigger) {
                document.querySelectorAll('[id$="-menu"]').forEach(m => {
                    if (m.classList.contains('is-open')) {
                        toggleDropdown(m.id, true);
                    }
                });
            }
        });

        // 7. Glow Effect Desktop
        document.querySelectorAll('.nav-item').forEach(item => {
            const glow = document.createElement('div');
            glow.className = 'glow-effect';
            item.appendChild(glow);
            item.addEventListener('mousemove', (e) => {
                const rect = item.getBoundingClientRect();
                gsap.to(glow, {
                    opacity: 0.4,
                    x: e.clientX - rect.left - 25,
                    y: e.clientY - rect.top - 25,
                    duration: 0.2
                });
            });
            item.addEventListener('mouseleave', () => gsap.to(glow, {
                opacity: 0,
                duration: 0.3
            }));
        });
    </script>
</body>

</html>