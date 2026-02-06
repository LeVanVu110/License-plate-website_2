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
require_once dirname(__DIR__) . "/models/News.php";
$newsModel = new News();

if (isset($_POST['btn_add_news'])) {
    // 1. Lấy author_id từ session của Customer (người đang đăng nhập)
    // Đảm bảo lúc bạn xử lý Login bạn đã lưu: $_SESSION['user_id'] = $row['id'];
    $author_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    if (!$author_id) {
        echo "<script>alert('Lỗi: Bạn phải đăng nhập để đăng bài!'); window.location.href='login.php';</script>";
        exit();
    }

    $title = $_POST['title'];

    // Hàm tạo Slug (đưa ra ngoài hoặc giữ nguyên bên trong)
    function create_slug($string) {
        $search = array(
            '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#', '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#', '#(ì|í|ị|ỉ|ĩ)#',
            '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#', '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#', '#(ỳ|ý|ỵ|ỷ|ỹ)#', '#(đ)#',
            '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#', '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#', '#(Ì|Í|Ị|Ỉ|Ĩ)#',
            '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#', '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#', '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#', '#(Đ)#',
            '/[^a-zA-Z0-9\-\_]/',
        );
        $replace = array('a','e','i','o','u','y','d','A','E','I','O','U','Y','D','-',);
        $string = preg_replace($search, $replace, $string);
        $string = preg_replace('/(-)+/', '-', $string);
        return strtolower(trim($string, '-'));
    }
    
    $slug = create_slug($title);
    $content = $_POST['content'];
    $summary = mb_substr(strip_tags($content), 0, 150) . '...';
    $thumbnail = !empty($_POST['thumbnail']) ? $_POST['thumbnail'] : 'https://via.placeholder.com/400x225';
    $tag = !empty($_POST['tag']) ? $_POST['tag'] : '#General';
    $category = $_POST['category'];
    $status = $_POST['status'];

    // Thực hiện insert (author_id ở đây là ID của Customer)
    $result = $newsModel->insert($title, $slug, $summary, $content, $thumbnail, $tag, $category, $author_id, $status);

    if ($result) {
        // Sau khi insert thành công, lấy ID bài viết vừa tạo
        $new_post_id = $result; 
        echo "<script>alert('Đăng bài thành công!'); window.location.href='News.php';</script>";
    } else {
        echo "<script>alert('Lỗi SQL: Hãy đảm bảo Database đã được đổi Khóa ngoại sang bảng Customer!');</script>";
    }
}

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
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
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
        /* 2. Tùy chỉnh thanh cuộn (Custom Scrollbar) phong cách Matrix */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #2563eb;
            /* Sapphire Blue khi hover */
        }

        /* 3. Article Forge (Side Panel) Shadow & Transition */
        #article-forge {
            box-shadow: -30px 0 70px rgba(0, 0, 0, 0.9);
            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* 4. Rich Text Editor Styling (Quan trọng) */
        [contenteditable="true"]:empty:before {
            content: attr(data-placeholder);
            color: rgba(255, 255, 255, 0.1);
            pointer-events: none;
        }

        #rich-editor img {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        #rich-editor img:hover {
            border-color: #2563eb;
            cursor: pointer;
        }

        /* 5. Hiệu ứng Floating Toolbar */
        #floating-toolbar {
            backdrop-filter: blur(10px);
            background: rgba(26, 26, 26, 0.9);
            animation: toolbarFadeIn 0.2s ease-out;
        }

        @keyframes toolbarFadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* 6. Trạng thái Badge Status Flip */
        .status-badge {
            backface-visibility: hidden;
            display: inline-block;
        }

        /* 7. Preview Mode - Giả lập giao diện người dùng xem */
        .preview-mode {
            background: #fff !important;
            color: #1a1a1a !important;
            padding: 40px !important;
            border-radius: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        /* 8. Hiệu ứng Progress Bar Sapphire Glow */
        #progress-bar {
            position: relative;
        }

        #progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 10px;
            height: 100%;
            background: #fff;
            filter: blur(5px);
            box-shadow: 0 0 15px #2563eb;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            #article-forge {
                width: 100% !important;
                /* Chiếm toàn màn hình trên mobile */
            }
        }

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

            <!-- <div class="editorial-grid space-y-4" id="post-list-container">
                <div class="article-card group relative bg-white/[0.02] border border-white/5 hover:border-blue-500/30 rounded-2xl p-3 flex flex-col md:flex-row items-center gap-6 transition-all duration-300 hover:shadow-[0_0_30px_rgba(37,99,235,0.1)]"
                    data-id="101">

                    <div class="hidden md:flex drag-handle cursor-grab active:cursor-grabbing text-white/10 hover:text-white/40 px-2">
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
                                <h3 class="text-lg font-bold text-white/90 group-hover:text-white transition-colors line-clamp-1">Kỷ lụcs đấu giá mới cho biển số ngũ quý 9: Đẳng cấp Sapphire</h3>
                            </div>
                            <div class="hidden md:block" style="margin-top: 20px;">
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
                        <button onclick="openArticleForge('create')" class="p-2 hover:bg-blue-500/20 rounded-lg text-blue-400 transition-colors" title="Edit"><i class="ri-pencil-line text-lg"></i></button>
                        <button class="p-2 hover:bg-white/10 rounded-lg text-white/60 transition-colors" title="Preview"><i class="ri-external-link-line text-lg"></i></button>
                        <button class="p-2 hover:bg-red-500/20 rounded-lg text-red-400 transition-colors" title="Delete"><i class="ri-delete-bin-line text-lg"></i></button>
                    </div>
                </div>
                <div class="article-card group relative bg-white/[0.02] border border-white/5 hover:border-blue-500/30 rounded-2xl p-3 flex flex-col md:flex-row items-center gap-6 transition-all duration-300 hover:shadow-[0_0_30px_rgba(37,99,235,0.1)]">

                    <div class="hidden md:flex drag-handle cursor-grab active:cursor-grabbing text-white/10 hover:text-white/40 px-2">
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
                            <div class="hidden md:block" style="margin-top: 20px;">
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
                        <button onclick="openArticleForge('create')" class="p-2 hover:bg-blue-500/20 rounded-lg text-blue-400 transition-colors" title="Edit"><i class="ri-pencil-line text-lg"></i></button>
                        <button class="p-2 hover:bg-white/10 rounded-lg text-white/60 transition-colors" title="Preview"><i class="ri-external-link-line text-lg"></i></button>
                        <button class="p-2 hover:bg-red-500/20 rounded-lg text-red-400 transition-colors" title="Delete"><i class="ri-delete-bin-line text-lg"></i></button>
                    </div>
                </div>
            </div> -->
            <div class="editorial-grid space-y-4" id="post-list-container">
                <?php
                // Xử lý logic phân trang ở đầu file
                $limit = 3; // Bạn muốn thấy bao nhiêu bài 1 trang (ví dụ 3 bài)
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                if ($page < 1) $page = 1;


                $listNews = $newsModel->getAllAdmin($page, $limit);
                $totalNews = $newsModel->countAll();
                $totalPages = ceil($totalNews / $limit);

                foreach ($listNews as $item):
                    // Xử lý hiển thị tag và màu sắc status
                    $statusClass = ($item['status'] == 'Published')
                        ? 'bg-blue-600/20 text-blue-400 border-blue-500/30'
                        : 'bg-white/10 text-white/40 border-white/20';

                    // Format ngày tháng
                    $date = date('M d, Y', strtotime($item['created_at']));
                ?>
                    <div class="article-card group relative bg-white/[0.02] border border-white/5 hover:border-blue-500/30 rounded-2xl p-3 flex flex-col md:flex-row items-center gap-6 transition-all duration-300 hover:shadow-[0_0_30px_rgba(37,99,235,0.1)]"
                        data-id="<?= $item['id'] ?>">

                        <div class="hidden md:flex drag-handle cursor-grab active:cursor-grabbing text-white/10 hover:text-white/40 px-2">
                            <i class="ri-draggable text-xl"></i>
                        </div>

                        <div class="w-full md:w-48 aspect-video rounded-xl overflow-hidden bg-white/5 border border-white/10 relative">
                            <img src="<?= $item['thumbnail'] ?>"
                                alt="<?= htmlspecialchars($item['title']) ?>"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">

                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent md:hidden"></div>

                            <div class="absolute bottom-3 left-3 md:hidden">
                                <span class="status-badge px-3 py-1 bg-blue-600 text-[10px] font-bold rounded-full">
                                    <?= strtoupper($item['status']) ?>
                                </span>
                            </div>
                        </div>

                        <div class="flex-grow space-y-2 w-full">
                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="text-[10px] text-blue-400 font-mono uppercase tracking-widest">
                                        <?= str_replace('_', ' ', $item['category']) ?>
                                    </span>
                                    <h3 class="text-lg font-bold text-white/90 group-hover:text-white transition-colors line-clamp-1">
                                        <?= htmlspecialchars($item['title']) ?>
                                    </h3>
                                </div>

                                <div class="hidden md:block" style="margin-top: 10px;">
                                    <span onclick="flipStatus(this, <?= $item['id'] ?>)"
                                        class="cursor-pointer status-badge px-3 py-1 border text-[10px] font-bold rounded-lg transition-all duration-500 <?= $statusClass ?>">
                                        <?= strtoupper($item['status']) ?>
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center gap-6 text-[11px] text-white/30 font-mono">
                                <span class="flex items-center gap-1">
                                    <i class="ri-eye-line"></i> <?= number_format($item['views'] ?? 0) ?>
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="ri-calendar-line"></i> <?= $date ?>
                                </span>
                                <span class="flex items-center gap-1 text-blue-400/60">
                                    <i class="ri-price-tag-3-line"></i> <?= $item['tag'] ?>
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="ri-user-smile-line"></i> <?= $item['author_name'] ?>
                                </span>
                            </div>
                        </div>

                        <div class="flex md:opacity-0 group-hover:opacity-100 items-center gap-2 transition-all duration-300 transform translate-x-4 group-hover:translate-x-0 pr-4">
                            <button onclick="openArticleForge('edit', <?= $item['id'] ?>)"
                                class="p-2 hover:bg-blue-500/20 rounded-lg text-blue-400 transition-colors" title="Edit">
                                <i class="ri-pencil-line text-lg"></i>
                            </button>
                            <a href="chitiet_tintuc.php?slug=<?= $item['slug'] ?>" target="_blank"
                                class="p-2 hover:bg-white/10 rounded-lg text-white/60 transition-colors" title="Preview">
                                <i class="ri-external-link-line text-lg"></i>
                            </a>
                            <button onclick="deletePost(<?= $item['id'] ?>)"
                                class="p-2 hover:bg-red-500/20 rounded-lg text-red-400 transition-colors" title="Delete">
                                <i class="ri-delete-bin-line text-lg"></i>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="mt-8 flex items-center justify-between border-t border-white/5 pt-6">
                    <p class="text-[11px] text-white/20 font-mono uppercase">
                        Showing <?= count($listNews) ?> of <?= $totalNews ?> articles
                    </p>

                    <div class="flex items-center gap-2">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?= $page - 1 ?>" class="p-2 bg-white/5 hover:bg-blue-600/20 text-white/40 hover:text-blue-400 rounded-lg transition-all">
                                <i class="ri-arrow-left-s-line"></i>
                            </a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?page=<?= $i ?>"
                                class="px-4 py-2 rounded-lg text-xs font-bold transition-all <?= $i == $page ? 'bg-blue-600 text-white shadow-[0_0_15px_rgba(37,99,235,0.4)]' : 'bg-white/5 text-white/40 hover:bg-white/10' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <a href="?page=<?= $page + 1 ?>" class="p-2 bg-white/5 hover:bg-blue-600/20 text-white/40 hover:text-blue-400 rounded-lg transition-all">
                                <i class="ri-arrow-right-s-line"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <button class="fixed md:hidden bottom-6 right-6 w-14 h-14 bg-blue-600 rounded-full shadow-[0_0_25px_rgba(37,99,235,0.5)] flex items-center justify-center text-white z-40 active:scale-90 transition-transform">
                <i class="ri-add-line text-3xl"></i>
            </button>

            <!-- <div id="side-panel" class="fixed top-0 right-0 h-full w-full md:w-[80%] bg-[#0a0a0a] border-l border-white/10 z-50 transform translate-x-full transition-transform duration-500 ease-out shadow-[-50px_0_100px_rgba(0,0,0,0.9)] overflow-y-auto">
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
            </div> -->
            <form action="News.php" method="POST">
                <div id="side-panel" class="fixed top-0 right-0 h-full w-full md:w-[80%] bg-[#0a0a0a] border-l border-white/10 z-50 transform translate-x-full transition-transform duration-500 ease-out shadow-[-50px_0_100px_rgba(0,0,0,0.9)] overflow-y-auto">
                    <div class="p-8">
                        <div class="flex justify-between items-center mb-10">
                            <h2 class="text-2xl font-bold flex items-center gap-3">
                                <i class="ri-edit-circle-line text-blue-500"></i> Editorial Composer
                            </h2>
                            <button type="button" onclick="toggleSidePanel()" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-white/5 transition-colors">
                                <i class="ri-close-line text-2xl"></i>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <div class="lg:col-span-2 space-y-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] uppercase text-white/40 font-bold tracking-widest">Article Title</label>
                                    <input type="text" name="title" required placeholder="Enter a catchy headline..."
                                        class="w-full bg-transparent border-b border-white/10 py-4 text-2xl font-bold focus:border-blue-500 outline-none transition-all text-white">
                                </div>

                                <div class="bg-white/5 rounded-2xl p-6 min-h-[450px] border border-white/5 flex flex-col">
                                    <label class="text-[10px] uppercase text-white/40 font-bold tracking-widest mb-4">Body Content</label>
                                    <textarea name="content" required placeholder="Write your story here..."
                                        class="w-full flex-grow bg-transparent outline-none text-white/70 resize-none min-h-[350px] leading-relaxed"></textarea>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div class="bg-white/5 rounded-2xl p-6 border border-white/5 space-y-4">
                                    <h5 class="font-bold text-sm border-b border-white/10 pb-2 text-blue-400">Classification</h5>
                                    <div>
                                        <label class="text-[9px] text-white/30 uppercase block mb-2">Category</label>
                                        <select name="category" class="w-full bg-black border border-white/10 rounded-xl p-3 text-xs text-white outline-none focus:border-blue-500">
                                            <option value="Auction_News">Auction News</option>
                                            <option value="Market_Trends">Market Trends</option>
                                            <option value="Event">Event</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="text-[9px] text-white/30 uppercase block mb-2">Visibility</label>
                                        <select name="status" class="w-full bg-black border border-white/10 rounded-xl p-3 text-xs text-white outline-none focus:border-blue-500">
                                            <option value="Published">Published</option>
                                            <option value="Draft">Draft</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="bg-white/5 rounded-2xl p-6 border border-white/5 space-y-4">
                                    <h5 class="font-bold text-sm border-b border-white/10 pb-2 text-blue-400">Assets & Metadata</h5>
                                    <div>
                                        <label class="text-[9px] text-white/30 uppercase block mb-2">Thumbnail URL</label>
                                        <input type="text" name="thumbnail" placeholder="https://images.unsplash.com/..."
                                            class="w-full bg-black border border-white/10 rounded-xl p-3 text-xs text-white outline-none focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="text-[9px] text-white/30 uppercase block mb-2">HashTags</label>
                                        <input type="text" name="tag" placeholder="#Auction #VipPlate"
                                            class="w-full bg-black border border-white/10 rounded-xl p-3 text-xs text-white outline-none focus:border-blue-500">
                                    </div>
                                </div>

                                <div class="pt-4">
                                    <button type="submit" name="btn_add_news"
                                        class="w-full py-4 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold shadow-[0_0_20px_rgba(37,99,235,0.3)] active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                                        <i class="ri-send-plane-fill"></i> PUBLISH CHANGES
                                    </button>
                                    <p class="text-[10px] text-center text-white/20 mt-4 italic">Auto-save is active for your drafts.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- ----------------------------- section 2 -----------------------------  -->
            <div id="article-forge" class="fixed inset-y-0 right-0 w-full lg:w-[85%] bg-[#080808] border-l border-white/10 z-[60] transform translate-x-full transition-transform duration-500 ease-in-out shadow-[-20px_0_60px_rgba(0,0,0,0.8)] flex flex-col">

                <div class="h-16 border-b border-white/5 bg-black/40 backdrop-blur-xl flex items-center justify-between px-6 shrink-0">
                    <div class="flex items-center gap-1">
                        <button onclick="closeForge()" class="text-white/40 hover:text-white transition-colors text-sm font-medium">CANCEL</button>
                        <div class="h-4 w-[1px] bg-white/10"></div>
                        <div class="flex flex-col">
                            <span class="text-[9px] text-white/40 font-bold tracking-widest uppercase">Completion</span>
                            <div class="w-32 h-1 bg-white/5 rounded-full mt-1 overflow-hidden">
                                <div id="progress-bar" class="h-full bg-blue-600 w-[65%] shadow-[0_0_10px_#2563eb]"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div id="auto-save-pulse" class="flex items-center gap-2 px-3 text-blue-400/60 hidden">
                            <i class="ri-cloud-line animate-pulse"></i>
                            <span class="text-[10px] font-mono uppercase">Auto-saved</span>
                        </div>
                        <button class="px-4 py-2 text-white/60 hover:text-white text-sm transition-colors">Save Draft</button>
                        <button class="px-6 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-[14px] font-bold shadow-[0_0_20px_rgba(37,99,235,0.3)] transition-all active:scale-95">
                            PUBLISH
                        </button>
                    </div>
                </div>

                <div class="flex flex-grow overflow-hidden">

                    <div class="flex-grow overflow-y-auto p-8 lg:p-12 custom-scrollbar relative" id="editor-container">
                        <div id="floating-toolbar" class="absolute hidden bg-[#1a1a1a] border border-white/10 rounded-lg p-1 shadow-2xl flex items-center gap-1 z-50">
                            <button class="p-2 hover:bg-white/5 rounded text-white/80"><i class="ri-bold"></i></button>
                            <button class="p-2 hover:bg-white/5 rounded text-white/80"><i class="ri-italic"></i></button>
                            <button class="p-2 hover:bg-white/5 rounded text-white/80"><i class="ri-link"></i></button>
                            <div class="w-[1px] h-4 bg-white/10 mx-1"></div>
                            <button class="p-2 hover:bg-white/5 rounded text-white/80"><i class="ri-h-1"></i></button>
                        </div>

                        <input type="text" placeholder="Article Headline..." class="w-full bg-transparent border-none text-4xl lg:text-5xl font-bold text-white placeholder:text-white/10 outline-none mb-8">

                        <div id="rich-editor" contenteditable="true" class="prose prose-invert prose-blue max-w-none min-h-[500px] outline-none text-white/70 text-lg leading-relaxed" data-placeholder="Start writing the future...">
                            <div contenteditable="false" class="my-6 p-4 bg-blue-500/5 border border-blue-500/20 rounded-2xl flex items-center justify-between group">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center font-bold text-blue-400">51K</div>
                                    <div>
                                        <p class="text-[10px] font-bold text-blue-400 uppercase tracking-widest">Linked Asset</p>
                                        <p class="text-white font-mono uppercase">999.99 - Ngũ Quý Sapphire</p>
                                    </div>
                                </div>
                                <button class="px-4 py-2 bg-white/5 hover:bg-white/10 rounded-lg text-xs font-bold transition-all">BID NOW</button>
                            </div>
                        </div>
                    </div>

                    <aside class="w-80 border-l border-white/5 bg-black/20 p-6 hidden lg:flex flex-col gap-8 overflow-y-auto shrink-0">

                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <h5 class="text-[11px] font-bold text-white/40 uppercase tracking-widest">SEO Analyzer</h5>
                                <div class="flex gap-1">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_#10b981]"></div>
                                    <div class="w-2 h-2 rounded-full bg-white/10"></div>
                                    <div class="w-2 h-2 rounded-full bg-white/10"></div>
                                </div>
                            </div>
                            <p class="text-[10px] text-emerald-400/80">Great! Headline is highly engaging.</p>
                        </div>

                        <div class="space-y-3">
                            <label class="text-[11px] font-bold text-white/40 uppercase tracking-widest">Featured Image</label>
                            <div id="drop-zone" class="aspect-video rounded-2xl border border-dashed border-white/10 bg-white/[0.02] flex flex-col items-center justify-center gap-2 group hover:border-blue-500/50 transition-all cursor-pointer overflow-hidden relative">
                                <i class="ri-image-add-line text-2xl text-white/20 group-hover:text-blue-500 transition-colors"></i>
                                <span class="text-[10px] text-white/20 font-bold group-hover:text-white transition-colors uppercase">Drop 16:9 Image</span>
                            </div>
                        </div>

                        <div class="space-y-5">
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-white/40 uppercase tracking-widest">Category</label>
                                <select class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white/80 outline-none focus:border-blue-500/50">
                                    <option>Auction News</option>
                                    <option>Market Trends</option>
                                    <option>Events</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-white/40 uppercase tracking-widest">Slug (URL)</label>
                                <div class="relative">
                                    <input type="text" value="bien-so-ngu-quy-999-99" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs text-blue-400 font-mono outline-none">
                                    <i class="ri-link absolute right-4 top-1/2 -translate-y-1/2 text-white/20"></i>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-white/40 uppercase tracking-widest">Tags</label>
                                <input type="text" placeholder="#NgũQuý, #BiểnĐẹp" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white/80 outline-none">
                            </div>
                        </div>
                    </aside>
                </div>

                <div class="lg:hidden h-16 border-t border-white/5 bg-black px-6 flex items-center justify-between shrink-0">
                    <button class="p-2 text-white/40"><i class="ri-settings-4-line text-xl"></i></button>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-blue-600"></div>
                        <span class="text-[10px] font-bold uppercase tracking-widest">Step 2: Content</span>
                    </div>
                    <button class="p-2 text-blue-500"><i class="ri-eye-line text-xl"></i></button>
                </div>
            </div>

        <!-- ----------------------------- section 3 -----------------------------  -->
        <!-- <section id="engagement-hub" class="mt-16 bg-[#080808] border border-white/5 rounded-3xl overflow-hidden shadow-2xl" style="margin-left: 3%;">

            <div class="grid grid-cols-1 md:grid-cols-4 border-b border-white/5 bg-white/[0.02]">
                <div class="p-6 border-r border-white/5">
                    <p class="text-[10px] text-white/40 font-bold uppercase tracking-widest">Total Comments</p>
                    <h3 class="text-2xl font-bold mt-1 font-mono">2,840</h3>
                </div>
                <div class="p-6 border-r border-white/5 relative overflow-hidden">
                    <p class="text-[10px] text-orange-400 font-bold uppercase tracking-widest">Pending Review</p>
                    <h3 class="text-2xl font-bold mt-1 font-mono text-orange-400">142</h3>
                    <div class="absolute bottom-0 left-0 h-1 bg-orange-500 w-1/3 shadow-[0_0_10px_#f97316]"></div>
                </div>
                <div class="p-6 border-r border-white/5">
                    <p class="text-[10px] text-blue-400 font-bold uppercase tracking-widest">VIP Interactions</p>
                    <h3 class="text-2xl font-bold mt-1 font-mono text-blue-400">89</h3>
                </div>
                <div class="p-6">
                    <p class="text-[10px] text-red-400 font-bold uppercase tracking-widest">Top Flagged Keyword</p>
                    <h3 class="text-lg font-bold mt-1 uppercase text-red-400">"Lừa đảo" <span class="text-[10px] text-white/20">(12)</span></h3>
                </div>
            </div>

            <div class="p-4 bg-black/40 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <button class="px-4 py-2 bg-blue-600/10 text-blue-400 text-xs font-bold rounded-lg border border-blue-500/20 hover:bg-blue-600 hover:text-white transition-all">All</button>
                    <button class="px-4 py-2 bg-white/5 text-white/40 text-xs font-bold rounded-lg border border-white/5 hover:border-red-500/30 hover:text-red-400 transition-all flex items-center gap-2">
                        <i class="ri-pulse-line"></i> Negative (AI)
                    </button>
                    <button class="px-4 py-2 bg-white/5 text-white/40 text-xs font-bold rounded-lg border border-white/5 hover:border-cyan-400/30 hover:text-cyan-400 transition-all">VIP Only</button>
                </div>

                <div class="flex items-center gap-4">
                    <span class="text-[10px] text-white/20 uppercase font-mono italic">Admin A is typing...</span>
                    <div class="h-4 w-[1px] bg-white/10"></div>
                    <button class="text-xs text-white/40 hover:text-white transition-colors">Bulk Approve</button>
                </div>
            </div>

            <div class="comment-feed divide-y divide-white/5" id="comment-list">

                <div class="comment-item group relative p-6 hover:bg-white/[0.01] transition-all flex gap-5 items-start border-l-4 border-red-500/50">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-red-500 shadow-[0_0_15px_#ef4444]"></div>

                    <div class="relative shrink-0">
                        <div class="w-12 h-12 rounded-full border-2 border-red-500/30 p-0.5 shadow-[0_0_10px_rgba(239,68,68,0.2)]">
                            <img src="https://i.pravatar.cc/100?u=12" class="w-full h-full rounded-full grayscale group-hover:grayscale-0 transition-all">
                        </div>
                        <div class="absolute -bottom-1 -right-1 px-1.5 bg-red-600 text-[8px] font-bold rounded border border-black uppercase">Spam?</div>
                    </div>

                    <div class="flex-grow">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h4 class="text-sm font-bold text-white/90">Nguyễn Văn Tèo <span class="ml-2 text-[10px] text-white/20 font-normal">#ID8829</span></h4>
                                <p class="text-[10px] text-blue-400/60 uppercase tracking-tighter mt-0.5">Bài viết: "Kỷ lục đấu giá mới..."</p>
                            </div>
                            <span class="text-[10px] text-white/20 font-mono italic">2 mins ago</span>
                        </div>
                        <p class="text-sm text-white/60 leading-relaxed bg-red-500/5 p-3 rounded-xl border border-red-500/10 italic">
                            "Web lừa đảo đó anh em ơi, đừng tin, tôi nạp tiền không được!"
                        </p>

                        <div class="mt-4 flex items-center gap-4">
                            <button onclick="approveComment(this)" class="text-[10px] font-bold text-emerald-400 hover:text-emerald-300 flex items-center gap-1 transition-all">
                                <i class="ri-check-double-line text-sm"></i> APPROVE
                            </button>
                            <button class="text-[10px] font-bold text-red-400 hover:text-red-300 flex items-center gap-1" onclick="this.closest('.comment-item').remove()">
                                <i class="ri-delete-bin-7-line text-sm"></i> DELETE
                            </button>
                            <button onclick="toggleReplyBox(this)" class="text-[10px] font-bold text-white/30 hover:text-white flex items-center gap-1">
                                <i class="ri-reply-line text-sm"></i> QUICK REPLY
                            </button>
                        </div>

                        <div class="reply-box hidden mt-4 pt-4 border-t border-white/5 animate-slide-down">
                            <div class="relative">
                                <textarea placeholder="Write a response as Admin..." class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-xs text-white outline-none focus:border-blue-500/50 min-h-[80px]"></textarea>
                                <button class="absolute bottom-3 right-3 px-4 py-1.5 bg-blue-600 text-[10px] font-bold rounded-lg">SEND</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="comment-item group relative p-6 hover:bg-white/[0.01] transition-all flex gap-5 items-start border-l-4 border-cyan-500">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-cyan-400 shadow-[0_0_15px_#22d3ee]"></div>

                    <div class="relative shrink-0">
                        <div class="w-12 h-12 rounded-full border-2 border-cyan-500 p-0.5 shadow-[0_0_15px_rgba(6,182,212,0.4)]">
                            <img src="https://i.pravatar.cc/100?u=99" class="w-full h-full rounded-full">
                        </div>
                        <div class="absolute -bottom-1 -right-1 px-1.5 bg-cyan-500 text-[8px] font-bold text-black rounded border border-black uppercase">DIAMOND</div>
                    </div>

                    <div class="flex-grow">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h4 class="text-sm font-bold text-cyan-400">Trần Thế Khải <i class="ri-vip-crown-fill text-xs"></i></h4>
                                <p class="text-[10px] text-white/20 uppercase tracking-tighter mt-0.5">Bài viết: "Sự trỗi dậy của Sapphire..."</p>
                            </div>
                            <span class="text-[10px] text-white/20 font-mono italic">10:45 AM</span>
                        </div>
                        <p class="text-sm text-white/80 leading-relaxed">
                            "Tuyệt vời! Tôi vừa trúng đấu giá biển 51K-999.99 nhờ bài viết hướng dẫn này. Sàn làm việc rất chuyên nghiệp."
                        </p>

                        <div class="mt-4 flex items-center gap-4">
                            <button class="text-[10px] font-bold text-white/30 hover:text-white flex items-center gap-1">
                                <i class="ri-thumb-up-line text-sm"></i> 24 LIKES
                            </button>
                            <button onclick="toggleReplyBox(this)" class="text-[10px] font-bold text-cyan-400 hover:text-cyan-300 flex items-center gap-1">
                                <i class="ri-reply-line text-sm"></i> REPLY AS ADMIN
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->

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
            // opacity: 0,
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
    document.addEventListener('DOMContentLoaded', function() {
        const postList = document.getElementById('post-list-container');

        // Khởi tạo Sortable
        new Sortable(postList, {
            handle: '.drag-handle', // Chỉ cho phép kéo tại icon 6 chấm
            animation: 150, // Tốc độ trượt (ms)
            ghostClass: 'bg-blue-600/10', // Màu nền của mục đang được kéo
            chosenClass: 'border-blue-500', // Viền của mục khi được chọn
            dragClass: 'opacity-50', // Độ mờ khi đang di chuyển

            // Sự kiện xảy ra khi thả chuột (kết thúc kéo)
            onEnd: function(evt) {
                // Lấy danh sách ID theo thứ tự mới
                const rows = postList.querySelectorAll('.article-card');
                let newOrder = [];
                rows.forEach((row, index) => {
                    newOrder.push({
                        id: row.getAttribute('data-id'),
                        position: index + 1
                    });
                });

                console.log('Thứ tự mới:', newOrder);

                // Gọi hàm lưu vào Database
                saveNewOrder(newOrder);
            },
        });
    });

    // Hàm gửi dữ liệu lên Server qua AJAX
    function saveNewOrder(orderData) {
        // Hiển thị hiệu ứng "Auto-save Pulse" đã làm ở Section 2 để thông báo
        triggerAutoSave();

        fetch('update_order.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    order: orderData
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Sắp xếp thành công!');
            })
            .catch(error => console.error('Lỗi sắp xếp:', error));
    }

    // ----------------------------- section 2 ----------------------------- //
    // 1. Hiệu ứng Floating Toolbar khi bôi đen văn bản
    const editor = document.getElementById('rich-editor');
    const toolbar = document.getElementById('floating-toolbar');

    editor.addEventListener('mouseup', () => {
        const selection = window.getSelection();
        if (selection.toString().length > 0) {
            const range = selection.getRangeAt(0);
            const rect = range.getBoundingClientRect();

            toolbar.style.left = `${rect.left + (rect.width / 2) - (toolbar.offsetWidth / 2)}px`;
            toolbar.style.top = `${rect.top - 50 + window.scrollY}px`;
            toolbar.classList.remove('hidden');

            gsap.from(toolbar, {
                y: 10,
                opacity: 0,
                duration: 0.2
            });
        } else {
            toolbar.classList.add('hidden');
        }
    });

    // 2. Giả lập hiệu ứng Auto-save Pulse
    function triggerAutoSave() {
        const pulse = document.getElementById('auto-save-pulse');
        pulse.classList.remove('hidden');

        gsap.fromTo(pulse, {
            opacity: 0
        }, {
            opacity: 1,
            duration: 0.5,
            onComplete: () => {
                setTimeout(() => {
                    gsap.to(pulse, {
                        opacity: 0,
                        duration: 1,
                        onComplete: () => pulse.classList.add('hidden')
                    });
                }, 2000);
            }
        });
    }
    // Chạy thử sau mỗi 10 giây
    setInterval(triggerAutoSave, 10000);

    // 3. Xử lý Drag-and-Drop ảnh vào Editor
    const dropZone = document.getElementById('drop-zone');

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-blue-500', 'bg-blue-500/10');
        gsap.to(dropZone, {
            scale: 1.02,
            duration: 0.3
        });
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-blue-500', 'bg-blue-500/10');
        gsap.to(dropZone, {
            scale: 1,
            duration: 0.3
        });
    });

    // 4. Asset Linker Logic (Gõ # hiện card)
    editor.addEventListener('input', (e) => {
        const content = editor.innerText;
        if (content.endsWith('#')) {
            // Logica hiển thị menu gợi ý biển số tại đây
            console.log("Trigger Asset Linker Menu...");
        }
    });
    // Hàm mở trình soạn thảo (Dùng cho cả Thêm mới và Sửa)
    function openArticleForge(mode = 'create', data = null) {
        const forge = document.getElementById('article-forge');
        const titleInput = forge.querySelector('input[type="text"]');
        const richEditor = document.getElementById('rich-editor');

        if (mode === 'create') {
            // Reset form nếu là thêm mới
            titleInput.value = '';
            richEditor.innerHTML = '';
            // Cập nhật thanh tiến trình về 0%
            updateProgress(0);
        } else if (mode === 'edit' && data) {
            // Nạp dữ liệu vào nếu là chỉnh sửa
            titleInput.value = data.title;
            richEditor.innerHTML = data.content;
            updateProgress(100);
        }

        // Hiệu ứng trượt vào bằng GSAP
        gsap.to(forge, {
            x: 0,
            duration: 0.6,
            ease: "power4.out"
        });
    }

    // Hàm đóng trình soạn thảo
    function closeForge() {
        const forge = document.getElementById('article-forge');
        gsap.to(forge, {
            x: '100%',
            duration: 0.5,
            ease: "power4.in"
        });
    }

    // Hàm cập nhật thanh tiến trình (Progress Bar)
    function updateProgress(percent) {
        gsap.to("#progress-bar", {
            width: `${percent}%`,
            duration: 0.5
        });
    }

    // ----------------------------- section 3 ----------------------------- //
    // 1. Hiệu ứng "The Sweep Action" khi duyệt bình luận
    function approveComment(btn) {
        const item = btn.closest('.comment-item');

        // GSAP Animation: Trượt phải + Mờ dần
        gsap.to(item, {
            x: 100,
            opacity: 0,
            duration: 0.5,
            ease: "power2.in",
            onComplete: () => {
                item.remove();
                // Cập nhật bộ đếm (Ví dụ đơn giản)
                const count = document.querySelector('.text-orange-400');
                count.innerText = parseInt(count.innerText) - 1;
            }
        });
    }

    // 2. Hiện khung trả lời nhanh (Quick Reply Overlay)
    function toggleReplyBox(btn) {
        const commentBody = btn.closest('.flex-grow');
        const replyBox = commentBody.querySelector('.reply-box');

        if (replyBox.classList.contains('hidden')) {
            replyBox.classList.remove('hidden');
            gsap.from(replyBox, {
                height: 0,
                opacity: 0,
                duration: 0.4,
                ease: "back.out(1.7)"
            });
        } else {
            gsap.to(replyBox, {
                height: 0,
                opacity: 0,
                duration: 0.3,
                onComplete: () => replyBox.classList.add('hidden')
            });
        }
    }

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>