<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit Task</title>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"></script>
    </head>
    <body>
    <div class="container">
        <div class="row pt-3">
            <div class="col-md-12">
                <nav class="nav nav-pills">
                    <a class="text-sm-center nav-link" href="{{url('/tasks/')}}">Tasks</a>
                    <a class="text-sm-center nav-link active" href="{{url('/tasks/add')}}">Add Task</a>
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
        <form id="edit_task" class="card mt-3" action="{{url('/tasks/edit/')}}" method="POST">
            {{ csrf_field() }}
            <div class="col-md-12">
                <h1 class="pt-3">Edit Task</h1>
                <div class="col-md-6 p-0">
                    <div class="form-group">
                        <label for="task_name">Name</label>
                        <input id="task_name" required="" value="{{$task->task_name}}" name="task_name" placeholder="Task Name" class="form-control lb-lg"/>
                    </div>
                    <div class="form-group">
                        <label for="project">Project</label>
                        <input id="project" required="" value="{{$task->project}}" name="project" placeholder="Project" class="form-control lb-lg"/>
                    </div>
                    <div class="form-group">
                        <label for="priority">Priority</label>
                        <input id="priority" required="" value="{{$task->priority}}" placeholder="(1 to 10) less being the highest" type="number" min="1" max="10" name="priority" class="form-control lb-lg"/>
                    </div>
                    <div class="form-group">
                        <input type="hidden" id="task_id" name="task_id" value="{{$task->id}}"/>
                        <input class="btn btn-secondary" type="submit" id="edit_task_btn" name="edit_task_btn" value="Save" />
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert-success').fadeOut('slow');
            }, 3000);
            setTimeout(function() {
                $('.alert-danger').fadeOut('slow');
            }, 3000);
        });
    </script>
    </body>
</html>
