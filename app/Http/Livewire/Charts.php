<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Charts extends Component
{
    public $teachers;

    public $selectedTeacher;

    public array $coursesTeacher = [];

    public array $numberOfExams = [];

    public $courses;

    public $constraints;

    public array $courseRoomTypes = [];

    public array $coursesConstraintsLevel = [];

    public array $examTypes = [];

    public function mount()
    {
        $filepath = session('filePath');
        $data = json_decode(file_get_contents($filepath), true);


        $this->constraints =$data['Constraints'];
        $this->teachers = $data['Teachers'];
        $this->courses = $data['Courses'];

        $this->mountCourseRoomTypes();
        $this->mountCoursesConstraintsLevel();
        $this->mountExamTypes();
    }

    public function render()
    {
        return view('livewire.charts');
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

    protected function mountCourseRoomTypes()
    {
        $small = collect($this->courses)->where('RoomsRequested.Type', 'Small')->count();
        $medium = collect($this->courses)->where('RoomsRequested.Type', 'Medium')->count();
        $large = collect($this->courses)->where('RoomsRequested.Type', 'Large')->count();

        $this->courseRoomTypes = [
            $small,
            $medium,
            $large
        ];
    }

    protected function mountCoursesConstraintsLevel()
    {
        $this->coursesConstraintsLevel = [
            collect($this->constraints)->whereNotNull('Course')->where('Level', 'Desired')->count(),
            collect($this->constraints)->whereNotNull('Course')->where('Level', 'Undesired')->count(),
            collect($this->constraints)->whereNotNull('Course')->where('Level', 'Forbidden')->count(),
            collect($this->constraints)->whereNotNull('Course')->where('Level', 'Preferred')->count(),
        ];
    }

    protected function mountExamTypes()
    {
        $this->examTypes = [
            collect($this->courses)->where('ExamType', 'Oral')->count(),
            collect($this->courses)->where('ExamType', 'Written')->count(),
            collect($this->courses)->where('ExamType', 'WrittenAndOral')->count(),
        ];
    }
}
