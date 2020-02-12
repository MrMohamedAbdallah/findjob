<!-- Card -->
<div class="col-md-4 col-sm-6 col-12 mb-60 job-card">
    <div class="card-content">
        @if($job->pic)
        <img src="http://{{ Storage::url($job->pic) }}" alt="{{ $job->title }}" />
        @endif
        <h1 class="card-heading mt-30 px-20">
            <a href="{{ route('job.show', $job->slug) }}">{{ $job->title }}</a>
        </h1>
        <p class="card-desc mt-20  px-20">{{ $job->description }}</p>
        <div class="tags px-20 mb-30">
            @foreach($job->tags as $tag)
            <a href="http://findjob.test/search?search={{ $tag }}&type=job" class="tag mt-20">{{ $tag }}</a>
            @endforeach
        </div>
    </div>
</div>
<!-- /Card -->