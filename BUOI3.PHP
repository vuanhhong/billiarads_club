<!-- Bài 1: Viết chương trình PHP sử dụng câu lệnh if else để kiểm tra 1 số là số chắn hay số lẻ -->
<?php
$number = 4;

if ($number % 2 == 0){
    echo "$number là số chẵn";
} else {
    echo "$number là số lẻ";
}
?>
<!-- Bài 2: Viết chương trình PHP, sử dụng câu lệnh if else để xếp hạng học lực của học sinh dựa trên điểm thi giữa kì, cuối kì
ĐTB = (điểm giữa kì * 30%) + (điểm cuối kì * 70%)
ĐTB >= 9.0 in ra "Xuất sắc"
7.0 <= ĐTB < 9.0 in ra "Giỏi"
5.0 <= ĐTB < 7.0 in ra "Khá"
ĐTB < 5.0 in ra "Trung bình" -->
<?php 
$giuaki = 9;
$cuoiki = 9.8;
$dtb = ($giuaki * 0.3) + ($cuoiki * 0.7);
if ($dtb >= 9.0){
    echo "<br/>Học lực: Xuất sắc";
} elseif ($dtb >= 7.0 && $dtb < 9.0){
    echo "<br/>Học lực: Giỏi";
} elseif ($dtb >= 5.0 && $dtb < 7.0){
    echo "<br/>Học lực: Khá";
} else {
    echo "<br/>Học lực: Trung bình";
}
?>
<!-- Bài 3: Kiểm tra năm nay là năm chẵn hay lẻ -->
<?php
$nam = 2025;
if ($nam % 2 == 0 ){
    echo "chan";
} else {
    echo "le";
}
?>
<!-- Bài 4: sử dụng vòng lặp For in ra các số từ 1 đến 100  -->
<?php
for ($x = 1; $x <= 100; $x++){
    echo "<br/>$x";
}
?>
<!-- Bài 5: sử dụng vòng lặp For in ra các số từ 1 đến 100, các số chẵn in đậm, số lẻ in thường -->
<?php 
for ($i = 1; $i <= 100; $i++){
    if ($i % 2 == 0){
        echo "<b>$i</b><br/>";
    }
    else {
        echo "$i<br/>";
    }
}
?>
<!-- Bài 6: Sử dụng vòng lặp Foreach in ra các năm trong mảng  -->
 <?php
 $year = array(1991, 1992, 1993, 1994, 1995);
 foreach ($year as $value){
    echo "<br/>$value";
 }
 ?>
