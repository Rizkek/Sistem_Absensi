<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

/**
 * AI Copilot Assistant Panel
 * Floating AI assistant for contextual help & suggestions
 *
 * Modern, clean design with smooth animations
 */
class AiCopilotPanel extends Component
{
    public bool $isOpen = false;
    public bool $isMinimized = false;
    public array $messages = [];
    public string $userMessage = '';

    public function mount()
    {
        // Load welcome message
        $this->messages = [
            [
                'type' => 'ai',
                'content' => $this->getWelcomeMessage(),
                'timestamp' => now(),
            ],
        ];
    }

    public function togglePanel()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function minimizePanel()
    {
        $this->isMinimized = !$this->isMinimized;
    }

    public function sendMessage()
    {
        if (blank($this->userMessage)) {
            return;
        }

        // Add user message
        $this->messages[] = [
            'type' => 'user',
            'content' => $this->userMessage,
            'timestamp' => now(),
        ];

        // Simulate AI response (replace with actual AI API call)
        sleep(1);
        $this->messages[] = [
            'type' => 'ai',
            'content' => $this->generateAiResponse($this->userMessage),
            'timestamp' => now(),
        ];

        $this->userMessage = '';
    }

    private function getWelcomeMessage(): string
    {
        $user = Auth::user();
        $role = $user->role === 'admin' ? 'Admin' : 'Mentor';

        return "Assalamualaikum, {$user->name}! 👋\n\n"
            . "Saya siap membantu Anda sebagai {$role}.\n\n"
            . "Saya dapat membantu dengan:\n"
            . "✨ Analisis kehadiran santri\n"
            . "✨ Laporan mingguan\n"
            . "✨ Saran perbaikan\n"
            . "✨ Manajemen sesi\n\n"
            . "Apa yang bisa saya bantu hari ini?";
    }

    private function generateAiResponse(string $message): string
    {
        // This is a placeholder - replace with actual AI API call
        $responses = [
            'kehadiran' => '📊 Tingkat kehadiran minggu ini mencapai 87%. Santri yang paling konsisten adalah Fatih & Aisha. Saran: Tingkatkan engagement untuk 3 santri dengan kehadiran di bawah 70%.',
            'laporan' => '📝 Laporan minggu ini menunjukkan peningkatan 5% dalam partisipasi. Total 45 sesi berjalan dengan baik. Apakah Anda ingin saya membuat laporan terperinci?',
            'saran' => '💡 Berdasarkan data, saya menyarankan fokus pada feedback yang lebih personal untuk meningkatkan engagement. Target: 90% kehadiran bulan depan.',
            'default' => '👋 Saya mengerti. Bagaimana saya bisa membantu lebih lanjut? Anda bisa tanyakan tentang kehadiran, laporan, atau saran perbaikan.',
        ];

        $lower = strtolower($message);
        foreach ($responses as $key => $response) {
            if ($key !== 'default' && str_contains($lower, $key)) {
                return $response;
            }
        }

        return $responses['default'];
    }

    public function render()
    {
        return view('livewire.ai-copilot-panel');
    }
}
