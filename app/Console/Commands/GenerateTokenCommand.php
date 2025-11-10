<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GenerateTokenCommand extends Command
{
    protected $signature = 'user:generate-token {email=admin@example.com}';
    
    protected $description = 'Generate an API token for a user';

    public function handle(): int
    {
        $email = $this->argument('email');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email '{$email}' not found!");
            return Command::FAILURE;
        }
        
        $tokenName = 'api-token-' . now()->format('Y-m-d-H-i-s');
        $token = $user->createToken($tokenName)->plainTextToken;
        
        $this->newLine();
        $this->line('════════════════════════════════════════');
        $this->info('✅ TOKEN GENERATED SUCCESSFULLY!');
        $this->line('════════════════════════════════════════');
        $this->newLine();
        $this->line('User: ' . $user->name . ' (' . $user->email . ')');
        $this->line('Admin: ' . ($user->is_admin ? 'Yes' : 'No'));
        $this->newLine();
        $this->line('Token:');
        $this->warn($token);
        $this->newLine();
        $this->line('════════════════════════════════════════');
        $this->line('Use it in your API requests:');
        $this->line('════════════════════════════════════════');
        $this->newLine();
        $this->line('curl -X POST \\');
        $this->line('  -H "Authorization: Bearer ' . $token . '" \\');
        $this->line('  -H "Content-Type: application/json" \\');
        $this->line('  http://localhost:8000/api/search/rebuild-index');
        $this->newLine();
        
        return Command::SUCCESS;
    }
}

