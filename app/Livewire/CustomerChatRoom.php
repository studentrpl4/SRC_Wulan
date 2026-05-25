<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;

class CustomerChatRoom extends Component
{
    public $newMessage = '';

    protected $rules = [
        'newMessage' => 'required|string|max:10000',
    ];

    public function sendMessage()
    {
        $this->validate();

        $customerId = Auth::guard('customer')->id();

        if (!$customerId) {
            return;
        }

        ChatMessage::create([
            'customer_id' => $customerId,
            'sender' => 'customer',
            'message' => trim($this->newMessage),
            'is_read' => false,
        ]);

        $this->newMessage = '';

        // Dispatch event to trigger scroll in JS
        $this->dispatch('scroll-to-bottom');
    }

    public function render()
    {
        $customerId = Auth::guard('customer')->id();

        if ($customerId) {
            // Mark admin messages as read when customer views chat
            ChatMessage::where('customer_id', $customerId)
                ->where('sender', 'admin')
                ->where('is_read', false)
                ->update(['is_read' => true]);

            $messages = ChatMessage::where('customer_id', $customerId)
                ->orderBy('created_at', 'asc')
                ->get();
        } else {
            $messages = collect();
        }

        return view('livewire.customer-chat-room', [
            'messages' => $messages,
        ]);
    }
}
