<?php
// Xử lý form khi người dùng submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy giá trị từ form
    $N = $_POST['number'];
    $X = $_POST['baseX'];
    $Y = $_POST['baseY'];

    // Hàm chuyển đổi từ cơ số X sang cơ số Y
    function convertBase($N, $X, $Y) {
        // Chuyển đổi từ cơ số X sang hệ thập phân
        $decimalValue = 0;
        $length = strlen($N);
        
        for ($i = 0; $i < $length; $i++) {
            // Lấy giá trị số tại vị trí $i
            $char = $N[$i];
            
            // Chuyển ký tự về giá trị số tương ứng
            if ('0' <= $char && $char <= '9') {
                $digitValue = ord($char) - ord('0');
            } elseif ('A' <= $char && $char <= 'F') {
                $digitValue = ord($char) - ord('A') + 10;
            } else {
                // Nếu không hợp lệ, trả về rỗng
                return "";
            }
            
            // Cập nhật giá trị hệ thập phân
            $decimalValue = $decimalValue * $X + $digitValue;
        }
        
        // Chuyển đổi từ hệ thập phân sang cơ số Y
        if ($decimalValue == 0) {
            return "0";
        }
        
        $result = "";
        
        while ($decimalValue > 0) {
            // Lấy phần dư khi chia cho Y
            $remainder = $decimalValue % $Y;
            
            // Chuyển đổi phần dư thành ký tự tương ứng
            if ($remainder < 10) {
                $result .= chr($remainder + ord('0'));
            } else {
                $result .= chr($remainder - 10 + ord('A'));
            }
            
            // Chia số hệ thập phân cho Y
            $decimalValue = (int)($decimalValue / $Y);
        }
        
        // Đảo ngược chuỗi kết quả để được kết quả đúng
        $result = strrev($result);
        
        return $result;
    }

    // Gọi hàm convertBase để chuyển đổi và lưu kết quả
    $output = convertBase($N, (int)$X, (int)$Y);

    // Chuyển hướng người dùng đến trang hiển thị kết quả
    header("Location: {$_SERVER['PHP_SELF']}?result=$output");
    exit();
}

// Lấy kết quả từ query string nếu có
$output = $_GET['result'] ?? "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chuyển đổi số từ cơ số X sang cơ số Y</title>
    <style>
        /* Your CSS styles */
    </style>
</head>
<body>
    <h2>Chuyển đổi số từ cơ số X sang cơ số Y</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="number">Nhập số nguyên dương N:</label>
        <input type="text" id="number" name="number" required>
        <br><br>
        <label for="baseX">Cơ số ban đầu X:</label>
        <input type="number" id="baseX" name="baseX" min="2" max="16" required>
        <br><br>
        <label for="baseY">Cơ số đích Y:</label>
        <input type="number" id="baseY" name="baseY" min="2" max="16" required>
        <br><br>
        <input type="submit" value="Chuyển đổi">
    </form>

    <?php
    // Hiển thị kết quả nếu có
    if (!empty($output)) {
        echo "<h3>Kết quả chuyển đổi:</h3>";
        echo "<p>Output: $output</p>";
    }
    ?>
</body>
</html>


//Để giải bài toán chuyển đổi số từ cơ số X sang cơ số Y, ta cần làm những bước sau đây:

Bước 1: Chuyển đổi từ cơ số X sang hệ thập phân
Đầu tiên, chúng ta cần chuyển số được nhập từ cơ số X sang hệ thập phân. Để làm điều này, ta sử dụng các bước sau:

Lấy từng ký tự của số N: Với mỗi ký tự trong chuỗi số N, ta xác định giá trị của nó dựa trên bảng chữ cái và số.

Chuyển đổi ký tự thành giá trị số: Nếu ký tự là một số từ 0 đến 9, ta lấy giá trị của nó bằng cách trừ đi mã ASCII của '0'. Nếu ký tự là một ký tự từ 'A' đến 'F', ta lấy giá trị của nó bằng cách trừ đi mã ASCII của 'A' và cộng thêm 10.

Tính toán giá trị hệ thập phân: Bắt đầu từ ký tự đầu tiên đến ký tự cuối cùng của chuỗi số N, ta nhân giá trị hiện tại với cơ số X và cộng thêm giá trị mới để tính toán giá trị hệ thập phân cuối cùng.

Bước 2: Chuyển đổi từ hệ thập phân sang cơ số Y
Sau khi có được giá trị hệ thập phân từ bước trên, ta tiến hành chuyển đổi giá trị này sang cơ số Y:

Chia liên tiếp cho cơ số Y: Bắt đầu từ giá trị hệ thập phân, ta liên tục chia cho cơ số Y và lấy phần dư.

Xây dựng chuỗi kết quả: Mỗi lần lấy phần dư, ta xây dựng chuỗi kết quả bằng cách chèn các ký tự tương ứng vào đầu chuỗi.

Đảo ngược chuỗi kết quả: Sau khi hoàn thành vòng lặp, chuỗi kết quả sẽ được đảo ngược để có được kết quả đúng.