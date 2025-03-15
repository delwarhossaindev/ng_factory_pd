<form action="{{ route('model.import') }}" method="post" class="needs-validation" role="form" novalidate
    enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 d-flex">
            <input type="file" name="csv" class="form-control" accept=".csv" required />
            <input type="submit" class="publish-post import" value="Import" /><br>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <span class="text-red">Read before importing users data</span>
            <a class="collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample"
                aria-expanded="false" aria-controls="collapseExample">
                Docs
            </a>
            <a href="{{ route('demo.user.import.download') }}">
                Download demo file
            </a>
            <div class="collapse" id="collapseExample" style="">
                <ul class="list-group list-group-flush mt-3">
                    @forelse (\DB::select('describe users') as $column)
                        <li class="list-group-item d-flex justify-content-between flex-wrap">
                            <b>Field:</b> {{ $column->Field }} <b>Accept Null:</b> {{ $column->Null }}
                        </li>
                    @empty
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</form>
