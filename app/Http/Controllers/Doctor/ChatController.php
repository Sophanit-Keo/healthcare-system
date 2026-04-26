<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class ChatController extends Controller
{
    public function index(): View
    {
        $userId = Auth::id();

        $messages = Message::query()
            ->where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->orderByDesc('created_at')
            ->get();

        Role::firstOrCreate(['name' => 'patient']);

        $patients = User::query()
            ->where(function ($q) {
                $q->where('role', 'patient')->orWhereHas('roles', function ($rq) {
                    $rq->where('name', 'patient');
                });
            })
            ->orderBy('name')
            ->get();

        return view('Doctor.chat', [
            'messages' => $messages,
            'patients' => $patients,
        ]);
    }

    public function send(Request $request): RedirectResponse
    {
        $request->validate([
            'receiver_id' => ['required', 'exists:users,id'],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => (int) $request->receiver_id,
            'subject' => $request->subject,
            'body' => $request->body,
            'is_read' => false,
        ]);

        return redirect()
            ->route('doctor.chat')
            ->with('success', 'Message sent successfully!');
    }
}
