<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Customer;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;

class AdminChatRoom extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static string $view = 'filament.pages.admin-chat-room';

    protected static ?string $navigationLabel = 'Chat Room';

    protected static ?string $title = 'Chat Room';

    protected static ?int $navigationSort = 10;

    public ?int $activeCustomerId = null;
    public string $replyMessage = '';

    protected $rules = [
        'replyMessage' => 'required|string|max:10000',
    ];

    public function mount()
    {
        // Select the customer with the latest unread or active chat by default
        $firstCustomer = Customer::select('customers.id')
            ->selectSub(function ($query) {
                $query->select('created_at')
                    ->from('chat_messages')
                    ->whereColumn('customer_id', 'customers.id')
                    ->latest()
                    ->limit(1);
            }, 'latest_message_at')
            ->has('chatMessages')
            ->orderByDesc('latest_message_at')
            ->first();

        if ($firstCustomer) {
            $this->selectCustomer($firstCustomer->id);
        }
    }

    public function selectCustomer(int $customerId)
    {
        $this->activeCustomerId = $customerId;
        $this->replyMessage = '';

        // Mark messages from this customer as read
        ChatMessage::where('customer_id', $this->activeCustomerId)
            ->where('sender', 'customer')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $this->dispatch('admin-chat-switched');
    }

    public function sendReply()
    {
        $this->validate();

        if (!$this->activeCustomerId) {
            return;
        }

        ChatMessage::create([
            'customer_id' => $this->activeCustomerId,
            'sender' => 'admin',
            'message' => trim($this->replyMessage),
            'is_read' => false,
        ]);

        $this->replyMessage = '';
        $this->dispatch('admin-scroll-to-bottom');
    }

    public function getCustomersProperty()
    {
        return Customer::select('customers.*')
            ->selectSub(function ($query) {
                $query->select('created_at')
                    ->from('chat_messages')
                    ->whereColumn('customer_id', 'customers.id')
                    ->latest()
                    ->limit(1);
            }, 'latest_message_at')
            ->selectSub(function ($query) {
                $query->select('message')
                    ->from('chat_messages')
                    ->whereColumn('customer_id', 'customers.id')
                    ->latest()
                    ->limit(1);
            }, 'latest_message')
            ->selectSub(function ($query) {
                $query->selectRaw('count(*)')
                    ->from('chat_messages')
                    ->whereColumn('customer_id', 'customers.id')
                    ->where('sender', 'customer')
                    ->where('is_read', false);
            }, 'unread_count')
            ->has('chatMessages')
            ->orderByDesc('latest_message_at')
            ->get();
    }

    public function getActiveCustomerProperty()
    {
        if (!$this->activeCustomerId) {
            return null;
        }

        return Customer::find($this->activeCustomerId);
    }

    public function getMessagesProperty()
    {
        if (!$this->activeCustomerId) {
            return collect();
        }

        // Keep marking incoming customer messages as read while actively viewing
        ChatMessage::where('customer_id', $this->activeCustomerId)
            ->where('sender', 'customer')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return ChatMessage::where('customer_id', $this->activeCustomerId)
            ->orderBy('created_at', 'asc')
            ->get();
    }
}
