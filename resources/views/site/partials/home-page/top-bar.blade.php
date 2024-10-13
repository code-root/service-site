<div class="header-top-bar">
    <div class="container">
        <div class="header-top">
            <div class="header-top-left">
                <ul class="header-info">
                    <li><a href="tel:+011235641231"><i class="icon-phone"></i>Call: {{ $settings['phone'] ?? 'Not Available' }}</a></li>
                    <li><a href="mailto:{{ $settings['email'] ?? 'Not Available' }}" target="_blank"><i class="icon-envelope"></i>Email: {{ $settings['email'] ?? 'Not Available' }}</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>