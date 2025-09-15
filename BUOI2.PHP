
<?php
//  Câu2: Viết một chương trình PHP để đếm số từ trong một chuỗi sử dụng hàm str_word_count().
$myString = "ThuyLinh!";
echo "Số từ của chuỗi là : ". str_word_count($myString);
?>
<?php
$number1 = 123; 
$number2 = 456;   
$string = "VTAH";
echo $number1; 
echo $string;
$tong = $number1 + $number2;
echo "<br/>Tổng của $number1 và $number2 là: $tong";

// ví dụ SWITCH CASE
$a = 10;
$b = 5;
$operator = "+"; 

switch ($operator) {
    case "+":
        echo "Tổng: " . ($a + $b);
        break;
    case "-":
        echo "Hiệu: " . ($a - $b);
        break;
    case "*":
        echo "Tích: " . ($a * $b);
        break;
    case "/":
        echo "Thương: " . ($a / $b);
        break;
    default:
        echo "Phép toán không hợp lệ!";
}
?>