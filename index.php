<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biển Số Đẹp | The Grand Gallery</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>
    <style>
        :root {
            --electric-blue: #007FFF;
            --navy-deep: #000D1A;
        }

        body {
            background-color: var(--navy-deep);
            overflow-x: hidden;
            cursor: auto;
            /* Sử dụng custom cursor */
        }

        /* ----------------------------- section 1 -----------------------------  */
        .serif-title {
            font-family: 'Cormorant Garamond', serif;
        }

        .sans-text {
            font-family: 'Inter', sans-serif;
        }

        #custom-cursor {
            width: 100px;
            height: 100px;
            border: 1px solid var(--electric-blue);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            /* Không chặn click */
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--electric-blue);
            mix-blend-mode: difference;
            transition: opacity 0.3s ease;
        }

        /* Hero Video Overlay */
        .video-overlay {
            background: linear-gradient(to bottom, rgba(0, 13, 26, 0.7) 0%, rgba(0, 13, 26, 0.4) 50%, rgba(0, 13, 26, 0.9) 100%);
            z-index: 1;
        }

        #search-wrapper {
            position: relative;
            z-index: 50 !important;
        }

        /* The Crystal Search Bar */
        .crystal-search {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
            pointer-events: auto !important;
            /* Cho phép tương tác */
            cursor: default;
        }

        /* Khi di chuột vào ô input, hiện trỏ chuột nhập liệu */
        .crystal-search input {
            cursor: text !important;
        }

        .crystal-search button {
            cursor: pointer !important;
        }

        /* Optical Glint Effect */
        .glint {
            position: absolute;
            top: -100%;
            left: -100%;
            width: 50%;
            height: 300%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.4), transparent);
            transform: rotate(45deg);
            pointer-events: none;
        }

        #headline,
        #sub-headline,
        #search-wrapper {
            will-change: transform, opacity;
            backface-visibility: hidden;
        }

        /* Loại bỏ viền mặc định khi click vào input */
        input:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        /* Hiệu ứng khi hover vào nút bấm */
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 127, 255, 0.4);
        }

        /* Mobile specific adjustments */
        @media (max-width: 768px) {
            #custom-cursor {
                display: none;
            }

            .crystal-search {
                backdrop-filter: blur(10px);
            }

            body {
                cursor: auto;
            }

            /* #search-input{
                width: 131px !important;
            } */
        }

        /* ----------------------------- section 2 -----------------------------  */
        /* Font mô phỏng biển số thực tế */
        @font-face {
            font-family: 'PlateFont';
            src: url('https://fonts.cdnfonts.com/s/14144/DIN-Bold.woff');
        }

        #infinite-vault {
            min-height: 100vh;
        }

        .plate-number h3,
        .plate-number-moto p {
            font-family: 'PlateFont', 'Inter', sans-serif;
        }

        /* Custom Cursor Icons */
        #gallery-auto {
            cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/><path d="M12 3l0 6"/><path d="M12 15l0 6"/><path d="M3 12l6 0"/><path d="M15 12l6 0"/></svg>'), auto;
        }

        #gallery-moto {
            cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M5 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/><path d="M19 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/><path d="M12 15h3.5l2.5 -4h3.5"/><path d="M9 15c1.5 -4 4 -4 4 -4h-3"/></svg>'), auto;
        }

        /* Plate Card Styling */
        .plate-card {
            transition: all 0.5s cubic-bezier(0.2, 0.8, 0.2, 1);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
        }

        .plate-card:hover {
            transform: translateY(-10px) scale(1.02);
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(0, 127, 255, 0.4);
            box-shadow: 0 20px 40px -10px rgba(0, 127, 255, 0.2);
        }

        .auto:hover {
            border-color: #007FFF;
        }

        .moto:hover {
            border-color: #C0C0C0;
        }

        .gallery-wrapper {
            grid-column: 1;
            grid-row: 1;
            width: 100%;
            transition: opacity 0.4s ease, transform 0.4s ease;
        }

        /* Mobile Stacked Cards Effect */
        @media (max-width: 768px) {
            .gallery-wrapper {
                display: flex;
                overflow-x: auto;
                padding-bottom: 20px;
                scroll-snap-type: x mandatory;
                height: 65% !important;
            }

            .plate-card {
                min-width: 280px;
                scroll-snap-align: center;
            }

        }

        /* 2. Responsive Grid cho Mobile */
        @media (max-width: 640px) {

            /* Hiệu ứng Stacked Cards cho Xe máy trên Mobile */
            #gallery-moto {
                display: flex !important;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                gap: 15px;
                padding: 20px 5px;
                scrollbar-width: none;
                padding-bottom: 20px;
                /* Ẩn scrollbar */
            }

            #gallery-moto.absolute {
                position: relative;
                /* Trên mobile nên để relative để dễ cuộn swipe */
            }

            #gallery-moto::-webkit-scrollbar {
                display: none;
            }

            #gallery-moto .plate-card {
                min-width: 200px;
                scroll-snap-align: center;
                transform: rotate(-2deg);
                /* Tạo cảm giác xếp chồng hơi lệch */
            }

            #gallery-moto:not(.invisible) {
                display: flex !important;
                /* Khi hiện thì dùng flex để swipe ngang */
                overflow-x: auto;
                padding-bottom: 20px;
            }

            /* Đảm bảo khi ẩn thì không chiếm diện tích */
            .invisible {
                display: none !important;
            }
        }

        /* 3. Hiệu ứng Hover chung */
        .plate-card {
            will-change: transform, opacity;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .plate-card:active {
            transform: scale(0.95);
        }

        /* 4. Font Biển số */
        .plate-number h3,
        .plate-number-moto p {
            font-family: sans-serif;
            /* Bạn hãy thay bằng font Plate thực tế */
            font-weight: 800;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }



        /* ----------------------------- section 3 -----------------------------  */
        /* Nền lưới Matrix */
        #matrix-grid {
            mask-image: radial-gradient(circle at center, black 30%, transparent 80%);
            -webkit-mask-image: radial-gradient(circle at center, black 30%, transparent 80%);
        }

        /* Hiệu ứng Portal Input */
        #plate-input {
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
            font-size: 1.25rem;
        }

        #plate-input::placeholder {
            color: rgba(255, 255, 255, 0.2);
            font-size: 0.9rem;
            letter-spacing: 0.2em;
        }

        /* Khối cầu AI Sphere */
        #ai-sphere {
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow:
                0 0 40px rgba(0, 127, 255, 0.1),
                inset 0 0 30px rgba(255, 255, 255, 0.05);
            transform-style: preserve-3d;
            perspective: 1000px;
        }

        /* Hiệu ứng hào quang khi có kết quả */
        .glow-text {
            color: #fff;
            text-shadow:
                0 0 10px #007FFF,
                0 0 20px #007FFF,
                0 0 40px #007FFF;
            animation: textPulse 2s infinite alternate;
        }

        @keyframes textPulse {
            from {
                opacity: 0.8;
                filter: brightness(1);
            }

            to {
                opacity: 1;
                filter: brightness(1.5);
            }
        }

        /* Vòng tròn Shockwave khi nổ giá trị */
        #shockwave {
            border: 2px solid #007FFF;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 50%;
            pointer-events: none;
        }

        /* Nút bấm Analyze */
        #btn-analyze {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        #btn-analyze:hover span {
            background-color: #fff;
            color: #007FFF;
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.5);
        }

        #plate-input:focus+#input-line {
            width: 100%;
        }

        #ai-sphere {
            transition: transform 0.3s ease-out, box-shadow 0.3s ease-out;
        }

        #ai-sphere:hover {
            box-shadow: 0 0 50px rgba(0, 127, 255, 0.3);
        }

        .glow-text {
            text-shadow: 0 0 20px rgba(0, 127, 255, 0.8), 0 0 40px rgba(0, 127, 255, 0.4);
        }

        .max-w-md {
            max-width: 33rem !important;
        }

        /* Khi input được focus, tìm thẻ anh em là #input-line */
        #plate-input:focus+#input-line {
            width: 100% !important;
        }

        /* Hiệu ứng mờ dần placeholder khi gõ */
        #plate-input:focus::placeholder {
            opacity: 0.3;
            transition: opacity 0.3s;
        }

        @keyframes spin-slow {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin-slow {
            animation: spin-slow 4s linear infinite;
        }

        /* ----------------------------- section 4 -----------------------------  */
        /* CSS cho Infinite Marquee */
        /* --- Section 4: Styles --- */
        #social-pulse {
            position: relative;
            z-index: 10;
            border-top: 1px solid rgba(255, 255, 255, 0.5);
        }

        .grainy-overlay {
            position: absolute;
            inset: 0;
            opacity: 0.03;
            pointer-events: none;
            background-image: url('https://grainy-gradients.vercel.app/noise.svg');
        }

        /* Marquee Styles */
        .marquee-wrapper {
            overflow: hidden;
            padding: 1rem 0;
            border-top: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
            mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
            -webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
        }

        .marquee-content {
            animation: marquee-scroll 30s linear infinite;
            width: max-content;
        }

        @keyframes marquee-scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .transaction-card {
            background: white;
            padding: 1rem 2rem;
            border-radius: 9999px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 1rem;
            border: 1px solid white;
            position: relative;
            overflow: hidden;
        }

        .glint-pulse {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.8), transparent);
            transform: skewX(-20deg) translateX(-150%);
            animation: glint-move 4s infinite;
        }

        @keyframes glint-move {
            0% {
                transform: skewX(-20deg) translateX(-150%);
            }

            20%,
            100% {
                transform: skewX(-20deg) translateX(250%);
            }
        }

        .customer-name {
            font-weight: 600;
            color: #001f3f;
            font-size: 0.875rem;
        }

        .plate-number {
            font-weight: 800;
            color: #007fff;
            letter-spacing: 0.05em;
        }

        .status-tag {
            color: #9ca3af;
            font-size: 0.75rem;
            font-style: italic;
        }

        /* Auction Box */
        .auction-box {
            background: #001F3F;
            border-radius: 2.5rem;
            padding: 2.5rem;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .plate-highlight {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            padding: 1.5rem;
            border-radius: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .plate-text {
            font-size: 3rem;
            font-weight: 700;
            font-family: 'Cormorant Garamond', serif;
        }

        .countdown-timer {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .time-num {
            display: block;
            font-size: 2.25rem;
            font-weight: 700;
        }

        .time-label {
            font-size: 10px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.2em;
        }

        .time-colon {
            font-size: 2.25rem;
            color: #007fff;
        }

        .btn-auction-join {
            margin-top: 2.5rem;
            padding: 1rem 2.5rem;
            background: white;
            color: #001f3f;
            font-weight: 700;
            border-radius: 9999px;
            transition: all 0.5s;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .btn-auction-join:hover {
            background: #007fff;
            color: white;
        }

        .auction-icon-bg {
            position: absolute;
            right: -20px;
            bottom: -20px;
            font-size: 200px;
            color: rgba(255, 255, 255, 0.05);
            transform: rotate(12deg);
            pointer-events: none;
        }

        /* Hub Box */
        .hub-box {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(20px);
            border-radius: 2.5rem;
            padding: 2.5rem;
            border: 1px solid white;
        }

        .hub-title {
            font-weight: 700;
            letter-spacing: 0.2em;
            color: #001f3f;
            margin-bottom: 2rem;
            font-size: 0.875rem;
            text-transform: uppercase;
        }

        .hub-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f3f4f6;
            padding-bottom: 1rem;
        }

        .hub-plate {
            font-size: 0.875rem;
            font-weight: 700;
            color: #001f3f;
        }

        .hub-meta {
            font-size: 10px;
            color: #9ca3af;
        }

        .hub-price {
            color: #007fff;
            font-weight: 700;
        }

        .endorsement-logos {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid #f3f4f6;
            display: flex;
            justify-content: space-between;
            filter: grayscale(100%);
            opacity: 0.3;
        }

        .endorsement-logos i {
            font-size: 1.5rem;
        }

        /* Đảm bảo sticky title luôn nằm dưới header nhưng trên nội dung section */
        #sticky-title {
            z-index: 5;
        }

        /* Thêm vào CSS chung để đảm bảo footer không bị đè ngược */
        footer {
            position: relative;
            z-index: 20;
            background-color: #000D1A;
            /* Màu navy deep của bạn */
        }

        /* Responsive */
        @media (max-width: 768px) {
            .plate-text {
                font-size: 2rem;
            }

            .countdown-timer {
                gap: 0.75rem;
            }

            .time-num {
                font-size: 1.5rem;
            }

            #social-pulse {
                padding-left: 0 !important;
            }

            .plate-text {
                letter-spacing: -0.02em;
            }
        }

        /* ----------------------------- section 5 -----------------------------  */
        /* Nền Layered Glass */
        #intelligence-hub {
            position: relative;
            background-color: #F8FAFC;
            z-index: 10;
        }

        /* Các khối kính mờ trang trí phía sau */
        #intelligence-hub .glass-decor-1 {
            position: absolute;
            top: 10%;
            right: -5%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(80px);
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.5);
            z-index: 1;
            pointer-events: none;
        }

        #intelligence-hub .glass-decor-2 {
            position: absolute;
            bottom: 5%;
            left: -5%;
            width: 500px;
            height: 500px;
            background: rgba(0, 127, 255, 0.03);
            backdrop-filter: blur(60px);
            border-radius: 4rem;
            transform: rotate(-6deg);
            border: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 1;
            pointer-events: none;
        }

        /* Thẻ tin tức (Knowledge Card) */
        .knowledge-card {
            perspective: 1500px;
            /* Tạo môi trường 3D */
            transition: transform 0.5s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        /* Hiệu ứng Parallax cho ảnh bài viết tiêu điểm */
        #featured-post {
            overflow: hidden;
            backface-visibility: hidden;
        }

        .parallax-img {
            will-change: transform;
            object-fit: cover;
            transform: scale(1.1);
            /* Để có khoảng trống khi di chuyển parallax */
        }

        /* Lớp phủ kính trên bài viết tiêu điểm */
        .featured-glass-overlay {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        /* Nút Read More với tia sáng chạy quanh (Border Beam) */
        .read-glow-btn {
            position: relative;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(0, 127, 255, 0.3);
            color: #007FFF;
            overflow: hidden;
            /* transition: all 0.4s ease; */
            transition: transform 0.3s ease, color 0.3s ease;
        }

        .knowledge-card:hover .read-glow-btn {
            transform: translate(3px, -3px);
            color: #001F3F;
        }

        .read-glow-btn:hover {
            background: #007FFF;
            color: #fff !important;
            box-shadow: 0 0 20px rgba(0, 127, 255, 0.5);
            transform: scale(1.1);
        }

        /* Thanh Progress Bar ở đáy section */
        #hub-progress {
            transition: width 0.1s linear;
        }

        /* Custom Cursor: Chữ "READ" khi rê vào tin tức */
        .reading-mode {
            cursor: none;
        }

        #custom-read-cursor {
            position: fixed;
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: bold;
            color: #001F3F;
            z-index: 9999;
            opacity: 0;
            transform: scale(0);
            transition: opacity 0.3s, transform 0.3s;
        }

        .reading-mode #custom-read-cursor {
            opacity: 1;
            transform: scale(1);
        }

        /* Ép khung ảnh có chiều cao cố định trước khi ảnh tải xong */
        .knowledge-card .relative {
            aspect-ratio: 16 / 9;
            /* Hoặc chiều cao cố định như h-[500px] */
            background: #f0f0f0;
            /* Màu nền giả lập ảnh đang tải */
        }

        /* Tối ưu Mobile */
        @media (max-width: 1024px) {
            .knowledge-card {
                /* perspective: none; */
                /* Tắt 3D trên mobile để mượt hơn */
                transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            }

            .featured-glass-overlay {
                position: relative;
                margin: -40px 15px 15px 15px;
                background: white;
                backdrop-filter: none;
            }

            .featured-glass-overlay h3 {
                color: #001F3F !important;
            }

            #featured-post {
                border-radius: 1.5rem;
            }

            #featured-post .relative.h-\[500px\] {
                height: 400px;
                /* Thu nhỏ chiều cao ảnh chính trên mobile */
            }

            #featured-post h3 {
                font-size: 1.25rem;
            }

            .absolute.inset-x-6.bottom-6 {
                left: 1rem;
                right: 1rem;
                bottom: 1rem;
                padding: 1.5rem;
            }

            /* Hiện mô tả luôn trên mobile vì không có hover */
            .excerpt {
                max-height: 100px !important;
                opacity: 1 !important;
                color: rgba(255, 255, 255, 0.9) !important;
                margin-top: 0.5rem;
            }
            .absolute.inset-x-4{
                width: 60%;
            }
        }

        /* Xử lý chữ trên mobile không bị quá to */
        @media (max-width: 768px) {
            .sans-text {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                /* Giới hạn tiêu đề 2 dòng */
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            /* Ép hiển thị excerpt nhẹ nhàng trên mobile */
            .excerpt {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                opacity: 0.8 !important;
            }
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        @media (max-width: 640px) {

            /* Ép font chữ nhỏ lại trên màn hình cực nhỏ để không đẩy khung */
            h3.sans-text {
                font-size: 1.15rem !important;
                line-height: 1.3;
            }

            .excerpt {
                display: none;
                /* Ẩn hẳn đoạn mô tả trên mobile nhỏ để tránh tràn */
            }
        }

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- section 1 -----------------------------  -->
    <section id="hero-stage" class="relative w-full h-screen flex flex-col items-center justify-center overflow-hidden">
        <div id="video-wrap" class="absolute inset-0 z-0">
            <video autoplay muted loop playsinline class="w-full h-full object-cover">
                <source src="https://assets.mixkit.co/videos/preview/mixkit-luxury-car-parked-in-a-dark-place-34460-large.mp4" type="video/mp4">
            </video>
            <div class="video-overlay absolute inset-0"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center">
            <h1 id="headline" class="serif-title text-5xl md:text-8xl text-white mb-6 opacity-0 tracking-tight leading-tight">
                ĐỊNH DANH VỊ THẾ<br>
                <span class="italic text-[#C0C0C0]">KHẮC GHI DI SẢN</span>
            </h1>

            <p id="sub-headline" class="sans-text text-sm md:text-xl text-gray-300 mb-12 opacity-0 tracking-[0.2em] uppercase">
                Hệ thống quản trị và giao dịch biển số định danh thượng lưu số 1 Việt Nam
            </p>

            <div id="search-wrapper" class="flex justify-center opacity-0 translate-y-10">
                <div class="crystal-search group w-full max-w-4xl rounded-full p-2 flex flex-col md:flex-row items-center gap-2">
                    <div class="glint" id="glint"></div>
                    <div class="flex-1 flex items-center px-6 border-r border-white/10 w-full relative z-20">
                        <i class="ri-search-2-line text-white/50 mr-3"></i>
                        <input type="text" placeholder="TÌM KIẾM DÃY SỐ PHONG THỦY..."
                            class="bg-transparent border-none focus:ring-0 text-white placeholder-white/30 w-full py-4 text-sm tracking-widest uppercase cursor-text">
                    </div>
                    <button class="relative z-20 bg-[#007FFF] text-white px-10 py-4 rounded-full font-bold sans-text text-sm hover:bg-white hover:text-[#007FFF] transition-all duration-500 shadow-lg shadow-blue-500/20">
                        KHÁM PHÁ NGAY
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 2 -----------------------------  -->

    <section id="infinite-vault" class="relative py-16 md:py-24 bg-[#000D1A] overflow-hidden">
        <div class="container mx-auto px-4 md:px-6 relative z-10">

            <div class="flex justify-center mb-12 md:mb-16">
                <div class="glass-tab-container relative p-1 bg-white/5 backdrop-blur-xl rounded-full border border-white/10 flex items-center scale-90 md:scale-100">
                    <div id="tab-slider" class="absolute h-[calc(100%-8px)] w-[120px] md:w-[140px] bg-blue-600 rounded-full transition-all duration-500 ease-out"></div>
                    <button onclick="switchGallery('auto')" class="relative z-10 w-[120px] md:w-[140px] py-2 md:py-3 text-[10px] md:text-xs font-bold tracking-widest text-white uppercase">Ô TÔ</button>
                    <button onclick="switchGallery('moto')" class="relative z-10 w-[120px] md:w-[140px] py-2 md:py-3 text-[10px] md:text-xs font-bold tracking-widest text-white/50 uppercase">XE MÁY</button>
                </div>
            </div>
            <div class=" grid grid-cols-1 relative min-h-[600px] md:min-h-[500px]">
                <div id="gallery-auto" class="gallery-wrapper grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 transition-all duration-500">
                    <div class="plate-card auto group relative aspect-[2/1] bg-white/5 backdrop-blur-md border border-white/10 rounded-xl md:rounded-2xl p-6 md:p-8 overflow-hidden cursor-pointer">
                        <div class="silhouette-bg absolute inset-0 opacity-5 group-hover:opacity-20 transition-all duration-700 pointer-events-none flex items-center justify-center">
                            <img src="https://purepng.com/public/uploads/large/purepng.com-rolls-royce-ghost-white-carcarvehicletransportrolls-royce-17015276229158n80m.png" class="w-4/5 grayscale invert" alt="Silhouette">
                        </div>
                        <div class="relative z-10 h-full flex flex-col justify-between">
                            <div class="flex justify-between items-start">
                                <span class="text-[8px] md:text-[10px] tracking-[0.2em] text-blue-400 font-bold uppercase">Heritage Plate</span>
                                <i class="ri- steering-fill text-white/20 text-sm md:text-base"></i>
                            </div>
                            <div class="plate-number text-center">
                                <h3 class="text-3xl md:text-4xl lg:text-5xl font-mono text-white tracking-tighter">30K - 999.99</h3>
                            </div>
                            <div class="flex justify-between items-end">
                                <div class="price">
                                    <p class="text-[10px] font-bold text-blue-500 md:text-lg">2.500.000.000đ</p>
                                </div>
                                <span class="text-[8px] md:text-[10px] text-white/30 italic">Ngũ Quý</span>
                            </div>
                        </div>

                    </div>
                    <div class="plate-card auto group relative aspect-[2/1] bg-white/5 backdrop-blur-md border border-white/10 rounded-xl md:rounded-2xl p-6 md:p-8 overflow-hidden cursor-pointer">
                        <div class="silhouette-bg absolute inset-0 opacity-5 group-hover:opacity-20 transition-all duration-700 pointer-events-none flex items-center justify-center">
                            <img src="https://purepng.com/public/uploads/large/purepng.com-rolls-royce-ghost-white-carcarvehicletransportrolls-royce-17015276229158n80m.png" class="w-4/5 grayscale invert" alt="Silhouette">
                        </div>
                        <div class="relative z-10 h-full flex flex-col justify-between">
                            <div class="flex justify-between items-start">
                                <span class="text-[8px] md:text-[10px] tracking-[0.2em] text-blue-400 font-bold uppercase">Heritage Plate</span>
                                <i class="ri- steering-fill text-white/20 text-sm md:text-base"></i>
                            </div>
                            <div class="plate-number text-center">
                                <h3 class="text-3xl md:text-4xl lg:text-5xl font-mono text-white tracking-tighter">30K - 999.99</h3>
                            </div>
                            <div class="flex justify-between items-end">
                                <div class="price">
                                    <p class="text-[10px] font-bold text-blue-500 md:text-lg">2.500.000.000đ</p>
                                </div>
                                <span class="text-[8px] md:text-[10px] text-white/30 italic">Ngũ Quý</span>
                            </div>
                        </div>

                    </div>
                    <div class="plate-card auto group relative aspect-[2/1] bg-white/5 backdrop-blur-md border border-white/10 rounded-xl md:rounded-2xl p-6 md:p-8 overflow-hidden cursor-pointer">
                        <div class="silhouette-bg absolute inset-0 opacity-5 group-hover:opacity-20 transition-all duration-700 pointer-events-none flex items-center justify-center">
                            <img src="https://purepng.com/public/uploads/large/purepng.com-rolls-royce-ghost-white-carcarvehicletransportrolls-royce-17015276229158n80m.png" class="w-4/5 grayscale invert" alt="Silhouette">
                        </div>
                        <div class="relative z-10 h-full flex flex-col justify-between">
                            <div class="flex justify-between items-start">
                                <span class="text-[8px] md:text-[10px] tracking-[0.2em] text-blue-400 font-bold uppercase">Heritage Plate</span>
                                <i class="ri- steering-fill text-white/20 text-sm md:text-base"></i>
                            </div>
                            <div class="plate-number text-center">
                                <h3 class="text-3xl md:text-4xl lg:text-5xl font-mono text-white tracking-tighter">30K - 999.99</h3>
                            </div>
                            <div class="flex justify-between items-end">
                                <div class="price">
                                    <p class="text-[10px] font-bold text-blue-500 md:text-lg">2.500.000.000đ</p>
                                </div>
                                <span class="text-[8px] md:text-[10px] text-white/30 italic">Ngũ Quý</span>
                            </div>
                        </div>

                    </div>

                </div>

                <div id="gallery-moto" class="gallery-wrapper hidden grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                    <div class="plate-card moto group relative aspect-square bg-white/5 backdrop-blur-md border border-white/10 rounded-xl p-4 md:p-6 overflow-hidden">
                        <div class="silhouette-bg absolute inset-0 opacity-5 group-hover:opacity-20 flex items-center justify-center pointer-events-none transition-all">
                            <img src="https://images.squarespace-cdn.com/content/v1/5a940f533e2d1033230b561c/1544605934507-6I1S6P7U3P6U6G6U6S6S/Vespa+Primavera+50+White.png" class="w-3/4 grayscale invert" alt="Moto">
                        </div>
                        <div class="relative z-10 h-full flex flex-col justify-between text-center">
                            <span class="text-[8px] tracking-[0.2em] text-gray-400 font-bold uppercase">Jewelry</span>
                            <div class="plate-number-moto leading-tight py-2">
                                <p class="text-xl md:text-2xl font-mono text-white/90">29-G1</p>
                                <p class="text-2xl md:text-3xl font-mono text-white tracking-widest">888.88</p>
                            </div>
                            <p class="text-sm md:text-base font-bold text-white">450.000.000đ</p>
                        </div>
                    </div>
                    <div class="plate-card moto group relative aspect-square bg-white/5 backdrop-blur-md border border-white/10 rounded-xl p-4 md:p-6 overflow-hidden">
                        <div class="silhouette-bg absolute inset-0 opacity-5 group-hover:opacity-20 flex items-center justify-center pointer-events-none transition-all">
                            <img src="https://images.squarespace-cdn.com/content/v1/5a940f533e2d1033230b561c/1544605934507-6I1S6P7U3P6U6G6U6S6S/Vespa+Primavera+50+White.png" class="w-3/4 grayscale invert" alt="Moto">
                        </div>
                        <div class="relative z-10 h-full flex flex-col justify-between text-center">
                            <span class="text-[8px] tracking-[0.2em] text-gray-400 font-bold uppercase">Jewelry</span>
                            <div class="plate-number-moto leading-tight py-2">
                                <p class="text-xl md:text-2xl font-mono text-white/90">29-G1</p>
                                <p class="text-2xl md:text-3xl font-mono text-white tracking-widest">888.88</p>
                            </div>
                            <p class="text-sm md:text-base font-bold text-white">450.000.000đ</p>
                        </div>
                    </div>
                    <div class="plate-card moto group relative aspect-square bg-white/5 backdrop-blur-md border border-white/10 rounded-xl p-4 md:p-6 overflow-hidden">
                        <div class="silhouette-bg absolute inset-0 opacity-5 group-hover:opacity-20 flex items-center justify-center pointer-events-none transition-all">
                            <img src="https://images.squarespace-cdn.com/content/v1/5a940f533e2d1033230b561c/1544605934507-6I1S6P7U3P6U6G6U6S6S/Vespa+Primavera+50+White.png" class="w-3/4 grayscale invert" alt="Moto">
                        </div>
                        <div class="relative z-10 h-full flex flex-col justify-between text-center">
                            <span class="text-[8px] tracking-[0.2em] text-gray-400 font-bold uppercase">Jewelry</span>
                            <div class="plate-number-moto leading-tight py-2">
                                <p class="text-xl md:text-2xl font-mono text-white/90">29-G1</p>
                                <p class="text-2xl md:text-3xl font-mono text-white tracking-widest">888.88</p>
                            </div>
                            <p class="text-sm md:text-base font-bold text-white">450.000.000đ</p>
                        </div>
                    </div>
                    <div class="plate-card moto group relative aspect-square bg-white/5 backdrop-blur-md border border-white/10 rounded-xl p-4 md:p-6 overflow-hidden">
                        <div class="silhouette-bg absolute inset-0 opacity-5 group-hover:opacity-20 flex items-center justify-center pointer-events-none transition-all">
                            <img src="https://images.squarespace-cdn.com/content/v1/5a940f533e2d1033230b561c/1544605934507-6I1S6P7U3P6U6G6U6S6S/Vespa+Primavera+50+White.png" class="w-3/4 grayscale invert" alt="Moto">
                        </div>
                        <div class="relative z-10 h-full flex flex-col justify-between text-center">
                            <span class="text-[8px] tracking-[0.2em] text-gray-400 font-bold uppercase">Jewelry</span>
                            <div class="plate-number-moto leading-tight py-2">
                                <p class="text-xl md:text-2xl font-mono text-white/90">29-G1</p>
                                <p class="text-2xl md:text-3xl font-mono text-white tracking-widest">888.88</p>
                            </div>
                            <p class="text-sm md:text-base font-bold text-white">450.000.000đ</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 3 -----------------------------  -->
    <section id="oracle-engine" class="relative py-32 bg-[#000D1A] min-h-screen flex items-center overflow-hidden">
        <div id="matrix-grid" class="absolute inset-0 opacity-20 pointer-events-none">
            <div class="absolute inset-0" style="background-image: linear-gradient(#007FFF 1px, transparent 1px), linear-gradient(90deg, #007FFF 1px, transparent 1px); background-size: 50px 50px;"></div>
        </div>

        <div id="data-nodes" class="absolute inset-0 pointer-events-none"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-16">

                <div class="w-full lg:w-1/2 text-left" id="oracle-content">
                    <h2 class="serif-title text-4xl md:text-6xl text-white mb-6 leading-tight">
                        GIẢI MÃ <br> <span class="text-[#007FFF] italic">GIÁ TRỊ DI SẢN</span>
                    </h2>
                    <p class="sans-text text-gray-400 mb-12 max-w-md tracking-wide">
                        Sử dụng thuật toán AI độc quyền để phân tích tầng số học, phong thủy và giá trị giao dịch thực tế của biển số định danh.
                    </p>

                    <div class="relative max-w-md" id="input-portal">
                        <div class="relative overflow-hidden">
                            <input type="text" id="plate-input" placeholder="NHẬP BIỂN SỐ CỦA BẠN (VD: 30K-999.99)"
                                class="w-full bg-transparent border-b-2 border-gray-700 py-4 text-white sans-text tracking-[0.3em] uppercase focus:outline-none transition-all duration-500">

                            <div id="input-line" class="absolute bottom-0 left-0 h-[2px] w-0 bg-[#007FFF] shadow-[0_0_15px_#007FFF] transition-all duration-500 ease-in-out"></div>
                        </div>

                        <button id="btn-analyze" class="mt-8 group flex items-center gap-4 text-white tracking-[0.2em] font-bold text-sm">
                            <span class="bg-[#007FFF] p-4 rounded-full group-hover:scale-110 transition-transform shadow-[0_0_20px_rgba(0,127,255,0.4)]">
                                <i class="ri-radar-line animate-spin-slow"></i>
                            </span>
                            BẮT ĐẦU ĐỊNH GIÁ AI
                        </button>
                    </div>
                </div>

                <div class="w-full lg:w-1/2 flex justify-center items-center relative">
                    <div id="sphere-aura" class="absolute w-[400px] h-[400px] bg-[#007FFF] rounded-full blur-[120px] opacity-10"></div>

                    <div id="ai-sphere" class="relative w-64 h-64 md:w-80 md:h-80 rounded-full flex items-center justify-center border border-white/10 backdrop-blur-md shadow-2xl overflow-hidden cursor-pointer"
                        style="background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.1) 0%, rgba(0,0,0,0.4) 100%);">

                        <div id="sphere-core" class="text-center z-10 p-6">
                            <div id="status-text" class="text-[#007FFF] text-[10px] tracking-[0.4em] uppercase mb-2 opacity-50">Hệ thống sẵn sàng</div>
                            <div id="result-price" class="text-white text-3xl md:text-4xl font-bold sans-serif hidden">0</div>
                            <div id="loading-spinner" class="hidden">
                                <div class="w-12 h-12 border-2 border-[#007FFF] border-t-transparent rounded-full animate-spin mx-auto"></div>
                            </div>
                        </div>

                        <canvas id="sphere-particles" class="absolute inset-0 opacity-40"></canvas>
                    </div>

                    <div id="shockwave" class="absolute w-20 h-20 border-2 border-[#007FFF] rounded-full opacity-0 pointer-events-none"></div>
                </div>

            </div>
        </div>
    </section>

    <!-- ----------------------------- section 4 -----------------------------  -->
    <section id="social-pulse" class="relative py-24 bg-[#F2F4F7] z-10 border-t border-white" style="padding-left: 45px;">
        <div class="grainy-overlay"></div>

        <div class="absolute inset-0 pointer-events-none">
            <div id="sticky-title-container" class="sticky top-1/2 -translate-y-1/2 h-fit">
                <div id="sticky-title" class="hidden lg:block ml-10">
                    <h2 class="serif-title text-sm tracking-[0.5em] text-[#001F3F] origin-left rotate-90 whitespace-nowrap opacity-50">
                        NHỊP ĐẬP THỊ TRƯỜNG
                    </h2>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="mb-20">
                <div class="flex items-center gap-4 mb-6">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </span>
                    <span class="sans-text text-[10px] font-bold tracking-[0.3em] text-[#001F3F] uppercase">Giao dịch trực tiếp</span>
                </div>

                <div class="marquee-wrapper">
                    <div class="marquee-content flex gap-8 whitespace-nowrap">
                        <div class="transaction-card">
                            <div class="glint-pulse"></div>
                            <span class="customer-name">Anh Trần V.</span>
                            <span class="plate-number">30K - 999.XX</span>
                            <span class="status-tag">Vừa chốt đơn</span>
                        </div>
                        <div class="transaction-card">
                            <span class="customer-name">Chị Lê M.</span>
                            <span class="plate-number">51L - 888.XX</span>
                            <span class="status-tag">10 phút trước</span>
                        </div>
                        <div class="transaction-card">
                            <span class="customer-name">Khách hàng 09xx</span>
                            <span class="plate-number">60A - 666.XX</span>
                            <span class="status-tag">Vừa thanh toán</span>
                        </div>
                        <div class="transaction-card">
                            <span class="customer-name">Anh Trần V.</span>
                            <span class="plate-number">30K - 999.XX</span>
                            <span class="status-tag">Vừa chốt đơn</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-12">
                <div class="w-full lg:w-[60%] bg-[#001F3F] rounded-[2.5rem] p-10 text-white relative overflow-hidden shadow-2xl">
                    <div class="relative z-10">
                        <h3 class="serif-title text-3xl mb-8 uppercase tracking-widest text-[#007FFF]">Phiên đấu giá tiêu điểm</h3>
                        <div class="flex items-center gap-12">
                            <div class="plate-highlight bg-white/10 backdrop-blur-md p-6 rounded-xl border border-white/20">
                                <span class="text-4xl md:text-5xl font-bold tracking-tighter serif-title">30K - 555.55</span>
                            </div>
                            <div class="countdown-timer flex gap-6" id="auction-timer">
                                <div class="time-block">
                                    <span class="block text-4xl font-bold" id="hours">02</span>
                                    <span class="text-[10px] text-gray-400 uppercase tracking-widest">Giờ</span>
                                </div>
                                <span class="text-4xl text-[#007FFF]">:</span>
                                <div class="time-block">
                                    <span class="block text-4xl font-bold" id="mins">45</span>
                                    <span class="text-[10px] text-gray-400 uppercase tracking-widest">Phút</span>
                                </div>
                                <span class="text-4xl text-[#007FFF]">:</span>
                                <div class="time-block">
                                    <span class="block text-4xl font-bold" id="secs">12</span>
                                    <span class="text-[10px] text-gray-400 uppercase tracking-widest">Giây</span>
                                </div>
                            </div>
                        </div>
                        <button class="mt-10 px-10 py-4 bg-white text-[#001F3F] font-bold rounded-full hover:bg-[#007FFF] hover:text-white transition-all duration-500 shadow-xl">
                            THAM GIA ĐẤU GIÁ NGAY
                        </button>
                    </div>
                    <i class="ri-hammer-line absolute right-[-20px] bottom-[-20px] text-[200px] text-white/5 rotate-12"></i>
                </div>

                <div class="w-full lg:w-[40%] bg-white/50 backdrop-blur-xl rounded-[2.5rem] p-10 border border-white">
                    <h3 class="sans-text font-bold tracking-[0.2em] text-[#001F3F] mb-8 text-sm uppercase">Ký gửi mới nhất</h3>
                    <div class="space-y-6" id="consignment-list">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                            <div>
                                <p class="text-sm font-bold text-[#001F3F]">30K-123.45</p>
                                <p class="text-[10px] text-gray-400">Vừa ký gửi - Hà Nội</p>
                            </div>
                            <span class="text-[#007FFF] font-bold">1.2 Tỷ</span>
                        </div>
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                            <div>
                                <p class="text-sm font-bold text-[#001F3F]">51L-999.99</p>
                                <p class="text-[10px] text-gray-400">Vừa ký gửi - TP.HCM</p>
                            </div>
                            <span class="text-[#007FFF] font-bold">3.5 Tỷ</span>
                        </div>
                    </div>

                    <div class="mt-12 pt-8 border-t border-gray-100 flex justify-between grayscale opacity-30">
                        <i class="ri-bank-line text-2xl"></i>
                        <i class="ri-newspaper-line text-2xl"></i>
                        <i class="ri-government-line text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 5 -----------------------------  -->
    <section id="intelligence-hub" class="relative py-24 bg-[#F8FAFC] overflow-hidden">
        <div class="absolute top-20 right-[-5%] w-96 h-96 bg-white/40 backdrop-blur-3xl rounded-full border border-white/50 rotate-12 pointer-events-none"></div>
        <div class="absolute bottom-10 left-[-5%] w-[500px] h-[500px] bg-blue-50/50 backdrop-blur-2xl rounded-[4rem] border border-white/20 -rotate-6 pointer-events-none"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="mb-16 text-left">
                <h2 class="serif-title text-4xl md:text-5xl text-[#001F3F] leading-tight">
                    NHẬT KÝ <br> <span class="text-[#007FFF] italic">THỊ TRƯỜNG & DI SẢN</span>
                </h2>
                <div class="w-20 h-1 bg-[#007FFF] mt-6"></div>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <div class="lg:w-2/3 group relative overflow-hidden rounded-[1.5rem] md:rounded-[2rem] border border-white bg-white shadow-xl lg:cursor-none knowledge-card" id="featured-post">
                    <div class="relative h-[300px] md:h-[400px] lg:h-[500px] overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&q=80"
                            class="parallax-img w-full h-full object-cover transition-transform duration-700 scale-110" alt="Legal Guide">

                        <div class="absolute inset-x-4 bottom-4 md:inset-x-6 md:bottom-6 backdrop-blur-md bg-white/20 border border-white/30 p-5 md:p-8 rounded-[1rem] md:rounded-[1.5rem] transform translate-y-2 md:translate-y-4 transition-all duration-500 group-hover:translate-y-0">
                            <span class="inline-block px-3 py-1 rounded-full bg-[#007FFF]/20 text-[#007FFF] text-[9px] md:text-[10px] font-bold tracking-widest uppercase mb-2 md:mb-4">Pháp lý & Thủ tục</span>

                            <h3 class="sans-text text-lg md:text-2xl lg:text-3xl font-bold text-white mb-2 md:mb-4 leading-tight">
                                Hướng dẫn thủ tục định danh biển số 2026
                            </h3>

                            <p class="excerpt text-white/90 md:text-white/0 md:group-hover:text-white/90 transition-all duration-500 max-h-[60px] md:max-h-0 md:group-hover:max-h-24 overflow-hidden sans-text text-xs md:text-sm">
                                Cập nhật mới nhất về quy trình chuyển nhượng, thu hồi và đăng ký biển số định danh...
                            </p>

                            <a href="#" class="inline-flex items-center gap-2 mt-4 text-white font-bold text-[10px] tracking-widest uppercase group/btn">
                                Xem chi tiết
                                <span class="w-6 h-[1px] bg-white group-hover/btn:w-10 transition-all"></span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="lg:w-1/3 flex flex-col gap-6">
                    <div class="knowledge-card p-6 bg-white/80 backdrop-blur-md border border-white rounded-[1.5rem] shadow-sm hover:shadow-lg transition-all group">
                        <span class="text-[9px] font-bold text-[#007FFF]/60 uppercase tracking-widest">Phong Thủy</span>
                        <h4 class="sans-text font-bold text-[#001F3F] mt-2 group-hover:text-[#007FFF] transition-colors">Tầm quan trọng của số 8 trong phong thủy biển số xe hiện đại</h4>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-[10px] text-gray-400">5 phút đọc</span>
                            <div class="read-glow-btn text-[#007FFF] text-lg"><i class="ri-arrow-right-up-line"></i></div>
                        </div>
                    </div>
                    <div class="knowledge-card p-6 bg-white/80 backdrop-blur-md border border-white rounded-[1.5rem] shadow-sm hover:shadow-lg transition-all group">
                        <span class="text-[9px] font-bold text-[#007FFF]/60 uppercase tracking-widest">Thị Trường</span>
                        <h4 class="sans-text font-bold text-[#001F3F] mt-2 group-hover:text-[#007FFF] transition-colors">Top 10 biển số đấu giá kỷ lục tháng 12/2025</h4>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-[10px] text-gray-400">3 phút đọc</span>
                            <div class="read-glow-btn text-[#007FFF] text-lg"><i class="ri-arrow-right-up-line"></i></div>
                        </div>
                    </div>
                    <div class="p-6 bg-[#001F3F] rounded-[1.5rem] text-white flex flex-col items-center text-center justify-center gap-4 group cursor-pointer overflow-hidden relative">
                        <div class="absolute inset-0 bg-[#007FFF] opacity-0 group-hover:opacity-10 transition-opacity"></div>
                        <i class="ri-magic-line text-3xl text-[#007FFF] animate-pulse"></i>
                        <p class="text-xs tracking-widest opacity-80 uppercase">Tóm tắt bằng AI</p>
                        <span class="text-[10px] text-gray-500 italic">Nắm bắt 24h tin tức trong 30 giây</span>
                    </div>
                </div>
            </div>

            <div class="mt-20 w-full h-[1px] bg-gray-200 relative overflow-hidden">
                <div id="hub-progress" class="absolute left-0 top-0 h-full bg-[#007FFF] w-0"></div>
            </div>
        </div>
    </section>
    <div id="custom-read-cursor">READ</div>

    <!-- ----------------------------- section 6 -----------------------------  -->

    <?php include "footer.php"; ?>

</body>
<script>
    // Sử dụng IIFE để chạy ngay nhưng kiểm soát được trình tự
    (function() {
        // 1. Ngăn trình duyệt tự động cuộn về vị trí cũ khi F5 (Nguyên nhân chính gây lỗi tọa độ)
        if (history.scrollRestoration) {
            history.scrollRestoration = 'manual';
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Khởi tạo các hiệu ứng
            initSection4();
            initSection5();

            // 2. Kỹ thuật "Double Refresh": Đảm bảo tọa độ chuẩn sau khi render
            let refreshSlider = setTimeout(() => {
                ScrollTrigger.refresh();
            }, 100);

            // 3. Tự động tính toán lại nếu có sự thay đổi về kích thước (do ảnh load muộn)
            const ro = new ResizeObserver(() => {
                ScrollTrigger.refresh();
            });
            ro.observe(document.body);
        });
    })();
    // ----------------------------- section 1 ----------------------------- //
    gsap.registerPlugin(ScrollTrigger);
    // 1. CHẠY NGAY LẬP TỨC (IIFE)
    (function() {
        // Ép trình duyệt không tự động cuộn (Fix lỗi F5 nhảy trang)
        if (history.scrollRestoration) {
            history.scrollRestoration = 'manual';
        }

        document.addEventListener('DOMContentLoaded', () => {

            // 2. TIMELINE KHỞI TẠO (Chạy ngay không đợi load)
            const mainTl = gsap.timeline();
            mainTl.to("#headline", {
                    opacity: 1,
                    y: 0,
                    duration: 1.2,
                    ease: "power4.out"
                })
                .to("#sub-headline", {
                    opacity: 1,
                    y: 0,
                    duration: 0.8
                }, "-=0.8")
                .to("#search-wrapper", {
                    opacity: 1,
                    y: 0,
                    duration: 0.8
                }, "-=0.5");

            // 3. SCROLLTRIGGER CHO HERO
            gsap.to("#headline, #sub-headline", {
                scrollTrigger: {
                    trigger: "#hero-stage",
                    start: "top top",
                    end: "30% top",
                    scrub: 1,
                    invalidateOnRefresh: true // Quan trọng: Tính lại khi refresh
                },
                y: -50,
                opacity: 0,
                immediateRender: false
            });

            gsap.to("#video-wrap video", {
                scrollTrigger: {
                    trigger: "#hero-stage",
                    start: "top top",
                    end: "bottom top",
                    scrub: 1
                },
                filter: "blur(15px) brightness(0.4)",
                scale: 1.1,
                force3D: true
            });

            // 4. FIX LỖI TỌA ĐỘ BẰNG REFRESH NHANH
            // Thay vì 'load', ta dùng 2 nhịp Refresh để ép trình duyệt tính toán lại
            ScrollTrigger.refresh();

            // Nhịp phụ sau 200ms khi trình duyệt đã render xong CSS
            setTimeout(() => {
                ScrollTrigger.refresh();
            }, 200);
        });

        // 5. MAGNETIC SEARCH & GLINT (Giữ nguyên logic nhưng chạy độc lập)
        // ... (Phần code Magnetic và Glint của bạn giữ nguyên)
        // 3. Magnetic Search FIXED
        const searchWrapper = document.getElementById('search-wrapper');
        const searchBox = document.querySelector('.crystal-search');

        // Chỉ chạy hiệu ứng hút khi chuột KHÔNG đè trực tiếp lên ô input
        document.addEventListener('mousemove', (e) => {
            const rect = searchWrapper.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;
            const dist = Math.hypot(e.clientX - centerX, e.clientY - centerY);

            // Kiểm tra nếu chuột nằm trong vùng ô search
            const isInside = e.clientX >= rect.left && e.clientX <= rect.right &&
                e.clientY >= rect.top && e.clientY <= rect.bottom;

            if (dist < 400 && !isInside) {
                gsap.to(searchBox, {
                    x: (e.clientX - centerX) * 0.12,
                    y: (e.clientY - centerY) * 0.12,
                    duration: 0.5,
                    ease: "power2.out"
                });
            } else {
                gsap.to(searchBox, {
                    x: 0,
                    y: 0,
                    duration: 0.4,
                    ease: "power3.out"
                });
            }
        });

        // 4. Glint Effect
        gsap.to("#glint", {
            left: "150%",
            duration: 2.5,
            repeat: -1,
            repeatDelay: 5,
            ease: "power2.inOut"
        });
    })();
    // ----------------------------- section 2 ----------------------------- //
    (function() {
        document.addEventListener('DOMContentLoaded', () => {
            // Khởi tạo ScrollTrigger cho Section 2
            gsap.from("#infinite-vault .plate-card", {
                scrollTrigger: {
                    trigger: "#infinite-vault",
                    start: "top 80%",
                    invalidateOnRefresh: true
                },
                y: 50,
                opacity: 0,
                scale: 0.9,
                stagger: 0.1,
                duration: 1,
                ease: "power2.out"
            });

            // Xử lý chuyển đổi Tab
            window.switchGallery = (type) => {
                const slider = document.getElementById('tab-slider');
                const autoG = document.getElementById('gallery-auto');
                const motoG = document.getElementById('gallery-moto');
                const isDesktop = window.innerWidth > 1024;

                // 1. Di chuyển thanh slider
                if (type === 'auto') {
                    gsap.to(slider, {
                        x: 0,
                        duration: 0.4,
                        ease: "back.out"
                    });
                    animateTransition(motoG, autoG);
                } else {
                    const moveVal = isDesktop ? 144 : 124;
                    gsap.to(slider, {
                        x: moveVal,
                        duration: 0.4,
                        ease: "back.out"
                    });
                    animateTransition(autoG, motoG);
                }
            };

            function hideGallery(el, callback) {
                gsap.to(el.querySelectorAll('.plate-card'), {
                    opacity: 0,
                    y: 20,
                    scale: 0.95,
                    stagger: 0.05,
                    duration: 0.3,
                    onComplete: () => {
                        el.classList.add('hidden');
                        if (callback) callback();
                    }
                });
            }

            function animateTransition(fadeOutEl, fadeInEl) {
                // 1. Thu nhỏ và ẩn gallery cũ
                gsap.to(fadeOutEl.querySelectorAll('.plate-card'), {
                    opacity: 0,
                    scale: 0.9,
                    y: 20,
                    stagger: 0.05,
                    duration: 0.3,
                    onComplete: () => {
                        fadeOutEl.classList.add('hidden');
                        fadeOutEl.classList.remove('absolute'); // Bỏ absolute để không chiếm chỗ ngầm

                        // 2. Hiện gallery mới
                        fadeInEl.classList.remove('hidden');
                        // Nếu là moto thì cho absolute để đè đúng vị trí nếu cần, 
                        // hoặc để tự nhiên nếu auto là chính. Ở đây ta để mặc định là grid

                        gsap.fromTo(fadeInEl.querySelectorAll('.plate-card'), {
                            opacity: 0,
                            scale: 1.1,
                            y: -20
                        }, {
                            opacity: 1,
                            scale: 1,
                            y: 0,
                            stagger: 0.08,
                            duration: 0.5,
                            ease: "power2.out"
                        });
                    }
                });
            }

            function showGallery(el) {
                el.classList.remove('hidden');
                // Force display cho mobile nếu đang ở dạng flex
                if (window.innerWidth <= 640 && el.id === 'gallery-moto') {
                    el.style.display = 'flex';
                } else {
                    el.style.display = 'grid';
                }

                gsap.fromTo(el.querySelectorAll('.plate-card'), {
                    opacity: 0,
                    y: -20,
                    scale: 1.05
                }, {
                    opacity: 1,
                    y: 0,
                    scale: 1,
                    stagger: 0.1,
                    duration: 0.5
                });
            }
        });
    })();

    // ----------------------------- section 3 ----------------------------- //
    window.addEventListener('load', () => {
        // 1. Matrix Pulse Effect
        gsap.to("#matrix-grid", {
            scale: 1.1,
            opacity: 0.3,
            duration: 4,
            repeat: -1,
            yoyo: true,
            ease: "sine.inOut"
        });

        // 2. Tạo các điểm sáng Nodes lơ lửng
        const nodesContainer = document.getElementById('data-nodes');
        for (let i = 0; i < 20; i++) {
            const node = document.createElement('div');
            node.className = 'absolute w-1 h-1 bg-[#007FFF] rounded-full opacity-40';
            node.style.left = Math.random() * 100 + '%';
            node.style.top = Math.random() * 100 + '%';
            nodesContainer.appendChild(node);

            gsap.to(node, {
                y: "random(-100, 100)",
                x: "random(-100, 100)",
                opacity: "random(0.1, 0.6)",
                duration: "random(3, 6)",
                repeat: -1,
                yoyo: true,
                ease: "sine.inOut"
            });
        }

        // 3. Logic Định giá AI
        const btnAnalyze = document.getElementById('btn-analyze');
        const plateInput = document.getElementById('plate-input');
        const resultPrice = document.getElementById('result-price');
        const statusText = document.getElementById('status-text');
        const loadingSpinner = document.getElementById('loading-spinner');
        const aiSphere = document.getElementById('ai-sphere');

        btnAnalyze.addEventListener('click', () => {
            if (plateInput.value === "") return alert("Vui lòng nhập biển số!");

            // Bắt đầu quét
            statusText.innerText = "Đang mã hóa dữ liệu...";
            loadingSpinner.classList.remove('hidden');
            resultPrice.classList.add('hidden');

            // Hiệu ứng hạt chảy vào tâm (Data Stream)
            gsap.to(aiSphere, {
                scale: 1.1,
                duration: 0.5,
                repeat: 3,
                yoyo: true
            });

            setTimeout(() => {
                loadingSpinner.classList.add('hidden');
                resultPrice.classList.remove('hidden');
                statusText.innerText = "ĐỊNH GIÁ HOÀN TẤT";

                // Giá giả lập ngẫu nhiên cho demo
                const finalVal = Math.floor(Math.random() * 5000000000) + 500000000;
                let obj = {
                    val: 0
                };

                // Counting Momentum
                gsap.to(obj, {
                    val: finalVal,
                    duration: 2.5,
                    ease: "expo.out",
                    onUpdate: () => {
                        resultPrice.innerHTML = Math.floor(obj.val).toLocaleString('vi-VN') + ' VNĐ';
                    },
                    onComplete: () => {
                        // Shockwave & Shake khi dừng lại
                        resultPrice.classList.add('glow-text');
                        gsap.fromTo(aiSphere, {
                            x: -5
                        }, {
                            x: 5,
                            duration: 0.05,
                            repeat: 10,
                            yoyo: true
                        });

                        // Shockwave animation
                        gsap.fromTo("#shockwave", {
                            width: 100,
                            height: 100,
                            opacity: 1
                        }, {
                            width: 800,
                            height: 800,
                            opacity: 0,
                            duration: 1.5,
                            ease: "power2.out"
                        });
                    }
                });
            }, 2000);
        });
    });

    // ----------------------------- section 4 ----------------------------- //
    window.addEventListener('load', () => {
        // 1. Tối ưu Marquee
        const marquee = document.querySelector('.marquee-content');
        // Chỉ nhân bản nếu chưa có đủ nội dung để lặp
        if (marquee.children.length < 8) {
            marquee.innerHTML += marquee.innerHTML;
        }

        // Velocity Mapping: Tốc độ marquee chạy theo nhịp cuộn
        let scrollVelocity = 1;
        ScrollTrigger.create({
            onUpdate: (self) => {
                scrollVelocity = 1 + Math.abs(self.getVelocity() / 1000);
                gsap.to(marquee, {
                    timeScale: scrollVelocity,
                    duration: 0.5
                });
            }
        });


        // Tìm đoạn này trong phần script Section 4
        gsap.to("#sticky-title", {
            scrollTrigger: {
                trigger: "#social-pulse",
                start: "top -80%",
                end: "bottom 80%", // Đảm bảo kết thúc trước khi chạm tới Footer
                pin: true,
                pinSpacing: false, // QUAN TRỌNG: Đặt là false để không tạo khoảng trống dư
                anticipatePin: 1
            }
        });

        // 3. Countdown Tension (Giữ nguyên logic nhảy số)
        const secsLabel = document.getElementById('secs');
        if (secsLabel) {
            setInterval(() => {
                let currentSec = parseInt(secsLabel.innerText);
                if (currentSec > 0) {
                    currentSec--;
                    secsLabel.innerText = currentSec < 10 ? '0' + currentSec : currentSec;
                    gsap.fromTo(secsLabel, {
                        scale: 1.2,
                        color: "#007FFF"
                    }, {
                        scale: 1,
                        color: "#FFFFFF",
                        duration: 0.4
                    });
                } else {
                    secsLabel.innerText = "59"; // Reset để demo
                }
            }, 1000);
        }

        // 4. Reveal Animation (Đảm bảo container hiện hết)
        gsap.from("#social-pulse .container", {
            scrollTrigger: {
                trigger: "#social-pulse",
                start: "top 80%",
            },
            y: 100,
            opacity: 0,
            duration: 1.5,
            ease: "power4.out"
        });
    });

    // ----------------------------- section 5 ----------------------------- //
    // Sử dụng IIFE để cô lập code và chạy ngay
    (function() {
        // Ngăn trình duyệt nhảy về vị trí cũ khi F5 (Nguyên nhân gây lệch ScrollTrigger)
        if (history.scrollRestoration) {
            history.scrollRestoration = 'manual';
        }

        document.addEventListener('DOMContentLoaded', () => {
            // 1. Khởi tạo thanh Progress trước (Vì nó đơn giản)
            gsap.to("#hub-progress", {
                width: "100%",
                ease: "none",
                scrollTrigger: {
                    trigger: "#intelligence-hub",
                    start: "top center",
                    end: "bottom center",
                    scrub: true
                }
            });

            // 2. Hiệu ứng Mở lối tri thức (3D Flip)
            gsap.from(".knowledge-card", {
                scrollTrigger: {
                    trigger: "#intelligence-hub",
                    start: "top 80%",
                    // Tự động tính lại tọa độ khi cửa sổ resize hoặc ảnh load xong
                    invalidateOnRefresh: true
                },
                rotateY: 45,
                opacity: 0,
                x: 100,
                stagger: 0.2,
                duration: 1.2,
                ease: "power3.out"
            });

            // 3. Parallax Image Hover (Tối ưu performance)
            const featuredPost = document.getElementById('featured-post');
            const parallaxImg = featuredPost?.querySelector('.parallax-img');

            // Kiểm tra thiết bị ngay đầu sự kiện hoặc dùng biến toàn cục
            const isMobile = window.innerWidth < 1024;

            if (featuredPost && parallaxImg) {
                // CHỈ gán sự kiện nếu không phải là Mobile
                if (!isMobile) {
                    featuredPost.addEventListener('mousemove', (e) => {
                        const {
                            left,
                            top,
                            width,
                            height
                        } = featuredPost.getBoundingClientRect();

                        // Tính toán vị trí chuột tương đối trong card
                        const xVal = (e.clientX - left) / width;
                        const yVal = (e.clientY - top) / height;

                        // Di chuyển ảnh nhẹ nhàng (Biên độ giảm xuống 20 để an toàn cho responsive)
                        gsap.to(parallaxImg, {
                            x: (xVal - 0.5) * 20,
                            y: (yVal - 0.5) * 20,
                            duration: 0.6,
                            ease: "power2.out",
                            overwrite: 'auto'
                        });
                    });

                    featuredPost.addEventListener('mouseleave', () => {
                        // Trả ảnh về vị trí trung tâm khi chuột rời đi
                        gsap.to(parallaxImg, {
                            x: 0,
                            y: 0,
                            scale: 1.1, // Giữ scale nhẹ để không bị lộ mép ảnh
                            duration: 1,
                            ease: "power2.out"
                        });

                        if (document.getElementById('intelligence-hub')) {
                            document.getElementById('intelligence-hub').classList.remove('reading-mode');
                        }
                    });

                    featuredPost.addEventListener('mouseenter', () => {
                        if (document.getElementById('intelligence-hub')) {
                            document.getElementById('intelligence-hub').classList.add('reading-mode');
                        }
                    });
                } else {
                    // ĐỐI VỚI MOBILE: Thay mousemove bằng hiệu ứng Scroll Parallax đơn giản
                    gsap.to(parallaxImg, {
                        scrollTrigger: {
                            trigger: featuredPost,
                            start: "top bottom",
                            end: "bottom top",
                            scrub: true
                        },
                        y: -20, // Chỉ trượt dọc nhẹ khi cuộn trang
                        ease: "none"
                    });
                }
            }
            // 4. Custom Cursor (Tách biệt khỏi load để chạy mượt)
            const readCursor = document.getElementById('custom-read-cursor');
            if (readCursor) {
                document.addEventListener('mousemove', (e) => {
                    gsap.to(readCursor, {
                        x: e.clientX - 30,
                        y: e.clientY - 30,
                        duration: 0.1,
                        overwrite: 'auto'
                    });
                });
            }

            // QUAN TRỌNG: Ép trình duyệt Refresh lại ScrollTrigger sau 2 nhịp
            // Nhịp 1: Ngay khi DOM xong
            ScrollTrigger.refresh();
            // Nhịp 2: Sau 500ms (Lúc này các CSS/Ảnh thường đã chiếm chỗ xong)
            setTimeout(() => {
                ScrollTrigger.refresh();
            }, 500);
        });
    })();
    // ----------------------------- section 6 ----------------------------- //
</script>

</html>