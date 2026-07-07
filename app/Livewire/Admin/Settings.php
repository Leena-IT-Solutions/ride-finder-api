<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Settings extends Component
{
    public $appName = 'RideFinder';
    public $supportPhone = '+91 96645 88677';
    public $baseFare = 30;
    public $perKmFare = 15;
    public $searchRadius = 5;
    public $maintenanceMode = false;
    
    // Maps Settings
    public $mapsPlatform = 'leaflet'; // leaflet or google
    public $googleMapsApiKey = '';
    public $driverLocationUpdateInterval = 20;

    public function mount()
    {
        $filePath = storage_path('app/settings.json');
        if (file_exists($filePath)) {
            $data = json_decode(file_get_contents($filePath), true);
            $this->appName = $data['app_name'] ?? $this->appName;
            $this->supportPhone = $data['support_phone'] ?? $this->supportPhone;
            $this->baseFare = $data['base_fare'] ?? $this->baseFare;
            $this->perKmFare = $data['per_km_fare'] ?? $this->perKmFare;
            $this->searchRadius = $data['search_radius'] ?? $this->searchRadius;
            $this->maintenanceMode = $data['maintenance_mode'] ?? $this->maintenanceMode;
            $this->mapsPlatform = $data['maps_platform'] ?? $this->mapsPlatform;
            $this->googleMapsApiKey = $data['google_maps_api_key'] ?? $this->googleMapsApiKey;
            $this->driverLocationUpdateInterval = $data['driver_location_update_interval'] ?? $this->driverLocationUpdateInterval;
        }
    }

    public function save()
    {
        $data = [
            'app_name' => $this->appName,
            'support_phone' => $this->supportPhone,
            'base_fare' => $this->baseFare,
            'per_km_fare' => $this->perKmFare,
            'search_radius' => $this->searchRadius,
            'maintenance_mode' => $this->maintenanceMode,
            'maps_platform' => $this->mapsPlatform,
            'google_maps_api_key' => $this->googleMapsApiKey,
            'driver_location_update_interval' => (int)$this->driverLocationUpdateInterval,
        ];

        $filePath = storage_path('app/settings.json');
        file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));
        
        session()->flash('settings_saved', 'Configuration updated successfully!');
    }

    public function render()
    {
        return view('livewire.admin.settings')
            ->layout('components.layouts.app', ['title' => 'Portal Settings - RideFinder']);
    }
}
