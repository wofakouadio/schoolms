<?php

namespace App\Http\Controllers\Admin\Assessment\EndTerm;

use App\Http\Controllers\Controller;
use App\Models\EndOfTerm;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class StudentsEndTermDataTables extends Controller
{
    public function __invoke()
    {
        $data = EndOfTerm::with('level')
            ->with('student')
            ->with('branch')
            ->with('term')
            ->where('school_id', Auth::guard('admin')->user()->school_id)->orderBy('created_at', 'DESC');
//            ->where('term.id', '=', 'studentMock.term_id')
//            ->where;
//        dd($data);
        return DataTables::of($data)

            ->addColumn('term', function ($row) {
                $term = $row->term->term_name . ' - ' . $row->term->academic_year->academic_year_start.'/'
                    .$row->term->academic_year->academic_year_end;
                return $term ?? '...';
            })
            ->addColumn('student_id', function ($row) {
                $student_id = $row->student->student_id;
                return $student_id ?? '...';
            })
            ->addColumn('student_name', function ($row) {
                $student_name = $row->student->student_firstname.' '.$row->student->student_lastname;
                return $student_name ?? '...';
            })
            ->addColumn('student_level', function ($row) {
                $student_level = $row->level->level_name;
                return $student_level ?? '...';
            })
            ->addColumn('total_class_score', function ($row) {
                $total_class_score = $row->total_class_score;
                return $total_class_score ?? '...';
            })
            ->addColumn('total_exam_score', function ($row) {
                $total_exam_score = $row->total_exam_score;
                return $total_exam_score ?? '...';
            })
            ->addColumn('total_score', function ($row) {
                $total_score = $row->total_score;
                return $total_score ?? '...';
            })
//            ->addColumn('is_active', function ($row) {
//                if ($row->is_active === 1) {
//                    return '<div class="bootstrap-badge">
//                                <span class="badge badge-xl light badge-success text-uppercase">active</span>
//                           </div>';
//                } else {
//                    return '<span class="badge badge-xl light badge-danger text-uppercase">disabled</span>';
//                }
//            })
            ->addColumn('action', function ($row) {
                $mock_id = $row->id;

//                return '<div class="d-flex">
//                            <a class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#edit-mock-setup-modal" data-id="'.$mock_id.'">
//                                <i class="fas fa-pencil-alt"></i>
//                            </a>
//                            <a class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#assign-subjects-to-mock-modal" data-id="'.$mock_id.'" data-name="'.$row->mock_type.'">
//                                <i class="fas fa-check-to-slot"></i>
//                            </a>
//                            <a href="" class="btn btn-danger shadow btn-xs sharp" data-bs-toggle="modal" data-bs-target="#delete-mock-setup-modal" data-id="'.$mock_id.'">
//                                <i class="fa fa-trash"></i>
//                            </a>
//                         </div>';
            })
            ->rawColumns(['action'])
            ->make(true);

    }
}
