<?php

namespace App\Http\Livewire\Practice;

use App\Models\Practice;
use App\Repositories\PracticeRepository;
use Filament\Forms;
use Livewire\Component;

class Result extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;
    public $practice;
    public $data;
    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('practice')
                ->options(Practice::all()->pluck('name', 'id'))
                ->searchable()
                ->required(),
        ];
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public function submit(PracticeRepository $repo): void
    {
        $this->data = $repo->getResult($this->practice);
    }


    public function render()
    {
        return view('livewire.practice.result');
    }
}
