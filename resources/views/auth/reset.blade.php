<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Code</title>
</head>
<body>
    <h3>Enter the verification code sent to your email</h3>

    <form action="{{ route('verify.code') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="verification_code">Verification Code</label>
            <input type="text" name="verification_code" id="verification_code" required class="form-control" placeholder="Enter 6-digit verification code">
        </div>

        <button type="submit" class="btn btn-submit">Verify Code</button>
    </form>
</body>
</html>
