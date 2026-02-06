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
require_once dirname(__DIR__) . "/models/Customer.php";

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/Draggable.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Inter:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <style>
        body {
            background-color: #000814;
            margin: 0;
            padding: 0;
        }

        /* ----------------------------- section 1 -----------------------------  */
        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }

        /* Hiệu ứng khung xương (Skeleton Shimmer) */
        @keyframes shimmer {
            100% {
                transform: translateX(100%);
            }
        }

        /* Custom Scrollbar cho phong cách Matrix */
        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #050505;
        }

        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #2563eb;
        }

        /* Hiệu ứng cho các Card */
        .article-card {
            perspective: 1000px;
        }

        /* Hiệu ứng trượt của Side Panel */
        #side-panel {
            box-shadow: -20px 0 50px rgba(0, 0, 0, 0.5);
        }

        /* ----------------------------- section 2 -----------------------------  */

        /* ----------------------------- section 3 -----------------------------  */

        /* ----------------------------- section 4 -----------------------------  */

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- sidebar -----------------------------  -->
    <?php include "Sidebar.php" ?>
    <main class="transition-all duration-300 ml-0 lg:ml-[230px] min-h-screen overflow-x-hidden" id="main-content">
        <!-- ----------------------------- section 1 -----------------------------  -->
        <div class="min-h-screen bg-[#050505] text-white p-4 lg:p-8 font-sans antialiased m-5">

            <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-white to-blue-400">
                        News & Media
                    </h1>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                        <p class="text-xs text-slate-400 uppercase tracking-widest font-mono">Total: <span id="post-count">128</span> Posts</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 w-full md:w-auto">
                    <div class="relative flex-grow md:w-80">
                        <i class="ri-search-ai-line absolute left-4 top-1/2 -translate-y-1/2 text-blue-400/60"></i>
                        <input type="text" placeholder="AI Search: Keyword or Plate ID..."
                            class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-12 pr-4 text-sm focus:border-blue-500/50 focus:ring-0 outline-none transition-all placeholder:text-white/20">
                    </div>
                    <button onclick="toggleSidePanel()" class="bg-blue-600 hover:bg-blue-500 shadow-[0_0_20px_rgba(37,99,235,0.4)] text-white px-6 py-3 rounded-xl flex items-center gap-2 font-bold transition-all transform active:scale-95 whitespace-nowrap">
                        <i class="ri-edit-box-line text-lg font-light"></i>
                        <span class="hidden sm:inline">Create New Post</span>
                    </button>
                </div>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-white/5 border border-white/10 p-5 rounded-2xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-30 transition-opacity">
                        <i class="ri-fire-line text-4xl text-orange-500"></i>
                    </div>
                    <p class="text-xs text-white/40 uppercase font-bold tracking-tighter">Trending (24h)</p>
                    <h4 class="text-xl font-bold mt-2 truncate">The Rise of Sapphire Plates</h4>
                    <p class="text-xs text-orange-400 mt-1">8.2k Views <i class="ri-arrow-right-up-line"></i></p>
                </div>
                <div class="bg-white/5 border border-white/10 p-5 rounded-2xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-30 transition-opacity">
                        <i class="ri-calendar-todo-line text-4xl text-blue-500"></i>
                    </div>
                    <p class="text-xs text-white/40 uppercase font-bold tracking-tighter">Scheduled</p>
                    <h4 class="text-2xl font-bold mt-2">14 Articles</h4>
                    <p class="text-xs text-blue-400 mt-1">Next: Today, 18:00</p>
                </div>
                <div class="bg-white/5 border border-white/10 p-5 rounded-2xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-30 transition-opacity">
                        <i class="ri-cursor-line text-4xl text-emerald-500"></i>
                    </div>
                    <p class="text-xs text-white/40 uppercase font-bold tracking-tighter">Engagement</p>
                    <h4 class="text-2xl font-bold mt-2">24.5%</h4>
                    <p class="text-xs text-emerald-400 mt-1">+2.3% from last week</p>
                </div>
            </div>

            <div class="editorial-grid space-y-4">
                <div class="article-card group relative bg-white/[0.02] border border-white/5 hover:border-blue-500/30 rounded-2xl p-3 flex flex-col md:flex-row items-center gap-6 transition-all duration-300 hover:shadow-[0_0_30px_rgba(37,99,235,0.1)]">

                    <div class="hidden md:flex cursor-grab active:cursor-grabbing text-white/10 hover:text-white/40 px-2">
                        <i class="ri-draggable text-xl"></i>
                    </div>

                    <div class="w-full md:w-48 aspect-video rounded-xl overflow-hidden bg-white/5 border border-white/10 relative">
                        <img src="https://images.unsplash.com/photo-1614062486668-3e9a59755497?q=80&w=400&h=225&fit=crop" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 grayscale-[0.5] group-hover:grayscale-0">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent md:hidden"></div>
                        <div class="absolute bottom-3 left-3 md:hidden">
                            <span class="status-badge px-3 py-1 bg-blue-600 text-[10px] font-bold rounded-full">PUBLIC</span>
                        </div>
                    </div>

                    <div class="flex-grow space-y-2 w-full">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-[10px] text-blue-400 font-mono uppercase tracking-widest">Market Insights</span>
                                <h3 class="text-lg font-bold text-white/90 group-hover:text-white transition-colors line-clamp-1">Kỷ lục đấu giá mới cho biển số ngũ quý 9: Đẳng cấp Sapphire</h3>
                            </div>
                            <div class="hidden md:block">
                                <span onclick="flipStatus(this)" class="cursor-pointer status-badge px-3 py-1 bg-blue-600/20 text-blue-400 border border-blue-500/30 text-[10px] font-bold rounded-lg transition-all duration-500">PUBLIC</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-6 text-[11px] text-white/30 font-mono">
                            <span class="flex items-center gap-1"><i class="ri-eye-line"></i> 1,240</span>
                            <span class="flex items-center gap-1"><i class="ri-calendar-line"></i> Feb 06, 2026</span>
                            <span class="flex items-center gap-1 text-blue-400/60"><i class="ri-price-tag-3-line"></i> 51K-999.99</span>
                        </div>
                    </div>

                    <div class="flex md:opacity-0 group-hover:opacity-100 items-center gap-2 transition-all duration-300 transform translate-x-4 group-hover:translate-x-0 pr-4">
                        <button class="p-2 hover:bg-blue-500/20 rounded-lg text-blue-400 transition-colors" title="Edit"><i class="ri-pencil-line text-lg"></i></button>
                        <button class="p-2 hover:bg-white/10 rounded-lg text-white/60 transition-colors" title="Preview"><i class="ri-external-link-line text-lg"></i></button>
                        <button class="p-2 hover:bg-red-500/20 rounded-lg text-red-400 transition-colors" title="Delete"><i class="ri-delete-bin-line text-lg"></i></button>
                    </div>
                </div>
            </div>

            <button class="fixed md:hidden bottom-6 right-6 w-14 h-14 bg-blue-600 rounded-full shadow-[0_0_25px_rgba(37,99,235,0.5)] flex items-center justify-center text-white z-40 active:scale-90 transition-transform">
                <i class="ri-add-line text-3xl"></i>
            </button>

            <div id="side-panel" class="fixed top-0 right-0 h-full w-full md:w-[80%] bg-[#0a0a0a] border-l border-white/10 z-50 transform translate-x-full transition-transform duration-500 ease-out shadow-[-50px_0_100px_rgba(0,0,0,0.9)] overflow-y-auto">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-10">
                        <h2 class="text-2xl font-bold flex items-center gap-3">
                            <i class="ri-edit-circle-line text-blue-500"></i> Editorial Composer
                        </h2>
                        <button onclick="toggleSidePanel()" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-white/5 transition-colors">
                            <i class="ri-close-line text-2xl"></i>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-2 space-y-6">
                            <div class="space-y-2">
                                <label class="text-[10px] uppercase text-white/40 font-bold tracking-widest">Article Title</label>
                                <input type="text" placeholder="Enter a catchy headline..." class="w-full bg-transparent border-b border-white/10 py-4 text-2xl font-bold focus:border-blue-500 outline-none transition-all">
                            </div>

                            <div class="bg-white/5 rounded-2xl p-6 min-h-[400px] border border-white/5">
                                <p class="text-white/20">Editor contents go here... Type @ to link a License Plate.</p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="bg-white/5 rounded-2xl p-6 border border-white/5 space-y-4">
                                <h5 class="font-bold text-sm border-b border-white/10 pb-2">Smart Crop Preview</h5>
                                <div class="aspect-video bg-black rounded-xl border border-dashed border-white/20 flex flex-col items-center justify-center text-white/20 cursor-pointer hover:border-blue-500 hover:text-blue-400 transition-all">
                                    <i class="ri-image-add-line text-3xl mb-2"></i>
                                    <span class="text-[10px] font-bold">UPLOAD THUMBNAIL (16:9)</span>
                                </div>
                            </div>

                            <div class="bg-white/5 rounded-2xl p-6 border border-white/5 space-y-4">
                                <h5 class="font-bold text-sm border-b border-white/10 pb-2">Asset Intelligence</h5>
                                <div class="p-3 bg-blue-500/10 rounded-xl border border-blue-500/20">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center text-xs font-bold text-blue-400">51K</div>
                                        <div>
                                            <p class="text-[10px] font-bold uppercase">Linked Asset</p>
                                            <p class="text-xs font-mono">999.99</p>
                                        </div>
                                    </div>
                                </div>
                                <button class="w-full py-3 bg-white/5 hover:bg-white/10 rounded-xl text-xs font-bold transition-all">+ Add Asset Link</button>
                            </div>

                            <button class="w-full py-4 bg-blue-600 rounded-xl font-bold shadow-lg shadow-blue-900/20 active:scale-95 transition-all">PUBLISH CHANGES</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ----------------------------- section 2 -----------------------------  -->

        <!-- ----------------------------- section 3 -----------------------------  -->

        <!-- ----------------------------- section 4 -----------------------------  -->

        <!-- ----------------------------- section 5 -----------------------------  -->

        <!-- ----------------------------- section 6 -----------------------------  -->
    </main>
</body>
<script>
    // ----------------------------- section 1 ----------------------------- //
    // Hiệu ứng Mở/Đóng Side Panel
    function toggleSidePanel() {
        const panel = document.getElementById('side-panel');
        panel.classList.toggle('translate-x-full');
    }

    // Hiệu ứng Flip Status Badge
    function flipStatus(element) {
        gsap.to(element, {
            rotateX: 360,
            duration: 0.5,
            ease: "back.out(1.7)",
            onComplete: () => {
                if (element.innerText === 'PUBLIC') {
                    element.innerText = 'DRAFT';
                    element.className = 'cursor-pointer status-badge px-3 py-1 bg-white/10 text-white/40 border border-white/20 text-[10px] font-bold rounded-lg';
                } else {
                    element.innerText = 'PUBLIC';
                    element.className = 'cursor-pointer status-badge px-3 py-1 bg-blue-600/20 text-blue-400 border border-blue-500/30 text-[10px] font-bold rounded-lg';
                }
                gsap.set(element, {
                    rotateX: 0
                });
            }
        });
    }

    // Giả lập Skeleton Loading khi vào trang
    window.addEventListener('load', () => {
        gsap.from(".article-card", {
            y: 20,
            opacity: 0,
            duration: 0.8,
            stagger: 0.1,
            ease: "power2.out"
        });
    });
    // Cấu hình màu sắc tùy chỉnh cho Tailwind (nếu cần)
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    sapphire: '#0f52ba',
                    matrix: '#050505',
                }
            }
        }
    }

    // ----------------------------- section 2 ----------------------------- //

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>