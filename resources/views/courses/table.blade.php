<table>
    <thead>
    <tr>
        @foreach($columns as $column)
            <th>{{ $column }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($courses as $course)
        <tr>
            @foreach($defaultColumns as $key=>$column)
                <td>
                    {{ $course[$key] ?? '' }}
                </td>
            @endforeach

            @for($i=0; $i<2;$i++)
                <td>
                    {{ $course['primary'][$i] ?? '-' }}
                </td>
            @endfor

            @for($i=0; $i<2;$i++)
                <td>
                    {{ $course['secondary'][$i] ?? '-' }}
                </td>
            @endfor
        </tr>
    @endforeach
    </tbody>
</table>
