<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $announcement->title }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333333;
            margin: 0;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
        }

        .header {
            background-color: #0d6efd;
            color: #ffffff;
            padding: 24px;
            text-align: left;
        }

        .header h1 {
            margin: 0 0 6px 0;
            font-size: 20px;
            font-weight: 600;
        }

        .header p {
            margin: 0;
            font-size: 13px;
            opacity: 0.9;
        }

        .content {
            padding: 28px 24px;
        }

        .announcement-title {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0 0 16px 0;
        }

        .meta-info {
            background-color: #f8f9fa;
            border-left: 3px solid #0d6efd;
            padding: 10px 14px;
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 20px;
        }

        .message-body {
            font-size: 15px;
            line-height: 1.6;
            color: #495057;
            white-space: pre-line;
            margin-bottom: 24px;
        }

        .footer {
            border-top: 1px solid #e9ecef;
            padding: 18px 24px;
            font-size: 12px;
            color: #888888;
            text-align: center;
            background-color: #fbfbfb;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>School Management</h1>
            <p>New Teacher Announcement</p>
        </div>
        <div class="content">
            <h2 class="announcement-title">{{ $announcement->title }}</h2>
            <div class="meta-info">
                <strong>Posted by:</strong> {{ $announcement->user?->name ?? 'Teacher' }} &bull; {{ $announcement->created_at ? $announcement->created_at->format('M d, Y h:i A') : 'Recent' }}
            </div>
            <div class="message-body">{{ $announcement->message }}</div>
        </div>
        <div class="footer">
            This is a notification from School Management System.
        </div>
    </div>
</body>

</html>