{{-- resources/views/auth/verify-email.blade.php --}}
@extends('layouts.main')

@section('title', 'Verify Email')

@push('styles')
    <style>
        .verification-container {
            min-height: calc(100vh - 200px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .verification-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 2rem;
            padding: 2.5rem;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .code-input {
            width: 60px;
            height: 70px;
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            border: 2px solid #e5e7eb;
            border-radius: 1rem;
            transition: all 0.2s;
        }

        .code-input:focus {
            border-color: #4f46e5;
            outline: none;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .code-input:not(:placeholder-shown) {
            border-color: #4f46e5;
            background: #f5f3ff;
        }

        .timer {
            font-family: monospace;
            font-size: 1.25rem;
            font-weight: 600;
            color: #4f46e5;
        }

        .resend-link {
            color: #4f46e5;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
        }

        .resend-link:hover {
            text-decoration: underline;
        }

        .resend-link.disabled {
            color: #9ca3af;
            pointer-events: none;
            cursor: not-allowed;
        }

        /* Popup styles */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            z-index: 9998;
            display: none;
        }

        .popup-overlay.active {
            display: block;
        }

        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            border-radius: 20px;
            padding: 30px;
            max-width: 400px;
            width: 90%;
            z-index: 9999;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
            display: none;
        }

        .popup.active {
            display: block;
            animation: popupFadeIn 0.3s ease;
        }

        @keyframes popupFadeIn {
            from {
                opacity: 0;
                transform: translate(-50%, -60%);
            }
            to {
                opacity: 1;
                transform: translate(-50%, -50%);
            }
        }

        .popup-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 30px;
        }

        .popup-icon.success {
            background: #10b981;
            color: white;
        }

        .popup-icon.error {
            background: #ef4444;
            color: white;
        }

        .popup-icon.info {
            background: #3b82f6;
            color: white;
        }

        .popup-icon.warning {
            background: #f59e0b;
            color: white;
        }

        .popup-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .popup-message {
            color: #6b7280;
            margin-bottom: 25px;
        }

        .popup-button {
            background: #4f46e5;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .popup-button:hover {
            background: #4338ca;
            transform: scale(1.05);
        }

        /* Flash message styles */
        .flash-message {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            padding: 15px 25px;
            border-radius: 10px;
            color: white;
            font-weight: 500;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            animation: slideIn 0.3s ease;
            max-width: 350px;
        }

        .flash-success { background: #10b981; }
        .flash-error { background: #ef4444; }
        .flash-warning { background: #f59e0b; }
        .flash-info { background: #3b82f6; }
        
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    </style>
@endpush

@section('content')
    <div class="verification-container">
        <div class="verification-card">
            {{-- Header --}}
            <div class="text-center mb-8">
                <div class="bg-indigo-100 w-20 h-20 rounded-2xl flex items-center justify-center text-indigo-600 text-3xl mx-auto mb-4">
                    <i class="fas fa-envelope"></i>
                </div>
                <h1 class="text-3xl font-bold mb-2">Verify your email</h1>
                <p class="text-gray-600">
                    We've sent a verification code to<br>
                    <span class="font-semibold text-indigo-600" id="emailDisplay">
                        {{ session('email') ?? Auth::user()->email ?? 'your email' }}
                    </span>
                </p>
            </div>

            {{-- Verification Form --}}
            <form method="POST" id="verificationForm">
                @csrf

                {{-- Code Input Fields --}}
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 mb-3 text-center">
                        Enter the 6-digit code
                    </label>
                    
                    <div class="flex justify-center gap-3">
                        <input type="text" maxlength="1" class="code-input" id="code1" inputmode="numeric" pattern="[0-9]" autofocus>
                        <input type="text" maxlength="1" class="code-input" id="code2" inputmode="numeric" pattern="[0-9]">
                        <input type="text" maxlength="1" class="code-input" id="code3" inputmode="numeric" pattern="[0-9]">
                        <input type="text" maxlength="1" class="code-input" id="code4" inputmode="numeric" pattern="[0-9]">
                        <input type="text" maxlength="1" class="code-input" id="code5" inputmode="numeric" pattern="[0-9]">
                        <input type="text" maxlength="1" class="code-input" id="code6" inputmode="numeric" pattern="[0-9]">
                    </div>

                    {{-- Hidden input for the complete code --}}
                    <input type="hidden" name="code" id="completeCode">
                </div>

                {{-- Timer and Resend --}}
                <div class="flex justify-between items-center mb-6 text-sm">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-hourglass-half text-gray-400"></i>
                        <span class="timer" id="timer">05:00</span>
                    </div>
                    <div>
                        <span class="text-gray-500 mr-2">Didn't receive code?</span>
                        <a href="#" class="resend-link" id="resendLink">Resend</a>
                    </div>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg transition transform hover:scale-[1.02] mb-4">
                    <i class="fas fa-check-circle mr-2"></i>
                    Verify Email
                </button>

                {{-- Back to login link --}}
                <div class="text-center">
                    <a href="logout" class="text-sm text-gray-500 hover:text-indigo-600 transition" id="backToLogin">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Back to login
                    </a>
                </div>
            </form>

            {{-- Help text --}}
            <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                <p class="text-xs text-gray-400">
                    <i class="fas fa-shield-alt mr-1"></i>
                    The code will expire in 5 minutes for security reasons.
                </p>
            </div>
        </div>
    </div>

    {{-- Popup for messages --}}
    <div class="popup-overlay" id="popupOverlay"></div>
    <div class="popup" id="popup">
        <div class="popup-icon" id="popupIcon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="popup-title" id="popupTitle">Success</div>
        <div class="popup-message" id="popupMessage">Operation completed successfully!</div>
        <button class="popup-button" id="popupButton">OK</button>
    </div>
@endsection

@push('scripts')
    <script>
        // Auto-focus and move to next input
        const inputs = document.querySelectorAll('.code-input');
        const completeCode = document.getElementById('completeCode');

        inputs.forEach((input, index) => {
            input.addEventListener('input', function() {
                // Only allow numbers
                this.value = this.value.replace(/[^0-9]/g, '');
                
                // Move to next input if value is entered
                if (this.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
                
                // Update hidden complete code
                updateCompleteCode();
            });

            input.addEventListener('keydown', function(e) {
                // Handle backspace
                if (e.key === 'Backspace' && this.value.length === 0 && index > 0) {
                    inputs[index - 1].focus();
                }
            });

            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const paste = e.clipboardData.getData('text');
                const numbers = paste.replace(/[^0-9]/g, '').split('');
                
                numbers.forEach((num, i) => {
                    if (i < inputs.length) {
                        inputs[i].value = num;
                    }
                });
                
                // Focus on next empty input or last input
                const nextEmpty = Array.from(inputs).find(input => !input.value);
                if (nextEmpty) {
                    nextEmpty.focus();
                } else {
                    inputs[inputs.length - 1].focus();
                }
                
                updateCompleteCode();
            });
        });

        function updateCompleteCode() {
            const code = Array.from(inputs).map(input => input.value).join('');
            completeCode.value = code;
        }

        // Timer functionality
        function startTimer(duration, display) {
            let timer = duration, minutes, seconds;
            
            const interval = setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    clearInterval(interval);
                    display.textContent = "00:00";
                    
                    // Enable resend link when timer expires
                    const resendLink = document.getElementById('resendLink');
                    resendLink.classList.remove('disabled');
                }
            }, 1000);
            
            return interval;
        }

        // Flash message function
        function showFlashMessage(type, message) {
            const flash = document.createElement('div');
            flash.className = `flash-message flash-${type}`;
            flash.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'} mr-2"></i>${message}`;
            document.body.appendChild(flash);
            
            setTimeout(() => {
                flash.style.animation = 'slideOut 0.3s ease forwards';
                setTimeout(() => {
                    if (flash.parentNode) {
                        flash.remove();
                    }
                }, 300);
            }, 3000);
        }

        // Popup function
        function showPopup(type, title, message) {
            const overlay = document.getElementById('popupOverlay');
            const popup = document.getElementById('popup');
            const icon = document.getElementById('popupIcon');
            const popupTitle = document.getElementById('popupTitle');
            const popupMessage = document.getElementById('popupMessage');
            
            // Set icon based on type
            icon.className = `popup-icon ${type}`;
            if (type === 'success') {
                icon.innerHTML = '<i class="fas fa-check-circle"></i>';
            } else if (type === 'error') {
                icon.innerHTML = '<i class="fas fa-exclamation-circle"></i>';
            } else if (type === 'warning') {
                icon.innerHTML = '<i class="fas fa-exclamation-triangle"></i>';
            } else {
                icon.innerHTML = '<i class="fas fa-info-circle"></i>';
            }
            
            popupTitle.textContent = title;
            popupMessage.textContent = message;
            
            overlay.classList.add('active');
            popup.classList.add('active');
            
            // Close button event
            document.getElementById('popupButton').onclick = function() {
                overlay.classList.remove('active');
                popup.classList.remove('active');
            };
            
            // Close on overlay click
            overlay.onclick = function() {
                overlay.classList.remove('active');
                popup.classList.remove('active');
            };
        }

        // Initialize timer on page load
        document.addEventListener('DOMContentLoaded', function() {
            const timerDisplay = document.getElementById('timer');
            const resendLink = document.getElementById('resendLink');
            
            // Check if there's a stored expiry time in session
            @if(session('verification_expires_at'))
                const expiryTime = new Date("{{ session('verification_expires_at') }}").getTime();
                const now = new Date().getTime();
                const remainingSeconds = Math.floor((expiryTime - now) / 1000);
                
                if (remainingSeconds > 0) {
                    resendLink.classList.add('disabled');
                    startTimer(remainingSeconds, timerDisplay);
                } else {
                    timerDisplay.textContent = "00:00";
                }
            @else
                // Default timer for new verification (5 minutes = 300 seconds)
                resendLink.classList.add('disabled');
                startTimer(300, timerDisplay);
            @endif
        });

        // Back to login handler
        document.getElementById('backToLogin').addEventListener('click', function(e) {
            e.preventDefault();
            showPopup('info', 'Leave page?', 'Are you sure you want to go back to login? Your verification progress will be lost.');
        });

        // Show welcome popup on page load (for demo)
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                showFlashMessage('info', 'Please check your email for the verification code');
            }, 500);
        });
    </script>
@endpush