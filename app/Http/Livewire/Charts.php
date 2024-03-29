<?php

namespace App\Http\Livewire;

use App\Services\FileContentData;
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

    public array $courseTypes = [];

    public function mount()
    {
        $data = (new FileContentData())->get();

        $this->constraints = $data['Constraints'] ?? [];
        $this->teachers = $data['Teachers'] ?? [];
        $this->courses = $data['Courses'] ?? [];

        $this->mountCourseRoomTypes();
        $this->mountCoursesConstraintsLevel();
        $this->mountExamTypes();
        $this->mountCourseTypes();
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

        $this->mountCourseTypes();
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

    protected function mountCourseTypes()
    {
        $teacherCourses = collect($this->courses)->where('Teacher', $this->selectedTeacher);

        $this->courseTypes = [
            $teacherCourses->where('ExamType', 'Written')->count(),
            $teacherCourses->where('ExamType', 'Oral')->count(),
            $teacherCourses->where('ExamType', 'WrittenAndOral')->count(),
        ];
    }
}
