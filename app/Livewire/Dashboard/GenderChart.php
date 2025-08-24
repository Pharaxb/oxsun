<?php

namespace App\Livewire\Dashboard;

use App\Models\User;
use Livewire\Component;

class GenderChart extends Component
{
    public $genderData = []; // داده‌های چارت

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $dataRow = array();
        $labels = array();
        $backgroundColor = array();

        $male = User::where('gender', 'male')->count();
        $female = User::where('gender', 'female')->count();
        $unknown = User::whereNull('gender')->orWhere('gender', 'other')->count();

        if ($male > 0) {
            $dataRow[] = $male;
            $labels[] = 'مرد';
            $backgroundColor[] = '#36A2EB';
        }
        if ($female > 0) {
            $dataRow[] = $female;
            $labels[] = 'زن';
            $backgroundColor[] = '#FF6384';
        }
        if ($unknown > 0) {
            $dataRow[] = $unknown;
            $labels[] = 'نامعلوم';
            $backgroundColor[] = '#BBBBBB';
        }

        $this->genderData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'نفر',
                    'data' => $dataRow,
                    'backgroundColor' => $backgroundColor,
                ]
            ]
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.gender-chart', ['genderData' => $this->genderData]);
    }
}
