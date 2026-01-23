<!DOCTYPE html>
<html lang="vi">

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
        }
    </style>
</head>
<?php
require_once "config.php";
require_once "Models/db.php";
require_once "Models/Plate.php";
require_once 'Models/News.php';

$plateModel = new Plate();
$data = $plateModel->get(); // Lấy mảng ['cars' => [...], 'motorbikes' => [...]]


?>

<body>

    <div id="top-bar" class="w-full bg-[#001A33] text-white py-1 px-6 flex justify-between items-center text-xs z-[100] relative">
        <span><i class="ri-notification-3-line mr-2"></i>Đang có 1,250 biển số mới lên sàn</span>
        <span>Hotline: 1900 8888</span>
    </div>

    <header id="main-header" class="glass-header sticky top-0 w-full z-50 transition-all duration-300 h-20 flex flex-col justify-center">
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
                <div id="search-container" class="flex items-center">
                    <input id="search-input" type="text" placeholder="Tìm biển số..." class="w-0 overflow-hidden bg-white/50 border-none rounded-full px-0 py-1 transition-all duration-500 focus:ring-1 ring-[#007FFF]">
                    <button id="search-btn" class="p-2 hover:text-[#007FFF] transition-colors">
                        <i class="ri-search-line text-xl"></i>
                    </button>
                </div>

                <div class="relative group" id="account-dropdown-trigger">
                    <div class="flex items-center gap-3 cursor-pointer p-1 rounded-full hover:bg-white/20 transition-all duration-500 relative z-20">
                        <div class="hidden sm:block text-right pointer-events-none">
                            <p class="text-[8px] text-[#001A33]/50 tracking-[1px] uppercase font-bold">Thành viên VIP</p>
                            <p class="text-[11px] text-[#001A33] font-semibold leading-tight">Mr. Sapphire</p>
                        </div>
                        <div class="relative pointer-events-none">
                            <div class="w-10 h-10 rounded-full border-2 border-[#007FFF]/30 p-0.5 overflow-hidden shadow-lg">
                                <img src="https://i.pravatar.cc/100?img=11" alt="Avatar" class="w-full h-full rounded-full object-cover">
                            </div>
                            <div class="absolute bottom-0 right-0 w-3 h-3 bg-[#00f2ff] border-2 border-white rounded-full status-pulse"></div>
                        </div>
                    </div>

                    <div id="account-menu" class="absolute top-[calc(100%+15px)] right-0 w-64 bg-white/95 backdrop-blur-2xl border border-white/40 rounded-2xl shadow-2xl opacity-0 invisible translate-y-4 transition-all duration-300 z-[120]">
                        <div class="p-5 space-y-3">
                            <a href="account_kho_bau.php" class="flex items-center justify-between text-[11px] font-bold tracking-wider text-[#001A33]/70 hover:text-[#007FFF] transition-all transform hover:translate-x-2">
                                KHO BÁU CỦA TÔI <i class="ri-gem-line"></i>
                            </a>
                            <a href="account_lich_su_dau_gia.php" class="flex items-center justify-between text-[11px] font-bold tracking-wider text-[#001A33]/70 hover:text-[#007FFF] transition-all transform hover:translate-x-2">
                                LỊCH SỬ ĐẤU GIÁ <i class="ri-history-line"></i>
                            </a>
                            <div class="h-[1px] bg-[#001A33]/5 my-2"></div>
                            <a href="Admin/login.php" class="flex items-center justify-between text-[11px] font-bold tracking-wider text-red-500 hover:scale-105 transition-all">
                                ĐĂNG XUẤT <i class="ri-logout-box-r-line"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <button class="md:hidden text-2xl" id="menu-toggle">
                    <i class="ri-menu-4-line"></i>
                </button>
            </div>
        </div>

    </header>

    <div id="mobile-menu" class="fixed inset-0 bg-[#001A33]/95 backdrop-blur-xl z-[60] flex flex-col items-center justify-center space-y-8 text-white translate-y-[-100%] hidden">
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
        // 1. Initial Reveal (Chào mừng)
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

        // 2. Scroll Morphing (Thích ứng cuộn)
        window.addEventListener('scroll', () => {
            const header = document.getElementById('main-header');
            const topBar = document.getElementById('top-bar');

            if (window.scrollY > 50) {
                header.style.height = '60px';
                header.style.backgroundColor = 'rgba(255, 255, 255, 0.85)';
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

        // 3. Pulse Animation cho nút Ký Gửi
        gsap.to("#btn-ky-gui", {
            scale: 1.05,
            duration: 0.8,
            repeat: -1,
            yoyo: true,
            ease: "sine.inOut"
        });

        // 4. Search Expansion
        let searchOpen = false;
        const searchBtn = document.getElementById('search-btn');
        const searchInput = document.getElementById('search-input');

        searchBtn.addEventListener('click', () => {
            // desktop
            if (window.innerWidth > 768) {
                if (!searchOpen) {
                    gsap.to(searchInput, {
                        width: 300,
                        paddingLeft: 15,
                        paddingRight: 15,
                        duration: 0.5,
                        ease: "expo.out"
                    });
                } else {
                    gsap.to(searchInput, {
                        width: 0,
                        paddingLeft: 0,
                        paddingRight: 0,
                        duration: 0.5,
                        ease: "expo.in"
                    });
                }
                searchOpen = !searchOpen;
            }
            // mobite
            if (window.innerWidth <= 768) {
                if (!searchOpen) {
                    gsap.to(searchInput, {
                        width: 95,
                        paddingLeft: 15,
                        paddingRight: 15,
                        duration: 0.5,
                        ease: "expo.out"
                    });
                } else {
                    gsap.to(searchInput, {
                        width: 0,
                        paddingLeft: 0,
                        paddingRight: 0,
                        duration: 0.5,
                        ease: "expo.in"
                    });
                }
                searchOpen = !searchOpen;
            }


        });

        // 5. Mobile Liquid Menu
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const closeMenu = document.getElementById('close-menu');

        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.remove('hidden');
            gsap.to(mobileMenu, {
                y: 0,
                duration: 0.8,
                ease: "power4.inOut"
            });
            gsap.from(".menu-link", {
                y: 50,
                opacity: 0,
                stagger: 0.1,
                duration: 0.6,
                delay: 0.3,
                ease: "back.out"
            });
        });

        closeMenu.addEventListener('click', () => {
            gsap.to(mobileMenu, {
                y: "-100%",
                duration: 0.6,
                ease: "power4.in",
                onComplete: () => {
                    mobileMenu.classList.add('hidden');
                }
            });
        });

        // 6. Micro-interactions: Glow effect
        const navItems = document.querySelectorAll('.nav-item');
        navItems.forEach(item => {
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

            item.addEventListener('mouseleave', () => {
                gsap.to(glow, {
                    opacity: 0,
                    duration: 0.3
                });
            });

        });
        // XỬ LÝ MENU TÀI KHOẢN (ACCOUNT DROPDOWN) - BẢN FIX CUỐI CÙNG
        const accountTrigger = document.getElementById('account-dropdown-trigger');
        const accountMenu = document.getElementById('account-menu');
        let isAccountMenuOpen = false;

        // Hàm mở menu
        function openAccountMenu() {
            accountMenu.classList.add('is-visible');
            gsap.to(accountMenu, {
                autoAlpha: 1,
                y: 0,
                duration: 0.4,
                ease: "power2.out"
            });
            isAccountMenuOpen = true;
        }

        // Hàm đóng menu
        function closeAccountMenu() {
            gsap.to(accountMenu, {
                autoAlpha: 0,
                y: 15,
                duration: 0.3,
                onComplete: () => accountMenu.classList.remove('is-visible')
            });
            isAccountMenuOpen = false;
        }

        // 1. Dành cho Desktop (Hover)
        accountTrigger.addEventListener('mouseenter', () => {
            if (window.innerWidth > 768) openAccountMenu();
        });

        accountTrigger.addEventListener('mouseleave', () => {
            if (window.innerWidth > 768) {
                e.preventDefault(); // Quan trọng: Chặn click giả lập sau touch
                e.stopPropagation();

                if (!isAccountMenuOpen) {
                    openAccountMenu();
                } else {
                    closeAccountMenu();
                }
            }
        });

        // 2. Dành cho Mobile (Dùng duy nhất Touchstart để tránh xung đột Click)
        accountTrigger.addEventListener('touchstart', (e) => {
            if (window.innerWidth <= 768) {
                e.preventDefault(); // Quan trọng: Chặn click giả lập sau touch
                e.stopPropagation();

                if (!isAccountMenuOpen) {
                    openAccountMenu();
                } else {
                    closeAccountMenu();
                }
            }
        }, {
            passive: false
        });

        // 3. Đóng menu khi chạm/bấm ra vùng ngoài
        const handleOutsideClick = (e) => {
            if (isAccountMenuOpen && !accountTrigger.contains(e.target)) {
                closeAccountMenu();
            }
        };

        document.addEventListener('mousedown', handleOutsideClick); // Cho Desktop
        document.addEventListener('touchstart', handleOutsideClick); // Cho Mobile
    </script>
</body>

</html>