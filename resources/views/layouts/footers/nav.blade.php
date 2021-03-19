<div class="row align-items-center justify-content-xl-between">
    <div class="col-xl-6">
        <div class="copyright text-center text-xl-left text-muted">
            &copy; {{ now()->year }} <a href="https://github.com/JanKrb" class="font-weight-bold ml-1" target="_blank">JanKrb</a>
        </div>
    </div>
    <div class="col-xl-6">
        <ul class="nav nav-footer justify-content-center justify-content-xl-end">
            <li class="nav-item">
                <a href="{{ route('impress') }}" class="nav-link" target="_blank">Impress</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('privacy') }}" class="nav-link" target="_blank">Privacy</a>
            </li>
            <li class="nav-item">
                <a href="mailto:contact@jankrb.com" class="nav-link">Contact</a>
            </li>
        </ul>
    </div>
</div>
