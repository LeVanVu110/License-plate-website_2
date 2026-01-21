<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!DOCTYPE html>
    <html lang="vi">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kho Báu Số - Di Sản Độc Bản</title>

        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/MotionPathPlugin.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,300&family=Space+Mono:wght@400;700&family=Inter:wght@300;400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
        <style>
            /* Glassmorphism Header */
            .glass-header {
                background: rgba(0, 15, 30, 0.7);
                backdrop-filter: blur(25px) saturate(150%);
                -webkit-backdrop-filter: blur(25px) saturate(150%);
                height: 70px !important;
            }

            /* Brand Glow */
            .silver-glow {
                text-shadow: 0 0 15px rgba(255, 255, 255, 0.2);
            }

            /* Navigation Links */
            .nav-link {
                font-size: 11px;
                font-weight: 600;
                letter-spacing: 4px;
                color: rgba(255, 255, 255, 0.6);
                transition: all 0.4s;
                position: relative;
            }

            .nav-link::after {
                content: '';
                position: absolute;
                bottom: -8px;
                left: 0;
                width: 0;
                height: 0.5;
                background: #007FFF;
                transition: 0.4s;
            }

            .nav-link:hover {
                color: white;
            }

            .nav-link:hover::after {
                width: 100%;
            }

            /* Account Menu Items */
            .dropdown-item {
                display: block;
                font-size: 10px;
                text-transform: uppercase;
                letter-spacing: 2px;
                color: rgba(255, 255, 255, 0.5);
                transition: all 0.3s;
            }

            .dropdown-item:hover {
                color: #007FFF;
                transform: translateX(5px);
            }

            /* Notification Pulse */
            .status-pulse {
                box-shadow: 0 0 0 0 rgba(34, 211, 238, 0.7);
                animation: pulse-neon 2s infinite;
            }

            @keyframes pulse-neon {
                0% {
                    box-shadow: 0 0 0 0 rgba(34, 211, 238, 0.4);
                }

                70% {
                    box-shadow: 0 0 0 10px rgba(34, 211, 238, 0);
                }

                100% {
                    box-shadow: 0 0 0 0 rgba(34, 211, 238, 0);
                }
            }

            /* Avatar Container Hover Effect */
            .avatar-container:hover {
                box-shadow: 0 0 20px rgba(0, 127, 255, 0.3);
                transform: scale(1.05);
                transition: all 0.4s;
            }
        </style>
    </head>

<body>
    <header id="main-header" class="fixed top-0 left-0 w-full z-[100] transition-all duration-500 border-b border-white/5">
        <div class="max-w-[1800px] mx-auto px-6 md:px-12 h-24 flex items-center justify-between">

            <div class="flex items-center gap-8">
                <button id="menu-toggle" class="group flex flex-col gap-1.5 focus:outline-none">
                    <div class="w-6 h-[1px] bg-white/60 group-hover:bg-blue-400 transition-all"></div>
                    <div class="w-4 h-[1px] bg-white/60 group-hover:bg-blue-400 transition-all"></div>
                    <div class="w-6 h-[1px] bg-white/60 group-hover:bg-blue-400 transition-all"></div>
                </button>
                <a href="/" class="text-xl font-bold tracking-[4px] text-transparent bg-clip-text bg-gradient-to-r from-slate-200 via-white to-slate-400 uppercase silver-glow">
                    Kho Báu Số
                </a>
            </div>

            <nav class="hidden md:flex items-center gap-16">
                <a href="#" class="nav-link">ĐẤU GIÁ</a>
                <a href="#" class="nav-link">DI SẢN</a>
                <a href="#" class="nav-link">PHONG THỦY</a>
            </nav>

            <div class="flex items-center gap-6">
                <button class="text-white/70 hover:text-blue-400 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                <div class="relative group" id="account-dropdown-trigger">
                    <div class="flex items-center gap-3 cursor-pointer">
                        <div class="hidden md:block text-right">
                            <p class="text-[9px] text-white/40 tracking-[2px] uppercase">Thành viên Diamond</p>
                            <p class="text-[11px] text-white font-medium tracking-wider">Mr. Sapphire</p>
                        </div>
                        <div class="relative avatar-container">
                            <div class="w-10 h-10 rounded-full border border-blue-500/50 p-0.5 overflow-hidden">
                                <img src="https://i.pravatar.cc/100?img=11" alt="Avatar" class="w-full h-full rounded-full object-cover">
                            </div>
                            <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-cyan-400 border-2 border-black rounded-full status-pulse"></div>
                        </div>
                    </div>

                    <div id="account-menu" class="absolute top-full right-0 mt-4 w-64 bg-[#001226]/80 backdrop-blur-2xl border border-white/10 rounded-2xl opacity-0 invisible translate-y-4 transition-all duration-300">
                        <div class="p-6 space-y-4">
                            <a href="#" class="dropdown-item flex items-center justify-between group">
                                <span>Kho báu của tôi</span>
                                <i class="ri-gem-line opacity-0 group-hover:opacity-100 transition-all"></i>
                            </a>
                            <a href="#" class="dropdown-item flex items-center justify-between group">
                                <span>Lịch sử đấu giá</span>
                                <i class="ri-history-line opacity-0 group-hover:opacity-100 transition-all"></i>
                            </a>
                            <a href="#" class="dropdown-item flex items-center justify-between group text-blue-400">
                                <span>Cài đặt VIP</span>
                                <i class="ri-vip-crown-line"></i>
                            </a>
                            <div class="h-[1px] bg-white/5 my-2"></div>
                            <a href="#" class="dropdown-item text-red-400">Đăng xuất</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</body>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const header = document.getElementById('main-header');
        const accountTrigger = document.getElementById('account-dropdown-trigger');
        const accountMenu = document.getElementById('account-menu');

        // 1. Hiệu ứng "The Floating Bar": Thu nhỏ khi cuộn
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('glass-header');
            } else {
                header.classList.remove('glass-header');
            }
        });

        // 2. Account Hover Reveal
        accountTrigger.addEventListener('mouseenter', () => {
            gsap.to(accountMenu, {
                autoAlpha: 1,
                y: 0,
                duration: 0.5,
                ease: "expo.out"
            });
        });

        accountTrigger.addEventListener('mouseleave', () => {
            gsap.to(accountMenu, {
                autoAlpha: 0,
                y: 10,
                duration: 0.3,
                ease: "power2.in"
            });
        });

        // 3. Mobile Hamburger Menu (Logic cơ bản)
        const menuBtn = document.getElementById('menu-toggle');
        menuBtn.addEventListener('click', () => {
            // Hiệu ứng click rung nhẹ hoặc mở Side Drawer
            if (window.navigator.vibrate) window.navigator.vibrate(10);
            alert("Mở Side Drawer cho Mobile...");
        });
    });
</script>

</html>