@php
    $code = $status ?? 500;
    $hint = $hint ?? null;

    [$title, $message] = match ($code) {
        400 => ['طلب غير صالح', 'الطلب الذي أرسلته غير مفهوم أو غير مسموح. يرجى التحقق والعودة للوحة التحكم.'],
        401 => ['تسجيل الدخول مطلوب', 'يجب تسجيل الدخول للوصول إلى هذه الصفحة.'],
        403 => ['وصول مرفوض', 'ليست لديك صلاحية الوصول إلى هذه الصفحة. يمكنك التواصل مع المشرف في حال كان ذلك خطأ.'],
        404 => ['الصفحة غير موجودة', 'الصفحة التي تبحث عنها غير متوفرة أو تم نقلها إلى عنوان آخر.'],
        405 => ['طريقة الطلب غير مدعومة', 'طريقة الطلب المستخدمة غير مدعومة لهذه الصفحة.'],
        413 => ['البيانات كبيرة جداً', 'البيانات أو الملف الذي أرسلته أكبر من الحد المسموح. حاول تقليل حجمه أو إرساله على دفعات.'],
        419 => ['انتهت الجلسة', 'انتهت صلاحية جلستك بسبب مرور وقت طويل. يرجى العودة وإعادة المحاولة.'],
        429 => ['طلبات كثيرة جداً', 'لقد أرسلت عدداً كبيراً من الطلبات في وقت قصير. انتظر لحظات ثم أعد المحاولة.'],
        500 => ['خطأ غير متوقع', 'حدث خطأ غير متوقع أثناء تنفيذ العملية. تم تسجيل المشكلة وسيتم حلها قريباً، يرجى إعادة المحاولة بعد قليل.'],
        503 => ['الصيانة جارية', 'نقوم حالياً بتحديث الخدمة. يرجى العودة بعد قليل.'],
        default => ['خطأ غير متوقع', 'حدث خطأ غير متوقع أثناء تنفيذ العملية. تم تسجيل المشكلة وسيتم حلها قريباً، يرجى إعادة المحاولة بعد قليل.'],
    };
@endphp
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>{{ $code }} - {{ $title }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Tahoma, 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #e2e8f0;
            padding: 1rem;
        }
        .card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 1rem;
            padding: 3rem 2.5rem;
            max-width: 34rem;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.45);
        }
        .code {
            font-size: 3.5rem;
            font-weight: bold;
            color: #f59e0b;
            line-height: 1;
            margin-bottom: 0.75rem;
        }
        h1 { font-size: 1.4rem; margin-bottom: 0.75rem; color: #f8fafc; }
        p { font-size: 1rem; line-height: 1.8; color: #94a3b8; }
        .hint {
            margin-top: 1rem;
            padding: 0.75rem 1rem;
            background: #fef3c7;
            color: #92400e;
            border-radius: 0.5rem;
        }
        .actions { margin-top: 2rem; }
        .actions a {
            display: inline-block;
            padding: 0.7rem 1.6rem;
            background: #f59e0b;
            color: #0f172a;
            font-weight: bold;
            text-decoration: none;
            border-radius: 0.5rem;
            transition: background 0.2s;
        }
        .actions a:hover { background: #fbbf24; }
    </style>
</head>
<body>
    <div class="card">
        <div class="code">{{ $code }}</div>
        <h1>{{ $title }}</h1>
        <p>{{ $message }}</p>
        @if ($hint)
            <p class="hint">{{ $hint }}</p>
        @endif
        <div class="actions">
            <a href="{{ url('/') }}">العودة للصفحة الرئيسية</a>
        </div>
    </div>
</body>
</html>