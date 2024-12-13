<div id="array-date-container">
  @php
    $dates = $dataTypeContent->{$row->field};
  @endphp


  @if ($dates)
    @foreach ($dates as $index => $date)
      <div class="row date-input-group" data-index="{{ $index }}">
        <div class="col-md-10">
          <input type="date" name="{{ $row->field }}[]" value="{{ $date }}" class="form-control" />
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-danger remove-date">Remove</button>
        </div>
      </div>
    @endforeach
  @endif

  <div id="date-input-template" class="date-input-group row" style="display:none;">
    <div class="col-md-10">

      <input type="date" name="{{ $row->field }}[]" class="form-control" disabled />
    </div>
    <div class="col-md-2">
      <button type="button" class="btn btn-danger remove-date">Remove</button>
    </div>
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
