<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public $updateOutput = '';
    public $isUpdating = false;
    public $currentCommit = '';

    public function mount()
    {
        $this->loadCurrentCommit();
    }

    public function loadCurrentCommit()
    {
        try {
            $basePath = base_path();
            $commitHash = shell_exec('git -c safe.directory="' . $basePath . '" rev-parse --short HEAD');
            $commitMessage = shell_exec('git -c safe.directory="' . $basePath . '" log -1 --pretty=%B');
            $branch = shell_exec('git -c safe.directory="' . $basePath . '" rev-parse --abbrev-ref HEAD');
            
            if ($commitHash) {
                $this->currentCommit = trim($branch) . ' @ ' . trim($commitHash) . ' (' . trim(strtok($commitMessage, "\n")) . ')';
            } else {
                $this->currentCommit = 'Unknown (Git not initialized or not accessible)';
            }
        } catch (\Exception $e) {
            $this->currentCommit = 'Error loading commit info: ' . $e->getMessage();
        }
    }

    public function updateSite()
    {
        $this->isUpdating = true;
        $this->updateOutput = "Starting update process...\n\n";

        $basePath = base_path();

        // Commands to run
        $commands = [
            'git -c safe.directory="' . $basePath . '" reset --hard HEAD 2>&1',
            'git -c safe.directory="' . $basePath . '" pull origin main 2>&1',
            'php artisan migrate --force 2>&1',
            'php artisan optimize:clear 2>&1',
        ];

        $output = [];
        foreach ($commands as $command) {
            $output[] = "$ " . $command;
            $cmdOutput = [];
            $status = null;
            exec("cd " . base_path() . " && " . $command, $cmdOutput, $status);
            $output[] = implode("\n", $cmdOutput);
            $output[] = "Exit Code: " . $status . "\n";
        }

        $this->updateOutput .= implode("\n", $output);

        $this->loadCurrentCommit();
        $this->isUpdating = false;
        
        session()->flash('update_message', 'Update process completed.');
    }

    public function render()
    {
        // Fetch stats
        $stats = [
            'total_users' => User::whereJsonContains('roles', 'user')->count(),
            'total_drivers' => User::whereJsonContains('roles', 'driver')->count(),
            'total_admins' => User::whereJsonContains('roles', 'admin')->count(),
            'bus_stops' => 2,
            'auto_stops' => 1,
            'taxi_stands' => 1,
            'parkings' => 1,
        ];

        return view('livewire.admin.dashboard', compact('stats'))
            ->layout('components.layouts.app', ['title' => 'Admin Dashboard - RideFinder']);
    }
}
