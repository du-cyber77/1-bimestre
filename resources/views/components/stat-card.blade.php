<div {{ $attributes->merge(['class' => 'col-lg-4 col-md-6 mb-3']) }}>
    <div class="card text-white {{ $bgColor }} shadow-sm h-100">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title display-4">{{ $value }}</h5>
                <p class="card-text">{{ $label }}</p>
            </div>
            <i class="fas {{ $icon }} fa-3x opacity-50"></i>
        </div>
    </div>
</div>