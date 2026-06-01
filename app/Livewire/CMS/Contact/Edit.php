<?php

namespace App\Livewire\CMS\Contact;

use App\Models\ContactSection;
use Livewire\Component;

class Edit extends Component
{
    public ?string $eyebrow = null;

    public string $title = '';

    public ?string $subtitle = null;

    public string $whatsappNumber = '';

    public ?string $email = null;

    public ?string $phone = null;

    public ?string $address = null;

    public ?string $buttonText = null;

    public function mount(): void
    {
        $contact = ContactSection::getOrCreate();

        $this->eyebrow = $contact->eyebrow;
        $this->title = $contact->title;
        $this->subtitle = $contact->subtitle;
        $this->whatsappNumber = $contact->whatsapp_number;
        $this->email = $contact->email;
        $this->phone = $contact->phone;
        $this->address = $contact->address;
        $this->buttonText = $contact->button_text;
    }

    public function save(): void
    {
        $this->validate([
            'eyebrow' => ['nullable', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'whatsappNumber' => ['required', 'string', 'regex:/^[0-9]{8,20}$/'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:1000'],
            'buttonText' => ['nullable', 'string', 'max:255'],
        ], [
            'whatsappNumber.regex' => 'Use country code digits only, without +, spaces, or dashes.',
        ]);

        ContactSection::getOrCreate()->update([
            'eyebrow' => $this->eyebrow,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'whatsapp_number' => $this->whatsappNumber,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'button_text' => $this->buttonText,
        ]);

        session()->flash('success', 'Contact section updated successfully!');
    }

    public function render()
    {
        return view('livewire.cms.contact.edit');
    }
}