
{{-- Simple CSS for flash messages --}}
<style>
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

    .flash-success { background: #10b981; }
    .flash-error { background: #ef4444; }
    .flash-warning { background: #f59e0b; }
    .flash-info { background: #3b82f6; }
</style>

{{-- Show flash messages directly in HTML --}}
@if(session('success'))
    <div class="flash-message flash-success" id="flashMessage">
        <i class="fas fa-check-circle mr-2"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="flash-message flash-error" id="flashMessage">
        <i class="fas fa-exclamation-circle mr-2"></i>
        {{ session('error') }}
    </div>
@endif

@if(session('warning'))
    <div class="flash-message flash-warning" id="flashMessage">
        <i class="fas fa-exclamation-triangle mr-2"></i>
        {{ session('warning') }}
    </div>
@endif

@if(session('info'))
    <div class="flash-message flash-info" id="flashMessage">
        <i class="fas fa-info-circle mr-2"></i>
        {{ session('info') }}
    </div>
@endif

@if(session('status'))
    <div class="flash-message flash-info" id="flashMessage">
        <i class="fas fa-bell mr-2"></i>
        {{ session('status') }}
    </div>
@endif

{{-- Show validation errors --}}
@if($errors->any())
    <div class="flash-message flash-error" id="flashMessage">
        <i class="fas fa-exclamation-circle mr-2"></i>
        @foreach($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
    </div>
@endif

{{-- Simple JavaScript to auto-hide the message --}}
<script>
    // Wait for page to load
    document.addEventListener('DOMContentLoaded', function() {
        // Find the flash message
        const flashMessage = document.getElementById('flashMessage');
        
        // If it exists, hide it after 3 seconds
        if (flashMessage) {
            setTimeout(function() {
                flashMessage.style.transition = 'opacity 0.5s ease';
                flashMessage.style.opacity = '0';
                
                // Remove from DOM after fade out
                setTimeout(function() {
                    if (flashMessage.parentNode) {
                        flashMessage.parentNode.removeChild(flashMessage);
                    }
                }, 500);
            }, 3000);
        }
    });
</script>