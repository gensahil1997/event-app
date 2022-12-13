<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Events</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="pull-left">
                    <h2>Events</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('events.create') }}"> Create Event</a>
                </div>
            </div>
        </div>
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p id="message">{{ $message }}</p> 
        </div>
        @endif
        <div>Filter By</div>
        <select id="eventType" onchange="fetchEvents()">
            <option value="all">All Events</option>
            <option value="upcoming" {{ request()->get('eventType') == 'upcoming' ? 'selected' : '' }}>Upcoming Events</option>
            <option value="finished" {{ request()->get('eventType') == 'finished' ? 'selected' : '' }}>Finished Events</option>
        </select>
        <table class="table table-bordered">
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th width="280px">Action</th>
            </tr>
            @foreach ($events as $event)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $event->title }}</td>
                <td>{{ $event->start_date }}</td>
                <td>{{ $event->end_date }}</td>
                <td>
                    <a class="btn btn-primary" href="{{ route('events.edit',$event->id) }}">Edit</a>
                    <button class="btn btn-danger" onclick="deleteEvent({{$event->id}})" href="#">Delete</button>
                </td>
            </tr>
            @endforeach
        </table>
        {!! $events->links() !!}
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>
    function deleteEvent(id)
    {
        $.ajax({
            url: `/events/destroy?id=` + id, 
            success: function (data) {
              window.location.reload();
            }
            });
    }

    function fetchEvents() {
        var eventType = document.getElementById("eventType").value;
        window.location.href = '/events?eventType=' + eventType;
    }
</script>

</html>