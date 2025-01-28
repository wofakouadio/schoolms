<?php
use Barryvdh\DomPDF\Facade\Pdf;

// Fetch results from the query
$results = DB::table('students_admissions as sa')
    ->join('levels as l', 'sa.student_level', '=', 'l.id')
    ->join('assign_subject_to_levels as asl', function ($join) {
        $join->on('asl.level_id', '=', 'l.id')
             ->whereColumn('sa.student_level', 'asl.level_id');
    })
    ->leftJoin('subjects as s', 's.id', '=', 'asl.subject_id')
    ->leftJoin('class_assessment_total_score_records as c', function ($join) {
        $join->on('c.student_id', '=', 'sa.id')
             ->on('s.id', '=', 'c.subject_id')
             ->on('l.id', '=', 'c.level_id');
    })
        $join->on('m.student_id', '=', 'sa.id')
             ->on('s.id', '=', 'm.subject_id');
    })
    ->leftJoin('end_of_term_breakdowns as e', function ($join) {
        $join->on('e.student_id', '=', 'sa.id')
             ->on('s.id', '=', 'e.subject_id');
    })
    ->select(
        'sa.student_id',
        'sa.student_firstname',
        'sa.student_lastname',
        'l.level_name',
        's.subject_name',
        DB::raw('IF(c.percentage, c.percentage, 0) as class_score_percentage'),
        DB::raw('IF(m.percentage, m.percentage, 0) as mid_term_score_percentage'),
        DB::raw('IF(e.percentage, e.percentage, 0) as end_term_score_percentage'),
        DB::raw('(IF(c.percentage, c.percentage, 0) + IF(m.percentage, m.percentage, 0) + IF(e.percentage, e.percentage, 0)) as total_100')
    )
    ->get();

// Organize data for the report card
$reportCard = [];

foreach ($results as $result) {
    $studentKey = $result->student_id;

    if (!isset($reportCard[$studentKey])) {
        $reportCard[$studentKey] = [
            'name' => $result->student_firstname . ' ' . $result->student_lastname,
            'level' => $result->level_name,
            'subjects' => []
        ];
    }

    $reportCard[$studentKey]['subjects'][] = [
        'subject' => $result->subject_name,
        'class_score' => $result->class_score_percentage,
        'mid_term_score' => $result->mid_term_score_percentage,
        'end_term_score' => $result->end_term_score_percentage,
        'total' => $result->total_100
    ];
}

// Generate PDF for the report card
$pdfContent = "<h1>School Report Card</h1>";

foreach ($reportCard as $student) {
    $pdfContent .= "<div style='page-break-after: always;'>";
    $pdfContent .= "<h2>" . htmlspecialchars($student['name']) . " (" . htmlspecialchars($student['level']) . ")</h2>";
    $pdfContent .= "<table border='1' cellspacing='0' cellpadding='5' style='width: 100%;'>";
    $pdfContent .= "<thead><tr><th>Subject</th><th>Class Score (%)</th><th>Mid-Term Score (%)</th><th>End-Term Score (%)</th><th>Total (%)</th></tr></thead><tbody>";

    foreach ($student['subjects'] as $subject) {
        $pdfContent .= "<tr>";
        $pdfContent .= "<td>" . htmlspecialchars($subject['subject']) . "</td>";
        $pdfContent .= "<td>" . htmlspecialchars($subject['class_score']) . "</td>";
        $pdfContent .= "<td>" . htmlspecialchars($subject['mid_term_score']) . "</td>";
        $pdfContent .= "<td>" . htmlspecialchars($subject['end_term_score']) . "</td>";
        $pdfContent .= "<td>" . htmlspecialchars($subject['total']) . "</td>";
        $pdfContent .= "</tr>";
    }

    $pdfContent .= "</tbody></table></div>";
}

// Create and download the PDF
$pdf = Pdf::loadHTML($pdfContent);
return $pdf->download('school_report_card.pdf');
?>
