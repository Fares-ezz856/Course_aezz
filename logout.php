<?php
// 1. بدء الجلسة
session_start();

// 2. إزالة جميع متغيرات الجلسة (لإلغاء حالة تسجيل الدخول)
$_SESSION = array();

// 3. التحقق مما إذا كانت ملفات تعريف الارتباط الخاصة بالجلسة موجودة، وإزالتها (اختياري لكن مفضل)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. تدمير الجلسة بالكامل من الخادم
session_destroy();

// 5. التوجيه لصفحة تسجيل الدخول (login.html موجود في المجلد الأعلى)
header("Location:index.html");
exit;
?>