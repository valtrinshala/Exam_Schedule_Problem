<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CourseExport implements FromView
{
    public array $courses = [];

    public array $columns = [];

    public array $defaultColumns = [];

    public function __construct(array $courses, array $columns, array $defaultColumns)
    {
        $this->courses = $courses;
        $this->columns = $columns;
        $this->defaultColumns = $defaultColumns;
    }

    public function view(): View
    {
        return view('courses.table', [
            'courses' => $this->courses,
            'columns' => $this->columns,
            'defaultColumns' => $this->defaultColumns,
        ]);
    }
}
