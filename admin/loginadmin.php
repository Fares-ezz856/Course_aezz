<?php 
// 🔑 بدء الجلسة للحفاظ على حالة الدخول
session_start();

// 🚨🚨 البيانات الثابتة المطلوبة 🚨🚨
$admin_email_fixed = 'ahmad@gmail.com';
$admin_password_fixed = 'ezzahmad123';

// 🚨 تصحيح خطأ بناء الجملة في شرط POST
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // استلام وتنظيف البيانات من النموذج
 $email_input = trim($_POST['email']);
 $password_input = trim($_POST['password']); 
    
    // 🔑🔑 التحقق المباشر من البيانات الثابتة 🔑🔑
    if ($email_input === $admin_email_fixed && $password_input === $admin_password_fixed) {
        
        // تسجيل الدخول بنجاح
        $_SESSION['admin_logged_in'] = true;
        
        // التوجيه إلى صفحة المشرف
        header("Location: dashboardhtml.php"); 
        exit();

    } else {
        // فشل الدخول
        $_SESSION['login_error'] = "خطأ في البريد الإلكتروني أو كلمة المرور.";
        header("Location: login.php");
        exit();
    }
}
else{
    // توجيه لصفحة الدخول إذا لم يكن الطلب POST
header("Location: login.php");
    exit();
}

// ⚠️ ملاحظة: تم حذف جميع كود الاتصال بقاعدة البيانات لعدم الحاجة إليه في هذه الطريقة
?>