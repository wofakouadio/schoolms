@props(['term_name', 'academic_year_start', 'academic_year_end'])

<div class="row page-titles">
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a>Term : <span class="text-primary fw-bolder">{{$term_name}}</span>
            </a>
        </li>
        <li class="breadcrumb-item">
            <a>Academic Year : <span class="text-primary fw-bolder">{{$academic_year_start}}/{{$academic_year_end}}</span>
            </a>
        </li>
    </ul>
</div>
