<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>العرض الأول</title>
    <style>
.container {
    /* تجعل الحاوية تملأ ارتفاع الصفحة بالكامل */
    height: 100vh;
    /* تفعيل Flexbox */
    display: flex;
    /* توسيط المحتوى أفقيًا */
    justify-content: center;
    /* توسيط المحتوى عموديًا */
    align-items: center;
}

/* يمكن إضافة تنسيقات إضافية للفورم نفسه */
.center-form {
    padding: 80px;
    border: 1px solid #ccc;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
label{
    font-size: 40px;
}
input{
    font-size: 40px;
}

/* تصحيح المحدّد وإضافة التنسيقات لزر الإرسال */
input[type='submit']{
    cursor: pointer;
    /* يمكنك إضافة المزيد من التنسيقات هنا لجعله أجمل */
    background-color: #28a745; 
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    margin-top: 15px; /* لإضافة فاصل بين الحقل والزر */
}
    </style>
</head>
<body>
    <?php 
    // يجب بدء الجلسة في أعلى ملف PHP قبل أي إخراج
    session_start();
    
    // --- جزء عرض رسالة الخطأ ---
    if (isset($_SESSION['error_message'])) {
        echo '<p style="color: red; text-align: center; font-size: 30px; position: absolute; top: 10px; width: 100%;">' . $_SESSION['error_message'] . '</p>';
        unset($_SESSION['error_message']); // حذف الرسالة بعد عرضها
    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "academy_db";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        // يمكنك تخزين رسالة خطأ الاتصال في جلسة أيضاً بدلاً من die
        die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
    }
    
    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['submit'])){
        $static_code="124589/*85";
        
        // استخدام real_escape_string للحماية
        $submitted_code = $conn->real_escape_string($_POST['code']);

        if($submitted_code == $static_code){
            header('Location: video_offer1.html');
            exit(); // مهم جداً
        }
        else{
            $_SESSION['error_message']="الكود الذي أدخلته غير صحيح. حاول مرة أخرى.";
            header('Location: offer.php'); // L كبيرة أفضل
            exit(); // مهم جداً
        }
    }
    ?>

    <div class="container">
    <form class="center-form" method="post" dir="rtl">
        <label>أدخل الكود: </label>
        <input type="text" name="code" >
        <input type="submit" name="submit" value="إرسال">
    </form>
    </div>
</body>
</html>