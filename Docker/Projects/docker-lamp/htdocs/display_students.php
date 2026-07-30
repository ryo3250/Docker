<?php
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>students</title>
</head>
<body>
    <h1>student_list</h1>
    <?php
        if (isset($_SESSION['data'])) {
            $data = $_SESSION['data'];
            if (count($data) > 0) {
                echo "<table>";
                echo "<thead><tr>";
                foreach (array_keys($data[0]) as $column) {
                    echo "<th>" . htmlspecialchars($column) . "</th>";
                }
                echo "</tr></thead>";
                echo "<tbody>";
                foreach ($data as $row) {
                    echo "<tr>";
                    foreach ($row as $k => $v) {
                        if ($k == "class_id") {
                            echo "<td><a href=\"http://localhost/get_class.php?class_id=" . htmlspecialchars($v) . "\">" . htmlspecialchars($v) . "</a></td>";
                        } else {
                            echo "<td>" . htmlspecialchars($v) . "</td>";
                        }
                    }
                    //削除ボタンを追加
                    echo"<td>";
                    echo"<form method=\"post\" action=\"delete_students.php\" style=\"display:inline;\">";
                    echo "<input type=\"hidden\" name=\"student_id\" value=\"" . htmlspecialchars($row['student_id']) . "\">";
                    echo "<button type=\"submit\" onclick=\"return confirm('ID: " . htmlspecialchars($row['student_id']) . " delete?');\">DELETE</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>no data1</p>";
            }
            unset($_SESSION['data']);
        } else {
            echo "<p>no data2</p>";
        }
    ?>
</body>
</html>
