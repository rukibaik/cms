@php
    $contact ??= new \App\Models\ContactSection(\App\Models\ContactSection::defaults());
    $contactFormId = 'contact-form-' . spl_object_id($contact);
@endphp

<section id="contact" class="content-visibility-auto relative overflow-hidden bg-brand-darker py-20 lg:py-28">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute left-0 top-0 h-px w-full bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
    </div>

    <div class="relative mx-auto grid max-w-7xl gap-12 px-5 sm:px-6 lg:grid-cols-[0.9fr_1.1fr] lg:gap-16 lg:px-8">
        <div class="flex flex-col justify-center">
            @if ($contact->eyebrow)
                <p class="mb-4 text-sm font-semibold uppercase tracking-[0.2em] text-brand-accent">
                    {{ $contact->eyebrow }}
                </p>
            @endif

            <h2 class="text-3xl font-bold leading-tight tracking-tight text-white text-balance sm:text-4xl lg:text-5xl">
                {{ $contact->title }}
            </h2>

            @if ($contact->subtitle)
                <p class="mt-6 max-w-xl text-base leading-relaxed text-white/65 text-pretty lg:text-lg">
                    {{ $contact->subtitle }}
                </p>
            @endif

            <div class="mt-10 grid gap-4 text-sm text-white/60">
                @if ($contact->email)
                    <a href="mailto:{{ $contact->email }}" class="group flex min-h-11 items-center gap-3 rounded-md transition-colors duration-150 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-accent">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-md border border-white/10 text-brand-accent transition-colors duration-150 group-hover:border-brand-accent/50">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0-9.75 6-9.75-6" />
                            </svg>
                        </span>
                        <span class="break-all">{{ $contact->email }}</span>
                    </a>
                @endif

                @if ($contact->phone)
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contact->phone) }}" class="group flex min-h-11 items-center gap-3 rounded-md transition-colors duration-150 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-accent">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-md border border-white/10 text-brand-accent transition-colors duration-150 group-hover:border-brand-accent/50">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102A1.125 1.125 0 0 0 5.872 2.25H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                            </svg>
                        </span>
                        <span>{{ $contact->phone }}</span>
                    </a>
                @endif

                @if ($contact->address)
                    <p class="flex min-h-11 items-center gap-3">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-md border border-white/10 text-brand-accent">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                        </span>
                        <span class="break-words">{{ $contact->address }}</span>
                    </p>
                @endif
            </div>
        </div>

        <form
            id="{{ $contactFormId }}"
            class="rounded-lg border border-white/10 bg-white/[0.03] p-5 sm:p-8 lg:shadow-xl lg:shadow-black/20"
            data-whatsapp-number="{{ $contact->whatsapp_number }}"
        >
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="{{ $contactFormId }}-name" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-white/45">
                        Full Name
                    </label>
                    <input id="{{ $contactFormId }}-name" name="name" type="text" required autocomplete="name" placeholder="Your name" class="form-control">
                </div>

                <div>
                    <label for="{{ $contactFormId }}-subject" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-white/45">
                        Subject
                    </label>
                    <input id="{{ $contactFormId }}-subject" name="subject" type="text" required autocomplete="off" placeholder="Project inquiry" class="form-control">
                </div>
            </div>

            <div class="mt-5">
                <label for="{{ $contactFormId }}-category" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-white/45">
                    Category
                </label>
                <select id="{{ $contactFormId }}-category" name="category" required class="form-control bg-brand-darker">
                    <option value="">Select a category</option>
                    <option value="General Inquiry">General Inquiry</option>
                    <option value="Creative Campaign">Creative Campaign</option>
                    <option value="Media Production">Media Production</option>
                    <option value="Partnership">Partnership</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="mt-5">
                <label for="{{ $contactFormId }}-message" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-white/45">
                    Message
                </label>
                <textarea id="{{ $contactFormId }}-message" name="message" rows="5" maxlength="500" required placeholder="Tell us what you want to create." class="form-control resize-none"></textarea>
                <p class="mt-2 text-xs text-white/30">Maximum 500 characters.</p>
            </div>

            <button type="submit" class="btn btn-primary mt-6 w-full">
                {{ $contact->button_text ?: 'Send via WhatsApp' }}
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                </svg>
            </button>
        </form>
    </div>
</section>

@once
    @push('scripts')
        <script>
            document.addEventListener('submit', (event) => {
                const form = event.target.matches('form[data-whatsapp-number]')
                    ? event.target
                    : event.target.closest('form[data-whatsapp-number]');

                if (!form) {
                    return;
                }

                event.preventDefault();

                const number = form.dataset.whatsappNumber;

                if (!number) {
                    return;
                }

                const data = new FormData(form);
                const message = [
                    `Name: ${data.get('name') || ''}`,
                    `Subject: ${data.get('subject') || ''}`,
                    `Category: ${data.get('category') || ''}`,
                    `Message: ${data.get('message') || ''}`,
                ].join('\n');

                window.open(`https://wa.me/${number}?text=${encodeURIComponent(message)}`, '_blank', 'noopener,noreferrer');
            });
        </script>
    @endpush
@endonce
