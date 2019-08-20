@if(count($errors) > 0)
        <div class="alert alert-danger" role>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </div>
 @endif