<?php
// 🚨 يجب استدعاء ملف البيانات أولاً، وهو يحتوي على الحماية وبدء الجلسة
include 'dashboard.php';

// ملاحظة: المتغير $result والاتصال $conn متاحان الآن هنا
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="../images/basata.webp" alt="logo" style="height: 40px;">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.html">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../about.html">نبذة عني</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../contact.html">تواصل معنا</a>
                    </li>
                </ul>
                <a class="btn btn-outline-danger me-2" href="../logout.php">
                    تسجيل الخروج
                </a>
            </div>
        </div>
    </nav>
    
    <div class="container mt-4">
        <div class="main">
            <h2 class="text-center mb-4">بيانات المشتركين</h2>
            
            <div class="table-responsive">
                <table class="table table-striped table-hover" dir='rtl'>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">الاسم</th>
                            <th scope="col">البريد الإلكتروني</th>
                            <th scope="col">الموبايل</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // 🔑 استخدام المتغير $result للعرض
                        if ($result->num_rows > 0) {
                            $counter = 1;
                            while ($row = $result->fetch_assoc()) {
                        ?>
                            <tr>
                                <th scope="row"><?php echo $counter++; ?></th>
                                <td><?php echo htmlspecialchars($row["name"]); ?></td>
                                <td><?php echo htmlspecialchars($row["email"]); ?></td>
                                <td><?php echo htmlspecialchars($row["phone"]); ?></td>
                            </tr>
                        <?php
                            } // نهاية حلقة while
                        } else {
                            echo "<tr><td colspan='4' class='text-center'>لا يوجد مشتركين حالياً.</td></tr>";
                        }
                        // 🔑 إغلاق الاتصال بعد انتهاء العرض
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div> </div>
    </div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>