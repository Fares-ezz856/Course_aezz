<?php
// 🔑 1. بدء الجلسة للحماية
session_start();

// التحقق من أن المشرف قام بتسجيل الدخول
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // إذا لم يكن مسجلاً للدخول، يتم توجيهه إلى صفحة الدخول (مع افتراض أن login.html في المجلد الأعلى)
    header("Location: ../login.html"); 
    exit();
}

// 2. إعدادات قاعدة البيانات
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "academy_db"; 
$table_name = "subscribers"; // جدول المشتركين

// 3. إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {

die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// 4. استعلام جلب البيانات
$sql = "SELECT id, name, email, phone FROM $table_name ORDER BY id "; 
$result = $conn->query($sql);

// 5. لا نغلق الاتصال هنا إلا إذا لم نعد نحتاجه. في هذه الحالة، نغلقه بعد انتهاء عملية العرض في الملف الآخر.
// 🔑 ولكن لتبسيط الأمر الآن، سنغلقه في الملف الآخر بعد انتهاء العرض.
// $conn->close();

// الآن المتغير $result أصبح جاهزاً للاستخدام في ملف dashboard.php
?>