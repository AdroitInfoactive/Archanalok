@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Counter</h1>
        </div>

        <form action="{{ route('admin.counter.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Counter One -->
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Counter One</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="counter_name_one">Counter Name One</label>
                                <input type="text" class="form-control" name="counter_name_one" value="{{ @$counter->counter_name_one }}">
                            </div>
                            <div class="form-group">
                                <label for="counter_count_one">Counter Count One</label>
                                <input type="text" class="form-control" name="counter_count_one" value="{{ @$counter->counter_count_one }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Counter Two -->
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Counter Two</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="counter_name_two">Counter Name Two</label>
                                <input type="text" class="form-control" name="counter_name_two" value="{{ @$counter->counter_name_two }}">
                            </div>
                            <div class="form-group">
                                <label for="counter_count_two">Counter Count Two</label>
                                <input type="text" class="form-control" name="counter_count_two" value="{{ @$counter->counter_count_two }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Counter Three -->
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Counter Three</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="counter_name_three">Counter Name Three</label>
                                <input type="text" class="form-control" name="counter_name_three" value="{{ @$counter->counter_name_three }}">
                            </div>
                            <div class="form-group">
                                <label for="counter_count_three">Counter Count Three</label>
                                <input type="text" class="form-control" name="counter_count_three" value="{{ @$counter->counter_count_three }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Counter Four -->
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Counter Four</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="counter_name_four">Counter Name Four</label>
                                <input type="text" class="form-control" name="counter_name_four" value="{{ @$counter->counter_name_four }}">
                            </div>
                            <div class="form-group">
                                <label for="counter_count_four">Counter Count Four</label>
                                <input type="text" class="form-control" name="counter_count_four" value="{{ @$counter->counter_count_four }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Counter Five -->
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Counter Five</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="counter_name_five">Counter Name Five</label>
                                <input type="text" class="form-control" name="counter_name_five" value="{{ @$counter->counter_name_five }}">
                            </div>
                            <div class="form-group">
                                <label for="counter_count_five">Counter Count Five</label>
                                <input type="text" class="form-control" name="counter_count_five" value="{{ @$counter->counter_count_five }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Counter Six -->
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Counter Six</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="counter_name_six">Counter Name Six</label>
                                <input type="text" class="form-control" name="counter_name_six" value="{{ @$counter->counter_name_six }}">
                            </div>
                            <div class="form-group">
                                <label for="counter_count_six">Counter Count Six</label>
                                <input type="text" class="form-control" name="counter_count_six" value="{{ @$counter->counter_count_six }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </section>
@endsection
