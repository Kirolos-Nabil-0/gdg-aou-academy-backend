<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $locale === 'ar' ? 'إعادة تعيين كلمة المرور' : 'Reset Password' }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            direction: {{ $locale === 'ar' ? 'rtl' : 'ltr' }};
        }
        
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 20px;
            text-align: center;
            color: white;
        }
        
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }
        
        .content {
            padding: 40px 30px;
        }
        
        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }
        
        .message {
            color: #666;
            line-height: 1.8;
            margin-bottom: 30px;
        }
        
        .token-box {
            background: #f8f9fa;
            border: 2px dashed #667eea;
            border-radius: 8px;
            padding: 20px;
            margin: 30px 0;
            text-align: center;
        }
        
        .token-label {
            color: #667eea;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 14px;
        }
        
        .token {
            font-family: 'Courier New', monospace;
            font-size: 16px;
            color: #333;
            background: white;
            padding: 15px;
            border-radius: 5px;
            word-break: break-all;
            border: 1px solid #e0e0e0;
        }
        
        .button {
            display: inline-block;
            padding: 15px 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
            transition: transform 0.2s;
        }
        
        .button:hover {
            transform: translateY(-2px);
        }
        
        .info-box {
            background: #fff3cd;
            border-{{ $locale === 'ar' ? 'right' : 'left' }}: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .info-box p {
            margin: 0;
            color: #856404;
        }
        
        .footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        
        .footer p {
            margin: 5px 0;
        }
        
        .divider {
            height: 1px;
            background: #e0e0e0;
            margin: 30px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>🎓 GDG Learning Platform</h1>
            <p>{{ $locale === 'ar' ? 'منصة التعلم' : 'Learning Platform' }}</p>
        </div>
        
        <div class="content">
            <div class="greeting">
                {{ $locale === 'ar' ? 'مرحباً' : 'Hello' }} {{ $user->full_name }}،
            </div>
            
            <div class="message">
                @if($locale === 'ar')
                    <p>لقد تلقينا طلباً لإعادة تعيين كلمة المرور الخاصة بحسابك.</p>
                    <p>يمكنك استخدام الرمز التالي لإعادة تعيين كلمة المرور:</p>
                @else
                    <p>We received a request to reset the password for your account.</p>
                    <p>You can use the following token to reset your password:</p>
                @endif
            </div>
            
            <div class="token-box">
                <div class="token-label">{{ $locale === 'ar' ? 'رمز إعادة التعيين' : 'Reset Token' }}</div>
                <div class="token">{{ $token }}</div>
            </div>
            
            <div class="info-box">
                <p>
                    <strong>{{ $locale === 'ar' ? '⏰ هام:' : '⏰ Important:' }}</strong>
                    {{ $locale === 'ar' ? 'هذا الرمز صالح لمدة 60 دقيقة فقط' : 'This token is valid for 60 minutes only' }}
                </p>
            </div>
            
            <div class="divider"></div>
            
            <div class="message" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e0e0e0;">
                <p style="color: #999; font-size: 14px;">
                    @if($locale === 'ar')
                        إذا لم تطلب إعادة تعيين كلمة المرور، يمكنك تجاهل هذه الرسالة بأمان.
                    @else
                        If you did not request a password reset, you can safely ignore this message.
                    @endif
                </p>
            </div>
        </div>
        
        <div class="footer">
            <p><strong>GDG Learning Platform</strong></p>
            <p>Google Developer Groups</p>
            <p style="margin-top: 15px; color: #999;">
                {{ $locale === 'ar' ? 'هذه رسالة تلقائية، يرجى عدم الرد عليها' : 'This is an automated message, please do not reply' }}
            </p>
        </div>
    </div>
</body>
</html>