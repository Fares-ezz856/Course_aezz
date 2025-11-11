<?php
/**
 * هذا الملف يستقبل بيانات النموذج، يخزنها في قاعدة البيانات،
 * ثم يرسل الرسالة الأخيرة المطلوبة فوراً باستخدام PHPMailer.
 */
session_start();
// 1. استدعاء ملفات PHPMailer عبر Composer
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// 2. بيانات الاتصال بقاعدة البيانات 🚨 يجب تعديلها إذا كانت مختلفة
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "academy_db";
$table_name = "subscribers";

// 🔑 إيميل المشرف الذي يجب منعه من التسجيل في الداتابيز
$admin_email = "ahmad@gmail.com";

// 3. إعدادات SMTP الخاصة بـ Gmail
$smtp_host = 'smtp.gmail.com';
$smtp_port = 587;
$smtp_username = 'faresaboelezz11@gmail.com'; // بريدك الإلكتروني
$smtp_password = 'wfar frma zipa nemn'; // 🔑 كلمة مرور التطبيق


// 4. إنشاء الاتصال بقاعدة البيانات
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 5. استلام وتنظيف البيانات
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    // 6. التنظيف والهروب من الرموز الخاصة
    $safe_name  = $conn->real_escape_string($name);
    $safe_email = $conn->real_escape_string($email);
    $safe_phone = $conn->real_escape_string($phone);

    // 🔑🔑🔑 بداية كتلة الشرط لمنع تسجيل المشرف 🔑🔑🔑
    
    // التحقق أولاً: هل هذا هو إيميل المشرف؟
    if ($safe_email != $admin_email) {
        
        // 7. استعلام الإدخال والتخزين (للمشتركين العاديين فقط)
        $sql = "INSERT INTO $table_name (name, email, phone) 
                 VALUES ('$safe_name', '$safe_email', '$safe_phone')";
        
        // تنفيذ استعلام الإدخال
        $db_insertion_success = mysqli_query($conn, $sql);
        
        // التحقق من نجاح التخزين قبل المتابعة
        if (!$db_insertion_success) {
            // التعامل مع خطأ الإدخال في قاعدة البيانات
            echo "عذراً، حدث خطأ أثناء حفظ بيانات الاشتراك. يرجى المحاولة لاحقاً.";
            echo "<br>الخطأ: " . mysqli_error($conn);
            $conn->close();
            exit();
        }
    } 
    
    // ** إذا كان الإيميل هو إيميل المشرف، سيتم تجاوز خطوة التخزين السابقة **
    
    // **********************************************
    // 8. محاولة إرسال البريد الإلكتروني عبر PHPMailer (تُرسل للمشترك والمشرف)
    // **********************************************
    
    $_SESSION['current_user_email'] = $safe_email;
    $mail = new PHPMailer(true);
    
    try {
        // إعدادات الخادم
        $mail->isSMTP();
        $mail->Host       = $smtp_host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtp_username;
        $mail->Password   = $smtp_password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $smtp_port;

        // إعدادات المرسل والمستلم
        $mail->setFrom($smtp_username, 'أكاديمية بساطة التعليمية');
        $mail->addAddress($email, $name);
        $mail->CharSet = 'UTF-8';

        // ==========================================================
        //       محتوى الرسالة الفورية (مع رابط الفيديو الجديد)
        // ==========================================================
        
        $mail->isHTML(true);
        $subject = 'مرحباً بك! خطوتك الأولى نحو مستقبل أولادك';
        $mail->Subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
        
        // 🔑 رابط الفيديو الفعلي
        $video_link = 'https://www.tandchub.com/sv-oto?cid=a7af487e-fe0b-4760-99a9-234d83311a6f';
        
        $message_html = "
            <p dir='rtl' style='text-align: right;'>السلام عليكم</p>
            <p dir='rtl' style='text-align: right;'><strong>$name مرحبًا</strong></p>
            <p dir='rtl' style='text-align: right;'>يسعدنا في أكاديمية بساطة أن نكمل رحلة التواصل مع عميل مميز مثلك، لديه رغبة حقيقية في تقديم المساعدة لأولاده وإعطائهم فرصة للتغيير.</p>
            <p dir='rtl' style='text-align: right;'>نعلم أن الحياة ضاغطة، والمشاغل كثيرة، وقد تظن أنك لا تمتلك الوقت، أو الجهد لتواصل رحلتك معنا، ولكن لا تقلق، الفرصة ما زالت موجودة!</p>
            <p dir='rtl' style='text-align: right;'>يمكنك مشاهدة فيديو العروض والهدايا مرة أخرى، كما يمكنك التواصل معنا إن كانت لديك مخاوف أو عقبات، وسنقدم لك الدعم اللازم والتفسيرات لكل ما يدور بعقلك.</p>
            <p dir='rtl' style='text-align: right;'>لا تتردد في التواصل معنا وطلب استشارة مجانية.</p>
            <p dir='rtl' style='text-align: right;'>أنت الآن على بُعد خطوة واحدة من الحصول على الأدوات التي تحتاجها لتحقيق النجاح لأولادك في القراءة والكتابة وتغيير مستقبلهم.</p>
            <p dir='rtl' style='text-align: right;'>نحن في انتظارك.</p>
            
            <p dir='rtl' style='text-align: right; margin-top: 20px;'>
                <a href='{$video_link}' style='display: inline-block; padding: 10px 20px; background-color: #f7a049; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;'>
                    اضغط لمشاهدة فيديو اليوم الثالث
                </a>
            </p>
            
            <p dir='rtl' style='text-align: right;'>تواصل معنا على رقم واتس أب: 
                <a href='https://wa.me/966545701004' style='color: #25d366; text-decoration: none; font-weight: bold;'>00966545701004</a>
            </p>
            
            <p dir='rtl' style='text-align: right; font-weight: bold; color: #cc0000;'>لا تدع الفرصة تفوتك.. إبدأ .. إبدأ !</p>
            
            <p dir='rtl' style='text-align: right; margin-top: 30px;'>تمنياتي بالتوفيق،<br>أحمد عبد الجليل<br>أكاديمية بساطة التعليمية</p>
        ";

        $mail->Body = $message_html;
        $mail->AltBody = strip_tags($message_html);

        $mail->send();

    } catch (Exception $e) {
        // يمكنك إظهار رسالة خطأ إرسال الإيميل هنا إذا لزم الأمر
        // echo "فشل إرسال الإيميل: {$mail->ErrorInfo}";
    }

    // 9. التوجيه النهائي
    $conn->close();
    if ($safe_email == $admin_email) {
        // توجيه المشرف لصفحة تسجيل الدخول (login.html)
        header("Location: admin/login.html");
    } else {
        // توجيه المشترك العادي لصفحة الكورسات
        header("Location: courses.html");
    }
    exit();

} else {
    header("Location: index.html");
    exit();
}
?>