<div id="array-date-container">
    @php
        $dates = $dataTypeContent->{$row->field};
    @endphp


    @if ($dates)
        @foreach ($dates as $index => $date)
            <div class="date-input-group" data-index="{{ $index }}">
                <input type="date" name="{{ $row->field }}[{{ $loop->iteration }}]" value="{{ $date }}"
                    class="form-control" />
                <button type="button" class="btn btn-danger remove-date">Remove</button>
            </div>
        @endforeach
    @endif

    <div id="date-input-template" class="date-input-group" style="display:none;">
        <input type="date" name="{{ $row->field }}[]" class="form-control" disabled  />
        <button type="button" class="btn btn-danger remove-date" >Remove</button>
    </div>

    <button type="button" class="btn btn-primary" id="add-date">Add Date</button>
</div>
<script>
    document.getElementById('add-date').addEventListener('click', function() {
        const container = document.getElementById('array-date-container');
        const template = document.getElementById('date-input-template').cloneNode(true);

        // Enable the date input field
        template.querySelector('input').disabled = false;

        template.style.display = 'block';
        container.insertBefore(template, this);
    });

    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-date')) {
            event.target.closest('.date-input-group').remove();
        }
    });
</script>