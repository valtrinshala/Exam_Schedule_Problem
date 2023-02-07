<?php

namespace App\Http\Livewire;

use App\Exports\CourseExport;
use App\Traits\LivewireSortable;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Export extends Component
{
    use WithFileUploads;
    use LivewireSortable;

    public $file;

    public ?string $query = '';

    public array $courses = [];

    public array $constraints = [];

    public array $columns = [];

    public int $maxPrimaryCount = 0;

    public int $maxSecondaryCount = 0;

    public function mount()
    {
        $this->courses = cache('courses') ?? [];

        $this->columns = cache('columns') ?? [];
    }

    public function render()
    {
        return view('export');
    }

    public function updatedFile()
    {
        $this->file->store('local');
        session(['filePath' => $this->file->getRealPath()]);

        $data = json_decode(file_get_contents($this->file->getRealPath()), true);

        $curricula = $data['Curricula'];
        $this->constraints = $data['Constraints'];

        $constraintsCount = collect($this->constraints)->groupBy('Course')
            ->mapWithKeys(fn($items, $key) => [$key => $items->count()])
            ->filter(fn($item, $course) => filled($course))
            ->toArray();

        $this->mountCourses(collect($data['Courses']), $curricula, $constraintsCount);

        $this->mountColumns();

        cache()->put('courses', $this->courses);
        cache()->put('columns', $this->columns);
    }

    public function getFilteredCoursesProperty(): array
    {
        if (!$this->query) {
            return $this->courses;
        }

        return collect($this->courses)
            ->filter(fn($course) => false !== stristr($course['course_name'], $this->query))
            ->values()
            ->toArray();
    }

    public function clear()
    {
        $this->courses = [];
        $this->columns = [];

        cache()->forget('courses');
        cache()->forget('columns');
    }

    public function export()
    {
        return Excel::download(new CourseExport($this->filteredCourses, $this->columns, $this->getDefaultColumnsProperty()), 'courses.csv');
    }

    protected function mountCourses(Collection $courses, array $curricula, array $constraintsCount): array
    {
        $this->courses = $courses->map(function (array $course) {
            $isMultiple = $course['ExamType'] === 'WrittenAndOral';

            return $this->multipleCourses($course, $isMultiple);
        })
            ->collapse()
            ->map(function (array $course, int $key) use ($curricula, $constraintsCount) {
                $primary = [];
                $secondary = [];

                $courseId = $course['Course'];

                foreach ($curricula as $item) {
                    if (in_array($courseId, $item['PrimaryCourses'])) {
                        $primary[] = $item['PrimaryCourses'];
                    }

                    if (in_array($courseId, $item['SecondaryCourses'])) {
                        $secondary[] = $item['SecondaryCourses'];
                    }
                }

                $primary = collect($primary)
                    ->collapse()
                    ->filter(fn($item) => $item != $courseId)
                    ->values()
                    ->toArray();

                $secondary = collect($secondary)
                    ->collapse()
                    ->filter(fn($item) => $item != $courseId)
                    ->values()
                    ->toArray();


                $roomForOral = $course['WrittenOralSpecs']['RoomForOral'] ?? null;
                if (!is_null($roomForOral)) {
                    $roomForOral = $roomForOral ? 'True' : 'False';
                }

                $constraint = collect($this->constraints)->where('Course', $course['Course'] ?? -1)->first();

                return [
                    'event_id' => $key + 1,
                    'event_type' => $course['ExamType'],
                    'course_name' => $course['Course'],
                    'min_distance_between_exams' => $course['MinimumDistanceBetweenExams'] ?? '-',
                    'number_of_exams' => $course['NumberOfExams'],
                    'rooms_requested_number' => $course['RoomsRequested']['Number'] ?? '-',
                    'rooms_requested_type' => $course['RoomsRequested']['Type'] ?? '-',

                    'teacher' => $course['Teacher'],
                    'written_oral_specs_max_distance' => $course['WrittenOralSpecs']['MaxDistance'] ?? '-',
                    'written_oral_specs_min_distance' => $course['WrittenOralSpecs']['MinDistance'] ?? '-',
                    'written_oral_specs_rom_for_oral' => $roomForOral ?? '-',
                    'written_oral_specs_same_day' => $course['WrittenOralSpecs']['SameDay'] ?? '-',
                    'constraints_count' => $constraintsCount[$courseId] ?? 0,
                    'constraints_forbidden' => ($constraint['Level'] ?? false) == 'Forbidden' ? 'True' : 'False',
                    'constraints_undesired' =>  ($constraint['Level'] ?? false) == 'Undesired' ? 'True' : 'False',
                    'constraints_preferred' => ($constraint['Level'] ?? false) == 'Preferred' ? 'True' : 'False',

                    'primary' => $primary,
                    'secondary' => $secondary,

                    'primary_count' => count($primary),
                    'secondary_count' => count($secondary),
                ];
            })
            ->toArray();
        return $this->courses;

    }

    protected function multipleCourses(array $course, bool $isMultiple): array
    {
        $numberOfExams = $course['NumberOfExams'] ?? 1;
        $total = $numberOfExams * ($isMultiple ? 2 : 1);

        $newCourses = collect();

        for ($i = 0; $i < $total; $i++) {
            $course['ExamType'] = $this->getExamType($course, $isMultiple, $i);
            $newCourses->push($course);
        }

        return $newCourses->toArray();
    }

    protected function getExamType(array $course, bool $isMultiple, int $i): string
    {
        return $isMultiple ? ($i % 2 == 0 ? 'Written' : 'Oral') : $course['ExamType'];
    }

    protected function mountColumns()
    {
        $columns = $this->getDefaultColumnsProperty();

        $this->maxPrimaryCount = collect($this->courses)->sortByDesc('primary_count')->value('primary_count');
        $this->maxSecondaryCount = collect($this->courses)->sortByDesc('secondary_count')->value('secondary_count');

        for ($i = 1; $i <= $this->maxPrimaryCount; $i++) {
            $columns[] = "Primary-Course-{$i}";
        }

        for ($i = 1; $i <= $this->maxSecondaryCount; $i++) {
            $columns[] = "Secondary-Course-{$i}";
        }

        $this->columns = collect($columns)->values()->toArray();
    }

    public function getDefaultColumnsProperty(): array
    {
        return [
            'event_id' => 'Event ID',
            'event_type' => 'EventType',
            'course_name' => 'CourseName',
            'min_distance_between_exams' => 'MinimumDistanceBetweenExams',
            'number_of_exams' => 'NumberOfExams',
            'rooms_requested_number' => 'RoomsRequestedNumber',
            'rooms_requested_type' => 'RoomsRequested-Type',
            'teacher' => 'Teacher',
            'written_oral_specs_max_distance' => 'WrittenOralSpecs-MaxDistance',
            'written_oral_specs_min_distance' => 'WrittenOralSpecs-MinDistance',
            'written_oral_specs_rom_for_oral' => 'WrittenOralSpecs-RoomForOral',
            'written_oral_specs_same_day' => 'WrittenOralSpecs-SameDay',
            'constraints_count' => 'Constraints-Count',
            'constraints_forbidden' => 'Constraints-EventPeriodConstraint-Forbidden',
            'constraints_undesired' => 'Constraints-EventPeriodConstraint-Undesired',
            'constraints_preferred' => 'Constraints-EventPeriodConstraint-Preferred'
        ];
    }
}
