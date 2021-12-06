<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tasks List</title>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
                integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
                crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    </head>
    <body>
    <div class="container">
        <div class="row pt-3">
            <div class="col-md-12">
                <nav class="nav nav-pills">
                    <a class="text-sm-center nav-link active" href="{{url('/tasks/')}}">Tasks</a>
                    <a class="text-sm-center nav-link" href="{{url('/tasks/add')}}">Add Task</a>
                </nav>
            </div>
        </div>

        @if(session()->has('message'))
            <div class="alert alert-success mt-3">
                {{ session()->get('message') }}
            </div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-danger mt-3">
                {{ session()->get('error') }}
            </div>
        @endif

        <div class="card mt-3">
            <h1 class="pb-0 p-3">Tasks List</h1>
            <hr>
            <form class="row col-md-12" id="filters" action="{{url('/tasks')}}/" method="GET">
                    <div class="col-md-2 pl-3 pt-2">
                        <label for="project_filter"><h5>Filter by Project</h5></label>
                    </div>
                    <div class="col-md-4">
                        <select id="project_filter" name="project_filter" class="form-control lb-lg">
                            <option value="">All</option>
                            <?php
                            foreach($all_tasks as $t){
                            ?>
                            <option {{(Request::query('project_filter') == $t->project)? 'selected=""':''}} value="{{$t->project}}">{{$t->project}}</option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
            </form>
            <hr>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Project</th>
                    <th scope="col">Priority</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Updated At</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody class="tasks_list">
                <?php
                    if(count($tasks) > 0){
                        $counter = 1;
                        foreach($tasks as $task){
                        ?>
                            <tr id="{{$task->id}}">
                                <th scope="row">{{$counter}}</th>
                                <td>{{ $task->task_name }}</td>
                                <td>{{ $task->project }}</td>
                                <td>
                                    <span class="font-size: 18px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="{!! ($task->priority <= 5 ?  "orangered" : "dodgerblue") !!}" class="bi bi-reception-4" viewBox="0 0 16 16">
                                        <path d="M0 11.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2zm4-3a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-5zm4-3a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-8zm4-3a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v11a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-11z"/>
                                    </svg>
                                    </span>

                                </td>
                                <td>{{ $task->created_at }}</td>
                                <td>{{ $task->updated_at }}</td>
                                <td>
                                    <a class="btn btn-primary" href="{{url('tasks/edit/')}}/{{$task->id}}">Edit</a>
                                    <a class="btn btn-outline-secondary" href="{{url('tasks/delete/')}}/{{$task->id}}">Delete</a>
                                </td>
                            </tr>
                        <?php
                        $counter++;
                        }
                    }else{
                        ?>
                    <tr>
                        <td colspan="5">No Record Found</td>
                    </tr>
                    <?php
                    }
                ?>
                </tbody>
            </table>
        </div>

    </div>
    <script>
        $("#project_filter").on("change", function () {
            this.form.submit();
        });

        $( ".tasks_list" ).sortable({
            delay: 200,
            stop: function() {
                var rows = new Array();
                $('.tasks_list > tr').each(function() {
                    rows.push($(this).attr("id"));
                });
                console.log(rows);
                sortTasks(rows);
            }
        });


        function sortTasks(rows) {
            $.ajax({
                url: '{{ url("/sort-tasks") }}',
                type: 'get',
                data: 'rows='+rows,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log('response:'+response);
                },
                error: function (data) {
                    console.log('failure:');
                    console.log(data);
                }
            });
        }
    </script>
    </body>
</html>
