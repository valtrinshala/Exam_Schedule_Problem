<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Charts extends Component
{

    public $teachers;
    public $selectedTeacher;
    public $coursesTeacher=[];
    public $numberOfExams=[];
    public $courses;


    public function render()
    {
        return view('livewire.charts');
    }

    public function mount()
    {
        $filepath = session('filePath');
        $data = json_decode(file_get_contents($filepath), true);

        $this->teachers = $data['Teachers'];
        $this->courses = $data['Courses'];

    }

    public function updateOrdersCount()
    {
        $this->coursesTeacher = collect($this->courses)
            ->where('Teacher', $this->selectedTeacher)
            ->pluck('Course')
            ->keys()
        ->toArray();

        $this->numberOfExams = collect($this->courses)
            ->where('Teacher', $this->selectedTeacher)
            ->pluck('NumberOfExams')
            ->toArray();
//        $this->$coursesTeacher = Order::getYearOrders($this->selectedYear - 1)->groupByMonth();

        $this->emit('updateTheChart');
    }
}
