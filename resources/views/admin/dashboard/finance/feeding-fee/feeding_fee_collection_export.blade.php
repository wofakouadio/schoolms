<table>
    <thead>
        <tr>
            <th colspan="8" style="text-align: center">{{ $schoolData->school_name }}</th>
        </tr>
        <tr>
            <th colspan="8" style="text-align: center">Feeding Fee Collection Record Sheet</th>
        </tr>
        <tr>
            <th colspan="4" style="text-align: center">Term: {{ $termData->term_name }}</th>
            <th colspan="4" style="text-align: center">Academic Year: {{ $academicYearData->academic_year_start .'/'. $academicYearData->academic_year_end }}</th>
        </tr>
        <tr>
            <th colspan="8" style="text-align: center">Week {{ $weekData }}</th>
        </tr>
        <tr>
            <th colspan="8" style="text-align: center">Date: {{ $date }}</th>
        </tr>
        <tr>
            <th colspan="8" style="text-align: center">Feeding Fee: {{ $feedingFeeData->school_currency->symbol.' '.$feedingFeeData->fee }}</th>
        </tr>
        <tr>
            <th style="text-align: center">#</th>
            <th style="text-align: center">Level</th>
            <th style="text-align: center">Number of Presents</th>
            <th style="text-align: center">Number of Who do not Pay</th>
            <th style="text-align: center">Number of Credits</th>
            <th style="text-align: center">Arrears Clearance</th>
            <th style="text-align: center">Advance Payment</th>
            <th style="text-align: center">Amount Realized</th>
        </tr>
    </thead>
    <tbody>
    @foreach($levelsData as $level)
        <tr>
            <td style="text-align: center">{{ $loop->iteration }}</td>
            <td>{{ $level->level_name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
