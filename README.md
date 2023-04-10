# THEME - PHIM 1080 - OPHIM CMS

Theme này dựa trên theme FFast: <https://github.com/phantom0803/ophim-theme-ffast>

## Requirements

https://github.com/hacoidev/ophim-core

## Install

1. Xóa theme ffast cũ `composer remove ophimcms/theme-ffast`
2. Tại thư mục của Project: `composer require ngaytho/ophim-theme-phim1080` hoặc (nếu bị lỗi) `composer require ngaytho/ophim-theme-phim1080:dev-main`
3. Kích hoạt giao diện trong Admin Panel

## Update
1. Tại thư mục của Project: `composer update ngaytho/ophim-theme-phim1080`
2. Re-Activate giao diện trong Admin Panel

## Note
- Một vài lưu ý quan trọng của các nút chức năng:
    + `Activate` và `Re-Activate` sẽ publish toàn bộ file js,css trong themes ra ngoài public của laravel.
    + `Reset` reset lại toàn bộ cấu hình của themes
