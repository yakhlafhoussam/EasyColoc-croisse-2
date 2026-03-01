<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>EasyColoc Invitation</title>
</head>

<body style="margin:0;padding:0;background:#f4f7fc;font-family:Arial,Helvetica,sans-serif;">

<table width="100%" bgcolor="#f4f7fc" cellpadding="0" cellspacing="0">
<tr>
<td align="center">

<!-- MAIN CONTAINER -->
<table width="600" cellpadding="0" cellspacing="0"
style="background:#ffffff;border-radius:20px;overflow:hidden;">

<!-- HEADER -->
<tr>
<td align="center"
style="background:linear-gradient(135deg,#4f46e5,#9333ea);
padding:40px 20px;color:white;">

<div style="font-size:60px;">🐷</div>

<h1 style="margin:10px 0 5px 0;">
EasyColoc
</h1>

<p style="margin:0;font-size:16px;">
Shared piggy bank for roommates
</p>

</td>
</tr>

<!-- CONTENT -->
<tr>
<td style="padding:35px;">

<h2 style="margin-top:0;color:#4f46e5;">
👋 You're invited to join a colocation!
</h2>

<p style="font-size:16px;color:#333;">
<strong>
{{ $invitation->inviter->firstname ?? 'A roommate' }}
</strong>
wants to share a piggy bank with you 🐷
</p>

<!-- DETAILS BOX -->
<table width="100%" cellpadding="15"
style="background:#f5f3ff;border-radius:12px;margin:20px 0;">

<tr>
<td>

<p style="margin:5px 0;">
🏠 <strong>Colocation:</strong>
{{ $invitation->colocation->name }}
</p>

<p style="margin:5px 0;">
📍 <strong>Location:</strong>
{{ $invitation->colocation->city }},
{{ $invitation->colocation->country }}
</p>

<p style="margin:5px 0;">
👥 <strong>Members:</strong>
{{ count($invitation->colocation->memberships->whereNull('left_at')) }} / {{ $invitation->colocation->max_members }}
</p>

</td>
</tr>

</table>

<!-- EXPIRY -->
<p style="
background:#fffbeb;
border:1px solid #fcd34d;
padding:12px;
border-radius:30px;
display:inline-block;
font-size:14px;
color:#92400e;
">
⏳ Invitation expires on
<strong>
{{ \Carbon\Carbon::parse($invitation->expires_at)->format('d M Y, H:i') }}
</strong>
</p>

<!-- BUTTON -->
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td align="center" style="padding:30px 0;">

<a href="{{ url('/invitation/accept/'.$invitation->token) }}"
style="
background:#4f46e5;
color:white;
text-decoration:none;
padding:16px 35px;
border-radius:40px;
font-weight:bold;
display:inline-block;
font-size:16px;
">
✅ Accept Invitation
</a>

</td>
</tr>
</table>

<p style="text-align:center;color:#666;font-size:14px;">
💜 Start sharing expenses stress-free
</p>

</td>
</tr>

<!-- FOOTER -->
<tr>
<td align="center"
style="padding:25px;font-size:12px;color:#888;">

EasyColoc · Shared piggy bank for modern roommates<br><br>

If you didn't expect this invitation,
you can safely ignore this email.

</td>
</tr>

</table>

</td>
</tr>
</table>

</body>
</html>