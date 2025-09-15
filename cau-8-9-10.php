<?php
// Cau 8: Viet function giai phuong trinh bac 2
function giaiPTB2($a, $b, $c) {
    if ($a == 0) {
        if ($b == 0) {
            if ($c == 0) {
                return "Phương trình có vô số nghiệm.";
            } else {
                return "Phương trình vô nghiệm.";
            }
        } else {
            $nghiem = -$c / $b;
            return "Phương trình có một nghiệm: x = $nghiem";
        }
    } else {
        $delta = $b * $b - 4 * $a * $c;
        if ($delta < 0) {
            return "Phương trình vô nghiệm.";
        } elseif ($delta == 0) {
            $nghiem = -$b / (2 * $a);
            return "Phương trình có nghiệm kép: x1 = x2 = $nghiem";
        } else {
            $x1 = (-$b + sqrt($delta)) / (2 * $a);
            $x2 = (-$b - sqrt($delta)) / (2 * $a);
            return "Phương trình có hai nghiệm phân biệt: x1 = $x1, x2 = $x2";
        }
    }
}
echo giaiPTB2(1, -3, 2);
// Cau 9: Viet function in ra man hinh chu nhat rong co kich thuoc 5x7 su dung dau sao (dung vong lap)
function inChuNhatRong($width, $height) {
    for ($i = 0; $i < $height; $i++) {
        for ($j = 0; $j < $width; $j++) {
            if ($i == 0 || $i == $height - 1 || $j == 0 || $j == $width - 1) {
                echo "*";
            } else {
                echo " ";
            }
        }
        echo "\n";
    }
}
inChuNhatRong(5, 7);
// Cau 10: Viet function tinh trung binh cong cua mang
function tinhTrungBinhMang($arr) {
    $sum = array_sum($arr);
    $count = count($arr);
    if ($count == 0) {
        return 0;
    }
    return $sum / $count;
}
// Ví dụ mảng
$numbers = [2, 4, 6, 8, 10];

// Gọi hàm và in kết quả
echo "Trung bình cộng của mảng là: " . tinhTrungBinhMang($numbers);
?>