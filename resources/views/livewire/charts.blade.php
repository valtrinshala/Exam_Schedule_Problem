<div>

    <div class="my-12 my-2">
        <h2 class="text-xl font-bold">Aggregated Exam Schedule Data Visualization</h2>
        <p>The charts below display the aggregated exam schedule data based on the uploaded JSON file. The data has been
            summarized and visualized to provide a clearer overview of exam schedules.</p>
    </div>

    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-8 bg-white p-4 rounded-lg">
            <span> Teacher: </span>

            <select name="selectedYear" id="selectedYear" class="border" wire:model="selectedTeacher"
                    wire:change="updateOrdersCount">
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher }}">{{ $teacher }}</option>
                @endforeach
            </select>

            <div x-data="teacherCourses({
            element:$refs.element,
            labels:@json($coursesTeacher),
            data:@json($numberOfExams),
            })"
                 wire:key="{{ \Illuminate\Support\Str::random() }}"
                 class="w-full">
                <canvas style="height:400px" class="w-full" x-ref="element"></canvas>
            </div>
        </div>

        <div class="col-span-4 bg-white p-4 rounded-lg">
            <h1 class="mb-4">Course Room Types</h1>
            <div x-data="courseTypes({
            element:$refs.element,
            labels:['Small', 'Medium', 'Large'],
            data:@json($courseRoomTypes),
            })"
                 wire:key="{{ \Illuminate\Support\Str::random() }}"
                 class="w-full">
                <canvas style="height:400px" class="w-full" x-ref="element"></canvas>
            </div>

            <div class="flex items-center gap-4 mt-5">
                <div class="flex items-center gap-1">
                    <div class="w-4 h-4 rounded bg-red-500"></div>
                    <span>Small</span>
                </div>

                <div class="flex items-center gap-1">
                    <div class="w-4 h-4 rounded bg-red-500"></div>
                    <span>Medium</span>
                </div>

                <div class="flex items-center gap-1">
                    <div class="w-4 h-4 rounded bg-yellow-600"></div>
                    <span>Large</span>
                </div>
            </div>
        </div>

        <div class="col-span-4 bg-white p-4 rounded-lg">
            <h1 class="mb-4">Course Room Types</h1>
            <div x-data="courseTypes({
            element:$refs.element,
            labels:['Desired', 'Undesired', 'Forbidden', 'Preferred'],
            data:@json($coursesConstraintsLevel),
            })"
                 wire:key="{{ \Illuminate\Support\Str::random() }}"
                 class="w-full">
                <canvas style="height:400px" class="w-full" x-ref="element"></canvas>
            </div>
        </div>

        <div class="col-span-4 bg-white p-4 rounded-lg">
            <h1 class="mb-4">Course Room Types</h1>
            <div x-data="courseTypes({
            element:$refs.element,
            labels:['Oral', 'Written', 'WrittenAndOral'],
            data:@json($examTypes),
            })"
                 wire:key="{{ \Illuminate\Support\Str::random() }}"
                 class="w-full">
                <canvas style="height:400px" class="w-full" x-ref="element"></canvas>
            </div>
        </div>
    </div>

</div>