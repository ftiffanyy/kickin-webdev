<!-- resources/views/auth/otp.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enter OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <h3>Enter OTP</h3>
                    </div>
                    <div class="card-body">
                        <!-- Display success message if OTP has been sent -->
                        @if(session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form action="{{ route('verify.otp') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="otp" class="form-label">OTP</label>
                                <input type="text" id="otp" name="otp" class="form-control" placeholder="Enter OTP" required>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary w-100">Verify OTP</button>
                            </div>
                        </form>
                        <div class="text-center">
                            <a href="{{ route('forgot.password') }}" class="text-link">Back to Forgot Password</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
