<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Completion</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Georgia', serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .certificate {
            width: 100%;
            min-height: 100vh;
            max-height: 100vh;
            box-sizing: border-box;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .border {
            border: 10px solid #fff;
            padding: 40px;
            width: 90%;
            max-width: 900px;
            box-sizing: border-box;
            background: rgba(255, 255, 255, 0.95);
        }

        .header {
            margin-bottom: 30px;
        }

        .logo {
            font-size: 48px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 10px;
        }

        .title {
            font-size: 42px;
            font-weight: bold;
            color: #333;
            margin: 20px 0;
            text-transform: uppercase;
            letter-spacing: 3px;
        }

        .subtitle {
            font-size: 18px;
            color: #666;
            margin-bottom: 40px;
        }

        .recipient {
            font-size: 16px;
            color: #666;
            margin-bottom: 10px;
        }

        .name {
            font-size: 36px;
            font-weight: bold;
            color: #333;
            margin: 20px 0;
            border-bottom: 2px solid #667eea;
            display: inline-block;
            padding-bottom: 10px;
        }

        .completion {
            font-size: 18px;
            color: #666;
            margin: 30px 0;
            line-height: 1.6;
        }

        .course-name {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
            margin: 20px 0;
        }

        .details {
            margin: 40px 0;
            font-size: 14px;
            color: #666;
        }

        .details-row {
            display: inline-block;
            margin: 0 30px;
        }

        .footer {
            margin-top: 50px;
            font-size: 12px;
            color: #999;
        }

        .certificate-number {
            margin-top: 150px;
            font-size: 12px;
            color: #999;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="certificate">
        <div class="border">
            <div class="header">
                <div class="logo">GDG</div>
                <div class="subtitle">Google Developer Groups</div>
            </div>

            <div class="title">Certificate of Completion</div>

            <div class="recipient">This is to certify that</div>

            <div class="name">{{ $userName }}</div>

            <div class="completion">
                has successfully completed the course
            </div>

            <div class="course-name">{{ $courseName }}</div>

            <div class="details">
                <div class="details-row">
                    <strong>Final Grade:</strong> {{ number_format($finalGrade, 2) }}%
                </div>
                <div class="details-row">
                    <strong>Attendance:</strong> {{ number_format($attendancePercentage, 2) }}%
                </div>
            </div>

            <div class="details">
                <strong>Date Issued:</strong> {{ $issuedDate }}
            </div>

            <div class="footer">
                This certificate is awarded in recognition of outstanding achievement and dedication.
            </div>

            <div class="certificate-number">
                Certificate No: {{ $certificateNumber }}
            </div>
        </div>
    </div>
</body>

</html>