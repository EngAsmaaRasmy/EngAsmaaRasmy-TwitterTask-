<!DOCTYPE html>
<html>
<head>
    <title>Login with Mobile Number</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://www.gstatic.com/firebasejs/8.6.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.6.1/firebase-auth.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Login with Mobile Number</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form id="login-form" class="mt-4">
                    <div class="form-group">
                        <input type="tel" class="form-control" id="phone-number" placeholder="Enter phone number" required>
                    </div>
                    <div id="recaptcha-container" class="mb-3"></div>
                    <button type="submit" class="btn btn-primary btn-block" id="send-code-button" disabled>Send Code</button>
                </form>
                <form id="verify-form" class="mt-4" style="display:none;">
                    <div class="form-group">
                        <input type="text" class="form-control" id="verification-code" placeholder="Enter verification code" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Verify Code</button>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        // Firebase config
        var firebaseConfig = {
            apiKey: "{{ env('FIREBASE_API_KEY') }}",
            authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
            projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
            storageBucket: "{{ env('FIREBASE_STORAGE_BUCKET') }}",
            messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
            appId: "{{ env('FIREBASE_APP_ID') }}"
        };
        firebase.initializeApp(firebaseConfig);

        // Initialize reCAPTCHA
        window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
            'size': 'normal',
            'callback': function(response) {
                // reCAPTCHA solved, enable send code button
                document.getElementById('send-code-button').disabled = false;
            },
            'expired-callback': function() {
                // reCAPTCHA expired, disable send code button
                document.getElementById('send-code-button').disabled = true;
            }
        });

        // Render reCAPTCHA
        recaptchaVerifier.render().then(function(widgetId) {
            window.recaptchaWidgetId = widgetId;
        });

        document.getElementById('login-form').addEventListener('submit', function(e) {
            e.preventDefault();
            var phoneNumber = document.getElementById('phone-number').value;
            var appVerifier = window.recaptchaVerifier;
            firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier)
                .then(function(confirmationResult) {
                    window.confirmationResult = confirmationResult;
                    document.getElementById('login-form').style.display = 'none';
                    document.getElementById('verify-form').style.display = 'block';
                    toastr.success('SMS sent successfully. Please enter the verification code.');
                }).catch(function(error) {
                    console.error("SMS not sent", error);
                    toastr.error("SMS not sent. Please try again.");
                });
        });

        document.getElementById('verify-form').addEventListener('submit', function(e) {
            e.preventDefault();
            var code = document.getElementById('verification-code').value;
            confirmationResult.confirm(code).then(function(result) {
                var user = result.user;
                console.log("User signed in:", user);
                // toastr.success('Login successful! Redirecting to dashboard...');
                setTimeout(() => {
                    window.location.href = '/dashboard';
                }, 1000);
            }).catch(function(error) {
                console.error("Code verification failed", error);
                toastr.error("Code verification failed. Please try again.");
            });
        });
    </script>
</body>
</html>
