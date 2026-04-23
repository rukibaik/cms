<section class="py-20">

    <h2 class="text-3xl text-center">Services</h2>

    <div class="grid grid-cols-3 gap-4 mt-6">
        @foreach ($services as $service)
            <a href="{{ route('services.show', $service->slug) }}" class="border p-4">

                <h3>{{ $service->title }}</h3>
                <p>{{ $service->subtitle }}</p>

            </a>
        @endforeach
    </div>

</section>
