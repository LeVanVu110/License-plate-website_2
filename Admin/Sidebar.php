<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/MotionPathPlugin.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,300&family=Space+Mono:wght@400;700&family=Inter:wght@300;400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        /* -- ----------------------------- sidebar -----------------------------  */
        /* Chế độ thu gọn (Collapsed) */
        #obsidian-sidebar.collapsed {
            width: 80px;
        }

        /* Tia sáng Sapphire (Hover Beam) */
        .nav-item:hover .nav-beam {
            height: 20px;
            box-shadow: 0 0 10px #22d3ee;
        }

        /* Active State Glow */
        .nav-item.active i {
            color: #22d3ee !important;
            filter: drop-shadow(0 0 8px rgba(34, 211, 238, 0.6));
        }

        .nav-item.active span {
            color: white !important;
        }

        .nav-item {
            text-decoration: none !important;
            /* Bỏ gạch chân */
            display: flex;
            align-items: center;
            /* Giữ nguyên các thuộc tính cũ của bạn */
        }

        .nav-item:hover,
        .nav-item.active {
            color: inherit;
            /* Giữ màu trắng/cyan của bạn */
        }

        /* Hiệu ứng kính Obsidian */
        #obsidian-sidebar {
            background: linear-gradient(180deg, rgba(16, 28, 79, 0.95) 0%, rgba(0, 8, 20, 0.98) 100%);
            /* box-shadow: 20px 0 50px rgba(0, 0, 0, 0.5); */
        }

        /* Tối ưu Mobile */
        @media (max-width: 768px) {
            #obsidian-sidebar {
                transform: translateX(-100%);
                width: 280px !important;
            }

            #obsidian-sidebar.mobile-active {
                transform: translateX(0);
            }

            #obsidian-sidebar.collapsed {
                width: 280px;
            }

            /* Mobile không thu gọn icon */
        }

        /* ----------------------------- section 1 -----------------------------  */


        /* ----------------------------- section 2 -----------------------------  */

        /* ----------------------------- section 3 -----------------------------  */

        /* ----------------------------- section 4 -----------------------------  */

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>
<?php

// 1. Lấy tên file hiện tại (ví dụ: MarketControl.php)
$current_page = basename($_SERVER['PHP_SELF']);
?>

<body>
    <!-- ----------------------------- sidebar -----------------------------  -->

    <aside id="obsidian-sidebar" class="fixed left-0 top-0 h-screen z-50 bg-[#020617]/80 backdrop-blur-2xl border-r border-white/5 transition-all duration-500 w-[260px] group">

        <div class="p-6 mb-8 flex items-center gap-4" style="margin-top: 50px;">
            <div class="w-10 h-10 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-lg flex items-center justify-center shadow-[0_0_20px_rgba(6,182,212,0.5)]">
                <i class="ri-gemstone-fill text-white text-xl"></i>
            </div>
            <span class="jetbrains text-white font-bold tracking-[2px] opacity-100 group-[.collapsed]:opacity-0 transition-opacity duration-300">KHO BÁU SỐ</span>
        </div>

        <nav class="mt-8 px-4 space-y-2 flex-1 overflow-y-auto custom-scrollbar">
            <a href="Dashboard.php" class="nav-item group/item relative flex items-center gap-4 p-3 rounded-xl transition-all <?php echo ($current_page == 'Dashboard.php' || $current_page == '') ? 'active' : ''; ?>" style="text-decoration: none;">
                <div class="nav-icon-box">
                    <i class="ri-dashboard-3-line text-white/50"></i>
                </div>
                <span class="nav-label text-white/50">Dashboard</span>
                <div class="active-indicator"></div>
            </a>

            <a href="MarketControl.php" class="nav-item group/item relative flex items-center gap-4 p-3 rounded-xl transition-all <?php echo ($current_page == 'MarketControl.php') ? 'active' : ''; ?>" style="text-decoration: none;">
                <div class="nav-icon-box">
                    <i class="ri-exchange-funds-line text-white/50"></i>
                </div>
                <span class="nav-label text-white/50">Market Control</span>
                <div class="active-indicator"></div>
            </a>
            <a href="VaultManager.php" class="nav-item group/item relative flex items-center gap-4 p-3 rounded-xl transition-all <?php echo ($current_page == 'VaultManager.php') ? 'active' : ''; ?>" style="text-decoration: none;">
                <div class="nav-icon-box">
                    <!-- <i class="ri-exchange-funds-line text-white/50"></i> -->
                    <i class="ri-safe-2-line text-xl text-white/50 group-hover/item:text-cyan-400"></i>
                </div>
                <span class="nav-label text-white/50">Vault Manager</span>
                <div class="active-indicator"></div>
            </a>
            <a href="VipVelations.php" class="nav-item group/item relative flex items-center gap-4 p-3 rounded-xl transition-all <?php echo ($current_page == 'VipVelations.php') ? 'active' : ''; ?>" style="text-decoration: none;">
                <div class="nav-icon-box">
                    <!-- <i class="ri-exchange-funds-line text-white/50"></i> -->
                    <i class="ri-user-star-line text-xl text-white/50 group-hover/item:text-cyan-400"></i>
                </div>
                <span class="nav-label text-white/50">Vip Velations</span>
                <div class="active-indicator"></div>
            </a>

            <a href="Financial.php" class="nav-item group/item relative flex items-center gap-4 p-3 rounded-xl transition-all <?php echo ($current_page == 'Financial.php') ? 'active' : ''; ?>" style="text-decoration: none;">
                <div class="nav-icon-box">
                    <!-- <i class="ri-exchange-funds-line text-white/50"></i> -->
                    <i class="ri-wallet-3-line text-xl text-white/50 group-hover/item:text-cyan-400"></i>

                </div>
                <span class="nav-label text-white/50">Financial Ledger</span>
                <div class="active-indicator"></div>
            </a>
            <a href="Security.php" class="nav-item group/item relative flex items-center gap-4 p-3 rounded-xl transition-all <?php echo ($current_page == 'Security.php') ? 'active' : ''; ?>" style="text-decoration: none;">
                <div class="nav-icon-box">
                    <i class="ri-shield-keyhole-line text-xl text-white/50 group-hover/item:text-cyan-400"></i>

                </div>
                <span class="nav-label text-white/50">Financial Ledger</span>
                <div class="active-indicator"></div>
            </a>



            <!-- <a href="#" class="nav-item group/item relative flex items-center gap-4 p-3 rounded-xl transition-all">
                <div class="nav-beam absolute left-0 w-1 h-0 bg-cyan-400 rounded-full transition-all duration-300"></div>
                <i class="ri-shield-keyhole-line text-xl text-white/50 group-hover/item:text-cyan-400"></i>
                <span class="jetbrains text-xs text-white/50 group-hover/item:text-white transition-opacity group-[.collapsed]:opacity-0">SECURITY CENTER</span>
            </a> -->
        </nav>

        <div class="absolute bottom-0 left-0 w-full p-4 border-t border-white/5 bg-black/20">
            <div class="flex items-center gap-3 mb-4 group-[.collapsed]:justify-center">
                <img src="https://ui-avatars.com/api/?name=Admin&background=06b6d4&color=fff" class="w-8 h-8 rounded-lg border border-cyan-500/30" alt="Avatar">
                <div class="group-[.collapsed]:hidden">
                    <p class="text-[10px] text-white font-bold jetbrains uppercase">Alex Sapphire</p>
                    <p class="text-[8px] text-white/40 jetbrains uppercase">Super Admin</p>
                </div>
            </div>
            <div class="flex gap-2 group-[.collapsed]:flex-col group-[.collapsed]:items-center relative">

                <div class="relative group/settings flex-1 w-full">
                    <button class="w-full p-2 hover:bg-white/5 rounded-lg text-white/40 group-hover/settings:text-white transition-colors flex justify-center items-center" title="Settings">
                        <i class="ri-settings-4-line"></i>
                    </button>

                    <div class="absolute bottom-full left-0 mb-2 w-48 bg-[#0a0a0a] border border-white/10 rounded-xl shadow-2xl opacity-0 invisible group-hover/settings:opacity-100 group-hover/settings:visible transition-all duration-300 z-[100] overflow-hidden">
                        <div class="p-1 flex flex-col">
                            <a href="../index.php" class="flex items-center gap-3 px-3 py-2 text-[10px] text-cyan-400 hover:text-white hover:bg-cyan-500/20 rounded-lg transition-all border-b border-white/5 mb-1">
                                <i class="ri-home-4-line"></i>
                                <span class="uppercase tracking-widest font-bold">Quay về Trang chủ</span>
                            </a>

                            <a href="Settings.php" class="flex items-center gap-3 px-3 py-2 text-[10px] text-white/60 hover:text-white hover:bg-white/5 rounded-lg transition-all">
                                <i class="ri-equalizer-line text-cyan-400"></i>
                                <span class="uppercase tracking-widest font-bold">Cài đặt chung</span>
                            </a>

                            <a href="Notifications.php" class="flex items-center gap-3 px-3 py-2 text-[10px] text-white/60 hover:text-white hover:bg-white/5 rounded-lg transition-all">
                                <i class="ri-notification-3-line text-amber-400"></i>
                                <span class="uppercase tracking-widest font-bold">Thông báo</span>
                            </a>

                            <a href="Infrastructure.php" class="flex items-center gap-3 px-3 py-2 text-[10px] text-white/60 hover:text-white hover:bg-white/5 rounded-lg transition-all">
                                <i class="ri-node-tree text-purple-400"></i>
                                <span class="uppercase tracking-widest font-bold font-mono">Infrastructure</span>
                            </a>
                        </div>
                    </div>
                </div>

                <a href="logout.php" class="flex-1 p-2 hover:bg-red-500/10 rounded-lg text-white/40 hover:text-red-400 transition-colors flex justify-center items-center w-full" title="Logout">
                    <i class="ri-logout-box-r-line"></i>
                </a>
            </div>
        </div>
    </aside>

    <button id="sidebar-toggle" class="fixed top-4 left-4 z-[60] md:hidden w-10 h-10 bg-white/5 backdrop-blur-md border border-white/10 rounded-xl flex items-center justify-center text-white">
        <i class="ri-menu-2-line"></i>
    </button>
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 hidden opacity-0 transition-opacity duration-300"></div>

    <!-- ----------------------------- section 1 -----------------------------  -->

    <!-- ----------------------------- section 2 -----------------------------  -->

    <!-- ----------------------------- section 3 -----------------------------  -->

    <!-- ----------------------------- section 4 -----------------------------  -->

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

</body>
<script>
    // -- ----------------------------- sidebar -----------------------------//
    document.addEventListener("DOMContentLoaded", () => {
        const sidebar = document.querySelector('#obsidian-sidebar');
        const toggleBtn = document.querySelector('#sidebar-toggle');
        const overlay = document.querySelector('#sidebar-overlay');
        const navItems = document.querySelectorAll('.nav-item');

        // -------------------------------------------------------------------------
        // MỚI: Logic tự động Active dựa trên URL (Fix lỗi Dashboard luôn sáng)
        // -------------------------------------------------------------------------
        const currentPath = window.location.pathname.split("/").pop() || "index.php";

        navItems.forEach(item => {
            // Lấy nội dung onclick để biết item này trỏ đến file nào
            const onClickAttr = item.getAttribute('onclick') || "";

            // Nếu URL hiện tại nằm trong chuỗi onclick, thì active nó
            if (onClickAttr.includes(currentPath)) {
                navItems.forEach(i => i.classList.remove('active'));
                item.classList.add('active');
            }
        });

        // 1. Expand/Collapse Logic (Tablet & Manual)
        const toggleSidebar = (isCollapsed) => {
            if (isCollapsed) {
                gsap.to(sidebar, {
                    width: 80,
                    ease: "elastic.out(1, 0.8)",
                    duration: 0.8
                });
                sidebar.classList.add('collapsed');
            } else {
                gsap.to(sidebar, {
                    width: 260,
                    ease: "elastic.out(1, 0.8)",
                    duration: 0.8
                });
                sidebar.classList.remove('collapsed');
            }
        };

        // Auto-collapse on Tablet
        if (window.innerWidth <= 1280 && window.innerWidth > 768) {
            toggleSidebar(true);
        }

        // Hover to expand on Tablet
        sidebar.addEventListener('mouseenter', () => {
            if (window.innerWidth <= 1280 && window.innerWidth > 768) toggleSidebar(false);
        });
        sidebar.addEventListener('mouseleave', () => {
            if (window.innerWidth <= 1280 && window.innerWidth > 768) toggleSidebar(true);
        });

        // 2. Mobile Drawer Logic
        toggleBtn.addEventListener('click', () => {
            const isActive = sidebar.classList.toggle('mobile-active');
            overlay.classList.toggle('hidden', !isActive);
            gsap.to(overlay, {
                opacity: isActive ? 1 : 0,
                duration: 0.3
            });

            // Icon animation
            gsap.to(toggleBtn.querySelector('i'), {
                rotate: isActive ? 90 : 0,
                duration: 0.3
            });
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('mobile-active');
            gsap.to(overlay, {
                opacity: 0,
                duration: 0.3,
                onComplete: () => overlay.classList.add('hidden')
            });
        });

        // 3. Active State Click (Giữ lại để đổi màu nhanh khi click)
        navItems.forEach(item => {
            item.addEventListener('click', function(e) {
                navItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');

                // Haptic feedback
                if (window.navigator.vibrate) window.navigator.vibrate(5);
            });
        });

        // 4. Swipe to open (Mobile)
        let touchStartX = 0;
        document.addEventListener('touchstart', e => touchStartX = e.touches[0].clientX);
        document.addEventListener('touchend', e => {
            const touchEndX = e.changedTouches[0].clientX;
            if (touchStartX < 30 && touchEndX > 100) { // Vuốt từ mép trái
                toggleBtn.click();
            }
        });
    });
    // ----------------------------- section 1 ----------------------------- //

    // ----------------------------- section 2 ----------------------------- //

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>