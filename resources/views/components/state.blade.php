@php
    $states = ['Capital Region of Denmark', 'Central Denmark Region', 'North Denmark Region', 'Region Zealand', 'Region of Southern Denmark	'];
@endphp

<select id="inputState" class=" form-select @error('meta.state') is-invalid @enderror" name="meta[state]" id="state" required>
    <option selected>Choose State</option>

    @foreach ($states as $state)
            <option value="{{ $state }}" {{ auth()->user()->state == $state ? 'selected' : '' }}>
                {{ $state }}</option>
       
    @endforeach


</select>
@error('state')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror
