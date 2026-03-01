<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>EasyColoc - Verify Your Email</title>
</head>

<body style="margin:0;padding:0;background:#f4f7fc;font-family:Arial,Helvetica,sans-serif;">

<table width="100%" bgcolor="#f4f7fc" cellpadding="0" cellspacing="0" style="width:100%;">
<tr>
    <td align="center" style="padding:40px 20px;">

        <!-- MAIN CONTAINER -->
        <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#ffffff;border-radius:30px;overflow:hidden;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);">

            <!-- HEADER WITH GRADIENT -->
            <tr>
                <td align="center" style="background:linear-gradient(135deg,#4f46e5,#9333ea);padding:45px 20px 35px;color:white;">
                    
                    <!-- Piggy bank icon -->
                    <div style="font-size:70px;line-height:1;margin-bottom:10px;">🐷</div>
                    
                    <!-- Logo text -->
                    <h1 style="margin:10px 0 5px;font-size:36px;font-weight:800;letter-spacing:-0.5px;color:white;">
                        EasyColoc
                    </h1>
                    
                    <!-- Tagline -->
                    <p style="margin:0;font-size:16px;opacity:0.9;">
                        Verify your email address
                    </p>

                </td>
            </tr>

            <!-- CONTENT -->
            <tr>
                <td style="padding:40px 35px;background:#ffffff;">
                    
                    <!-- Greeting -->
                    <h2 style="margin-top:0;margin-bottom:15px;color:#4f46e5;font-size:28px;font-weight:700;">
                        Hello {{ $info['firstname'] ?? 'there' }}! 👋
                    </h2>
                    
                    <!-- Instructions -->
                    <p style="font-size:18px;color:#1f2937;margin-bottom:25px;line-height:1.5;">
                        Thank you for joining EasyColoc! Please use the verification code below to complete your email verification.
                    </p>

                    <!-- CODE CARD - Main verification code display -->
                    <table width="100%" cellpadding="0" cellspacing="0" style="margin:30px 0;">
                        <tr>
                            <td align="center" style="background:#f5f3ff;border-radius:20px;padding:30px 20px;">
                                
                                <!-- Label -->
                                <p style="margin:0 0 15px;font-size:16px;color:#4f46e5;font-weight:600;text-transform:uppercase;letter-spacing:1px;">
                                    Verification Code
                                </p>
                                
                                <!-- 6-digit code - Large and prominent -->
                                <div style="
                                    background:white;
                                    padding:20px 30px;
                                    border-radius:16px;
                                    display:inline-block;
                                    box-shadow:0 4px 6px -1px rgba(0,0,0,0.1);
                                ">
                                    <span style="
                                        font-size:48px;
                                        font-weight:800;
                                        letter-spacing:8px;
                                        color:#4f46e5;
                                        font-family:monospace;
                                    ">{{ $info['code'] }}</span>
                                </div>
                                
                                <!-- Expiry message -->
                                <p style="margin:20px 0 0;font-size:14px;color:#6b7280;">
                                    <span style="display:inline-block;margin-right:5px;">⏳</span>
                                    This code will expire in 5 minutes
                                </p>

                            </td>
                        </tr>
                    </table>

                    <!-- INSTRUCTIONS CARD -->
                    <table width="100%" cellpadding="0" cellspacing="0" style="margin:25px 0;">
                        <tr>
                            <td style="background:#f9fafb;border-radius:16px;padding:20px;">
                                
                                <p style="margin:0 0 12px;font-weight:600;color:#1f2937;font-size:16px;">
                                    📋 Next steps:
                                </p>
                                
                                <p style="margin:8px 0;color:#4b5563;font-size:15px;">
                                    1. Enter this 6-digit code on the verification page
                                </p>
                                
                                <p style="margin:8px 0;color:#4b5563;font-size:15px;">
                                    2. Click the "Verify Email" button
                                </p>
                                
                                <p style="margin:8px 0;color:#4b5563;font-size:15px;">
                                    3. Start managing your colocation finances!
                                </p>

                            </td>
                        </tr>
                    </table>

                    <!-- TROUBLESHOOTING -->
                    <table width="100%" cellpadding="0" cellspacing="0" style="margin:25px 0;background:#fff7ed;border-radius:16px;">
                        <tr>
                            <td style="padding:20px;">
                                
                                <p style="margin:0 0 10px;font-weight:600;color:#9a3412;font-size:16px;">
                                    ⚠️ Having trouble?
                                </p>
                                
                                <p style="margin:5px 0;color:#b45309;font-size:14px;">
                                    • The code expires after 5 minutes for security reasons
                                </p>
                                
                                <p style="margin:5px 0;color:#b45309;font-size:14px;">
                                    • If you didn't request this, please ignore this email
                                </p>
                                
                                <p style="margin:5px 0;color:#b45309;font-size:14px;">
                                    • Need help? Contact our support team
                                </p>

                            </td>
                        </tr>
                    </table>

                    <p style="text-align:center;color:#6b7280;font-size:14px;margin:20px 0 0;">
                        <span style="display:inline-block;margin-right:5px;">💜</span>
                        Welcome to the EasyColoc community!
                    </p>

                </td>
            </tr>

            <!-- FOOTER -->
            <tr>
                <td align="center" style="background:#f9fafb;padding:30px 20px;border-top:1px solid #e5e7eb;">
                    
                    <p style="margin:0 0 10px;font-size:14px;color:#4f46e5;font-weight:600;">
                        EasyColoc · Shared piggy bank for modern roommates
                    </p>
                    
                    <p style="margin:5px 0;font-size:12px;color:#9ca3af;">
                        This email was sent to {{ $email ?? 'you' }}
                    </p>
                    
                    <p style="margin:0;font-size:12px;color:#9ca3af;line-height:1.6;">
                        If you didn't create an account with EasyColoc, please ignore this email.<br>
                        © {{ date('Y') }} EasyColoc. All rights reserved.
                    </p>

                    <!-- Social icons -->
                    <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:15px;">
                        <tr>
                            <td align="center">
                                <a href="#" style="text-decoration:none;margin:0 8px;">
                                    <img src="https://img.icons8.com/ios-filled/20/4f46e5/facebook-new.png" alt="Facebook" style="width:20px;height:20px;">
                                </a>
                                <a href="#" style="text-decoration:none;margin:0 8px;">
                                    <img src="https://img.icons8.com/ios-filled/20/4f46e5/twitter.png" alt="Twitter" style="width:20px;height:20px;">
                                </a>
                                <a href="#" style="text-decoration:none;margin:0 8px;">
                                    <img src="https://img.icons8.com/ios-filled/20/4f46e5/instagram-new.png" alt="Instagram" style="width:20px;height:20px;">
                                </a>
                            </td>
                        </tr>
                    </table>

                </td>
            </tr>

        </table>

    </td>
</tr>
</table>

</body>
</html>