<?php
include "header.php";
$db = new Db();
// 1. Truy vấn lấy thông báo (Đảm bảo đã có $user_id từ session ở đầu file)

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/Draggable.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* ----------------------------- section 1 -----------------------------  */
        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 10px;
        }

        /* Stagger Animation Class */
        .notif-item {
            will-change: transform, opacity;
        }

        /* Depth Hover */
        .notif-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
            z-index: 10;
        }

        /* Detail Expansion Logic */
        @media (max-width: 1024px) {
            .detail-active #notification-list {
                display: none;
            }

            .detail-active #notification-detail {
                display: flex;
                position: fixed;
                inset: 0;
                z-index: 100;
                background: #020617;
            }
        }

        /* ----------------------------- section 2 -----------------------------  */
        /* Magnetic Toggle Switch with Spring Physics */
        .magnetic-toggle {
            appearance: none;
            width: 48px;
            height: 24px;
            background: #e2e8f0;
            border-radius: 99px;
            position: relative;
            cursor: pointer;
            transition: background 0.3s;
        }

        .magnetic-toggle:checked {
            background: #4f46e5;
        }

        .magnetic-toggle::before {
            content: '';
            position: absolute;
            width: 18px;
            height: 18px;
            background: white;
            border-radius: 50%;
            top: 3px;
            left: 3px;
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .magnetic-toggle:checked::before {
            transform: translateX(24px);
        }

        /* Glow Sync Effect */
        .glow-sync {
            animation: sapphire-glow 1s ease-out;
        }

        @keyframes sapphire-glow {
            0% {
                box-shadow: 0 0 0px 0px rgba(79, 70, 229, 0);
            }

            50% {
                box-shadow: 0 0 20px 2px rgba(79, 70, 229, 0.3);
                border-color: #4f46e5;
            }

            100% {
                box-shadow: 0 0 0px 0px rgba(79, 70, 229, 0);
            }
        }

        /* ----------------------------- section 3 -----------------------------  */

        /* ----------------------------- section 4 -----------------------------  */

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <!-- <section id="intelligence-inbox" class="py-12 px-4 md:px-10 bg-[#020617] text-slate-300 min-h-screen">
        <div class="max-w-7xl mx-auto">

            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-6 sticky top-0 z-50 bg-[#020617]/80 backdrop-blur-md py-4">
                <div class="flex items-center gap-4">
                    <h2 class="text-2xl font-black text-white tracking-tighter uppercase">Inbox</h2>
                    <span class="px-3 py-1 bg-blue-500/10 text-blue-400 text-[10px] font-bold rounded-full border border-blue-500/20">
                        5 TIN MỚI
                    </span>
                </div>

                <div class="flex items-center gap-2 overflow-x-auto pb-2 w-full md:w-auto">
                    <button class="filter-chip active px-4 py-2 rounded-full text-[10px] font-bold uppercase transition-all whitespace-nowrap bg-blue-600 text-white shadow-[0_0_15px_rgba(37,99,235,0.4)]">Tất cả</button>
                    <button class="filter-chip px-4 py-2 rounded-full text-[10px] font-bold uppercase transition-all whitespace-nowrap bg-slate-900 border border-slate-800 hover:border-blue-500/50">Đấu giá</button>
                    <button class="filter-chip px-4 py-2 rounded-full text-[10px] font-bold uppercase transition-all whitespace-nowrap bg-slate-900 border border-slate-800 hover:border-blue-500/50">Thanh toán</button>
                    <button class="filter-chip px-4 py-2 rounded-full text-[10px] font-bold uppercase transition-all whitespace-nowrap bg-slate-900 border border-slate-800 hover:border-blue-500/50">Hệ thống</button>

                    <div class="h-6 w-[1px] bg-slate-800 mx-2 hidden md:block"></div>
                    <button class="text-[10px] font-bold text-slate-500 hover:text-white uppercase transition-colors whitespace-nowrap">Đánh dấu đã đọc</button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-1 bg-slate-900/20 border border-slate-800/50 rounded-[2rem] overflow-hidden shadow-2xl">

                <div id="notification-list" class="lg:col-span-5 border-r border-slate-800/50 h-[700px] overflow-y-auto custom-scrollbar bg-slate-950/40">

                    <div class="notif-item unread relative p-6 border-b border-slate-900 hover:bg-slate-900/50 transition-all cursor-pointer group" onclick="openDetail(1)">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-blue-500"></div>
                        <div class="flex gap-4">
                            <div class="relative">
                                <div class="w-12 h-12 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-400">
                                    <i class="ri-gavel-line text-xl"></i>
                                </div>
                                <div class="absolute -top-1 -right-1 w-3 h-3 bg-rose-500 rounded-full animate-pulse shadow-[0_0_10px_#f43f5e]"></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start mb-1">
                                    <h4 class="text-sm font-bold text-white truncate group-hover:text-blue-400 transition-colors">Bạn đã bị vượt giá!</h4>
                                    <span class="text-[9px] font-mono text-slate-500 uppercase">2 phút trước</span>
                                </div>
                                <p class="text-xs text-slate-400 line-clamp-1 mb-3">Biển số 30K-888.88 hiện đang có mức giá mới là 2.5 tỷ VND...</p>
                                <button class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-[10px] font-black uppercase rounded-lg transition-all shadow-lg shadow-blue-900/20">Trả giá ngay</button>
                            </div>
                        </div>
                    </div>

                    <div class="notif-item read p-6 border-b border-slate-900 hover:bg-slate-900/50 transition-all cursor-pointer group opacity-60 hover:opacity-100" onclick="openDetail(2)">
                        <div class="flex gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-400">
                                <i class="ri-bank-card-line text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start mb-1">
                                    <h4 class="text-sm font-bold text-slate-300 truncate">Thanh toán cọc thành công</h4>
                                    <span class="text-[9px] font-mono text-slate-500 uppercase">1 giờ trước</span>
                                </div>
                                <p class="text-xs text-slate-500 line-clamp-1">Hệ thống đã xác nhận khoản tiền 40,000,000đ...</p>
                            </div>
                        </div>
                    </div>

                    <div class="notif-item read p-6 border-b border-slate-900 hover:bg-slate-900/50 transition-all cursor-pointer group opacity-60" onclick="openDetail(3)">
                        <div class="flex gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 flex items-center justify-center text-amber-400">
                                <i class="ri-shield-check-line text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start mb-1">
                                    <h4 class="text-sm font-bold text-slate-300 truncate">Thiết bị đăng nhập mới</h4>
                                    <span class="text-[9px] font-mono text-slate-500 uppercase">Hôm qua</span>
                                </div>
                                <p class="text-xs text-slate-500 line-clamp-1">Trình duyệt Chrome trên Windows đã đăng nhập vào...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="notification-detail" class="hidden lg:flex lg:col-span-7 bg-slate-950/20 items-center justify-center p-12 relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10 pointer-events-none">
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] bg-blue-500 rounded-full blur-[120px]"></div>
                    </div>

                    <div id="detail-placeholder" class="text-center relative z-10">
                        <div class="w-20 h-20 bg-slate-900 rounded-full flex items-center justify-center mx-auto mb-6 border border-slate-800">
                            <i class="ri-mail-open-line text-3xl text-slate-700"></i>
                        </div>
                        <h3 class="text-white font-bold mb-2">Chọn một thông báo</h3>
                        <p class="text-xs text-slate-500 max-w-xs">Nhấn vào danh sách bên trái để xem nội dung chi tiết của các giao dịch hoặc tin nhắn hệ thống.</p>
                    </div>

                    <div id="detail-content" class="hidden w-full h-full p-10 flex-col">
                        <div class="flex items-center gap-6 mb-10">
                            <div id="detail-icon" class="w-16 h-16 rounded-[1.5rem] bg-blue-500/20 flex items-center justify-center text-blue-400 text-2xl"></div>
                            <div>
                                <h3 id="detail-title" class="text-2xl font-black text-white leading-none mb-2"></h3>
                                <p id="detail-time" class="text-[10px] font-mono text-slate-500 uppercase tracking-widest"></p>
                            </div>
                        </div>
                        <div class="h-[1px] w-full bg-slate-800/50 mb-10"></div>
                        <p id="detail-body" class="text-sm text-slate-400 leading-relaxed mb-10"></p>
                        <div id="detail-action" class="mt-auto"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:hidden mt-6 text-center">
            <p class="text-[10px] text-slate-600 font-bold uppercase tracking-widest">Vuốt sang trái để xóa • Vuốt phải để lưu</p>
        </div>
    </section> -->
    <?php
    // 1. Truy vấn lấy thông báo (Đảm bảo đã có $user_id từ session ở đầu file)
    // $user_id = $_SESSION['user_id'] ?? 0;
    $sql = "SELECT * FROM notifications WHERE receiver_id = ? ORDER BY created_at DESC";
    $stmt = Db::$connection->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $notifications = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Đếm số tin chưa đọc
    $unread_count = 0;
    foreach ($notifications as $n) {
        if (!$n['is_read']) $unread_count++;
    }
    ?>

    <section id="intelligence-inbox" class="py-12 px-4 md:px-10 bg-[#020617] text-slate-300 min-h-screen">
        <div class="max-w-7xl auto">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-6 sticky top-0 z-50 bg-[#020617]/80 backdrop-blur-md py-4">
                <div class="flex items-center gap-4">
                    <h2 class="text-2xl font-black text-white tracking-tighter uppercase">Inbox</h2>
                    <span class="px-3 py-1 bg-blue-500/10 text-blue-400 text-[10px] font-bold rounded-full border border-blue-500/20">
                        <?= $unread_count ?> TIN MỚI
                    </span>
                </div>

                <div class="flex items-center gap-2 overflow-x-auto pb-2 w-full md:w-auto">
                    <button class="filter-chip active px-4 py-2 rounded-full text-[10px] font-bold uppercase transition-all whitespace-nowrap bg-blue-600 text-white shadow-[0_0_15px_rgba(37,99,235,0.4)]">Tất cả</button>
                    <button class="filter-chip px-4 py-2 rounded-full text-[10px] font-bold uppercase transition-all whitespace-nowrap bg-slate-900 border border-slate-800 hover:border-blue-500/50">Đấu giá</button>
                    <button class="filter-chip px-4 py-2 rounded-full text-[10px] font-bold uppercase transition-all whitespace-nowrap bg-slate-900 border border-slate-800 hover:border-blue-500/50">Hệ thống</button>
                    <div class="h-6 w-[1px] bg-slate-800 mx-2 hidden md:block"></div>
                    <button class="text-[10px] font-bold text-slate-500 hover:text-white uppercase transition-colors whitespace-nowrap">Đánh dấu đã đọc</button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-1 bg-slate-900/20 border border-slate-800/50 rounded-[2rem] overflow-hidden shadow-2xl">

                <div id="notification-list" class="lg:col-span-5 border-r border-slate-800/50 h-[700px] overflow-y-auto custom-scrollbar bg-slate-950/40">
                    <?php if (empty($notifications)): ?>
                        <div class="p-10 text-center text-slate-500 text-xs">Không có thông báo nào.</div>
                    <?php else: ?>
                        <?php foreach ($notifications as $noti):
                            $is_unread = !$noti['is_read'];
                            // Xác định icon và màu sắc dựa trên Type
                            $icon = "ri-notification-3-line";
                            $color_class = "blue";
                            if ($noti['type'] == 'SMS') {
                                $icon = "ri-message-2-line";
                                $color_class = "amber";
                            }
                            if ($noti['type'] == 'Email') {
                                $icon = "ri-mail-line";
                                $color_class = "emerald";
                            }
                        ?>
                            <div class="notif-item <?= $is_unread ? 'unread' : 'read' ?> relative p-6 border-b border-slate-900 hover:bg-slate-900/50 transition-all cursor-pointer group <?= !$is_unread ? 'opacity-60' : '' ?>"
                                onclick='openDetail(<?= json_encode($noti) ?>)'>

                                <?php if ($is_unread): ?>
                                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-blue-500"></div>
                                <?php endif; ?>

                                <div class="flex gap-4">
                                    <div class="relative">
                                        <div class="w-12 h-12 rounded-2xl bg-<?= $color_class ?>-500/10 flex items-center justify-center text-<?= $color_class ?>-400">
                                            <i class="<?= $icon ?> text-xl"></i>
                                        </div>
                                        <?php if ($is_unread): ?>
                                            <div class="absolute -top-1 -right-1 w-3 h-3 bg-rose-500 rounded-full animate-pulse shadow-[0_0_10px_#f43f5e]"></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-start mb-1">
                                            <h4 class="text-sm font-bold text-white truncate group-hover:text-blue-400 transition-colors">
                                                <?= htmlspecialchars($noti['title']) ?>
                                            </h4>
                                            <span class="text-[9px] font-mono text-slate-500 uppercase">
                                                <?= date('H:i', strtotime($noti['created_at'])) ?>
                                            </span>
                                        </div>
                                        <p class="text-xs text-slate-400 line-clamp-1"><?= htmlspecialchars($noti['content']) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div id="notification-detail" class="hidden lg:flex lg:col-span-7 bg-slate-950/20 items-center justify-center p-12 relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10 pointer-events-none">
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] bg-blue-500 rounded-full blur-[120px]"></div>
                    </div>

                    <div id="detail-placeholder" class="text-center relative z-10">
                        <div class="w-20 h-20 bg-slate-900 rounded-full flex items-center justify-center mx-auto mb-6 border border-slate-800">
                            <i class="ri-mail-open-line text-3xl text-slate-700"></i>
                        </div>
                        <h3 class="text-white font-bold mb-2">Chọn một thông báo</h3>
                        <p class="text-xs text-slate-500 max-w-xs">Nhấn vào danh sách bên trái để xem nội dung chi tiết.</p>
                    </div>

                    <div id="detail-content" class="hidden w-full h-full p-10 flex-col relative z-10 text-left">
                        <div class="flex items-center gap-6 mb-10 text-left">
                            <div id="detail-icon-box" class="w-16 h-16 rounded-[1.5rem] bg-blue-500/20 flex items-center justify-center text-blue-400 text-2xl">
                                <i id="detail-icon-i" class="ri-notification-3-line"></i>
                            </div>
                            <div class="text-left">
                                <h3 id="detail-title" class="text-2xl font-black text-white leading-none mb-2"></h3>
                                <p id="detail-time" class="text-[10px] font-mono text-slate-500 uppercase tracking-widest"></p>
                            </div>
                        </div>
                        <div class="h-[1px] w-full bg-slate-800/50 mb-10"></div>
                        <p id="detail-body" class="text-sm text-slate-300 leading-relaxed mb-10 text-left"></p>
                        <div id="detail-action" class="mt-auto">
                            <button class="px-8 py-3 bg-blue-600 text-white text-[10px] font-black uppercase rounded-xl">Xác nhận giao dịch</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 2 -----------------------------  -->
    <section id="notification-settings" class="py-20 px-4 md:px-10 bg-[#f8fafc] text-slate-900 overflow-hidden">
        <div class="max-w-7xl mx-auto">

            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-12 gap-6 bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <div>
                    <h2 class="text-3xl font-black tracking-tighter uppercase flex items-center gap-3 text-indigo-950">
                        <i class="ri-settings-5-fill text-indigo-600"></i>
                        The Control Matrix
                    </h2>
                    <p class="text-slate-500 font-mono text-[10px] mt-2 uppercase tracking-[3px]">Notification Channels & Preference Architecture</p>
                </div>

                <div class="flex items-center gap-6 px-6 py-3 bg-slate-50 rounded-2xl border border-slate-100 group">
                    <div class="text-right">
                        <p class="text-[10px] font-black text-slate-900 uppercase">Do Not Disturb (DND)</p>
                        <p class="text-[8px] text-slate-400 font-bold uppercase tracking-widest">Tự động: 22:00 - 06:00</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" onchange="hapticFeedback()">
                        <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-indigo-600 after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all after:duration-300 after:ease-[cubic-bezier(0.34,1.56,0.64,1)] shadow-inner"></div>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6">

                <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 group transition-all duration-500 hover:shadow-xl hover:shadow-indigo-900/5">
                    <div class="flex items-center gap-4 mb-10">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <i class="ri-gavel-fill text-xl"></i>
                        </div>
                        <h3 class="text-sm font-black uppercase tracking-[2px] text-indigo-950">Nhóm sự kiện: Đấu giá</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8 items-center">
                        <div class="hidden lg:block"></div>
                        <div class="hidden lg:flex justify-center text-[10px] font-black text-slate-400 uppercase tracking-widest">App Push</div>
                        <div class="hidden lg:flex justify-center text-[10px] font-black text-slate-400 uppercase tracking-widest">SMS</div>
                        <div class="hidden lg:flex justify-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Email</div>

                        <div class="lg:col-span-1">
                            <p class="text-sm font-bold text-slate-700">Thông báo bị vượt giá</p>
                            <p class="text-[10px] text-slate-400 mt-1 italic">Tức thì (Real-time)</p>
                        </div>
                        <div class="flex justify-between lg:justify-center items-center p-4 bg-slate-50 lg:bg-transparent rounded-xl">
                            <span class="lg:hidden text-[10px] font-bold uppercase">App Push</span>
                            <input type="checkbox" checked class="magnetic-toggle" onchange="syncEffect(this)">
                        </div>
                        <div class="flex justify-between lg:justify-center items-center p-4 bg-slate-50 lg:bg-transparent rounded-xl relative group/sms">
                            <span class="lg:hidden text-[10px] font-bold uppercase">SMS</span>
                            <input type="checkbox" class="magnetic-toggle" onchange="syncEffect(this)">
                            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-3 bg-slate-900 text-white text-[9px] rounded-xl opacity-0 group-hover/sms:opacity-100 pointer-events-none transition-all duration-300 translate-y-2 group-hover/sms:translate-y-0 z-20">
                                "Chào Anh A, quý khách vừa bị vượt giá tại biển 30K-88.88. Trả giá ngay tại..."
                                <div class="absolute top-full left-1/2 -translate-x-1/2 border-8 border-transparent border-t-slate-900"></div>
                            </div>
                        </div>
                        <div class="flex justify-between lg:justify-center items-center p-4 bg-slate-50 lg:bg-transparent rounded-xl">
                            <span class="lg:hidden text-[10px] font-bold uppercase">Email</span>
                            <input type="checkbox" checked class="magnetic-toggle" onchange="syncEffect(this)">
                        </div>

                        <div class="lg:col-span-1 py-4 border-t border-slate-50 lg:border-none">
                            <div class="flex items-center gap-2">
                                <p class="text-sm font-bold text-slate-700">Thông báo thắng phiên</p>
                                <i class="ri-error-warning-fill text-rose-500" title="Bắt buộc để tránh mất cọc"></i>
                            </div>
                            <p class="text-[10px] text-rose-500 mt-1 font-bold uppercase">Critical Alert</p>
                        </div>
                        <div class="flex justify-between lg:justify-center items-center p-4 bg-indigo-50/50 lg:bg-indigo-50/20 rounded-xl">
                            <span class="lg:hidden text-[10px] font-bold uppercase">App Push</span>
                            <input type="checkbox" checked disabled class="magnetic-toggle opacity-50 cursor-not-allowed">
                        </div>
                        <div class="flex justify-between lg:justify-center items-center p-4 bg-indigo-50/50 lg:bg-indigo-50/20 rounded-xl">
                            <span class="lg:hidden text-[10px] font-bold uppercase">SMS</span>
                            <input type="checkbox" checked disabled class="magnetic-toggle opacity-50 cursor-not-allowed">
                        </div>
                        <div class="flex justify-between lg:justify-center items-center p-4 bg-indigo-50/50 lg:bg-indigo-50/20 rounded-xl">
                            <span class="lg:hidden text-[10px] font-bold uppercase">Email</span>
                            <input type="checkbox" checked disabled class="magnetic-toggle opacity-50 cursor-not-allowed">
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100">
                    <div class="flex items-center gap-4 mb-10">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                            <i class="ri-hand-coin-fill text-xl"></i>
                        </div>
                        <h3 class="text-sm font-black uppercase tracking-[2px] text-indigo-950">Nhóm sự kiện: Tài chính</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8 items-center">
                        <div class="lg:col-span-1">
                            <p class="text-sm font-bold text-slate-700">Nạp/Rút tiền & Hóa đơn</p>
                        </div>
                        <div class="flex justify-between lg:justify-center items-center p-4 bg-slate-50 lg:bg-transparent rounded-xl">
                            <span class="lg:hidden text-[10px] font-bold uppercase">App Push</span>
                            <input type="checkbox" checked class="magnetic-toggle" onchange="syncEffect(this)">
                        </div>
                        <div class="flex justify-between lg:justify-center items-center p-4 bg-slate-50 lg:bg-transparent rounded-xl">
                            <span class="lg:hidden text-[10px] font-bold uppercase">SMS</span>
                            <input type="checkbox" checked class="magnetic-toggle" onchange="syncEffect(this)">
                        </div>
                        <div class="flex justify-between lg:justify-center items-center p-4 bg-slate-50 lg:bg-transparent rounded-xl">
                            <span class="lg:hidden text-[10px] font-bold uppercase">Email</span>
                            <input type="checkbox" checked class="magnetic-toggle" onchange="syncEffect(this)">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 3 -----------------------------  -->

    <!-- ----------------------------- section 4 -----------------------------  -->

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

    <?php
    include "footer.php";
    ?>
</body>
<script>
    // ----------------------------- section 1 ----------------------------- //
    // 1. Staggered Entrance Animation
    window.addEventListener('DOMContentLoaded', () => {
        gsap.from(".notif-item", {
            y: 30,
            opacity: 0,
            duration: 0.8,
            stagger: 0.1,
            ease: "expo.out"
        });
    });

    // 2. Mock Data Detail Logic
    const mockData = {
        1: {
            title: "Bạn đã bị vượt giá!",
            icon: "ri-gavel-line",
            time: "Hôm nay, lúc 14:20",
            body: "Cảnh báo: Một người dùng khác vừa trả giá 2,550,000,000 VND cho biển số 30K-888.88. Thời gian còn lại của phiên đấu giá là 05:42. Bạn cần trả giá tối thiểu là 2,600,000,000 VND để lấy lại vị trí dẫn đầu.",
            action: `<button class="w-full py-4 bg-blue-600 text-white font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-blue-900/40">Tiếp tục trả giá</button>`
        },
        2: {
            title: "Thanh toán cọc thành công",
            icon: "ri-bank-card-line",
            time: "Hôm nay, lúc 13:05",
            body: "Giao dịch mã số #VCB-992100 đã được xác nhận. Số tiền cọc 40,000,000 VND cho phiên đấu giá ngày 25/01 đã được ghi nhận vào tài khoản của bạn. Bạn đã đủ điều kiện tham gia đấu giá.",
            action: `<button class="w-full py-4 bg-slate-800 text-white font-black uppercase tracking-widest rounded-2xl">Xem biên lai</button>`
        }
    };

    function openDetail(noti) {
        // Ẩn placeholder, hiện content
        document.getElementById('detail-placeholder').classList.add('hidden');
        const content = document.getElementById('detail-content');
        content.classList.remove('hidden');
        content.classList.add('flex');

        // Đổ dữ liệu
        document.getElementById('detail-title').innerText = noti.title;
        document.getElementById('detail-time').innerText = noti.created_at;
        document.getElementById('detail-body').innerHTML = noti.content.replace(/\n/g, '<br>');

        // Đổi icon theo type
        const iconI = document.getElementById('detail-icon-i');
        if (noti.type === 'SMS') iconI.className = 'ri-message-2-line';
        else if (noti.type === 'Email') iconI.className = 'ri-mail-line';
        else iconI.className = 'ri-notification-3-line';

        // (Tùy chọn) Gọi AJAX để cập nhật is_read = 1 trong Database
        fetch('mark_as_read.php?id=' + noti.id);
    }

    // 3. Simple Swipe Simulator for Mobile (Demo logic)
    let touchstartX = 0;
    document.querySelectorAll('.notif-item').forEach(item => {
        item.addEventListener('touchstart', e => touchstartX = e.changedTouches[0].screenX);
        item.addEventListener('touchend', e => {
            let touchendX = e.changedTouches[0].screenX;
            if (touchendX < touchstartX - 100) {
                // Swipe Left - Delete
                gsap.to(item, {
                    x: -500,
                    opacity: 0,
                    duration: 0.5,
                    onComplete: () => item.remove()
                });
                if (window.navigator.vibrate) window.navigator.vibrate(50);
            }
            if (touchendX > touchstartX + 100) {
                // Swipe Right - Mark Read
                item.style.opacity = '0.5';
                if (window.navigator.vibrate) window.navigator.vibrate(20);
            }
        });
    });

    // ----------------------------- section 2 ----------------------------- //
    // 1. Optimistic UI & Sync Glow Effect
    function syncEffect(checkbox) {
        const card = checkbox.closest('.group') || checkbox.closest('.bg-white');

        // Haptic Feedback
        hapticFeedback();

        // Thêm hiệu ứng phát sáng đồng bộ
        card.classList.add('glow-sync');
        setTimeout(() => {
            card.classList.remove('glow-sync');
        }, 1000);

        // Giả lập gửi API ngầm (Optimistic UI)
        console.log(`Syncing ${checkbox.checked ? 'ON' : 'OFF'} state to Database...`);
    }

    // 2. Haptic Feedback Simulation
    function hapticFeedback() {
        if (window.navigator.vibrate) {
            window.navigator.vibrate(10); // Rung nhẹ 10ms
        }
    }

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>