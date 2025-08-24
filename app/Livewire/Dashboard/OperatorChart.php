<?php

namespace App\Livewire\Dashboard;

use App\Models\User;
use Livewire\Component;

class OperatorChart extends Component
{
    public $operatorData = [];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $dataRow = array();
        $labels = array();
        $backgroundColor = array();

        $operators = User::select('operators.brand as brand', \DB::raw('count(users.id) as count'))
            ->leftJoin('operators', 'users.operator_id', '=', 'operators.id')
            ->groupBy('operators.brand')
            ->get()
            ->keyBy('brand');

        if (array_key_exists('MCI', $operators->toArray())) {
            $dataRow[] = $operators['MCI']->count;
            $labels[] = 'همراه اول';
            $backgroundColor[] = '#54C5D0';
        }
        if (array_key_exists('MTN', $operators->toArray())) {
            $dataRow[] = $operators['MTN']->count;
            $labels[] = 'ایرانسل';
            $backgroundColor[] = '#FEBE10';
        }
        if (array_key_exists('Rightel', $operators->toArray())) {
            $dataRow[] = $operators['Rightel']->count;
            $labels[] = 'رایتل';
            $backgroundColor[] = '#800080';
        }
        if (array_key_exists('', $operators->toArray())) {
            $dataRow[] = $operators['']->count;
            $labels[] = 'سایر';
            $backgroundColor[] = '#BBBBBB';
        }

        $this->operatorData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'تعداد',
                    'data' => $dataRow,
                    'backgroundColor' => $backgroundColor,
                ]
            ]
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.operator-chart', ['operatorData' => $this->operatorData]);
    }
}
