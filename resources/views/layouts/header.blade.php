<!-- Header -->
<header class="header home header-1">
<div class="overlay"></div>
<h1 class="heading text-white w-100 text-center words-header">
    <div class="mr-10">Find Your</div>
    <div class="bg-green px-10 py-10 text-white words-continer" id="words-continer">
        <span>Dream</span>
        <span>Job</span>
        <span>Employee</span>
    </div>
</h1>
<div class="form search-form w-100">
    <form action="{{ route('job.search') }}" method="GET">
    <div class="container-fluid">
        <div class="row">
        <div class="offset-lg-2"></div>
        <!-- Serach -->
        <div class="col-lg-4 col-sm-6">
            <div class="form-group">
            <label for="search" class="text-white">Search term:</label>
            <input type="text" name="search" id="search" />
            </div>
        </div>
        <!-- /Serach -->
        <!-- Type -->
        @auth
        <div class="col-lg-4 col-sm-6">
            <div class="form-group">
            <label for="type" class="text-white">Job / Employee:</label>
            <select name="type" id="type">
                <option value="job">Job</option>
                <option value="user">Employee</option>
            </select>
            </div>
        </div>
        @endif
        <!-- Type -->
        </div>
    </div>
    </form>
</div>
</header>