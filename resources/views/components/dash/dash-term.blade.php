@props(['term_name', 'academic_year_start', 'academic_year_end'])

<div class="row page-titles">
    {{-- {{ dd(Auth::guard('admin'))->user()->school_id }} --}}
    @if(Auth::guard('admin')->user()->onboarding()->inProgress())
        {{-- @if (auth()->user()->onboarding()->inProgress()) --}}
            <div>
                <h4>Do the following to properly use your dashboard</h4>
                @foreach (Auth::guard('admin')->user()->onboarding()->steps as $step)
                {{-- {{ dd($step) }} --}}
                    <ol style="">
                        @if($step->complete())
                            <li style="text-decoration: line-through" class="fw-bolder">
                                {{ $loop->iteration }}. {{ $step->title }} : <span class="text-success">Done</span>
                            </li>
                        @else
                            <li style="text-decoration: none" class="fw-bolder">
                                {{ $loop->iteration }}. {{ $step->title }} : <span class="text-danger"><a href="{{ $step->link }}">Click here to {{ $step->cta }}</a></span>
                            </li>
                        @endif
                    </ol>
                @endforeach
            </div>
        {{-- @endif --}}
    @endif
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
