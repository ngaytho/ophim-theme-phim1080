<?php

if (!function_exists('ffast_format_view')) {
    function ffast_format_view($num)
    {
        if ($num > 1000) {
            $x = round($num);
            $x_number_format = number_format($x);
            $x_array = explode(',', $x_number_format);
            $x_parts = array('K', 'M', 'B', 'T');
            $x_count_parts = count($x_array) - 1;
            $x_display = $x;
            $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
            $x_display .= $x_parts[$x_count_parts - 1];
            return $x_display;
        }
        return $num;
    }
}

if (!function_exists('ffast_format_icon_menu_left')) {
    function ffast_format_icon_menu_left($name)
    {
        $iconHTML = '<i class="icon icon-ribbon"></i>';

        switch($name) {
            case 'Thể Loại':
                $iconHTML = '<i class="icon icon-book"></i>';
                break;
            case 'Quốc gia':
                $iconHTML = '<i class="icon icon-globe"></i>';
                break;
            case 'Phim Lẻ':
                $iconHTML = '<i class="icon icon-film"></i>';
                break;
            case 'Phim Bộ':
                $iconHTML = '<i class="icon icon-news"></i>';
                break;
            case 'Chiếu Rạp':
                $iconHTML = '<i class="icon icon-ribbon"></i>';
                break;
            case 'Sắp Chiếu':
                $iconHTML = '<i class="icon icon-chart"></i>';
                break;

        }

        return $iconHTML;
    }
}