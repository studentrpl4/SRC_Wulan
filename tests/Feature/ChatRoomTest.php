<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Customer;
use App\Models\ChatMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\CustomerChatRoom;
use App\Filament\Pages\AdminChatRoom;

class ChatRoomTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function customer_can_send_a_message_via_livewire()
    {
        $customer = Customer::create([
            'email' => 'customer@test.com',
            'password' => bcrypt('password'),
            'name' => 'John Doe',
        ]);

        $this->actingAs($customer, 'customer');

        Livewire::test(CustomerChatRoom::class)
            ->set('newMessage', 'Hello Admin!')
            ->call('sendMessage');

        $this->assertDatabaseHas('chat_messages', [
            'customer_id' => $customer->id,
            'sender' => 'customer',
            'message' => 'Hello Admin!',
            'is_read' => false,
        ]);
    }

    /** @test */
    public function admin_can_reply_via_filament_page()
    {
        $customer = Customer::create([
            'email' => 'customer@test.com',
            'password' => bcrypt('password'),
            'name' => 'John Doe',
        ]);

        // Pre-create a message from the customer so they appear in active chat list
        ChatMessage::create([
            'customer_id' => $customer->id,
            'sender' => 'customer',
            'message' => 'Hello!',
        ]);

        Livewire::test(AdminChatRoom::class)
            ->call('selectCustomer', $customer->id)
            ->set('replyMessage', 'Hello Customer, how can we help?')
            ->call('sendReply');

        $this->assertDatabaseHas('chat_messages', [
            'customer_id' => $customer->id,
            'sender' => 'admin',
            'message' => 'Hello Customer, how can we help?',
        ]);
    }
}
