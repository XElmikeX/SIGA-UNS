<?php
echo "PHP Version: " . phpversion() . "<br>";
echo "Working Directory: " . getcwd() . "<br>";
echo "Files in directory:<br>";

foreach (scandir('.') as $file) {
    if ($file != '.' && $file != '..') {
        echo "- $file<br>";
    }
}

// Test PostgreSQL
echo "<br>Testing PostgreSQL: ";
try {
    include __DIR__ . '/php/yave.php';
    echo "✅ Connected<br>";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}
?>